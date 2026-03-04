@extends('backend.app.layout')

@section('title', 'Edit Contact')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6 mb-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('backend.contacts.index') }}" 
               class="text-slate-600 hover:text-slate-800 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Edit Contact</h1>
                <p class="text-slate-600 mt-1">Update contact information</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <form action="{{ route('backend.contacts.update', $contact) }}" method="POST">
        @csrf
        @method('PUT')
        
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
                               value="{{ old('title', $contact->title) }}"
                               class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('title') border-red-500 @enderror"
                               placeholder="e.g., Customer Service">
                        @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Contact 1 -->
                    <div>
                        <label for="contact_1" class="block text-sm font-semibold text-slate-700 mb-2">
                            Contact 1
                        </label>
                        <input type="text" 
                               id="contact_1" 
                               name="contact_1" 
                               value="{{ old('contact_1', $contact->contact_1) }}"
                               class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('contact_1') border-red-500 @enderror"
                               placeholder="e.g., +1234567890 or email@example.com">
                        @error('contact_1')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Contact 2 -->
                    <div>
                        <label for="contact_2" class="block text-sm font-semibold text-slate-700 mb-2">
                            Contact 2
                        </label>
                        <input type="text" 
                               id="contact_2" 
                               name="contact_2" 
                               value="{{ old('contact_2', $contact->contact_2) }}"
                               class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('contact_2') border-red-500 @enderror"
                               placeholder="Alternative contact">
                        @error('contact_2')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Contact 3 -->
                    <div>
                        <label for="contact_3" class="block text-sm font-semibold text-slate-700 mb-2">
                            Contact 3
                        </label>
                        <input type="text" 
                               id="contact_3" 
                               name="contact_3" 
                               value="{{ old('contact_3', $contact->contact_3) }}"
                               class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('contact_3') border-red-500 @enderror"
                               placeholder="Additional contact">
                        @error('contact_3')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Icon -->
                    <div>
                        <label for="icon" class="block text-sm font-semibold text-slate-700 mb-2">
                            Icon Class
                        </label>
                        <input type="text" 
                               id="icon" 
                               name="icon" 
                               value="{{ old('icon', $contact->icon) }}"
                               class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('icon') border-red-500 @enderror"
                               placeholder="e.g., fas fa-phone">
                        <p class="mt-1 text-xs text-slate-500">FontAwesome icon class (e.g., fas fa-phone, fas fa-envelope)</p>
                        @error('icon')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Background -->
                    <div>
                        <label for="background" class="block text-sm font-semibold text-slate-700 mb-2">
                            Background Color
                        </label>
                        <input type="text" 
                               id="background" 
                               name="background" 
                               value="{{ old('background', $contact->background) }}"
                               class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('background') border-red-500 @enderror"
                               placeholder="e.g., #3b82f6 or blue-500">
                        <p class="mt-1 text-xs text-slate-500">Hex color code or Tailwind color class</p>
                        @error('background')
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
                            <option value="active" {{ old('status', $contact->status) === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $contact->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <hr class="border-slate-200">

                    <!-- Actions -->
                    <div class="space-y-3">
                        <button type="submit" 
                                class="w-full px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium transition-colors flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Update Contact
                        </button>
                        <a href="{{ route('backend.contacts.index') }}" 
                           class="w-full px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg font-medium transition-colors text-center block">
                            Cancel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
