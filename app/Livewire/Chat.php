<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;
use App\Models\Message;
use App\Models\FileShare;
use App\Models\OnlineUser;
use App\Events\MessageSent;
use App\Events\UserTyping;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class Chat extends Component
{
    use WithFileUploads;

    public $message = '';
    public $messages = [];
    public $activeChat = null; // null = global, atau session_id untuk private
    public $activeChatUsername = null;
    public $file;
    public $chatType = 'global'; // 'global' or 'private'

    public function getFileName()
    {
        if (!$this->file) return null;
        
        // Handle Livewire 4 temporary file
        if (is_array($this->file)) {
            return $this->file['name'] ?? 'file';
        }
        
        // Handle UploadedFile object
        if (is_object($this->file) && method_exists($this->file, 'getClientOriginalName')) {
            return $this->file->getClientOriginalName();
        }
        
        return 'file';
    }

    public function mount()
    {
        // Pastikan user terdaftar sebagai online
        OnlineUser::updateOrCreate(
            ['session_id' => session()->getId()],
            [
                'username' => session('username'),
                'last_seen' => Carbon::now()
            ]
        );
        
        $this->loadMessages();
        $this->updateLastSeen();
    }

    #[On('startPrivateChat')]
    public function startPrivateChat($sessionId, $username)
    {
        $this->activeChat = $sessionId;
        $this->activeChatUsername = $username;
        $this->chatType = 'private';
        $this->loadMessages();
    }

    public function switchToGlobal()
    {
        $this->activeChat = null;
        $this->activeChatUsername = null;
        $this->chatType = 'global';
        $this->loadMessages();
    }

    public function clearFile()
    {
        $this->file = null;
    }

    public function loadMessages()
    {
        if ($this->chatType === 'global') {
            $this->messages = Message::global()
                ->with('fileShare')
                ->latest()
                ->take(50)
                ->get()
                ->reverse()
                ->values()
                ->toArray();
        } else {
            $this->messages = Message::private(session()->getId(), $this->activeChat)
                ->with('fileShare')
                ->latest()
                ->take(50)
                ->get()
                ->reverse()
                ->values()
                ->toArray();
            
            // Mark messages as read
            Message::where('sender_session_id', $this->activeChat)
                ->where('receiver_session_id', session()->getId())
                ->where('is_read', false)
                ->update([
                    'is_read' => true,
                    'read_at' => Carbon::now()
                ]);
        }
    }

    public function sendMessage()
    {
        // Detect mobile and adjust file size limit
        $maxFileSize = 5120; // 5MB default for mobile safety
        
        $rules = [
            'message' => 'nullable|max:1000',
            'file' => 'nullable|max:' . $maxFileSize,
        ];
        
        // At least one must be present
        if (empty($this->message) && empty($this->file)) {
            $this->addError('message', 'Please enter a message or attach a file.');
            return;
        }
        
        $this->validate($rules);

        $this->updateLastSeen();

        $messageData = [
            'sender_session_id' => session()->getId(),
            'sender_username' => session('username'),
            'receiver_session_id' => $this->activeChat,
            'receiver_username' => $this->activeChatUsername,
            'message' => $this->message,
            'is_system_message' => false,
        ];

        $message = Message::create($messageData);

        // Handle file upload
        if ($this->file) {
            try {
                // Get file info - handle both array and object
                $fileName = $this->getFileName();
                $fileSize = 0;
                $fileMime = 'application/octet-stream';
                
                if (is_object($this->file)) {
                    $fileName = $this->file->getClientOriginalName();
                    $fileSize = $this->file->getSize();
                    $fileMime = $this->file->getMimeType();
                } elseif (is_array($this->file)) {
                    $fileName = $this->file['name'] ?? 'file';
                    $fileSize = $this->file['size'] ?? 0;
                    $fileMime = $this->file['type'] ?? 'application/octet-stream';
                }
                
                $filename = time() . '_' . $fileName;
                $path = $this->file->storeAs('uploads', $filename, 'public');
                
                FileShare::create([
                    'message_id' => $message->id,
                    'file_name' => $fileName,
                    'file_path' => $path,
                    'file_type' => $fileMime,
                    'file_size' => $fileSize,
                ]);

                $message->load('fileShare');
            } catch (\Exception $e) {
                \Log::error('File upload error: ' . $e->getMessage());
                $this->addError('file', 'Failed to upload file. Please try again.');
                return;
            }
        }

        // Broadcast message
        broadcast(new MessageSent($message))->toOthers();

        $this->message = '';
        $this->file = null;
        $this->loadMessages();
    }

    public function typing()
    {
        broadcast(new UserTyping(session('username'), $this->activeChat))->toOthers();
    }

    public function messageReceived($payload)
    {
        $this->loadMessages();
    }

    public function userTyping($payload)
    {
        $this->dispatch('user-typing', username: $payload['username']);
    }

    public function updateLastSeen()
    {
        OnlineUser::where('session_id', session()->getId())
            ->update(['last_seen' => Carbon::now()]);
    }

    public function render()
    {
        return view('livewire.chat');
    }
}
