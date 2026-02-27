@extends('backend.app.layout')

@section('title', 'Product Categories')

@section('content')
<div class="p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Product Categories</h1>
                <p class="text-gray-600 mt-1">Manage your product categories</p>
            </div>
            <a href="{{ route('backend.product-categories.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 px-6 rounded-lg transition-colors flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add New Category
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg">
                <p class="font-semibold">{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg">
                <p class="font-semibold">{{ session('error') }}</p>
            </div>
        @endif

        <!-- Categories Table -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-slate-700 to-slate-800">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">ID</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Name</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Slug</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Products</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-white uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($categories as $category)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $category->id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-gray-900">{{ $category->name }}</div>
                                @if($category->description)
                                    <div class="text-xs text-gray-500">{{ Str::limit($category->description, 50) }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ $category->slug }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 text-xs font-semibold text-blue-800 bg-blue-100 rounded-full">
                                    {{ $category->products_count }} products
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($category->status === 'active')
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
                                    <a href="{{ route('backend.product-categories.edit', $category) }}" class="text-indigo-600 hover:text-indigo-900 font-semibold">
                                        Edit
                                    </a>
                                    <form action="{{ route('backend.product-categories.destroy', $category) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this category?');">
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
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                    <p class="text-gray-500 text-lg font-semibold">No categories found</p>
                                    <p class="text-gray-400 mt-1">Get started by creating a new category.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
