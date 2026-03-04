@extends('backend.app.layout')

@section('title', 'Blog Posts')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Blog Posts</h1>
                <p class="text-slate-600 mt-1">Manage all your blog posts</p>
            </div>
            <a href="{{ route('backend.blogs.create') }}" 
               class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium transition-colors flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add New Post
            </a>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6">
        {{ session('success') }}
    </div>
    @endif

    <!-- Table -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
        @if($blogs->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Image</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Author</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Published</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-slate-700 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @foreach($blogs as $blog)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            @if($blog->image)
                            <img src="{{ asset('storage/' . $blog->image) }}" 
                                 alt="{{ $blog->title }}"
                                 class="w-16 h-16 rounded-lg object-cover"
                                 loading="lazy"
                                 width="64"
                                 height="64">
                            @else
                            <div class="w-16 h-16 rounded-lg bg-slate-100 flex items-center justify-center">
                                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="font-medium text-slate-900">{{ $blog->title }}</span>
                                @if($blog->is_featured == '1')
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-medium bg-amber-100 text-amber-800 mt-1 w-fit">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    Featured
                                </span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($blog->category)
                            <span class="inline-flex px-2 py-1 rounded-md text-xs font-medium bg-indigo-100 text-indigo-800">
                                {{ $blog->category->name }}
                            </span>
                            @else
                            <span class="text-slate-400 text-sm">Uncategorized</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-700">
                            {{ $blog->author ?: '-' }}
                        </td>
                        <td class="px-6 py-4">
                            @if($blog->status === 'published')
                            <span class="inline-flex px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Published
                            </span>
                            @else
                            <span class="inline-flex px-2 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-800">
                                Draft
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-700">
                            {{ $blog->publish_date ? $blog->publish_date->format('M d, Y') : '-' }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('backend.blogs.edit', $blog) }}" 
                                   class="px-3 py-1.5 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg text-sm font-medium transition-colors">
                                    Edit
                                </a>
                                <form action="{{ route('backend.blogs.destroy', $blog) }}" 
                                      method="POST" 
                                      class="inline"
                                      onsubmit="return confirm('Are you sure you want to delete this blog post?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg text-sm font-medium transition-colors">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-slate-200">
            {{ $blogs->links() }}
        </div>
        @else
        <!-- Empty State -->
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-slate-900">No blog posts</h3>
            <p class="mt-1 text-sm text-slate-500">Get started by creating a new blog post.</p>
            <div class="mt-6">
                <a href="{{ route('backend.blogs.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add New Post
                </a>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
