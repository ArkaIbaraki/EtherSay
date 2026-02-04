<div class="flex flex-col h-full">
    <!-- Chat Header -->
    <div class="bg-white border-b px-4 md:px-6 py-3 md:py-4 flex items-center justify-between">
        <div class="flex items-center space-x-2 md:space-x-3 flex-1 min-w-0">
            <!-- Menu button untuk mobile -->
            <button class="md:hidden p-1.5 hover:bg-gray-100 rounded-lg transition flex-shrink-0"
                onclick="toggleMobileMenu()">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            @if ($chatType === 'private')
                <button wire:click="switchToGlobal" class="p-2 hover:bg-gray-100 rounded-lg transition flex-shrink-0">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
            @endif
            <div class="flex-1 min-w-0">
                <h2 class="text-lg md:text-xl font-bold text-gray-800">
                    @if ($chatType === 'private')
                        {{ $activeChatUsername }}
                    @else
                        Global Chat
                    @endif
                </h2>
                <p class="text-xs md:text-sm text-gray-500 hidden sm:block">
                    @if ($chatType === 'private')
                        Private conversation
                    @else
                        Everyone can see messages
                    @endif
                </p>
            </div>
        </div>
        <div class="text-xs md:text-sm text-gray-600 truncate max-w-[100px] md:max-w-none">
            {{ session('username') }}
        </div>
    </div>

    <!-- Messages Area -->
    <div class="flex-1 overflow-y-auto p-3 md:p-6 space-y-3 md:space-y-4 bg-gray-50" id="messages-container"
        wire:poll.5s="loadMessages">
        @foreach ($messages as $msg)
            @if ($msg['is_system_message'])
                <!-- System Message -->
                <div class="text-center">
                    <span class="text-xs text-gray-500 bg-gray-200 px-3 py-1 rounded-full">
                        {{ $msg['message'] }}
                    </span>
                </div>
            @else
                <!-- Regular Message -->
                <div
                    class="flex {{ $msg['sender_session_id'] === session()->getId() ? 'justify-end' : 'justify-start' }}">
                    <div
                        class="max-w-[85%] sm:max-w-sm md:max-w-md {{ $msg['sender_session_id'] === session()->getId() ? 'order-2' : 'order-1' }}">
                        @if ($msg['sender_session_id'] !== session()->getId())
                            <p class="text-xs text-gray-600 mb-1 ml-1">{{ $msg['sender_username'] }}</p>
                        @endif

                        <div
                            class="rounded-lg p-2.5 md:p-3 {{ $msg['sender_session_id'] === session()->getId() ? 'bg-blue-600 text-white' : 'bg-white text-gray-800' }} shadow">
                            @if ($msg['message'])
                                <p class="break-words text-sm md:text-base">{{ $msg['message'] }}</p>
                            @endif

                            @if (isset($msg['file_share']) && $msg['file_share'])
                                <div class="mt-2">
                                    @php
                                        $file = $msg['file_share'];
                                        $isImage = str_starts_with($file['file_type'], 'image/');
                                    @endphp

                                    @if ($isImage)
                                        <img src="{{ asset('storage/' . $file['file_path']) }}"
                                            alt="{{ $file['file_name'] }}" class="rounded max-w-full h-auto">
                                    @endif

                                    <a href="{{ asset('storage/' . $file['file_path']) }}"
                                        download="{{ $file['file_name'] }}"
                                        class="flex items-center space-x-2 mt-2 p-2 bg-black bg-opacity-10 rounded hover:bg-opacity-20 transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <span class="text-sm">{{ $file['file_name'] }}</span>
                                    </a>
                                </div>
                            @endif
                        </div>

                        <p
                            class="text-xs text-gray-500 mt-1 {{ $msg['sender_session_id'] === session()->getId() ? 'text-right' : 'text-left' }}">
                            {{ \Carbon\Carbon::parse($msg['created_at'])->format('H:i') }}
                            @if ($msg['sender_session_id'] === session()->getId() && $msg['is_read'])
                                <span class="text-blue-600">✓✓</span>
                            @endif
                        </p>
                    </div>
                </div>
            @endif
        @endforeach

        <!-- Typing Indicator Placeholder -->
        <div id="typing-indicator" class="hidden text-sm text-gray-500 italic"></div>
    </div>

    <!-- Message Input -->
    <div class="bg-white border-t p-2 md:p-4">
        @if ($errors->any())
            <div class="mb-2 p-2 bg-red-100 text-red-700 text-sm rounded">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form wire:submit="sendMessage" class="flex items-end space-x-1 md:space-x-2">
            <!-- File Upload Button -->
            <label class="cursor-pointer p-1.5 md:p-2 hover:bg-gray-100 rounded-lg transition flex-shrink-0">
                <input type="file" id="file-input" name="file" wire:model="file" accept="image/*,.pdf,.zip,.rar"
                    class="hidden" onchange="validateFile(this)">
                <svg class="w-5 h-5 md:w-6 md:h-6 text-gray-600" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                </svg>
            </label>

            <!-- Message Input -->
            <div class="flex-1">
                <textarea id="message-input" name="message" wire:model="message" wire:keydown="typing" rows="1"
                    class="w-full px-3 py-2 md:px-4 text-sm md:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none outline-none"
                    placeholder="Type a message..." style="max-height: 100px;"></textarea>

                @if ($file)
                    <div
                        class="mt-2 text-xs md:text-sm text-gray-600 flex items-center space-x-2 bg-blue-50 p-2 rounded">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span
                            class="truncate max-w-[120px] sm:max-w-[200px] md:max-w-none flex-1">{{ $this->getFileName() }}</span>
                        <button type="button" wire:click="clearFile"
                            class="text-red-600 hover:text-red-800 text-xl font-bold flex-shrink-0">
                            ×
                        </button>
                    </div>
                    <div class="mt-1 text-xs text-gray-500" wire:loading wire:target="file">
                        <svg class="animate-spin inline w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        Uploading...
                    </div>
                @endif

                @error('message')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                @error('file')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Send Button -->
            <button type="submit" wire:loading.attr="disabled" wire:target="sendMessage,file"
                class="bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 text-white p-2 md:p-3 rounded-lg transition shadow-md hover:shadow-lg flex-shrink-0">
                <svg wire:loading.remove wire:target="sendMessage" class="w-5 h-5 md:w-6 md:h-6" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                </svg>
                <svg wire:loading wire:target="sendMessage" class="animate-spin w-5 h-5 md:w-6 md:h-6" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
            </button>
        </form>
    </div>
</div>

@script
    // File validation and compression
    async function validateFile(input) {
    const file = input.files[0];
    if (!file) return;

    const maxSize = 10 * 1024 * 1024; // 10MB
    const maxSizeMobile = 5 * 1024 * 1024; // 5MB for mobile
    const isMobile = window.innerWidth < 768; const limit=isMobile ? maxSizeMobile : maxSize; // Check file size if
        (file.size> limit) {
        alert(`File terlalu besar! Maksimal ${isMobile ? '5MB' : '10MB'} untuk ${isMobile ? 'mobile' : 'desktop'}.`);
        input.value = '';
        return;
        }

        // Compress image if it's too large and is an image
        if (file.type.startsWith('image/') && file.size > 1024 * 1024) {
        try {
        const compressed = await compressImage(file);

        // Create new File object
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(compressed);
        input.files = dataTransfer.files;

        console.log(`Compressed: ${(file.size / 1024).toFixed(0)}KB → ${(compressed.size / 1024).toFixed(0)}KB`);
        } catch (e) {
        console.error('Compression failed:', e);
        // Continue with original file if compression fails
        }
        }
        }

        async function compressImage(file) {
        return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.readAsDataURL(file);

        reader.onload = (event) => {
        const img = new Image();
        img.src = event.target.result;

        img.onload = () => {
        const canvas = document.createElement('canvas');
        let width = img.width;
        let height = img.height;

        // Resize if too large
        const maxDimension = 1920;
        if (width > maxDimension || height > maxDimension) {
        if (width > height) {
        height = (height / width) * maxDimension;
        width = maxDimension;
        } else {
        width = (width / height) * maxDimension;
        height = maxDimension;
        }
        }

        canvas.width = width;
        canvas.height = height;

        const ctx = canvas.getContext('2d');
        ctx.drawImage(img, 0, 0, width, height);

        // Convert to blob with compression
        canvas.toBlob((blob) => {
        if (blob) {
        const compressedFile = new File([blob], file.name, {
        type: 'image/jpeg',
        lastModified: Date.now(),
        });
        resolve(compressedFile);
        } else {
        reject(new Error('Canvas to Blob failed'));
        }
        }, 'image/jpeg', 0.8);
        };

        img.onerror = reject;
        };

        reader.onerror = reject;
        });
        }

        // Auto scroll to bottom
        function scrollToBottom() {
        const container = document.getElementById('messages-container');
        if (container) {
        container.scrollTop = container.scrollHeight;
        }
        }

        // Scroll on load and on message update
        document.addEventListener('DOMContentLoaded', scrollToBottom);
        window.addEventListener('livewire:update', scrollToBottom);

        // Handle typing indicator
        let typingTimeout;
        $wire.on('user-typing', (event) => {
        const indicator = document.getElementById('typing-indicator');
        indicator.textContent = `${event.username} is typing...`;
        indicator.classList.remove('hidden');

        clearTimeout(typingTimeout);
        typingTimeout = setTimeout(() => {
        indicator.classList.add('hidden');
        }, 3000);
        });

        // Heartbeat to keep user online
        setInterval(() => {
        fetch('/heartbeat', {
        method: 'POST',
        headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
        }
        }).catch(err => console.log('Heartbeat failed:', err));
        }, 30000); // Every 30 seconds
    @endscript
