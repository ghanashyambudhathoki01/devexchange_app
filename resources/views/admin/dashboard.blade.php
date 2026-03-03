<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-black text-slate-900 tracking-tight">Admin Dashboard</h2>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="card p-6 border-l-4 border-indigo-600">
            <div class="text-slate-500 text-sm font-bold uppercase mb-1">Total Users</div>
            <div class="text-3xl font-black text-slate-900">{{ $stats['total_users'] }}</div>
        </div>
        <div class="card p-6 border-l-4 border-emerald-500">
            <div class="text-slate-500 text-sm font-bold uppercase mb-1">Questions</div>
            <div class="text-3xl font-black text-slate-900">{{ $stats['total_questions'] }}</div>
        </div>
        <div class="card p-6 border-l-4 border-amber-500">
            <div class="text-slate-500 text-sm font-bold uppercase mb-1">Answers</div>
            <div class="text-3xl font-black text-slate-900">{{ $stats['total_answers'] }}</div>
        </div>
        <div class="card p-6 border-l-4 border-rose-500">
            <div class="text-slate-500 text-sm font-bold uppercase mb-1">Tags</div>
            <div class="text-3xl font-black text-slate-900">{{ $stats['popular_tags']->count() }}</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Top Contributors -->
        <div class="card overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-black text-slate-900">Top Contributors</h3>
                <a href="{{ route('admin.users.index') }}" class="text-xs font-bold text-indigo-600 hover:underline">View All Users</a>
            </div>
            <div class="divide-y divide-slate-50">
                @foreach($stats['top_contributors'] as $user)
                    <div class="p-4 flex items-center justify-between hover:bg-slate-50 transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center text-slate-700 font-bold">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="text-sm font-bold text-slate-900">{{ $user->name }}</div>
                                <div class="text-xs text-slate-500">{{ $user->email }}</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-sm font-black text-indigo-600">{{ $user->reputation }}</div>
                            <div class="text-[10px] text-slate-400 uppercase font-bold">Points</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Popular Tags -->
        <div class="card overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-black text-slate-900">Popular Tags</h3>
                <a href="{{ route('admin.tags.index') }}" class="text-xs font-bold text-indigo-600 hover:underline">Manage Tags</a>
            </div>
            <div class="divide-y divide-slate-50">
                @foreach($stats['popular_tags'] as $tag)
                    <div class="p-4 flex items-center justify-between hover:bg-slate-50 transition-colors">
                        <div class="flex items-center gap-2">
                            <span class="badge-tag">#{{ $tag->name }}</span>
                        </div>
                        <div class="text-right">
                            <div class="text-sm font-black text-slate-900">{{ $tag->questions_count }}</div>
                            <div class="text-[10px] text-slate-400 uppercase font-bold">Questions</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
