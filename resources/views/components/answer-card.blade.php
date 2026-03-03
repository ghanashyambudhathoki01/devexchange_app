@props(['answer'])

<div class="card p-6 mb-4 {{ $answer->is_best ? 'ring-2 ring-emerald-500 bg-emerald-50/10' : '' }}">
    <div class="flex items-start gap-4">
        <x-vote-control :model="$answer" type="answer" />
        
        <div class="flex-1">
            <div class="prose prose-slate max-w-none mb-4">
                {!! $answer->body_html !!}
            </div>
            
            <div class="flex items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    @can('markBest', $answer)
                        @if(!$answer->is_best)
                            <form action="{{ route('answers.best', $answer) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-sm font-medium text-emerald-600 hover:underline">Mark as best</button>
                            </form>
                        @endif
                    @endcan
                    
                    @if($answer->is_best)
                        <div class="flex items-center gap-1 text-emerald-600 font-bold text-sm">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"></path></svg>
                            Best Answer
                        </div>
                    @endif

                    @can('update', $answer)
                        <a href="#" class="text-sm text-slate-500 hover:text-indigo-600">edit</a>
                    @endcan
                    @can('delete', $answer)
                        <form action="{{ route('answers.destroy', $answer) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-sm text-slate-500 hover:text-rose-600" onclick="return confirm('Delete this answer?')">delete</button>
                        </form>
                    @endcan
                </div>
                
                <div class="text-sm text-slate-500">
                    answered {{ $answer->created_at->diffForHumans() }} by <span class="font-medium text-indigo-600 underline">{{ $answer->user->name }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
