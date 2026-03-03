<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-black text-slate-900 tracking-tight">Notifications</h2>
    </x-slot>

    <div class="max-w-3xl mx-auto">
        <div class="card overflow-hidden">
            @forelse($notifications as $notification)
                <div class="p-6 border-b border-slate-50 flex items-start gap-4 {{ $notification->unread() ? 'bg-indigo-50/30' : '' }}">
                    <div class="p-2 bg-indigo-100 text-indigo-600 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-slate-900 mb-1">
                            {{ $notification->data['message'] ?? 'New notification' }}
                        </p>
                        <span class="text-xs text-slate-500">{{ $notification->created_at->diffForHumans() }}</span>
                    </div>
                    @if($notification->unread())
                        <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="text-xs font-bold text-indigo-600 hover:underline">Mark as read</button>
                        </form>
                    @endif
                </div>
            @empty
                <div class="p-20 text-center">
                    <p class="text-slate-500">You're all caught up!</p>
                </div>
            @endforelse

            <div class="p-4">
                {{ $notifications->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
