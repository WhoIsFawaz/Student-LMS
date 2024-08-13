<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Module;
use App\Models\Favourite;
use App\Models\ModuleFolder;
use Illuminate\Http\Request;
use App\Models\ModuleContent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class ProfessorModuleContentController extends Controller
{
    public function index($module_id)
    {
        $module = Module::findOrFail($module_id);
        $folders = ModuleFolder::where('module_id', $module_id)->with('contents')->get();
        return view('professor.content.index', compact('module', 'folders', 'module_id'));
    }

    public function show($module_id, $content_id)
    {
        $module = Module::findOrFail($module_id);
        $content = ModuleContent::findOrFail($content_id);
        return view('professor.content.show', compact('module', 'content', 'module_id'));
    }

    // Method to show form to create new content
    public function create($module_id)
    {
        Log::info("Creating content for module: $module_id");
        $module = Module::findOrFail($module_id);
        $folders = ModuleFolder::where('module_id', $module_id)->get();
        return view('professor.content.create_content', compact('module', 'folders', 'module_id'));
    }

    public function store(Request $request, $module_id)
    {
        // Validate the incoming request data
        $request->validate([
            'module_folder_id' => 'required|exists:module_folders,module_folder_id', 
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file_path' => 'nullable|file',
        ]);

        // Initialize the $filePath variable
        $filePath = null;

        // Check if the file is present
        if ($request->hasFile('file_path')) {
            // Get the original file name
            $originalFileName = $request->file('file_path')->getClientOriginalName();

            // Store the file with the original name in the 'contents' directory
            $filePath = $request->file('file_path')->storeAs('contents', $originalFileName, 'public');
        }

        // Create a new ModuleContent record in the database
        ModuleContent::create([
            'module_folder_id' => $request->module_folder_id, 
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $filePath,
            'upload_date' => now(), 
        ]);

        // Redirect to the module content index page with a success message
        return redirect()->route('modules.professor.content.index', ['module_id' => $module_id])
            ->with('success', 'Content created successfully.');
    }



    public function edit($module_id, $content_id)
    {
        $module = Module::findOrFail($module_id);
        $content = ModuleContent::findOrFail($content_id);
        $folders = ModuleFolder::where('module_id', $module_id)->get();
        return view('professor.content.edit_content', compact('module', 'content', 'folders', 'module_id'));
    }

    public function update(Request $request, $module_id, $content_id)
    {
        $request->validate([
            'module_folder_id' => 'required|exists:module_folders,module_folder_id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file_path' => 'nullable|file',
        ]);
    
        $content = ModuleContent::findOrFail($content_id);
    
        // Initialize the $data array with the updated values
        $data = [
            'module_folder_id' => $request->module_folder_id,
            'title' => $request->title,
            'description' => $request->description,
        ];
    
        // Check if a new file is uploaded
        if ($request->hasFile('file_path')) {
            // Delete the old file if it exists
            if ($content->file_path && Storage::exists($content->file_path)) {
                Storage::delete($content->file_path);
            }
    
            // Store the new file with its original name
            $originalFileName = $request->file('file_path')->getClientOriginalName();
            $data['file_path'] = $request->file('file_path')->storeAs('contents', time() . '_' . $originalFileName, 'public');
        }
    
        // Update the content record in the database
        $content->update($data);
    
        return redirect()->route('modules.professor.content.index', ['module_id' => $module_id])
            ->with('success', 'Content updated successfully.');
    }
    
    public function viewContent($module_id, $content_id)
    {
        $content = ModuleContent::findOrFail($content_id);
        $path = storage_path('app/' . $content->file_path);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->file($path);
    }

    public function destroy($module_id, $content_id)
    {
        $content = ModuleContent::findOrFail($content_id);
    
        // Delete the file from storage if it exists
        if ($content->file_path && Storage::exists($content->file_path)) {
            Storage::delete($content->file_path);
        }
    
        // Delete the content record from the database
        $content->delete();
    
        return redirect()->route('modules.professor.content.index', ['module_id' => $module_id])
            ->with('success', 'Content deleted successfully.');
    }
    

    
}