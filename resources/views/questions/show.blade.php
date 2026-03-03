<x-app-layout>
    <div class="max-w-4xl mx-auto">
        <div class="flex items-start justify-between gap-4 mb-6">
            <h1 class="text-3xl font-extrabold text-slate-900 leading-tight">
                {{ $question->title }}
            </h1>
            <a href="{{ route('questions.create') }}" class="btn-primary whitespace-nowrap">Ask Question</a>
        </div>

        <div class="flex flex-wrap items-center gap-4 text-sm text-slate-500 border-b border-slate-100 pb-6 mb-8">
            <div class="flex items-center gap-1">
                <span>Asked</span>
                <span class="text-slate-900 font-medium">{{ $question->created_at->diffForHumans() }}</span>
            </div>
            <div class="flex items-center gap-1">
                <span>Views</span>
                <span class="text-slate-900 font-medium">{{ $question->views_count }}</span>
            </div>
            @if($question->is_answered)
                <div class="flex items-center gap-1 text-emerald-600 font-bold">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"></path></svg>
                    <span>Answered</span>
                </div>
            @endif
        </div>

        <div class="flex items-start gap-6 mb-12">
            <x-vote-control :model="$question" type="question" />
            
            <div class="flex-1">
                <div class="prose prose-slate prose-lg max-w-none mb-8">
                    {!! $question->body_html !!}
                </div>

                <div class="flex flex-wrap gap-2 mb-8">
                    @foreach($question->tags as $tag)
                        <x-tag-badge :tag="$tag" />
                    @endforeach
                </div>

                <div class="flex items-center justify-between py-6 border-y border-slate-50">
                    <div class="flex items-center gap-4">
                        @can('update', $question)
                            <a href="{{ route('questions.edit', $question->slug) }}" class="text-sm text-slate-500 hover:text-indigo-600 font-medium">Edit question</a>
                        @endcan
                        @can('delete', $question)
                            <form action="{{ route('questions.destroy', $question->slug) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm text-slate-500 hover:text-rose-600 font-medium" onclick="return confirm('Delete this question?')">Delete question</button>
                            </form>
                        @endcan
                    </div>
                    
                    <div class="bg-indigo-50/50 p-4 rounded-xl border border-indigo-100 flex items-center gap-3">
                        <div class="w-10 h-10 bg-indigo-600 rounded-lg flex items-center justify-center text-white font-bold text-lg">
                            {{ strtoupper(substr($question->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="text-xs text-slate-500 italic">asked by</div>
                            <div class="text-sm font-bold text-indigo-600">{{ $question->user->name }}</div>
                            <div class="text-[10px] text-slate-400 font-medium tracking-tight uppercase">REP: {{ $question->user->reputation }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Answers Section -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-slate-900 mb-8 flex items-center gap-3">
                {{ $question->answers->count() }} Answers
            </h2>

            @foreach($question->answers->sortByDesc('is_best') as $answer)
                <x-answer-card :answer="$answer" />
            @endforeach
        </div>

        <!-- Post Answer Form -->
        <div class="mb-20">
            <h2 class="text-2xl font-bold text-slate-900 mb-6">Your Answer</h2>
            @auth
                <form action="{{ route('answers.store', $question) }}" method="POST">
                    @csrf
                    <div class="card p-6 overflow-hidden">
                        <textarea name="body" rows="8" class="w-full border-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500" placeholder="Describe your solution in detail... (Markdown supported)"></textarea>
                        @error('body') <p class="text-rose-600 text-sm mt-1">{{ $message }}</p> @enderror
                        
                        <div class="mt-4 flex items-center justify-between">
                            <span class="text-xs text-slate-400">Be helpful and concise. Markdown is supported.</span>
                            <button type="submit" class="btn-primary">Post Your Answer</button>
                        </div>
                    </div>
                </form>
            @else
                <div class="card p-10 text-center bg-slate-50 border-dashed border-2 border-slate-200">
                    <p class="text-slate-600 mb-4">You must be logged in to answer this question.</p>
                    <a href="{{ route('login') }}" class="btn-primary px-10">Sign In</a>
                </div>
            @endauth
        </div>
    </div>
</x-app-layout>
