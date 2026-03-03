<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-black text-slate-900 tracking-tight">Manage Users</h2>
    </x-slot>

    <div class="card overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="px-6 py-4 text-xs font-black text-slate-500 uppercase">User</th>
                    <th class="px-6 py-4 text-xs font-black text-slate-500 uppercase text-center">Reputation</th>
                    <th class="px-6 py-4 text-xs font-black text-slate-500 uppercase text-center">Status</th>
                    <th class="px-6 py-4 text-xs font-black text-slate-500 uppercase text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($users as $user)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-indigo-600 text-white rounded-lg flex items-center justify-center font-bold">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-slate-900">{{ $user->name }}</div>
                                    <div class="text-xs text-slate-500">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-indigo-600 font-bold">{{ $user->reputation }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($user->is_banned)
                                <span class="px-2 py-1 bg-rose-50 text-rose-600 rounded-md text-[10px] font-black uppercase tracking-wider border border-rose-100 italic">Banned</span>
                            @else
                                <span class="px-2 py-1 bg-emerald-50 text-emerald-600 rounded-md text-[10px] font-black uppercase tracking-wider border border-emerald-100">Active</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            @if($user->id !== auth()->id())
                                @if($user->is_banned)
                                    <form action="{{ route('admin.users.unban', $user) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-xs font-bold text-emerald-600 hover:underline">Unban</button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.users.ban', $user) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-xs font-bold text-rose-600 hover:underline">Ban User</button>
                                    </form>
                                @endif
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-4 border-t border-slate-50">
            {{ $users->links() }}
        </div>
    </div>
</x-app-layout>
