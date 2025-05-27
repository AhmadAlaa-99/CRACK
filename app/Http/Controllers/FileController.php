<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileController extends Controller
{
    /**
     * Display a listing of the files.
     */
    public function index()
    {
        $files = File::where('user_id', Auth::id())->latest()->paginate(10);
        $plans = Plan::all(); // Get all plans for dropdown selection
        return view('admin.files.index', compact('files', 'plans'));
    }

    /**
     * Store a newly created file in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // 10MB max file size
            'description' => 'nullable|string|max:500',
            'plan_id' => 'nullable|exists:plans,id',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $size = $file->getSize();
            $mimeType = $file->getMimeType();

            // Generate a unique filename
            $filename = Str::random(40) . '.' . $extension;

            // Store the file in the storage directory
            $path = $file->storeAs('uploads', $filename, 'public');
              $paln=Plan::create([
                'name' => pathinfo($originalName, PATHINFO_FILENAME),
                'price' => 5,
                'file_path' => $path,
            ]);
            
            // Create file record in database
            File::create([
                'name' => pathinfo($originalName, PATHINFO_FILENAME),
                'original_name' => $originalName,
                'path' => $path,
                'extension' => $extension,
                'size' => $size,
                'mime_type' => $mimeType,
                'description' => $request->description,
                'plan_id' => $paln->id,
                'user_id' => Auth::id(),
            ]);
            
            

            return redirect()->route('files.index')
                ->with('success', 'File uploaded successfully');
        }

        return back()->with('error', 'No file was uploaded');
    }

    /**
     * Get file details for AJAX request.
     */
    public function getFile(File $file)
    {
        // Check if the user owns this file
        if ($file->user_id !== Auth::id() && !Auth::user()->hasRole('admin')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json($file);
    }

    /**
     * Update the specified file in storage.
     */
    public function update(Request $request, File $file)
    {
        // Check if the user owns this file
        if ($file->user_id !== Auth::id() && !Auth::user()->hasRole('admin')) {
            return redirect()->route('files.index')->with('error', 'Unauthorized access');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'plan_id' => 'nullable|exists:plans,id',
            'new_file' => 'nullable|file|max:10240', // Optional new file upload
        ]);

        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'plan_id' => $request->plan_id,
        ];

        // Check if a new file is being uploaded
        if ($request->hasFile('new_file')) {
            // Delete the old file
            Storage::disk('public')->delete($file->path);

            // Process the new file
            $newFile = $request->file('new_file');
            $originalName = $newFile->getClientOriginalName();
            $extension = $newFile->getClientOriginalExtension();
            $size = $newFile->getSize();
            $mimeType = $newFile->getMimeType();

            // Generate a unique filename
            $filename = Str::random(40) . '.' . $extension;

            // Store the new file
            $path = $newFile->storeAs('uploads', $filename, 'public');

            // Update file data
            $data = array_merge($data, [
                'original_name' => $originalName,
                'path' => $path,
                'extension' => $extension,
                'size' => $size,
                'mime_type' => $mimeType,
            ]);
        }

        $file->update($data);

        return redirect()->route('files.index')
            ->with('success', 'File updated successfully');
    }

    /**
     * Remove the specified file from storage.
     */
    public function destroy(File $file)
    {
        // Check if the user owns this file
        if ($file->user_id !== Auth::id() && !Auth::user()->hasRole('admin')) {
            return redirect()->route('files.index')->with('error', 'Unauthorized access');
        }

        // Delete the file from storage
        Storage::disk('public')->delete($file->path);

        // Delete the database record
        $file->delete();

        return redirect()->route('files.index')
            ->with('success', 'File deleted successfully');
    }

    /**
     * Download the specified file.
     */
    public function download(File $file)
    {
        // Check if the user owns this file or is admin
        if ($file->user_id !== Auth::id() && !Auth::user()->hasRole('admin')) {
            return redirect()->route('files.index')->with('error', 'Unauthorized access');
        }

        return Storage::disk('public')->download($file->path, $file->original_name);
    }
}
