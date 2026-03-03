@props(['model', 'type'])

<div class="flex flex-col items-center gap-1">
    <form action="{{ route('vote') }}" method="POST">
        @csrf
        <input type="hidden" name="voteable_id" value="{{ $model->id }}">
        <input type="hidden" name="voteable_type" value="{{ $type }}">
        <input type="hidden" name="type" value="1">
        <button type="submit" class="p-2 rounded-full hover:bg-emerald-50 text-slate-400 hover:text-emerald-500 transition-all active:scale-90 {{ $model->votes->where('user_id', auth()->id())->where('type', 1)->first() ? 'text-emerald-500 bg-emerald-50' : '' }}">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"></path></svg>
        </button>
    </form>
    
    <span class="text-lg font-bold text-slate-700">
        {{ $model->votes->sum('type') }}
    </span>
    
    <form action="{{ route('vote') }}" method="POST">
        @csrf
        <input type="hidden" name="voteable_id" value="{{ $model->id }}">
        <input type="hidden" name="voteable_type" value="{{ $type }}">
        <input type="hidden" name="type" value="-1">
        <button type="submit" class="p-2 rounded-full hover:bg-rose-50 text-slate-400 hover:text-rose-500 transition-all active:scale-90 {{ $model->votes->where('user_id', auth()->id())->where('type', -1)->first() ? 'text-rose-500 bg-rose-50' : '' }}">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
        </button>
    </form>
</div>
