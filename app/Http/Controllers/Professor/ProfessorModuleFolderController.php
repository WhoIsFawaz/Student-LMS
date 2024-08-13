<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\ModuleFolder;
use Illuminate\Http\Request;

class ProfessorModuleFolderController extends Controller
{

    /**
     * Show the form for creating a new resource.
     */
    public function create($module_id)
    {
        $module = Module::findOrFail($module_id);
        return view('professor.content.create_folder', compact('module', 'module_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $module_id)
    {
        $request->validate([
            'folder_name' => 'required|string|max:255',
        ]);

        ModuleFolder::create([
            'module_id' => $module_id,
            'folder_name' => $request->folder_name,
        ]);

        return redirect()->route('modules.professor.content.index', ['module_id' => $module_id])
            ->with('success', 'Folder created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($module_id, $folder_id)
    {
        $module = Module::findOrFail($module_id);
        $folder = ModuleFolder::findOrFail($folder_id);
        return view('professor.content.edit_folder', compact('module', 'folder', 'module_id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $module_id, $folder_id)
    {
        $request->validate([
            'folder_name' => 'required|string|max:255',
        ]);

        $folder = ModuleFolder::findOrFail($folder_id);
        $folder->update([
            'folder_name' => $request->folder_name,
        ]);

        return redirect()->route('modules.professor.content.index', ['module_id' => $module_id])
            ->with('success', 'Folder updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($module_id, $folder_id)
    {
        $folder = ModuleFolder::findOrFail($folder_id);
        $folder->delete();

        return redirect()->route('modules.professor.content.index', ['module_id' => $module_id])
            ->with('success', 'Folder deleted successfully.');
    }
}
