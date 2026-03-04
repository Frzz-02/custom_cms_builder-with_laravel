@extends('backend.app.layout')

@section('title', 'Edit Theme File')

@push('styles')
<style>
    body { overflow: hidden; }
    #monaco-editor {
        width: 100%;
        height: 100%;
    }
</style>
@endpush

@section('content')
<div class="h-screen flex flex-col" x-data="themeEditor()">
    <!-- Top Bar -->
    <div class="bg-gray-900 border-b border-gray-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('backend.theme-editor.index') }}" class="inline-flex items-center text-gray-300 hover:text-white">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Back to Files
                </a>
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                    </svg>
                    <h1 class="text-xl font-semibold text-white">{{ $relativePath }}</h1>
                </div>
            </div>
            
            <div class="flex items-center space-x-3">
                <!-- Save Status -->
                <div x-show="saveStatus" x-transition class="text-sm" :class="saveStatusClass">
                    <span x-text="saveMessage"></span>
                </div>
                
                <!-- Save Button -->
                <button 
                    @click="saveFile"
                    :disabled="saving"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 disabled:bg-blue-400 text-white rounded-lg transition-colors"
                    :class="{ 'opacity-50 cursor-not-allowed': saving }"
                >
                    <svg x-show="!saving" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                    </svg>
                    <svg x-show="saving" class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span x-text="saving ? 'Saving...' : 'Save Changes'"></span>
                </button>
            </div>
        </div>
    </div>

    <!-- Editor Container -->
    <div class="flex-1 overflow-hidden">
        <div class="grid grid-cols-12 h-full">
            <!-- File Browser Sidebar -->
            <div class="col-span-3 bg-gray-800 border-r border-gray-700 overflow-y-auto">
                <div class="p-4">
                    <h3 class="text-sm font-semibold text-gray-200 mb-3 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                        </svg>
                        Files
                    </h3>
                    <div class="space-y-1">
                        @if(count($files) > 0)
                            @foreach($files as $item)
                                @if($item['type'] === 'directory')
                                    <div class="border border-gray-700 rounded overflow-hidden bg-gray-900">
                                        <button onclick="toggleFolder(this)" class="w-full flex items-center p-2 hover:bg-gray-700 transition-colors">
                                            <svg class="w-4 h-4 mr-2 text-blue-400 folder-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                            <svg class="w-4 h-4 mr-2 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                                            </svg>
                                            <span class="text-sm font-medium text-gray-200">{{ $item['name'] }}</span>
                                        </button>
                                        <div class="folder-content hidden pl-4">
                                            @include('backend.theme-editor.partials.file-tree-small', ['files' => $item['children'], 'level' => 1, 'currentFile' => $relativePath])
                                        </div>
                                    </div>
                                @else
                                    <a href="{{ route('backend.theme-editor.edit', ['file' => $item['path']]) }}" 
                                       class="flex items-center p-2 rounded hover:bg-gray-700 transition-colors {{ $relativePath === $item['path'] ? 'bg-blue-600 text-white' : 'text-gray-300' }}">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                        </svg>
                                        <span class="text-sm truncate">{{ $item['name'] }}</span>
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <!-- Code Editor -->
            <div class="col-span-9 bg-gray-900 overflow-hidden flex flex-col">
                <div class="flex-1 overflow-hidden">
                    <!-- Monaco Editor Container -->
                    <div id="monaco-editor"></div>
                </div>

                <!-- Status Bar -->
                <div class="bg-blue-600 border-t border-gray-700 px-4 py-2 flex items-center justify-between text-xs text-white">
                    <div class="flex items-center space-x-4">
                        <span>File: <strong>{{ $relativePath }}</strong></span>
                        <span x-show="contentChanged" class="text-yellow-300">● Unsaved changes</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span>Lines: <strong x-text="lineCount"></strong></span>
                        <span>Characters: <strong x-text="charCount"></strong></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Monaco Editor CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.45.0/min/vs/loader.min.js"></script>

<script>
let monacoEditor;

function themeEditor() {
    return {
        editorContent: '',
        originalContent: @json($content),
        contentChanged: false,
        saving: false,
        saveStatus: false,
        saveMessage: '',
        saveStatusClass: '',
        
        get lineCount() {
            return monacoEditor ? monacoEditor.getModel().getLineCount() : 0;
        },
        
        get charCount() {
            return this.editorContent.length;
        },
        
        async saveFile() {
            if (this.saving) return;
            
            this.saving = true;
            this.saveStatus = false;
            
            // Get content from Monaco Editor
            this.editorContent = monacoEditor.getValue();
            
            try {
                const response = await fetch('{{ route('backend.theme-editor.update') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        file: '{{ $relativePath }}',
                        content: this.editorContent
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    this.originalContent = this.editorContent;
                    this.contentChanged = false;
                    this.showSaveStatus('success', data.message || 'File saved successfully!');
                } else {
                    this.showSaveStatus('error', data.message || 'Failed to save file');
                }
            } catch (error) {
                this.showSaveStatus('error', 'Error: ' + error.message);
            } finally {
                this.saving = false;
            }
        },
        
        showSaveStatus(type, message) {
            this.saveStatus = true;
            this.saveMessage = message;
            this.saveStatusClass = type === 'success' 
                ? 'text-green-400' 
                : 'text-red-400';
            
            setTimeout(() => {
                this.saveStatus = false;
            }, 3000);
        },
        
        init() {
            const self = this;
            
            // Initialize Monaco Editor
            require.config({ 
                paths: { 
                    'vs': 'https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.45.0/min/vs' 
                } 
            });
            
            require(['vs/editor/editor.main'], function() {
                // Detect file language based on extension
                const fileName = '{{ $relativePath }}';
                let language = 'html';
                
                if (fileName.endsWith('.php') || fileName.endsWith('.blade.php')) {
                    language = 'php';
                } else if (fileName.endsWith('.js')) {
                    language = 'javascript';
                } else if (fileName.endsWith('.css')) {
                    language = 'css';
                } else if (fileName.endsWith('.json')) {
                    language = 'json';
                }
                
                // Create Monaco Editor
                monacoEditor = monaco.editor.create(document.getElementById('monaco-editor'), {
                    value: self.originalContent,
                    language: language,
                    theme: 'vs-dark',
                    automaticLayout: true,
                    fontSize: 14,
                    lineNumbers: 'on',
                    roundedSelection: false,
                    scrollBeyondLastLine: false,
                    minimap: {
                        enabled: true
                    },
                    wordWrap: 'on',
                    formatOnPaste: true,
                    formatOnType: true,
                    tabSize: 4,
                    insertSpaces: true,
                });
                
                // Track content changes
                monacoEditor.onDidChangeModelContent(() => {
                    self.editorContent = monacoEditor.getValue();
                    self.contentChanged = self.editorContent !== self.originalContent;
                });
                
                // Keyboard shortcut: Ctrl+S or Cmd+S to save
                monacoEditor.addCommand(monaco.KeyMod.CtrlCmd | monaco.KeyCode.KeyS, () => {
                    self.saveFile();
                });
            });
            
            // Warn before leaving with unsaved changes
            window.addEventListener('beforeunload', (e) => {
                if (this.contentChanged) {
                    e.preventDefault();
                    e.returnValue = '';
                }
            });
        }
    }
}

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
