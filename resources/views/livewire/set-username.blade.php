<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-500 to-purple-600">
    <div class="bg-white rounded-lg shadow-2xl p-8 w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-2">EtherSay</h1>
            <p class="text-gray-600">Local Network Chat</p>
        </div>

        <form wire:submit="setUsername">
            <div class="mb-6">
                <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                    Enter Your Username
                </label>
                <input type="text" id="username" name="username" wire:model="username"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                    placeholder="Choose a username..." autofocus>
                @error('username')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-200 shadow-md hover:shadow-lg">
                Join Chat
            </button>
        </form>

        <div class="mt-6 text-center text-sm text-gray-500">
            <p>No login required • LAN only • Session-based</p>
        </div>
    </div>
</div>
