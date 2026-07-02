<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Driver;
use App\Models\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ClientMessageController extends Controller
{
    public function index(Request $request): View
    {
        $this->ensureConversation($request);

        $conversations = Conversation::query()
            ->with(['driver', 'messages' => fn ($query) => $query->latest()->limit(1)])
            ->where('cliente_id', $request->user()->id)
            ->latest('updated_at')
            ->get();

        $active = $conversations->first();

        return view('dashboards.cliente.mensajes', [
            'conversations' => $conversations,
            'activeConversation' => $active,
            'messages' => $active ? $active->messages()->oldest()->get() : collect(),
        ]);
    }

    public function show(Request $request, Conversation $conversation): JsonResponse
    {
        abort_unless($conversation->cliente_id === $request->user()->id, 403);

        $conversation->messages()
            ->whereNull('read_at')
            ->where('sender_id', '!=', $request->user()->id)
            ->update(['read_at' => now()]);

        return response()->json([
            'conversation' => $conversation->load('driver'),
            'messages' => $conversation->messages()->oldest()->get()->map(fn (Message $message) => $this->formatMessage($message, $request->user()->id)),
        ]);
    }

    public function send(Request $request, Conversation $conversation): JsonResponse
    {
        abort_unless($conversation->cliente_id === $request->user()->id, 403);

        $validated = $request->validate([
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $message = $conversation->messages()->create([
            'sender_id' => $request->user()->id,
            'sender_role' => 'cliente',
            'message' => $validated['message'],
            'type' => 'text',
        ]);

        $conversation->touch();

        return response()->json(['message' => $this->formatMessage($message, $request->user()->id)]);
    }

    public function upload(Request $request, Conversation $conversation): JsonResponse
    {
        abort_unless($conversation->cliente_id === $request->user()->id, 403);

        $validated = $request->validate([
            'file' => ['required', 'file', 'mimes:jpg,jpeg,png,webp,pdf,doc,docx,xls,xlsx', 'max:5120'],
        ]);

        $file = $validated['file'];
        $path = $file->store('chat-files', 'public');
        $type = str_starts_with((string) $file->getMimeType(), 'image/') ? 'image' : 'file';

        $message = $conversation->messages()->create([
            'sender_id' => $request->user()->id,
            'sender_role' => 'cliente',
            'message' => $file->getClientOriginalName(),
            'type' => $type,
            'file' => $path,
        ]);

        $conversation->touch();

        return response()->json(['message' => $this->formatMessage($message, $request->user()->id)]);
    }

    public function location(Request $request, Conversation $conversation): JsonResponse
    {
        abort_unless($conversation->cliente_id === $request->user()->id, 403);

        $validated = $request->validate([
            'lat' => ['required', 'numeric'],
            'lng' => ['required', 'numeric'],
        ]);

        $message = $conversation->messages()->create([
            'sender_id' => $request->user()->id,
            'sender_role' => 'cliente',
            'message' => $validated['lat'] . ', ' . $validated['lng'],
            'type' => 'location',
        ]);

        $conversation->touch();

        return response()->json(['message' => $this->formatMessage($message, $request->user()->id)]);
    }

    private function ensureConversation(Request $request): void
    {
        if (Conversation::where('cliente_id', $request->user()->id)->exists()) {
            return;
        }

        $driver = Driver::query()->orderByDesc('rating')->first();

        if (! $driver) {
            return;
        }

        $conversation = Conversation::create([
            'request_number' => '#000123',
            'cliente_id' => $request->user()->id,
            'conductor_id' => $driver->id,
        ]);

        foreach ([
            'Conversacion creada para la solicitud #000123.',
            'El conductor acepto la solicitud.',
            'El conductor va en camino.',
        ] as $systemMessage) {
            $conversation->messages()->create([
                'sender_role' => 'system',
                'message' => $systemMessage,
                'type' => 'system',
            ]);
        }

        $conversation->messages()->create([
            'sender_role' => 'conductor',
            'message' => 'Hola, estoy disponible para coordinar la recogida.',
            'type' => 'text',
        ]);
    }

    private function formatMessage(Message $message, int $userId): array
    {
        return [
            'id' => $message->id,
            'message' => $message->message,
            'type' => $message->type,
            'file' => $message->file ? Storage::url($message->file) : null,
            'sender_role' => $message->sender_role,
            'mine' => $message->sender_id === $userId,
            'read' => filled($message->read_at),
            'time' => $message->created_at->format('h:i A'),
        ];
    }
}
