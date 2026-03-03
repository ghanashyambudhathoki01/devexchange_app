<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class QuestionController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tags = Tag::all();
        return view('questions.create', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'tags' => 'required|array',
            'tags.*' => 'exists:tags,id',
        ]);

        $question = auth()->user()->questions()->create([
            'title' => $request->title,
            'body' => $request->body,
        ]);

        $question->tags()->attach($request->tags);

        return redirect()->route('questions.show', $question->slug)
            ->with('success', 'Question posted successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $question = Question::where('slug', $slug)->with(['user', 'tags', 'answers.user'])->firstOrFail();
        
        // Simple view count increment
        $question->increment('views_count');

        return view('questions.show', compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug)
    {
        $question = Question::where('slug', $slug)->firstOrFail();
        
        Gate::authorize('update', $question);

        $tags = Tag::all();
        return view('questions.edit', compact('question', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $slug)
    {
        $question = Question::where('slug', $slug)->firstOrFail();
        
        Gate::authorize('update', $question);

        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'tags' => 'required|array',
            'tags.*' => 'exists:tags,id',
        ]);

        $question->update([
            'title' => $request->title,
            'body' => $request->body,
        ]);

        $question->tags()->sync($request->tags);

        return redirect()->route('questions.show', $question->slug)
            ->with('success', 'Question updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug)
    {
        $question = Question::where('slug', $slug)->firstOrFail();
        
        Gate::authorize('delete', $question);

        $question->delete();

        return redirect()->route('home')->with('success', 'Question deleted successfully!');
    }
}
