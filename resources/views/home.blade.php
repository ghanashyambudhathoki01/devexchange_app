<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                {{ isset($tag) ? 'Questions tagged #' . $tag->name : 'All Questions' }}
            </h2>
            <a href="{{ route('questions.create') }}" class="btn-primary flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Ask Question
            </a>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <div class="lg:col-span-3">
            <!-- Search & Filters -->
            <div class="card p-4 mb-8 flex flex-col md:flex-row items-center justify-between gap-4">
                <form action="{{ route('home') }}" method="GET" class="relative w-full md:w-96">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search questions..." class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                    <svg class="w-5 h-5 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </form>
                
                <div class="flex items-center gap-2 overflow-x-auto w-full md:w-auto pb-2 md:pb-0">
                    @foreach(['latest' => 'Latest', 'most-upvoted' => 'Top Rated', 'most-answered' => 'Most Answered', 'unanswered' => 'Unanswered'] as $key => $label)
                        <a href="{{ route('home', array_merge(request()->query(), ['filter' => $key])) }}" 
                           class="px-4 py-2 rounded-xl text-sm font-medium transition-all {{ (request('filter', 'latest') == $key) ? 'bg-indigo-600 text-white shadow-md' : 'bg-white text-slate-600 border border-slate-200 hover:border-indigo-500' }}">
                            {{ $label }}
                        </a>
                    @endforeach
                </div>
            </div>

            @forelse($questions as $question)
                <x-question-card :question="$question" />
            @empty
                <div class="card p-20 text-center">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 9.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">No questions found</h3>
                    <p class="text-slate-500">We couldn't find any questions matching your criteria.</p>
                </div>
            @endforelse

            <div class="mt-8">
                {{ $questions->links() }}
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <div class="card p-6 mb-6">
                <h4 class="font-bold text-slate-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 11h.01m0 4h.01M10 7H21m-11 4H21m-11 4H21"></path></svg>
                    Top Tags
                </h4>
                <div class="flex flex-wrap gap-2">
                    @php $tags = \App\Models\Tag::take(15)->get(); @endphp
                    @foreach($tags as $tag)
                        <x-tag-badge :tag="$tag" />
                    @endforeach
                </div>
            </div>

            <div class="card p-6 bg-indigo-600 text-white">
                <h4 class="font-bold mb-2">Build your reputation</h4>
                <p class="text-indigo-100 text-sm mb-4">Help the community by providing great answers and get reputation points.</p>
                <a href="{{ route('home', ['filter' => 'unanswered']) }}" class="inline-block bg-white text-indigo-600 px-4 py-2 rounded-xl text-sm font-bold hover:shadow-lg transition-all">Answer Questions</a>
            </div>
        </div>
    </div>
</x-app-layout>
