@extends('backend.app.layout')

@section('title', 'Create Menu Item')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('backend.header.index') }}" class="text-slate-600 hover:text-slate-800">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-slate-800">Create Menu Item</h1>
                <p class="text-slate-600 mt-1">Add a new navigation menu item</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <form action="{{ route('backend.header.store') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-3 gap-6">
            <!-- Main Content - 2 Columns -->
            <div class="col-span-2 space-y-6">
                <!-- Basic Information -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-slate-800 mb-6">Basic Information</h2>
                    
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <!-- Menu Label -->
                        <div>
                            <label for="menu_label" class="block text-sm font-medium text-slate-700 mb-2">
                                Menu Label <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="menu_label" 
                                   id="menu_label" 
                                   value="{{ old('menu_label') }}"
                                   class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="HOME" 
                                   required>
                            @error('menu_label')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Menu Slug -->
                        <div>
                            <label for="menu_slug" class="block text-sm font-medium text-slate-700 mb-2">
                                Menu Slug <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="menu_slug" 
                                   id="menu_slug" 
                                   value="{{ old('menu_slug') }}"
                                   class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="home" 
                                   required>
                            @error('menu_slug')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Menu URL -->
                    <div class="mb-6">
                        <label for="menu_url" class="block text-sm font-medium text-slate-700 mb-2">
                            Menu URL
                        </label>
                        <input type="text" 
                               name="menu_url" 
                               id="menu_url" 
                               value="{{ old('menu_url') }}"
                               class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="/">
                        @error('menu_url')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Menu Icon -->
                    <div>
                        <label for="menu_icon" class="block text-sm font-medium text-slate-700 mb-2">
                            Menu Icon (Font Awesome class)
                        </label>
                        <input type="text" 
                               name="menu_icon" 
                               id="menu_icon" 
                               value="{{ old('menu_icon') }}"
                               class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="fas fa-home">
                        <p class="mt-2 text-sm text-slate-500">Example: fas fa-home, fas fa-box, fas fa-envelope</p>
                        @error('menu_icon')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Display Settings -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-slate-800 mb-6">Display Settings</h2>
                    
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <!-- Menu Location -->
                        <div>
                            <label for="menu_location" class="block text-sm font-medium text-slate-700 mb-2">
                                Menu Location <span class="text-red-500">*</span>
                            </label>
                            <select name="menu_location" 
                                    id="menu_location" 
                                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    required>
                                <option value="both" {{ old('menu_location') === 'both' ? 'selected' : '' }}>Both (Navbar & Sidebar)</option>
                                <option value="navbar" {{ old('menu_location') === 'navbar' ? 'selected' : '' }}>Navbar Only</option>
                                <option value="sidebar" {{ old('menu_location') === 'sidebar' ? 'selected' : '' }}>Sidebar Only</option>
                                <option value="footer" {{ old('menu_location') === 'footer' ? 'selected' : '' }}>Footer</option>
                            </select>
                            @error('menu_location')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Menu Order -->
                        <div>
                            <label for="menu_order" class="block text-sm font-medium text-slate-700 mb-2">
                                Menu Order
                            </label>
                            <input type="number" 
                                   name="menu_order" 
                                   id="menu_order" 
                                   value="{{ old('menu_order', 0) }}"
                                   min="0"
                                   class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('menu_order')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Display Checkboxes -->
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" 
                                       name="show_in_navbar" 
                                       value="1" 
                                       {{ old('show_in_navbar', true) ? 'checked' : '' }}
                                       class="w-5 h-5 text-blue-600 border-slate-300 rounded focus:ring-blue-500">
                                <span class="ml-3 text-sm font-medium text-slate-700">Show in Navbar</span>
                            </label>
                        </div>

                        <div>
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" 
                                       name="show_in_sidebar" 
                                       value="1" 
                                       {{ old('show_in_sidebar', true) ? 'checked' : '' }}
                                       class="w-5 h-5 text-blue-600 border-slate-300 rounded focus:ring-blue-500">
                                <span class="ml-3 text-sm font-medium text-slate-700">Show in Sidebar</span>
                            </label>
                        </div>

                        <div>
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" 
                                       name="show_in_footer" 
                                       value="1" 
                                       {{ old('show_in_footer', true) ? 'checked' : '' }}
                                       class="w-5 h-5 text-blue-600 border-slate-300 rounded focus:ring-blue-500">
                                <span class="ml-3 text-sm font-medium text-slate-700">Show in Footer</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Link Settings -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-slate-800 mb-6">Link Settings</h2>
                    
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" 
                                       name="is_external" 
                                       value="1" 
                                       {{ old('is_external') ? 'checked' : '' }}
                                       class="w-5 h-5 text-blue-600 border-slate-300 rounded focus:ring-blue-500">
                                <span class="ml-3 text-sm font-medium text-slate-700">External Link</span>
                            </label>
                        </div>

                        <div>
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" 
                                       name="open_new_tab" 
                                       value="1" 
                                       {{ old('open_new_tab') ? 'checked' : '' }}
                                       class="w-5 h-5 text-blue-600 border-slate-300 rounded focus:ring-blue-500">
                                <span class="ml-3 text-sm font-medium text-slate-700">Open in New Tab</span>
                            </label>
                        </div>
                    </div>

                    <!-- Button Settings -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" 
                                       name="is_button" 
                                       id="is_button"
                                       value="1" 
                                       {{ old('is_button') ? 'checked' : '' }}
                                       class="w-5 h-5 text-blue-600 border-slate-300 rounded focus:ring-blue-500">
                                <span class="ml-3 text-sm font-medium text-slate-700">Display as Button</span>
                            </label>
                        </div>

                        <div>
                            <label for="button_style" class="block text-sm font-medium text-slate-700 mb-2">
                                Button Style
                            </label>
                            <select name="button_style" 
                                    id="button_style" 
                                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">None</option>
                                <option value="primary" {{ old('button_style') === 'primary' ? 'selected' : '' }}>Primary</option>
                                <option value="outline" {{ old('button_style') === 'outline' ? 'selected' : '' }}>Outline</option>
                                <option value="ghost" {{ old('button_style') === 'ghost' ? 'selected' : '' }}>Ghost</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar - 1 Column -->
            <div class="space-y-6">
                <!-- Status Settings -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-slate-800 mb-6">Status & Permissions</h2>
                    
                    <!-- Status Toggle -->
                    <div class="mb-6">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" 
                                   name="is_active" 
                                   value="1" 
                                   {{ old('is_active', true) ? 'checked' : '' }}
                                   class="w-5 h-5 text-blue-600 border-slate-300 rounded focus:ring-blue-500">
                            <span class="ml-3 text-sm font-medium text-slate-700">Active Menu</span>
                        </label>
                    </div>

                    <!-- Require Auth -->
                    <div>
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" 
                                   name="require_auth" 
                                   value="1" 
                                   {{ old('require_auth') ? 'checked' : '' }}
                                   class="w-5 h-5 text-blue-600 border-slate-300 rounded focus:ring-blue-500">
                            <span class="ml-3 text-sm font-medium text-slate-700">Require Authentication</span>
                        </label>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <button type="submit" 
                            class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition-colors font-semibold shadow-lg hover:shadow-xl">
                        Create Menu Item
                    </button>
                    <a href="{{ route('backend.header.index') }}" 
                       class="block w-full text-center mt-3 px-4 py-2 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 transition-colors">
                        Cancel
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
