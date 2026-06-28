<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-semibold mb-4"><i class="fa-solid fa-user-circle"></i> {{ Auth::user()->name }}</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <div class="flex items-center">
                                <i class="fa-solid fa-list-ul text-2xl text-blue-600 me-3"></i>
                                <div>
                                    <p class="text-sm text-gray-600">Shopping Lists</p>
                                    <p class="text-2xl font-bold">{{ Auth::user()->shoppingLists()->count() }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg">
                            <div class="flex items-center">
                                <i class="fa-solid fa-check text-2xl text-green-600 me-3"></i>
                                <div>
                                    <p class="text-sm text-gray-600">Active Items</p>
                                    <p class="text-2xl font-bold">{{ Auth::user()->shoppingLists()->where('is_completed', false)->pluck('items')->flatten()->where('checked', false)->count() }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-purple-50 p-4 rounded-lg">
                            <div class="flex items-center">
                                <i class="fa-solid fa-boxes-stacked text-2xl text-purple-600 me-3"></i>
                                <div>
                                    <p class="text-sm text-gray-600">Products</p>
                                    <p class="text-2xl font-bold">{{ App\Models\Product::count() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="border-t pt-6">
                        <h4 class="text-lg font-medium mb-3"><i class="fa-solid fa-arrow-right-long"></i> <a href="{{ route('shopping-list') }}" class="text-blue-600 hover:underline">View All Shopping Lists</a></h4>
                        <h4 class="text-lg font-medium mb-3"><i class="fa-solid fa-box"></i> <a href="{{ route('products.index') }}" class="text-blue-600 hover:underline">Browse Products</a></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
