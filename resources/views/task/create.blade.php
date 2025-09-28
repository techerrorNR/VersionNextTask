<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl leading-tight">Task – Create User & Add Products</h2>
            <a href="{{ route('records.index') }}" class="text-sm px-3 py-2 rounded bg-gray-800 text-white hover:bg-gray-900">
                View Records
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-xl p-6 sm:p-8 space-y-8">

                @if (session('status'))
                    <div class="p-3 rounded bg-emerald-50 text-emerald-700">{{ session('status') }}</div>
                @endif
                @if ($errors->any())
                    <div class="p-3 rounded bg-red-50 text-red-700">
                        <ul class="list-disc ml-5 text-sm">
                            @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('task.store') }}" id="product-form" class="space-y-8">
                    @csrf

                    {{-- User Mode --}}
                    <div>
                        <h3 class="text-lg font-semibold">User</h3>

                        <div class="mt-3 flex items-center gap-6">
                            <label class="inline-flex items-center gap-2">
                                <input type="radio" name="use_existing" value="1" class="text-indigo-600" checked>
                                <span>Use Existing User</span>
                            </label>
                            <label class="inline-flex items-center gap-2">
                                <input type="radio" name="use_existing" value="0" class="text-indigo-600">
                                <span>Create New User</span>
                            </label>
                        </div>

                        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                            {{-- Existing user select --}}
                            <div class="md:col-span-2" id="existing-user-wrap">
                                <label class="block text-sm font-medium mb-1">Select User</label>
                                <select name="existing_user_id" class="w-full rounded border-gray-300">
                                    <option value="">-- Select user --</option>
                                    @foreach($users as $u)
                                        <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>
                                    @endforeach
                                </select>
                                <p class="text-xs text-gray-500 mt-1">Choose a user to attach products.</p>
                            </div>

                            {{-- New user fields --}}
                            <div class="hidden" id="new-user-wrap">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium mb-1">Name <span class="text-red-500">*</span></label>
                                        <input type="text" name="user[name]" class="w-full rounded border-gray-300">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1">Username <span class="text-red-500">*</span></label>
                                        <input type="text" name="user[username]" class="w-full rounded border-gray-300">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1">Phone</label>
                                        <input type="text" name="user[phone]" class="w-full rounded border-gray-300">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-1">Email <span class="text-red-500">*</span></label>
                                        <input type="email" name="user[email]" class="w-full rounded border-gray-300">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium mb-1">Password <span class="text-red-500">*</span></label>
                                        <input type="password" name="user[password]" class="w-full rounded border-gray-300">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Products --}}
                    <div>
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold">Products</h3>
                            <button type="button" id="add-row"
                                class="inline-flex items-center gap-2 px-3 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M11 11V5a1 1 0 1 1 2 0v6h6a1 1 0 1 1 0 2h-6v6a1 1 0 1 1-2 0v-6H5a1 1 0 1 1 0-2h6z"/></svg>
                                Add Row
                            </button>
                        </div>

                        <div class="overflow-x-auto mt-3">
                            <table class="min-w-full text-sm border rounded" id="product-table">
                                <thead class="bg-gray-50 text-left">
                                    <tr>
                                        <th class="p-3 border">Name</th>
                                        <th class="p-3 border">Price</th>
                                        <th class="p-3 border">Qty</th>
                                        <th class="p-3 border">Type</th>
                                        <th class="p-3 border">Discount (₹)</th>
                                        <th class="p-3 border">Row Total (₹)</th>
                                        <th class="p-3 border">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="product-tbody"></tbody>
                            </table>
                        </div>

                        <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                            <div class="md:col-span-2"></div>
                            <div>
                                <label class="block text-sm font-medium mb-1">Final Amount (₹)</label>
                                <input name="final_amount" id="final-amount" readonly
                                       class="w-full rounded border-gray-300 bg-gray-100 font-semibold" value="0.00">
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('records.index') }}" class="px-4 py-2 rounded border border-gray-300 hover:bg-gray-50">Cancel</a>
                        <button type="submit" class="inline-flex items-center px-5 py-2.5 rounded bg-emerald-600 text-white hover:bg-emerald-700">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Row template --}}
    <template id="row-template">
        <tr class="hover:bg-gray-50">
            <td class="p-2 border">
                <input name="__NAME__" class="w-full rounded border-gray-300" placeholder="Product name" />
            </td>
            <td class="p-2 border">
                <input type="number" step="0.01" min="0" name="__PRICE__" class="w-full rounded border-gray-300 price" placeholder="0.00" />
            </td>
            <td class="p-2 border">
                <input type="number" step="1" min="1" name="__QTY__" class="w-full rounded border-gray-300 qty" value="1" />
            </td>
            <td class="p-2 border">
                <select name="__TYPE__" class="w-full rounded border-gray-300 type">
                    <option value="flat">Flat</option>
                    <option value="discount">Discount</option>
                </select>
            </td>
            <td class="p-2 border">
                <input type="number" step="0.01" min="0" name="__DISC__" class="w-full rounded border-gray-300 discount" placeholder="0.00" readonly />
            </td>
            <td class="p-2 border">
                <input type="text" class="w-full rounded border-gray-300 bg-gray-100 row-total font-medium" value="0.00" readonly />
            </td>
            <td class="p-2 border text-center">
                <button type="button" class="px-2 py-1 rounded bg-red-600 text-white hover:bg-red-700 remove-row">Remove</button>
            </td>
        </tr>
    </template>

    <script>
        // Toggle existing/new user views
        const radios = document.querySelectorAll('input[name="use_existing"]');
        const existingWrap = document.getElementById('existing-user-wrap');
        const newWrap = document.getElementById('new-user-wrap');
        const existingSelect = existingWrap.querySelector('select');

        const switchMode = () => {
            const useExisting = document.querySelector('input[name="use_existing"]:checked').value === '1';
            existingWrap.classList.toggle('hidden', !useExisting);
            newWrap.classList.toggle('hidden', useExisting);
            if (useExisting) {
                existingSelect.setAttribute('name', 'existing_user_id');
            } else {
                existingSelect.removeAttribute('name');
            }
        };
        radios.forEach(r => r.addEventListener('change', switchMode));
        switchMode();

        // Product rows + totals
        const tbody = document.getElementById('product-tbody');
        const addBtn = document.getElementById('add-row');
        const tpl = document.getElementById('row-template');
        const finalAmount = document.getElementById('final-amount');
        let idx = 0;

        function addRow() {
            const clone = tpl.content.cloneNode(true);
            clone.querySelector('[name="__NAME__"]').setAttribute('name', `products[${idx}][name]`);
            clone.querySelector('[name="__PRICE__"]').setAttribute('name', `products[${idx}][price]`);
            clone.querySelector('[name="__QTY__"]').setAttribute('name', `products[${idx}][quantity]`);
            clone.querySelector('[name="__TYPE__"]').setAttribute('name', `products[${idx}][type]`);
            clone.querySelector('[name="__DISC__"]').setAttribute('name', `products[${idx}][discount]`);
            idx++;

            const rowEl = clone.querySelector('tr');
            tbody.appendChild(rowEl);

            bindRow(rowEl);
            recalcRow(rowEl);
            recalcFinal();
        }

        function bindRow(row) {
            const price = row.querySelector('.price');
            const qty = row.querySelector('.qty');
            const type = row.querySelector('.type');
            const discount = row.querySelector('.discount');
            const remove = row.querySelector('.remove-row');

            const onChange = () => { recalcRow(row); recalcFinal(); };

            price.addEventListener('input', onChange);
            qty.addEventListener('input', onChange);
            discount.addEventListener('input', onChange);
            type.addEventListener('change', () => {
                if (type.value === 'discount') {
                    discount.removeAttribute('readonly');
                } else {
                    discount.value = '';
                    discount.setAttribute('readonly', 'readonly');
                }
                onChange();
            });

            remove.addEventListener('click', () => {
                row.remove();
                recalcFinal();
            });
        }

        function recalcRow(row) {
            const price = parseFloat(row.querySelector('.price').value || 0);
            const qty = parseInt(row.querySelector('.qty').value || 0);
            const type = row.querySelector('.type').value;
            const disc = parseFloat(row.querySelector('.discount').value || 0);
            const unit = type === 'discount' ? Math.max(price - disc, 0) : price;
            row.querySelector('.row-total').value = (unit * qty).toFixed(2);
        }

        function recalcFinal() {
            let sum = 0;
            tbody.querySelectorAll('.row-total').forEach(i => sum += parseFloat(i.value || 0));
            finalAmount.value = sum.toFixed(2);
        }

        addBtn.addEventListener('click', addRow);
        addRow();
    </script>
</x-app-layout>
