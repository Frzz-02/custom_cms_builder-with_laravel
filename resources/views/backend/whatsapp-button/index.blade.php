@extends('backend.app.layout')

@section('title', 'WhatsApp Button Configuration')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6 mb-6">
        <h1 class="text-2xl font-bold text-slate-800">WhatsApp Button Configuration</h1>
        <p class="text-slate-600 mt-1">Configure the floating WhatsApp button for your website</p>
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
    <form action="{{ route('backend.whatsapp-button.store') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-12 gap-6">
            <!-- Main Content -->
            <div class="col-span-8">
                <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6 space-y-6">
                    <!-- Phone Number -->
                    <div>
                        <label for="phone_number" class="block text-sm font-semibold text-slate-700 mb-2">
                            Phone Number <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="phone_number" 
                               name="phone_number" 
                               value="{{ old('phone_number', $whatsappButton->phone_number ?? '') }}"
                               class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('phone_number') border-red-500 @enderror"
                               placeholder="e.g., +628123456789"
                               required>
                        <p class="mt-1 text-xs text-slate-500">Include country code (e.g., +62 for Indonesia)</p>
                        @error('phone_number')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Message -->
                    <div>
                        <label for="message" class="block text-sm font-semibold text-slate-700 mb-2">
                            Default Message <span class="text-red-500">*</span>
                        </label>
                        <textarea id="message" 
                                  name="message" 
                                  rows="4"
                                  class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('message') border-red-500 @enderror"
                                  placeholder="e.g., Hello, I'm interested in your services..."
                                  required>{{ old('message', $whatsappButton->message ?? '') }}</textarea>
                        <p class="mt-1 text-xs text-slate-500">This message will be pre-filled when users click the WhatsApp button</p>
                        @error('message')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Position -->
                    <div>
                        <label for="position" class="block text-sm font-semibold text-slate-700 mb-2">
                            Position <span class="text-red-500">*</span>
                        </label>
                        <select id="position" 
                                name="position" 
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('position') border-red-500 @enderror"
                                required>
                            <option value="bottom-right" {{ old('position', $whatsappButton->position ?? 'bottom-right') === 'bottom-right' ? 'selected' : '' }}>Bottom Right</option>
                            <option value="bottom-left" {{ old('position', $whatsappButton->position ?? '') === 'bottom-left' ? 'selected' : '' }}>Bottom Left</option>
                            <option value="top-right" {{ old('position', $whatsappButton->position ?? '') === 'top-right' ? 'selected' : '' }}>Top Right</option>
                            <option value="top-left" {{ old('position', $whatsappButton->position ?? '') === 'top-left' ? 'selected' : '' }}>Top Left</option>
                        </select>
                        <p class="mt-1 text-xs text-slate-500">Choose where the button appears on the screen</p>
                        @error('position')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Offset Configuration -->
                    <div class="grid grid-cols-2 gap-4">
                        <!-- Offset X -->
                        <div>
                            <label for="offset_x" class="block text-sm font-semibold text-slate-700 mb-2">
                                Offset X (Horizontal) <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="number" 
                                       id="offset_x" 
                                       name="offset_x" 
                                       value="{{ old('offset_x', $whatsappButton->offset_x ?? 20) }}"
                                       class="w-full px-4 py-2 pr-12 border border-slate-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('offset_x') border-red-500 @enderror"
                                       required>
                                <span class="absolute right-3 top-2 text-slate-500 text-sm">px</span>
                            </div>
                            <p class="mt-1 text-xs text-slate-500">Distance from left/right edge</p>
                            @error('offset_x')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Offset Y -->
                        <div>
                            <label for="offset_y" class="block text-sm font-semibold text-slate-700 mb-2">
                                Offset Y (Vertical) <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="number" 
                                       id="offset_y" 
                                       name="offset_y" 
                                       value="{{ old('offset_y', $whatsappButton->offset_y ?? 20) }}"
                                       class="w-full px-4 py-2 pr-12 border border-slate-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('offset_y') border-red-500 @enderror"
                                       required>
                                <span class="absolute right-3 top-2 text-slate-500 text-sm">px</span>
                            </div>
                            <p class="mt-1 text-xs text-slate-500">Distance from top/bottom edge</p>
                            @error('offset_y')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Visual Preview Helper -->
                    <div class="bg-slate-50 border border-slate-200 rounded-lg p-4">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-slate-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            <div class="text-sm text-slate-700">
                                <p class="font-semibold mb-1">Position Preview</p>
                                <p>The button will appear at the selected position with the specified offset values. Standard offset is 20px from screen edges.</p>
                            </div>
                        </div>
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
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                required>
                            <option value="active" {{ old('status', $whatsappButton->status ?? 'active') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $whatsappButton->status ?? '') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        <p class="mt-1 text-xs text-slate-500">Button will only show when active</p>
                        @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <hr class="border-slate-200">

                    <!-- Current Status Info -->
                    @if($whatsappButton)
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                        <p class="text-xs font-semibold text-blue-800 mb-1">Current Configuration</p>
                        <p class="text-xs text-blue-700">Updating existing settings</p>
                    </div>
                    @else
                    <div class="bg-green-50 border border-green-200 rounded-lg p-3">
                        <p class="text-xs font-semibold text-green-800 mb-1">New Configuration</p>
                        <p class="text-xs text-green-700">Creating new WhatsApp button</p>
                    </div>
                    @endif

                    <hr class="border-slate-200">

                    <!-- Actions -->
                    <div class="space-y-3">
                        <button type="submit" 
                                class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                            </svg>
                            {{ $whatsappButton ? 'Update Configuration' : 'Save Configuration' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
