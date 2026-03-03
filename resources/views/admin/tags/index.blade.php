<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-black text-slate-900 tracking-tight">Manage Tags</h2>
            <button onclick="document.getElementById('add-tag-form').classList.toggle('hidden')" class="btn-primary">Add New Tag</button>
        </div>
    </x-slot>

    <div id="add-tag-form" class="hidden mb-8 card p-6">
        <form action="{{ route('admin.tags.store') }}" method="POST" class="flex items-end gap-4">
            @csrf
            <div class="flex-1">
                <label class="block text-sm font-bold text-slate-700 mb-1">Tag Name</label>
                <input type="text" name="name" class="w-full border-slate-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500" placeholder="e.g. typescript">
            </div>
            <button type="submit" class="btn-primary">Create Tag</button>
        </form>
    </div>

    <div class="card overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="px-6 py-4 text-xs font-black text-slate-500 uppercase">Tag Name</th>
                    <th class="px-6 py-4 text-xs font-black text-slate-500 uppercase">Slug</th>
                    <th class="px-6 py-4 text-xs font-black text-slate-500 uppercase text-center">Questions</th>
                    <th class="px-6 py-4 text-xs font-black text-slate-500 uppercase text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($tags as $tag)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="badge-tag">#{{ $tag->name }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-500">{{ $tag->slug }}</td>
                        <td class="px-6 py-4 text-sm text-slate-900 font-bold text-center">{{ $tag->questions_count }}</td>
                        <td class="px-6 py-4 text-right">
                            <form action="{{ route('admin.tags.destroy', $tag) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs font-bold text-rose-600 hover:underline" onclick="return confirm('Delete this tag?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-4 border-t border-slate-50">
            {{ $tags->links() }}
        </div>
    </div>
</x-app-layout>
