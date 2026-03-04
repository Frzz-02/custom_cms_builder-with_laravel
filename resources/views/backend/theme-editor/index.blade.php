@extends('backend.app.layout')

@section('title', 'Theme File Editor')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
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

    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-1">Theme File Editor</h1>
        <p class="text-gray-600 text-sm">Edit theme files directly from the admin panel. Only files in <code class="bg-gray-100 px-2 py-1 rounded text-xs">resources/views/frontend</code> can be edited.</p>
    </div>

    <!-- Warning Alert -->
    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-yellow-700">
                    <strong class="font-medium">Warning:</strong> Be careful when editing theme files. Incorrect changes may break your website. Always make backups before editing.
                </p>
            </div>
        </div>
    </div>

    <!-- File List Card -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Available Files</h2>
            <p class="text-sm text-gray-500 mt-1">Click on a file to edit it</p>
        </div>
        
        <div class="p-6">
            <div class="space-y-2">
                @if(count($files) > 0)
                    @foreach($files as $item)
                        @if($item['type'] === 'directory')
                            <div class="border border-gray-200 rounded-lg overflow-hidden">
                                <button onclick="toggleFolder(this)" class="w-full flex items-center justify-between p-3 bg-gray-50 hover:bg-gray-100 transition-colors">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-blue-500 folder-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                        <svg class="w-5 h-5 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                                        </svg>
                                        <span class="font-medium text-gray-700">{{ $item['name'] }}/</span>
                                    </div>
                                </button>
                                <div class="folder-content hidden pl-8 pr-3 pb-3">
                                    @include('backend.theme-editor.partials.file-tree', ['files' => $item['children'], 'level' => 1])
                                </div>
                            </div>
                        @else
                            <a href="{{ route('backend.theme-editor.edit', ['file' => $item['path']]) }}" class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition-colors group">
                                <svg class="w-5 h-5 mr-2 text-gray-400 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                                <span class="text-gray-700 group-hover:text-blue-700">{{ $item['name'] }}</span>
                                @if(isset($item['extension']))
                                    <span class="ml-auto text-xs text-gray-400 bg-gray-100 px-2 py-1 rounded">{{ $item['extension'] }}</span>
                                @endif
                            </a>
                        @endif
                    @endforeach
                @else
                    <div class="text-center py-8 text-gray-500">
                        <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p>No files found</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Info Card -->
    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800">Information</h3>
                <div class="mt-2 text-sm text-blue-700">
                    <ul class="list-disc list-inside space-y-1">
                        <li>Only files in the <code class="bg-blue-100 px-1 rounded">resources/views/frontend</code> directory can be edited</li>
                        <li>You cannot create or delete files from this editor</li>
                        <li>This feature is only accessible to superadmin users</li>
                        <li>Changes are applied immediately after saving</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleFolder(button) {
    const content = button.nextElementSibling;
    const icon = button.querySelector('.folder-icon');
    
    if (content.classList.contains('hidden')) {
        content.classList.remove('hidden');
        icon.style.transform = 'rotate(90deg)';
    } else {
        content.classList.add('hidden');
        icon.style.transform = 'rotate(0deg)';
    }
}
</script>

<style>
.folder-icon {
    transition: transform 0.2s ease;
}
</style>
@endsection
