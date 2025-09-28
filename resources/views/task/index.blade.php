<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl leading-tight">All Records</h2>
            <a href="{{ route('task.create') }}"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M11 11V5a1 1 0 1 1 2 0v6h6a1 1 0 1 1 0 2h-6v6a1 1 0 1 1-2 0v-6H5a1 1 0 1 1 0-2h6z" />
                </svg>
                Add Products
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Filters --}}
            <form method="GET" action="{{ route('records.index') }}" class="bg-white shadow-sm sm:rounded-xl mb-4">
                <div class="p-4 sm:p-6 grid grid-cols-1 md:grid-cols-5 gap-3">
                    <div class="md:col-span-2">
                        <label class="block text-sm text-gray-700 mb-1">Search (product/user/email)</label>
                        <input type="text" name="q" value="{{ $q }}"
                            class="w-full rounded border-gray-300" placeholder="Type & enter or click Search">
                    </div>

                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Filter by User</label>
                        <select name="user_id" class="w-full rounded border-gray-300">
                            <option value="">All</option>
                            @foreach ($userNames as $u)
                                <option value="{{ $u->id }}" @selected((string) $userId === (string) $u->id)>{{ $u->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Per Page</label>
                        <select name="perPage" class="w-full rounded border-gray-300">
                            @foreach ([10, 25, 50, 100] as $pp)
                                <option value="{{ $pp }}" @selected($perPage == $pp)>{{ $pp }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-end gap-2">
                        <button class="px-4 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700">Search</button>
                        <a href="{{ route('records.index') }}"
                            class="px-4 py-2 rounded border border-gray-300 hover:bg-gray-50">Reset</a>
                    </div>
                </div>
            </form>

            {{-- Table --}}
            <div class="bg-white shadow-sm sm:rounded-xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-50">
                            @php
                                // helper to build sortable header links
                                function sort_link($label, $key, $current, $dir)
                                {
                                    $params = request()->query();
                                    $params['sort'] = $key;
                                    $params['dir'] = $current === $key && $dir === 'asc' ? 'desc' : 'asc';
                                    $url = request()->url() . '?' . http_build_query($params);
                                    $arrow = $current === $key ? ($dir === 'asc' ? '▲' : '▼') : '';
                                    return '<a href="' .
                                        $url .
                                        '" class="inline-flex items-center gap-1">' .
                                        $label .
                                        ' <span class="text-xs">' .
                                        $arrow .
                                        '</span></a>';
                                }
                            @endphp
                            <tr class="text-gray-700">
                                <th class="px-4 py-3 text-left font-semibold">{!! sort_link('#', 'created_at', $sort, $dir) !!}</th>
                                <th class="px-4 py-3 text-left font-semibold">{!! sort_link('Product', 'name', $sort, $dir) !!}</th>
                                <th class="px-4 py-3 text-right font-semibold">{!! sort_link('Price', 'price', $sort, $dir) !!}</th>
                                <th class="px-4 py-3 text-right font-semibold">{!! sort_link('Qty', 'quantity', $sort, $dir) !!}</th>
                                <th class="px-4 py-3 text-left font-semibold">{!! sort_link('Type', 'type', $sort, $dir) !!}</th>
                                <th class="px-4 py-3 text-right font-semibold">{!! sort_link('Discount', 'discount', $sort, $dir) !!}</th>
                                <th class="px-4 py-3 text-right font-semibold">{!! sort_link('Computed Total', 'computed_total', $sort, $dir) !!}</th>
                                <th class="px-4 py-3 text-left font-semibold">{!! sort_link('Created', 'created_at', $sort, $dir) !!}</th>
                                <th class="px-4 py-3 text-left font-semibold">{!! sort_link('User', 'user_name', $sort, $dir) !!}</th>
                                <th class="px-4 py-3 text-left font-semibold">Username</th>
                                <th class="px-4 py-3 text-left font-semibold">Phone</th>
                                <th class="px-4 py-3 text-left font-semibold">Email</th>
                                <th class="px-4 py-3 text-left font-semibold">Actions</th>

                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rows as $i => $r)
                                <tr class="{{ $i % 2 ? 'bg-gray-50' : 'bg-white' }} hover:bg-gray-100">
                                    <td class="px-4 py-3 border-t border-gray-100">{{ ($rows->firstItem() ?? 1) + $i }}
                                    </td>
                                    <td class="px-4 py-3 border-t border-gray-100 font-medium text-gray-900">
                                        <span class="block truncate max-w-[220px]"
                                            title="{{ $r->name }}">{{ $r->name }}</span>
                                    </td>
                                    <td class="px-4 py-3 border-t border-gray-100 text-right">₹
                                        {{ number_format($r->price, 2) }}</td>
                                    <td class="px-4 py-3 border-t border-gray-100 text-right">{{ $r->quantity }}</td>
                                    <td class="px-4 py-3 border-t border-gray-100">
                                        @if ($r->type === 'discount')
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">Discount</span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Flat</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 border-t border-gray-100 text-right">
                                        {{ $r->type === 'discount' ? '₹ ' . number_format($r->discount ?? 0, 2) : '—' }}
                                    </td>
                                    <td class="px-4 py-3 border-t border-gray-100 text-right font-semibold">
                                        ₹ {{ number_format($r->computed_total, 2) }}
                                    </td>
                                    <td class="px-4 py-3 border-t border-gray-100 text-gray-600 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($r->created_at)->format('d-M-Y H:i') }}
                                    </td>
                                    <td class="px-4 py-3 border-t border-gray-100">{{ $r->user_name }}</td>
                                    <td class="px-4 py-3 border-t border-gray-100 text-gray-700">
                                        {{ $r->user_username }}</td>
                                    <td class="px-4 py-3 border-t border-gray-100">{{ $r->user_phone }}</td>
                                    <td class="px-4 py-3 border-t border-gray-100">{{ $r->user_email }}</td>
                                    @php $isOwner = (int)$r->owner_id === (int)auth()->id(); @endphp
                                    <td class="px-4 py-3 border-t border-gray-100">
                                        <div class="flex items-center gap-2">
                                            @if ($isOwner)
                                                <a href="{{ route('products.edit', $r->id) }}"
                                                    class="px-3 py-1.5 rounded bg-blue-600 text-white hover:bg-blue-700 text-xs">Edit</a>

                                                <form method="POST" action="{{ route('products.destroy', $r->id) }}"
                                                    onsubmit="return confirm('Delete this product?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="px-3 py-1.5 rounded bg-red-600 text-white hover:bg-red-700 text-xs">
                                                        Delete
                                                    </button>
                                                </form>
                                            @else
                                                <button
                                                    class="px-3 py-1.5 rounded bg-gray-200 text-gray-500 cursor-not-allowed text-xs"
                                                    disabled title="Only the owner can edit/delete">
                                                    No access
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="12" class="px-4 py-6 text-center text-gray-500">No records found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="px-4 py-3 border-t border-gray-100">
                    {{ $rows->onEachSide(1)->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
