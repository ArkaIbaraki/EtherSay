<x-layout>
    <div class="h-screen flex bg-gray-100 relative">
        <!-- Mobile Menu Toggle Button -->
        <button id="mobile-menu-btn"
            class="md:hidden fixed top-4 left-4 z-50 bg-blue-600 text-white p-2 rounded-lg shadow-lg"
            onclick="toggleMobileMenu()">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <!-- Overlay untuk mobile -->
        <div id="mobile-overlay" class="md:hidden fixed inset-0 bg-black bg-opacity-50 z-30 hidden"
            onclick="toggleMobileMenu()"></div>

        <!-- Sidebar - Online Users -->
        <div id="mobile-sidebar"
            class="fixed md:relative md:block w-80 md:w-64 lg:w-80 border-r bg-white z-40 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out h-full">
            <div class="h-full flex flex-col">
                <div class="p-3 md:p-4 bg-gradient-to-r from-blue-600 to-purple-600 flex items-center justify-between">
                    <div>
                        <h1 class="text-xl md:text-2xl font-bold text-white">EtherSay</h1>
                        <p class="text-xs md:text-sm text-blue-100 truncate">{{ session('username') }}</p>
                    </div>
                    <!-- Close button untuk mobile -->
                    <button class="md:hidden text-white" onclick="toggleMobileMenu()">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="flex-1 overflow-y-auto">
                    <livewire:online-users />
                </div>

                <div class="p-3 md:p-4 border-t bg-gray-50">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full text-center text-xs md:text-sm text-gray-600 hover:text-gray-800 py-2">
                            Leave Chat
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Chat Area -->
        <div class="flex-1 w-full md:w-auto">
            <livewire:chat />
        </div>
    </div>

    <script>
        function toggleMobileMenu() {
            const sidebar = document.getElementById('mobile-sidebar');
            const overlay = document.getElementById('mobile-overlay');

            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        // Close menu when clicking on a user (start private chat)
        document.addEventListener('livewire:init', () => {
            Livewire.on('startPrivateChat', () => {
                if (window.innerWidth < 768) {
                    toggleMobileMenu();
                }
            });
        });
    </script>
</x-layout>
