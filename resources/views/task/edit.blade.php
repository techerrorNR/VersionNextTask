<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <h2 class="font-semibold text-xl leading-tight">Edit Product</h2>
      <a href="{{ route('records.index') }}" class="text-sm px-3 py-2 rounded bg-gray-800 text-white hover:bg-gray-900">
        Back
      </a>
    </div>
  </x-slot>

  <div class="py-8">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white shadow-sm sm:rounded-xl p-6 space-y-6">

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

        <form method="POST" action="{{ route('products.update', $product->id) }}" class="space-y-6" id="edit-form">
          @csrf
          @method('PUT')

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium mb-1">Name <span class="text-red-500">*</span></label>
              <input type="text" name="name" value="{{ old('name', $product->name) }}"
                     class="w-full rounded border-gray-300" required>
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Price <span class="text-red-500">*</span></label>
              <input type="number" step="0.01" min="0" name="price" value="{{ old('price', $product->price) }}"
                     class="w-full rounded border-gray-300" required>
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Quantity <span class="text-red-500">*</span></label>
              <input type="number" step="1" min="1" name="quantity" value="{{ old('quantity', $product->quantity) }}"
                     class="w-full rounded border-gray-300" required>
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Type <span class="text-red-500">*</span></label>
              <select name="type" id="type" class="w-full rounded border-gray-300" required>
                <option value="flat" {{ old('type', $product->type) === 'flat' ? 'selected' : '' }}>Flat</option>
                <option value="discount" {{ old('type', $product->type) === 'discount' ? 'selected' : '' }}>Discount</option>
              </select>
            </div>

            <div class="md:col-span-2">
              <label class="block text-sm font-medium mb-1">Discount (₹)</label>
              <input type="number" step="0.01" min="0" name="discount" id="discount"
                     value="{{ old('discount', $product->discount) }}"
                     class="w-full rounded border-gray-300" {{ old('type', $product->type) === 'discount' ? '' : 'readonly' }}>
              <p class="text-xs text-gray-500 mt-1">Enabled only if Type = Discount.</p>
            </div>
          </div>

          <div class="flex items-center justify-end gap-3">
            <a href="{{ route('records.index') }}" class="px-4 py-2 rounded border border-gray-300 hover:bg-gray-50">Cancel</a>
            <button type="submit" class="inline-flex items-center px-5 py-2.5 rounded bg-emerald-600 text-white hover:bg-emerald-700">
              Update
            </button>
          </div>
        </form>

      </div>
    </div>
  </div>

  {{-- tiny toggle (no external libs) --}}
  <script>
    (function () {
      const typeSel = document.getElementById('type');
      const discInp = document.getElementById('discount');
      function sync() {
        if (typeSel.value === 'discount') discInp.removeAttribute('readonly');
        else { discInp.value = ''; discInp.setAttribute('readonly', 'readonly'); }
      }
      typeSel.addEventListener('change', sync);
      sync();
    })();
  </script>
</x-app-layout>
