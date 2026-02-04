<div class="bg-white rounded-lg shadow-md p-3 md:p-4 h-full">
    <div class="flex items-center justify-between mb-3 md:mb-4">
        <h2 class="text-base md:text-lg font-bold text-gray-800">Online Users</h2>
        <span class="text-xs md:text-sm text-gray-500">{{ count($onlineUsers) }} online</span>
    </div>

    <div class="space-y-1.5 md:space-y-2">
        @forelse($onlineUsers as $index => $user)
            <div wire:click="selectUser({{ $index }})"
                class="flex items-center space-x-2 md:space-x-3 p-2 md:p-3 rounded-lg hover:bg-blue-50 cursor-pointer transition group">
                <div class="relative flex-shrink-0">
                    <div
                        class="w-8 h-8 md:w-10 md:h-10 rounded-full bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center text-white text-sm md:text-base font-semibold">
                        {{ strtoupper(substr($user['username'], 0, 2)) }}
                    </div>
                    <div
                        class="absolute bottom-0 right-0 w-2 h-2 md:w-3 md:h-3 bg-green-500 rounded-full border-2 border-white">
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-medium text-sm md:text-base text-gray-800 group-hover:text-blue-600 truncate">
                        {{ $user['username'] }}</p>
                    <p class="text-xs text-gray-500 hidden sm:block">Click to chat</p>
                </div>
            </div>
        @empty
            <div class="text-center py-8 text-gray-400">
                <svg class="w-16 h-16 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <p>No users online</p>
            </div>
        @endforelse
    </div>
</div>
