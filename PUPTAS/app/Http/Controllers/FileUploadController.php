<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserFile;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    public function uploadAll(Request $request)
    {
        // REQUIRED FILES (all must be uploaded)
        $request->validate([
            'email' => 'required|email|exists:users,email',

            'file10Front'   => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'file10Back'    => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'file11Front'   => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'file11'        => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'file12Front'   => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'file12'        => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',

            'fileId'        => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'fileNonEnroll' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'filePSA'       => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'fileGoodMoral' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'fileUnderOath' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'filePhoto2x2'  => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Get user by email
        $user = User::where('email', $request->email)->first();

        // Mapping form input → database type name
        $requiredFiles = [
            'file10Front'   => 'file10_front',
            'file10Back'    => 'file10_back',
            'file11Front'   => 'file11_front',
            'file11'        => 'file11_back',
            'file12Front'   => 'file12_front',
            'file12'        => 'file12_back',

            'fileId'        => 'school_id',
            'fileNonEnroll' => 'non_enroll_cert',
            'filePSA'       => 'psa',
            'fileGoodMoral' => 'good_moral',
            'fileUnderOath' => 'under_oath',
            'filePhoto2x2'  => 'photo_2x2',
        ];

        // Save all files
        foreach ($requiredFiles as $inputName => $type) {

            $file = $request->file($inputName);

            // Make unique filename
            $filename = time() . '_' . $file->getClientOriginalName();

            // Store file to storage/app/public/uploads
            $path = $file->storeAs('uploads', $filename, 'public');

            // Save file info to database
            UserFile::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'type'    => $type
                ],
                [
                    'file_path'     => $path,
                    'original_name' => $file->getClientOriginalName()
                ]
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'All required documents uploaded successfully.'
        ]);
    }

    /**
     * Compatibility wrapper: route expects `saveUploadedFile`.
     */
    public function saveUploadedFile(Request $request)
    {
        return $this->uploadAll($request);
    }
}
