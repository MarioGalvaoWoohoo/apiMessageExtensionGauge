<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Services\MessageService;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    protected $messageService;

    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    public function index()
    {
        $messages =  $this->messageService->getAll();
        return response()->json([
            'message' => 'Listagem realizada com sucesso',
            'data' => $messages,
        ]);
    }

    public function store(Request $request)
    {
        $message = new Message();
        $message->title = $request->input('title');
        $message->content = $request->input('content');
        $message->save();
        return response()->json($message);
    }

    public function show(Message $message)
    {
        return view('messages.show', compact('message'));
    }

    public function edit(Message $message)
    {
        return view('messages.edit', compact('message'));
    }

    public function update(Request $request, Message $message)
    {
        $message->title = $request->input('title');
        $message->content = $request->input('content');
        $message->save();
        return redirect()->route('messages.show', $message->id);
    }

    public function destroy(Message $message)
    {
        $message->delete();
        return redirect()->route('messages.index');
    }
}
