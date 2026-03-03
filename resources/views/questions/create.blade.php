<x-app-layout>
    <div class="max-w-3xl mx-auto">
        <h1 class="text-3xl font-extrabold text-slate-900 mb-8">Ask a public question</h1>

        <form action="{{ route('questions.store') }}" method="POST">
            @csrf
            <div class="card p-8 space-y-8">
                <div>
                    <label class="block text-lg font-bold text-slate-900 mb-1">Title</label>
                    <p class="text-sm text-slate-500 mb-3">Be specific and imagine you’re asking a question to another person.</p>
                    <input type="text" name="title" value="{{ old('title') }}" 
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all placeholder:text-slate-400" 
                           placeholder="e.g. Is there an R function for finding the index of an element in a vector?">
                    @error('title') <p class="text-rose-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-lg font-bold text-slate-900 mb-1">What are the details of your problem?</label>
                    <p class="text-sm text-slate-500 mb-3">Introduce the problem and expand on what you put in the title. Minimum 20 characters.</p>
                    <textarea name="body" rows="12" 
                              class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all font-mono text-sm" 
                              placeholder="Describe your problem... (Markdown supported)">{{ old('body') }}</textarea>
                    @error('body') <p class="text-rose-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-lg font-bold text-slate-900 mb-1">Tags</label>
                    <p class="text-sm text-slate-500 mb-3">Add up to 5 tags to describe what your question is about.</p>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                        @foreach($tags as $tag)
                            <label class="flex items-center gap-2 p-3 border border-slate-200 rounded-xl cursor-pointer hover:bg-indigo-50 hover:border-indigo-200 transition-all">
                                <input type="checkbox" name="tags[]" value="{{ $tag->id }}" class="rounded text-indigo-600 focus:ring-indigo-500" {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}>
                                <span class="text-sm font-medium text-slate-700">#{{ $tag->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('tags') <p class="text-rose-600 text-sm mt-1 mb-4">{{ $message }}</p> @enderror
                </div>

                <div class="pt-4 flex items-center justify-end gap-4 border-t border-slate-100">
                    <a href="{{ route('home') }}" class="text-slate-500 font-bold hover:text-slate-700">Cancel</a>
                    <button type="submit" class="btn-primary">Post your question</button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
