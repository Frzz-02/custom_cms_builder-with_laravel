@foreach($files as $item)
    @if($item['type'] === 'directory')
        <div class="border border-gray-700 rounded overflow-hidden bg-gray-900 mt-1">
            <button onclick="toggleFolder(this)" class="w-full flex items-center p-2 hover:bg-gray-700 transition-colors">
                <svg class="w-3 h-3 mr-2 text-blue-400 folder-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <svg class="w-3 h-3 mr-2 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                </svg>
                <span class="text-xs font-medium text-gray-200">{{ $item['name'] }}</span>
            </button>
            <div class="folder-content hidden pl-3">
                @include('backend.theme-editor.partials.file-tree-small', ['files' => $item['children'], 'level' => $level + 1, 'currentFile' => $currentFile])
            </div>
        </div>
    @else
        <a href="{{ route('backend.theme-editor.edit', ['file' => $item['path']]) }}" 
           class="flex items-center p-2 rounded hover:bg-gray-700 transition-colors mt-1 {{ $currentFile === $item['path'] ? 'bg-blue-600 text-white' : 'text-gray-300' }}">
            <svg class="w-3 h-3 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
            </svg>
            <span class="text-xs truncate">{{ $item['name'] }}</span>
        </a>
    @endif
@endforeach
