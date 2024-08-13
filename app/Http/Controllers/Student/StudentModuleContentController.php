<?php

namespace App\Http\Controllers\Student;

use App\Models\News;
use App\Models\Module;
use App\Models\Favourite;
use App\Models\ModuleFolder;
use Illuminate\Http\Request;
use App\Models\ModuleContent;
use App\Models\ModuleVisited;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class StudentModuleContentController extends Controller
{

    public function index($module_id)
    {
        $module = Module::findOrFail($module_id);
        $folders = ModuleFolder::where('module_id', $module_id)->with('contents')->get();
        $favouriteContentIds = Favourite::where('user_id', Auth::id())->pluck('content_id')->toArray();
        return view('student.content.index', compact('module', 'folders', 'favouriteContentIds', 'module_id'));
    }


    public function toggleFavouriteContent(Request $request, $module_id)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('modules.student.content.index', ['module_id' => $module_id])
                ->with('error', 'User not authenticated.');
        }

        foreach ($request->content_ids as $content_id) {
            $favourite = Favourite::where('user_id', $user->user_id)
                ->where('content_id', $content_id)
                ->first();

            if ($favourite) {
                $favourite->delete();
            } else {
                Favourite::create([
                    'user_id' => $user->user_id,
                    'content_id' => $content_id,
                    'module_id' => $module_id
                ]);
            }
        }

        return redirect()->route('modules.student.content.index', ['module_id' => $module_id])
            ->with('success', 'Content favourite status toggled successfully.');
    }

    

    public function downloadSingleContent($module_id, $content_id)
    {
        $content = ModuleContent::findOrFail($content_id);

        // Get the file path from the content
        $filePath = storage_path('app/' . $content->file_path);

        // Check if file exists
        if (!file_exists($filePath)) {
            return redirect()->route('modules.student.content.index', ['module_id' => $module_id])
                ->with('error', 'File not found.');
        }

        // Return the file as a download response
        return response()->download($filePath, basename($filePath));
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

    public function show($module_id, $content_id)
    {
        // Retrieve the module and content
        $module = Module::findOrFail($module_id);
        $content = ModuleContent::with('favourites')->findOrFail($content_id);

        // Log the module visit
        ModuleVisited::create([
            'user_id' => Auth::id(),
            'content_id' => $content->content_id,
            'module_id' => $module->module_id,
        ]);

        // Return the view
        return view('student.content.show', compact('module', 'content', 'module_id'));
    }



    // public function index($moduleFolderId)
    // {
    //     // Fetch all ModuleContent entries with the given module_folder_id and load the related module
    //     $moduleContents = ModuleContent::with('module')
    //                                    ->where('module_folder_id', $moduleFolderId)
    //                                    ->get();

    //     // Handle cases where there is no content available or the module is not defined
    //     if ($moduleContents->isEmpty()) {
    //         $moduleName = 'No Module Name';
    //     } else {
    //         // Fetch module name from the first content item's related module, if available
    //         $moduleName = optional($moduleContents->first()->module)->module_name ?? 'No Module Name';
    //     }

    //     if (Auth::user()->role === 'professor') {
    //         return view('content.create', compact('moduleFolderId'));
    //     }

    //     $userId = Auth::id();
    //     $userType = Auth::user()->user_type;

    //     if ($userType == 'professor') {
    //         // Fetch the module names and IDs for professors
    //         $modules = DB::table('modules')
    //             ->join('teaches', 'modules.module_id', '=', 'teaches.module_id')
    //             ->where('teaches.user_id', $userId)
    //             ->select('modules.module_name', 'modules.module_id') // Include module_id in the selection
    //             ->get();
    //     } elseif ($userType == 'student') {
    //         // Fetch the module names and IDs for students
    //         $modules = DB::table('modules')
    //             ->join('enrollments', 'modules.module_id', '=', 'enrollments.module_id')
    //             ->where('enrollments.user_id', $userId)
    //             ->select('modules.module_name', 'modules.module_id') // Include module_id in the selection
    //             ->get();
    //     } else {
    //         // If not professor or student, maybe redirect or handle differently
    //         $modules = collect(); // Return an empty collection or handle as needed
    //     }

    //     return view('content.content_dashboard', compact('moduleContents', 'modules','moduleName'));
    // }

    // public function store(Request $request, $moduleFolderId)
    // {
    //     $request->validate([
    //         'title' => 'required|string|max:100',
    //         'description' => 'required|string',
    //         'file' => 'required|file|max:10240', // Allows files up to 10MB
    //     ]);

    //     $filePath = $request->file('file')->store('module_contents');

    //     $content = new ModuleContent([
    //         'module_folder_id' => $moduleFolderId,
    //         'title' => $request->input('title'),
    //         'description' => $request->input('description'),
    //         'file_path' => $filePath,
    //         'upload_date' => now(),
    //         'created_at' => now(),
    //         'updated_at' => now()
    //     ]);

    //     $content->save();

    //     return back()->with('success', 'Content uploaded successfully!');
    // }
}
