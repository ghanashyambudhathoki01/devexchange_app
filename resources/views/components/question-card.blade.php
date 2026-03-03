@props(['question'])

<div class="card p-6 mb-4">
    <div class="flex items-start gap-4">
        <x-vote-control :model="$question" type="question" />
        
        <div class="flex-1">
            <h3 class="text-xl font-bold text-slate-900 mb-2 hover:text-indigo-600 transition-colors">
                <a href="{{ route('questions.show', $question->slug) }}">{{ $question->title }}</a>
            </h3>
            <p class="text-slate-600 line-clamp-2 mb-4">
                {{ Str::limit(strip_tags($question->body_html), 150) }}
            </p>
            
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="flex flex-wrap gap-2">
                    @foreach($question->tags as $tag)
                        <x-tag-badge :tag="$tag" />
                    @endforeach
                </div>
                
                <div class="flex items-center gap-3 text-sm text-slate-500">
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"></path></svg>
                        <span>{{ $question->answers_count ?? $question->answers->count() }} answers</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        <span>{{ $question->views_count }} views</span>
                    </div>
                    <span>asked {{ $question->created_at->diffForHumans() }} by <span class="font-medium text-indigo-600 underline">{{ $question->user->name }}</span></span>
                </div>
            </div>
        </div>
    </div>
</div>
