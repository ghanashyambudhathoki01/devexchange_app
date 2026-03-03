<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::withCount('questions')->paginate(20);
        return view('admin.tags.index', compact('tags'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:tags,name']);

        Tag::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return back()->with('success', 'Tag created!');
    }

    public function update(Request $request, Tag $tag)
    {
        $request->validate(['name' => 'required|unique:tags,name,' . $tag->id]);

        $tag->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return back()->with('success', 'Tag updated!');
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();
        return back()->with('success', 'Tag deleted!');
    }
}
