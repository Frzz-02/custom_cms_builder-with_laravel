@foreach($files as $item)
    @if($item['type'] === 'directory')
        <div class="border border-gray-200 rounded-lg overflow-hidden mt-2" style="margin-left: {{ $level * 1 }}rem;">
            <button onclick="toggleFolder(this)" class="w-full flex items-center justify-between p-3 bg-gray-50 hover:bg-gray-100 transition-colors">
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-2 text-blue-500 folder-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    <svg class="w-4 h-4 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                    </svg>
                    <span class="text-sm font-medium text-gray-700">{{ $item['name'] }}/</span>
                </div>
            </button>
            <div class="folder-content hidden pl-4 pr-3 pb-3">
                @include('backend.theme-editor.partials.file-tree', ['files' => $item['children'], 'level' => $level + 1])
            </div>
        </div>
    @else
        <a href="{{ route('backend.theme-editor.edit', ['file' => $item['path']]) }}" class="flex items-center p-2 border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition-colors group mt-2" style="margin-left: {{ $level * 1 }}rem;">
            <svg class="w-4 h-4 mr-2 text-gray-400 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
            </svg>
            <span class="text-sm text-gray-700 group-hover:text-blue-700">{{ $item['name'] }}</span>
            @if(isset($item['extension']))
                <span class="ml-auto text-xs text-gray-400 bg-gray-100 px-2 py-1 rounded">{{ $item['extension'] }}</span>
            @endif
        </a>
    @endif
@endforeach
