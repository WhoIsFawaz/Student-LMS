<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Module;
use App\Models\News;

class ProfessorNewsController extends Controller
{

    public function index($module_id)
    {
        $module = Module::findOrFail($module_id);
        $newsItems = News::where('module_id', $module_id)->get();
        return view('professor.news.index', compact('module', 'newsItems', 'module_id'));
    }

    public function create($module_id)
    {
        $module = Module::findOrFail($module_id);
        return view('professor.news.create', compact('module', 'module_id'));
    }

    public function show($module_id, $news_id)
    {
        $module = Module::findOrFail($module_id);
        $newsItem = News::findOrFail($news_id);
        return view('professor.news.show', compact('module', 'newsItem', 'module_id'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'module_id' => 'required',
            'news_title' => 'required|string|max:50',
            'news_description' => 'required|string|max:255',
        ]);

        News::create([
            'module_id' => $request->module_id,
            'news_title' => $request->news_title,
            'news_description' => $request->news_description,
            'created_at' => now(),
        ]);

        return redirect()->route('modules.professor.news.index', ['module_id' => $request->module_id])->with('success', 'News created successfully');
    }

    public function edit($module_id, $news_id)
    {
        $module = Module::findOrFail($module_id);
        $newsItem = News::findOrFail($news_id);
        return view('professor.news.edit', compact('module', 'newsItem', 'module_id'));
    }

    public function update(Request $request, $module_id, $news_id)
    {
        $request->validate([
            'news_title' => 'required|string|max:50',
            'news_description' => 'required|string|max:255',
        ]);

        $newsItem = News::findOrFail($news_id);
        $newsItem->update([
            'news_title' => $request->news_title,
            'news_description' => $request->news_description,
            'updated_at' => now()
        ]);

        return redirect()->route('modules.professor.news.index', ['module_id' => $module_id])->with('success', 'News updated successfully');
    }

    public function destroy($module_id, $news_id)
    {
        $newsItem = News::findOrFail($news_id);
        $newsItem->delete();

        return redirect()->route('modules.professor.news.index', ['module_id' => $module_id])->with('success', 'News deleted successfully');
    }

 
}