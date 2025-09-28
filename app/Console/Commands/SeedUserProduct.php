<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SeedUserProduct extends Command
{
    // php artisan seed:user-product --products=5
    protected $signature = 'seed:user-product {--products=3 : Number of products to create for the new user}';

    protected $description = 'Create a new user (password: "password") and some products, without deleting old data';

    public function handle(): int
    {
        $productsCount = (int) $this->option('products');
        if ($productsCount < 1) $productsCount = 1;

        // --- Create a unique user each run ---
        $name = fake()->name();
        $username = Str::slug($name) . Str::lower(Str::random(4));   // e.g. john-doeab3k
        $email = fake()->unique()->safeEmail();

        $user = User::create([
            'name'     => $name,
            'username' => $username,
            'phone'    => fake()->numerify('9#########'),
            'email'    => $email,
            'password' => Hash::make('password'), // default password
        ]);

        // --- Create products for this user ---
        for ($i = 1; $i <= $productsCount; $i++) {
            $type = fake()->randomElement(['flat', 'discount']);
            $price = fake()->randomFloat(2, 10, 500);

            $discount = $type === 'discount'
                ? round(min($price, fake()->randomFloat(2, 1, $price * 0.5)), 2)
                : null;

            Product::create([
                'user_id'  => $user->id,
                'name'     => ucfirst(fake()->unique()->word()),
                'price'    => $price,
                'quantity' => fake()->numberBetween(1, 5),
                'type'     => $type,
                'discount' => $discount,
            ]);
        }

        // Output credentials & summary
        $this->info('✅ New user created with products.');
        $this->table(
            ['User ID', 'Name', 'Username', 'Email', 'Password', 'Products'],
            [[
                $user->id,
                $user->name,
                $user->username,
                $user->email,
                'password',
                $productsCount,
            ]]
        );

        return self::SUCCESS;
    }
}
