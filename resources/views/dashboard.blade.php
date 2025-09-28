<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>

            {{-- Quick actions in header --}}
            <div class="hidden md:flex gap-3">
                <a href="{{ route('task.create') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    <!-- plus icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M11 11V5a1 1 0 1 1 2 0v6h6a1 1 0 1 1 0 2h-6v6a1 1 0 1 1-2 0v-6H5a1 1 0 1 1 0-2h6z"/></svg>
                    Add Products
                </a>
                <a href="{{ route('records.index') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-gray-800 text-white hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-400">
                    <!-- doc icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M6 2a2 2 0 0 0-2 2v16c0 1.103.897 2 2 2h12a2 2 0 0 0 2-2V8.828a2 2 0 0 0-.586-1.414l-3.828-3.828A2 2 0 0 0 14.172 3H6zm8 2.414L18.586 9H15a1 1 0 0 1-1-1V4.414z"/></svg>
                    My Records
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Welcome --}}
            <div class="bg-white shadow-sm sm:rounded-xl">
                <div class="p-6 sm:p-8">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Welcome back 👋</h3>
                            <p class="mt-1 text-sm text-gray-600">
                                You’re logged in. Use the actions below to add products and review your records.
                            </p>
                        </div>
                        <span class="hidden sm:inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">
                            Auth Active
                        </span>
                    </div>
                </div>
            </div>

            {{-- Action cards --}}
            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Add Products Card -->
                <a href="{{ route('task.create') }}"
                   class="group block rounded-xl border border-gray-200 bg-white p-6 shadow-sm hover:shadow-md hover:border-indigo-300 transition">
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor"><path d="M11 11V5a1 1 0 1 1 2 0v6h6a1 1 0 1 1 0 2h-6v6a1 1 0 1 1-2 0v-6H5a1 1 0 1 1 0-2h6z"/></svg>
                        </div>
                        <div>
                            <h4 class="text-base font-semibold text-gray-900">Add Products</h4>
                            <p class="mt-1 text-sm text-gray-600">
                                Insert rows, choose Flat/Discount, and the final amount auto-calculates.
                            </p>
                        </div>
                    </div>
                    <div class="mt-4 text-sm font-medium text-indigo-700 group-hover:underline">
                        Open product form →
                    </div>
                </a>

                <!-- My Records Card -->
                <a href="{{ route('records.index') }}"
                   class="group block rounded-xl border border-gray-200 bg-white p-6 shadow-sm hover:shadow-md hover:border-gray-400 transition">
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 text-gray-800">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor"><path d="M6 2a2 2 0 0 0-2 2v16c0 1.103.897 2 2 2h12a2 2 0 0 0 2-2V8.828a2 2 0 0 0-.586-1.414l-3.828-3.828A2 2 0 0 0 14.172 3H6zm8 2.414L18.586 9H15a1 1 0 0 1-1-1V4.414z"/></svg>
                        </div>
                        <div>
                            <h4 class="text-base font-semibold text-gray-900">My Records</h4>
                            <p class="mt-1 text-sm text-gray-600">
                                View saved products with computed totals and timestamps.
                            </p>
                        </div>
                    </div>
                    <div class="mt-4 text-sm font-medium text-gray-800 group-hover:underline">
                        View records →
                    </div>
                </a>
            </div>

           
            
        </div>
    </div>

    
</x-app-layout>
