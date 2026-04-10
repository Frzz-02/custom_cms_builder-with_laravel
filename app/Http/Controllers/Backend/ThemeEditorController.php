<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use App\Models\Setting;


class ThemeEditorController extends Controller
{
    protected $basePath;
    protected $allowedPath;

    public function __construct()
    {
        // Set base path to resources/views/frontend
        $this->basePath = resource_path('views/frontend');
        $this->allowedPath = 'resources/views/frontend';
    }

    /**
     * Check if user has superadmin role
     */
    protected function checkSuperAdmin()
    {
        $user = Auth::user();
        if (!$user || !$user->role || $user->role->name !== 'superadmin') {
            abort(403, 'Unauthorized. Only superadmin can access this feature.');
        }
    }

    /**
     * Display theme file editor
     */
    public function index()
    {
        $this->checkSuperAdmin();

        $files = $this->getFileTree($this->basePath);
        $settings = Setting::first();
        return view('backend.theme-editor.index', compact('files', 'settings'));
    }

    /**
     * Show file content for editing
     */
    public function edit(Request $request)
    {
        $this->checkSuperAdmin();
        $settings = Setting::first();
        $relativePath = $request->get('file');
        
        if (!$relativePath) {
            return redirect()->route('backend.theme-editor.index')
                ->with('error', 'No file specified.');
        }

        // Security check: ensure file is within allowed directory
        $filePath = $this->basePath . '/' . $relativePath;
        $realPath = realpath($filePath);
        
        if (!$realPath || !str_starts_with($realPath, realpath($this->basePath))) {
            abort(403, 'Access denied. File is outside allowed directory.');
        }

        if (!File::exists($filePath)) {
            return redirect()->route('backend.theme-editor.index')
                ->with('error', 'File not found.');
        }

        if (!File::isFile($filePath)) {
            return redirect()->route('backend.theme-editor.index')
                ->with('error', 'Not a valid file.');
        }

        $content = File::get($filePath);
        $files = $this->getFileTree($this->basePath);
        
        return view('backend.theme-editor.edit', compact('content', 'relativePath', 'files', 'settings'));
    }

    /**
     * Update file content
     */
    public function update(Request $request)
    {
        $this->checkSuperAdmin();

        $request->validate([
            'file' => 'required|string',
            'content' => 'required|string',
        ]);

        $relativePath = $request->input('file');
        $content = $request->input('content');
        
        // Security check: ensure file is within allowed directory
        $filePath = $this->basePath . '/' . $relativePath;
        $realPath = realpath($filePath);
        
        if (!$realPath || !str_starts_with($realPath, realpath($this->basePath))) {
            return response()->json([
                'success' => false,
                'message' => 'Access denied. File is outside allowed directory.'
            ], 403);
        }

        if (!File::exists($filePath)) {
            return response()->json([
                'success' => false,
                'message' => 'File not found.'
            ], 404);
        }

        try {
            File::put($filePath, $content);
            
            return response()->json([
                'success' => true,
                'message' => 'File saved successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save file: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get file tree structure
     */
    protected function getFileTree($directory, $prefix = '')
    {
        $files = [];
        
        if (!File::isDirectory($directory)) {
            return $files;
        }

        $items = File::allFiles($directory);
        $directories = File::directories($directory);

        // Add directories first
        foreach ($directories as $dir) {
            $dirName = basename($dir);
            $relativePath = $prefix ? $prefix . '/' . $dirName : $dirName;
            
            $files[] = [
                'name' => $dirName,
                'path' => $relativePath,
                'type' => 'directory',
                'children' => $this->getFileTree($dir, $relativePath)
            ];
        }

        // Add files
        foreach ($items as $file) {
            $fileName = $file->getFilename();
            $fileDir = dirname($file->getPathname());
            
            // Only add files that are direct children of this directory
            if ($fileDir === $directory) {
                $relativePath = $prefix ? $prefix . '/' . $fileName : $fileName;
                
                $files[] = [
                    'name' => $fileName,
                    'path' => $relativePath,
                    'type' => 'file',
                    'extension' => $file->getExtension()
                ];
            }
        }

        return $files;
    }

    /**
     * Get list of files only (flat structure)
     */
    public function getFiles()
    {
        $this->checkSuperAdmin();

        $files = $this->getAllFiles($this->basePath);
        
        return response()->json(['files' => $files]);
    }

    /**
     * Get all files recursively (flat list)
     */
    protected function getAllFiles($directory, $prefix = '')
    {
        $result = [];
        
        if (!File::isDirectory($directory)) {
            return $result;
        }

        $items = File::allFiles($directory);

        foreach ($items as $file) {
            $relativePath = str_replace($this->basePath . DIRECTORY_SEPARATOR, '', $file->getPathname());
            $relativePath = str_replace('\\', '/', $relativePath);
            
            $result[] = [
                'name' => $file->getFilename(),
                'path' => $relativePath,
                'size' => $file->getSize(),
                'modified' => date('Y-m-d H:i:s', $file->getMTime())
            ];
        }

        return $result;
    }
}
