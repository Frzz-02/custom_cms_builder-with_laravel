@extends('backend.app.layout')

@section('title', 'Site Settings')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center space-x-2 text-sm text-slate-600 mb-2">
            <a href="{{ route('backend.dashboard') }}" class="hover:text-slate-900">Dashboard</a>
            <span>/</span>
            <span class="text-slate-900">Settings</span>
        </div>
        <h1 class="text-3xl font-bold text-slate-800">Site Settings</h1>
        <p class="text-slate-600 mt-1">Manage your website settings and configuration</p>
    </div>

    @if(session('success'))
        <div class="bg-emerald-100 border border-emerald-300 text-emerald-800 px-5 py-4 rounded-lg mb-5 text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-300 text-red-800 px-5 py-4 rounded-lg mb-5 text-sm">
            {{ session('error') }}
        </div>
    @endif

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="p-6">
            <form action="{{ route('backend.settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- General Settings Section -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        General Settings
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Site Title -->
                        <div>
                            <label for="site_title" class="block text-sm font-semibold text-slate-700 mb-2">
                                Site Title <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="site_title" 
                                name="site_title" 
                                value="{{ old('site_title', $setting->site_title) }}"
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('site_title') border-red-500 @enderror"
                                placeholder="Enter site title"
                                required
                            >
                            @error('site_title')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Site Subtitle -->
                        <div>
                            <label for="site_subtitle" class="block text-sm font-semibold text-slate-700 mb-2">
                                Site Subtitle
                            </label>
                            <input 
                                type="text" 
                                id="site_subtitle" 
                                name="site_subtitle" 
                                value="{{ old('site_subtitle', $setting->site_subtitle) }}"
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('site_subtitle') border-red-500 @enderror"
                                placeholder="Enter site subtitle"
                            >
                            @error('site_subtitle')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Site URL -->
                        <div>
                            <label for="site_url" class="block text-sm font-semibold text-slate-700 mb-2">
                                Site URL
                            </label>
                            <input 
                                type="url" 
                                id="site_url" 
                                name="site_url" 
                                value="{{ old('site_url', $setting->site_url) }}"
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('site_url') border-red-500 @enderror"
                                placeholder="https://example.com"
                            >
                            @error('site_url')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Time Zone -->
                        <div>
                            <label for="time_zone" class="block text-sm font-semibold text-slate-700 mb-2">
                                Time Zone
                            </label>
                            <select 
                                id="time_zone" 
                                name="time_zone" 
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('time_zone') border-red-500 @enderror"
                            >
                                <option value="UTC" @selected(old('time_zone', $setting->time_zone) == 'UTC')>UTC</option>
                                <option value="Asia/Jakarta" @selected(old('time_zone', $setting->time_zone) == 'Asia/Jakarta')>Asia/Jakarta (WIB)</option>
                                <option value="Asia/Makassar" @selected(old('time_zone', $setting->time_zone) == 'Asia/Makassar')>Asia/Makassar (WITA)</option>
                                <option value="Asia/Jayapura" @selected(old('time_zone', $setting->time_zone) == 'Asia/Jayapura')>Asia/Jayapura (WIT)</option>
                            </select>
                            @error('time_zone')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Locale Language -->
                        <div>
                            <label for="locale_language" class="block text-sm font-semibold text-slate-700 mb-2">
                                Language
                            </label>
                            <select 
                                id="locale_language" 
                                name="locale_language" 
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('locale_language') border-red-500 @enderror"
                            >
                                <option value="en" @selected(old('locale_language', $setting->locale_language) == 'en')>English</option>
                                <option value="id" @selected(old('locale_language', $setting->locale_language) == 'id')>Indonesian</option>
                            </select>
                            @error('locale_language')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Site Keywords -->
                        <div>
                            <label for="site_keywords" class="block text-sm font-semibold text-slate-700 mb-2">
                                Site Keywords
                            </label>
                            <input 
                                type="text" 
                                id="site_keywords" 
                                name="site_keywords" 
                                value="{{ old('site_keywords', $setting->site_keywords) }}"
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('site_keywords') border-red-500 @enderror"
                                placeholder="keyword1, keyword2, keyword3"
                            >
                            @error('site_keywords')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Site Description -->
                    <div class="mt-6">
                        <label for="site_description" class="block text-sm font-semibold text-slate-700 mb-2">
                            Site Description
                        </label>
                        <textarea 
                            id="site_description" 
                            name="site_description" 
                            rows="4"
                            class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('site_description') border-red-500 @enderror"
                            placeholder="Enter site description for SEO"
                        >{{ old('site_description', $setting->site_description) }}</textarea>
                        @error('site_description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Media Settings Section -->
                <div class="mb-8 border-t border-slate-200 pt-8">
                    <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Media & Logos
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Site Logo -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Site Logo
                            </label>
                            @if($setting->site_logo)
                                <div class="mb-3">
                                    <img src="{{ asset('storage/' . $setting->site_logo) }}" alt="Site Logo" class="h-20 object-contain border border-slate-200 rounded p-2 bg-white">
                                    <button 
                                        type="button" 
                                        onclick="removeImage('site_logo')"
                                        class="mt-2 text-sm text-red-600 hover:text-red-800"
                                    >
                                        Remove Image
                                    </button>
                                </div>
                            @endif
                            <input 
                                type="file" 
                                id="site_logo" 
                                name="site_logo" 
                                accept="image/*"
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('site_logo') border-red-500 @enderror"
                            >
                            <p class="mt-1 text-xs text-slate-500">Recommended: PNG, JPG, SVG (Max: 2MB)</p>
                            @error('site_logo')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Site Logo 2 -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Site Logo 2 (Alternative)
                            </label>
                            @if($setting->site_logo_2)
                                <div class="mb-3">
                                    <img src="{{ asset('storage/' . $setting->site_logo_2) }}" alt="Site Logo 2" class="h-20 object-contain border border-slate-200 rounded p-2 bg-white">
                                    <button 
                                        type="button" 
                                        onclick="removeImage('site_logo_2')"
                                        class="mt-2 text-sm text-red-600 hover:text-red-800"
                                    >
                                        Remove Image
                                    </button>
                                </div>
                            @endif
                            <input 
                                type="file" 
                                id="site_logo_2" 
                                name="site_logo_2" 
                                accept="image/*"
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('site_logo_2') border-red-500 @enderror"
                            >
                            <p class="mt-1 text-xs text-slate-500">Recommended: PNG, JPG, SVG (Max: 2MB)</p>
                            @error('site_logo_2')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Favicon -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Favicon
                            </label>
                            @if($setting->favicon)
                                <div class="mb-3">
                                    <img src="{{ asset('storage/' . $setting->favicon) }}" alt="Favicon" class="h-12 object-contain border border-slate-200 rounded p-2 bg-white">
                                    <button 
                                        type="button" 
                                        onclick="removeImage('favicon')"
                                        class="mt-2 text-sm text-red-600 hover:text-red-800"
                                    >
                                        Remove Image
                                    </button>
                                </div>
                            @endif
                            <input 
                                type="file" 
                                id="favicon" 
                                name="favicon" 
                                accept=".ico,.png"
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('favicon') border-red-500 @enderror"
                            >
                            <p class="mt-1 text-xs text-slate-500">Recommended: ICO or PNG (Max: 1MB)</p>
                            @error('favicon')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Preloader -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Preloader
                            </label>
                            @if($setting->preloader)
                                <div class="mb-3">
                                    <img src="{{ asset('storage/' . $setting->preloader) }}" alt="Preloader" class="h-20 object-contain border border-slate-200 rounded p-2 bg-white">
                                    <button 
                                        type="button" 
                                        onclick="removeImage('preloader')"
                                        class="mt-2 text-sm text-red-600 hover:text-red-800"
                                    >
                                        Remove Image
                                    </button>
                                </div>
                            @endif
                            <input 
                                type="file" 
                                id="preloader" 
                                name="preloader" 
                                accept=".gif,.svg"
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('preloader') border-red-500 @enderror"
                            >
                            <p class="mt-1 text-xs text-slate-500">Recommended: GIF or SVG (Max: 2MB)</p>
                            @error('preloader')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end space-x-3 pt-6 border-t border-slate-200">
                    <button 
                        type="submit" 
                        class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                        </svg>
                        Save Settings
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
async function removeImage(field) {
    if (!confirm('Are you sure you want to remove this image?')) {
        return;
    }

    try {
        const response = await fetch('{{ route('backend.settings.remove-image') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ field: field })
        });

        const data = await response.json();

        if (data.success) {
            location.reload();
        } else {
            alert('Failed to remove image');
        }
    } catch (error) {
        alert('Error: ' + error.message);
    }
}
</script>
@endsection
