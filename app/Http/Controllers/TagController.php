<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Tag;

class TagController extends Controller
{
    public function show(string $slug)
    {
        $tag = Tag::where('slug', $slug)->firstOrFail();
        $questions = $tag->questions()->with(['user', 'tags'])->latest()->paginate(15);

        return view('home', compact('questions', 'tag'));
    }
}
