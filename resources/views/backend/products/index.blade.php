@extends('backend.app.layout')

@section('title', 'Products')

@section('content')
<div class="p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Products</h1>
                <p class="text-gray-600 mt-1">Manage your product inventory</p>
            </div>
            <a href="{{ route('backend.products.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 px-6 rounded-lg transition-colors flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add New Product
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg">
                <p class="font-semibold">{{ session('success') }}</p>
            </div>
        @endif

        <!-- Products Table -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-slate-700 to-slate-800">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Code</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Product</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Category</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Price</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Stock</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-white uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($products as $product)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $product->products_code }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @if($product->image)
                                            <img src="{{ $product->image }}" alt="{{ $product->title }}" class="w-12 h-12 object-cover rounded-lg">
                                        @else
                                            <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="text-sm font-semibold text-gray-900">{{ $product->title }}</div>
                                            @if($product->is_featured === 'yes')
                                                <span class="text-xs px-2 py-0.5 bg-yellow-100 text-yellow-800 rounded-full">Featured</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $product->category->name ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <div>
                                        @if($product->sale_price)
                                            <div class="font-semibold text-red-600">Rp {{ number_format($product->sale_price, 0, ',', '.') }}</div>
                                            <div class="text-xs line-through text-gray-400">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                                        @else
                                            <div class="font-semibold">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($product->stock > 0)
                                        <span class="px-3 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">
                                            {{ $product->stock }} units
                                        </span>
                                    @else
                                        <span class="px-3 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded-full">
                                            Out of stock
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($product->status === 'active')
                                        <span class="px-3 py-1 text-xs font-semibold text-emerald-800 bg-emerald-100 rounded-full">
                                            Active
                                        </span>
                                    @else
                                        <span class="px-3 py-1 text-xs font-semibold text-gray-800 bg-gray-100 rounded-full">
                                            Inactive
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('backend.products.edit', $product) }}" class="text-indigo-600 hover:text-indigo-900 font-semibold">
                                            Edit
                                        </a>
                                        <form action="{{ route('backend.products.destroy', $product) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 font-semibold">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                        </svg>
                                        <p class="text-gray-500 text-lg font-semibold">No products found</p>
                                        <p class="text-gray-400 mt-1">Get started by creating a new product.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
