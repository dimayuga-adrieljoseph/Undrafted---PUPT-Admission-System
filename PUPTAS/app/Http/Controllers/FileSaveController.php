<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileSaveController extends Controller
{
    public function saveUploadedFile(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240',
        ]);

        try {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('uploads', $filename, 'public');
            
            return [
                'success' => true,
                'message' => 'File uploaded successfully',
                'filename' => $filename,
                'path' => $path,
                'full_path' => storage_path('app/public/' . $path)
            ];
            
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'File upload failed: ' . $e->getMessage()
            ];
        }
    }
}