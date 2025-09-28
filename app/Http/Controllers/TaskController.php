<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $q        = (string) $request->query('q', '');
        $userId   = $request->query('user_id', '');
        $perPage  = (int) $request->query('perPage', 10);
        if ($perPage < 5 || $perPage > 100) $perPage = 10;

        
        $sort = $request->query('sort', 'created_at');
        $dir  = $request->query('dir', 'desc') === 'asc' ? 'asc' : 'desc';

        $sortMap = [
            'name'           => 'products.name',
            'price'          => 'products.price',
            'quantity'       => 'products.quantity',
            'type'           => 'products.type',
            'discount'       => 'products.discount',
            'computed_total' => DB::raw("(CASE WHEN products.type='discount'
                THEN products.price - COALESCE(products.discount,0) ELSE products.price END) * products.quantity"),
            'created_at'     => 'products.created_at',
            'user_name'      => 'users.name',
        ];
        $orderBy = $sortMap[$sort] ?? $sortMap['created_at'];

        $computedExpr = "(CASE WHEN products.type='discount'
            THEN products.price - COALESCE(products.discount,0) ELSE products.price END) * products.quantity";

        $base = DB::table('products')
            ->join('users', 'users.id', '=', 'products.user_id');

        if ($userId !== '') {
            $base->where('users.id', (int)$userId);
        }

        if ($q !== '') {
            $base->where(function ($w) use ($q) {
                $w->where('products.name', 'like', "%{$q}%")
                  ->orWhere('users.name', 'like', "%{$q}%")
                  ->orWhere('users.username', 'like', "%{$q}%")
                  ->orWhere('users.phone', 'like', "%{$q}%")
                  ->orWhere('users.email', 'like', "%{$q}%");
            });
        }

        $rows = $base->select([
                'products.id',
                'products.user_id as owner_id',
                'products.name',
                'products.price',
                'products.quantity',
                'products.type',
                'products.discount',
                'products.created_at',
                'users.name as user_name',
                'users.username as user_username',
                'users.phone as user_phone',
                'users.email as user_email',
            ])
            ->selectRaw("$computedExpr as computed_total")
            ->orderBy($orderBy, $dir)
            ->paginate($perPage)
            ->appends($request->query()); 

       
        $userNames = DB::table('products')
            ->join('users', 'users.id', '=', 'products.user_id')
            ->select('users.id', 'users.name')
            ->groupBy('users.id', 'users.name')
            ->orderBy('users.name')
            ->get();

        return view('task.index', [
            'rows'      => $rows,
            'userNames' => $userNames,
            'q'         => $q,
            'userId'    => $userId,
            'sort'      => $sort,
            'dir'       => $dir,
            'perPage'   => $perPage,
        ]);
    }

    public function create()
    {
       
        $users = User::orderBy('name')->get(['id','name','email','username']);
        return view('task.create', compact('users'));
    }

    
    public function store(Request $request)
    {

        $useExisting = $request->boolean('use_existing');

        $rules = [
            'products'               => ['required','array','min:1'],
            'products.*.name'        => ['required','string','max:255'],
            'products.*.price'       => ['required','numeric','min:0'],
            'products.*.quantity'    => ['required','integer','min:1'],
            'products.*.type'        => ['required','in:flat,discount'],
            'products.*.discount'    => ['nullable','numeric','min:0'],
            'final_amount'           => ['required','numeric','min:0'],
        ];

        if ($useExisting) {
            $rules['existing_user_id'] = ['required','exists:users,id'];
        } else {
            $rules['user'] = ['required','array'];
            $rules['user.name'] = ['required','string','max:255'];
            $rules['user.username'] = ['required','string','max:255','unique:users,username'];
            $rules['user.phone'] = ['nullable','string','max:20'];
            $rules['user.email'] = ['required','email','max:255','unique:users,email'];
            $rules['user.password'] = ['required','string','min:6'];
        }

        $validated = $request->validate($rules);

        DB::transaction(function () use ($validated, $useExisting) {
            if ($useExisting) {
                $userId = (int) $validated['existing_user_id'];
            } else {
                $u = $validated['user'];
                $user = User::create([
                    'name' => $u['name'],
                    'username' => $u['username'],
                    'phone' => $u['phone'] ?? null,
                    'email' => $u['email'],
                    'password' => Hash::make($u['password']),
                ]);
                $userId = $user->id;
            }

            foreach ($validated['products'] as $row) {
                Product::create([
                    'user_id'  => $userId,
                    'name'     => $row['name'],
                    'price'    => $row['price'],
                    'quantity' => $row['quantity'],
                    'type'     => $row['type'],
                    'discount' => $row['type'] === 'discount' ? ($row['discount'] ?? 0) : null,
                ]);
            }
        });

        return redirect()->route('records.index')->with('status', 'User & products saved successfully.');
    }
    public function edit(Product $product)
{

    abort_unless($product->user_id === Auth::id(), 403);
    return view('task.edit', compact('product'));
}
public function update(Request $request, Product $product)
{
    abort_unless($product->user_id === Auth::id(), 403);

    $validated = $request->validate([
        'name'     => ['required','string','max:255'],
        'price'    => ['required','numeric','min:0'],
        'quantity' => ['required','integer','min:1'],
        'type'     => ['required', Rule::in(['flat','discount'])],
        'discount' => ['nullable','numeric','min:0'],
    ]);

    $product->update([
        'name'     => $validated['name'],
        'price'    => $validated['price'],
        'quantity' => $validated['quantity'],
        'type'     => $validated['type'],
        'discount' => $validated['type'] === 'discount' ? ($validated['discount'] ?? 0) : null,
    ]);

    return redirect()->route('records.index')->with('status', 'Product updated.');
}

public function destroy(Product $product)
{
    // Only owner can delete
    abort_unless($product->user_id === Auth::id(), 403);

    $product->delete();
    return redirect()->route('records.index')->with('status', 'Product deleted.');
}
}
