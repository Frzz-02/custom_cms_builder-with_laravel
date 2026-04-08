@extends('backend.app.layout')

@section('title', 'Edit Team Member')

@section('content')
<div class="p-6">
    <div class="max-w-5xl mx-auto">
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6 mb-6">
            <div class="flex items-center gap-4">
                <a href="{{ route('backend.teams.index') }}"
                   class="text-slate-600 hover:text-slate-800 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">Edit Team Member</h1>
                    <p class="text-slate-600 mt-1">Update section team data</p>
                </div>
            </div>
        </div>

        <form action="{{ route('backend.teams.update', $team) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-12 gap-6">
                <div class="col-span-8">
                    <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6 space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">Name</label>
                            <input type="text"
                                   id="name"
                                   name="name"
                                   value="{{ old('name', $team->name) }}"
                                   class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                   placeholder="e.g., John Doe">
                            @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="position" class="block text-sm font-semibold text-slate-700 mb-2">Position</label>
                            <input type="text"
                                   id="position"
                                   name="position"
                                   value="{{ old('position', $team->position) }}"
                                   class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                   placeholder="e.g., Marketing Manager">
                            @error('position')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div data-media-picker
                             data-field-name="image"
                             data-field-id="team_image"
                             data-label="Profile Image"
                             data-placeholder="https://example.com/image.webp"
                             data-initial-value="{{ old('image', $team->image) }}">
                            @include('backend.components.media-picker-input')
                            @error('image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Select from media library or enter custom URL.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="link_profile_1" class="block text-sm font-semibold text-slate-700 mb-2">Profile Link 1</label>
                                <input type="url"
                                       id="link_profile_1"
                                       name="link_profile_1"
                                       value="{{ old('link_profile_1', $team->link_profile_1) }}"
                                       class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                       placeholder="https://...">
                                @error('link_profile_1')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="link_profile_2" class="block text-sm font-semibold text-slate-700 mb-2">Profile Link 2</label>
                                <input type="url"
                                       id="link_profile_2"
                                       name="link_profile_2"
                                       value="{{ old('link_profile_2', $team->link_profile_2) }}"
                                       class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                       placeholder="https://...">
                                @error('link_profile_2')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="link_profile_3" class="block text-sm font-semibold text-slate-700 mb-2">Profile Link 3</label>
                                <input type="url"
                                       id="link_profile_3"
                                       name="link_profile_3"
                                       value="{{ old('link_profile_3', $team->link_profile_3) }}"
                                       class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                       placeholder="https://...">
                                @error('link_profile_3')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="link_profile_4" class="block text-sm font-semibold text-slate-700 mb-2">Profile Link 4</label>
                                <input type="url"
                                       id="link_profile_4"
                                       name="link_profile_4"
                                       value="{{ old('link_profile_4', $team->link_profile_4) }}"
                                       class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                       placeholder="https://...">
                                @error('link_profile_4')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-span-4">
                    <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6 space-y-6 sticky top-24">
                        <div>
                            <label for="status" class="block text-sm font-semibold text-slate-700 mb-2">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select id="status"
                                    name="status"
                                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                    required>
                                <option value="active" {{ old('status', $team->status) === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $team->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <hr class="border-slate-200">

                        <div class="space-y-3">
                            <button type="submit"
                                    class="w-full px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium transition-colors flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Update Team Member
                            </button>
                            <a href="{{ route('backend.teams.index') }}"
                               class="w-full px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg font-medium transition-colors text-center block">
                                Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@include('backend.components.media-picker-modal')
@endsection
