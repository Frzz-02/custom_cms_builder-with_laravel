@extends('backend.app.layout')

@section('title', 'Newsletter Settings')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6 mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Newsletter Form Settings</h1>
        <p class="text-slate-600 mt-1">Configure the newsletter subscription form</p>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    <!-- Form -->
    <form action="{{ route('backend.newsletter.settings.store') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-12 gap-6">
            <!-- Main Content -->
            <div class="col-span-8">
                <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6 space-y-6">
                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-semibold text-slate-700 mb-2">
                            Title
                        </label>
                        <input type="text" 
                               id="title" 
                               name="title" 
                               value="{{ old('title', $newsletterSettings->title ?? '') }}"
                               class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('title') border-red-500 @enderror"
                               placeholder="e.g., Subscribe to Our Newsletter">
                        @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Subtitle -->
                    <div>
                        <label for="subtitle" class="block text-sm font-semibold text-slate-700 mb-2">
                            Subtitle
                        </label>
                        <input type="text" 
                               id="subtitle" 
                               name="subtitle" 
                               value="{{ old('subtitle', $newsletterSettings->subtitle ?? '') }}"
                               class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('subtitle') border-red-500 @enderror"
                               placeholder="e.g., Get the latest updates and offers">
                        @error('subtitle')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Action Label (Button Text) -->
                    <div>
                        <label for="action_label" class="block text-sm font-semibold text-slate-700 mb-2">
                            Button Text
                        </label>
                        <input type="text" 
                               id="action_label" 
                               name="action_label" 
                               value="{{ old('action_label', $newsletterSettings->action_label ?? '') }}"
                               class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('action_label') border-red-500 @enderror"
                               placeholder="e.g., Subscribe Now">
                        @error('action_label')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Placeholder -->
                    <div>
                        <label for="placeholder" class="block text-sm font-semibold text-slate-700 mb-2">
                            Input Placeholder
                        </label>
                        <input type="text" 
                               id="placeholder" 
                               name="placeholder" 
                               value="{{ old('placeholder', $newsletterSettings->placeholder ?? '') }}"
                               class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('placeholder') border-red-500 @enderror"
                               placeholder="e.g., Enter your email address">
                        @error('placeholder')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-span-4">
                <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6 space-y-6 sticky top-24">
                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-semibold text-slate-700 mb-2">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select id="status" 
                                name="status" 
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                required>
                            <option value="active" {{ old('status', $newsletterSettings->status ?? 'active') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $newsletterSettings->status ?? '') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        <p class="mt-1 text-xs text-slate-500">Form will only show when active</p>
                    </div>

                    <hr class="border-slate-200">

                    <!-- Current Status Info -->
                    @if($newsletterSettings)
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                        <p class="text-xs font-semibold text-blue-800 mb-1">Current Configuration</p>
                        <p class="text-xs text-blue-700">Updating existing settings</p>
                    </div>
                    @else
                    <div class="bg-green-50 border border-green-200 rounded-lg p-3">
                        <p class="text-xs font-semibold text-green-800 mb-1">New Configuration</p>
                        <p class="text-xs text-green-700">Creating newsletter form settings</p>
                    </div>
                    @endif

                    <hr class="border-slate-200">

                    <!-- Actions -->
                    <div class="space-y-3">
                        <button type="submit" 
                                class="w-full px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium transition-colors flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            {{ $newsletterSettings ? 'Update Settings' : 'Save Settings' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
