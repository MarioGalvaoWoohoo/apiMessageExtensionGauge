<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageRequest;
use App\Http\Resources\MessagesResource;
use App\Http\Resources\MessagesWithStatusIfReadResource;
use App\Models\Message;
use App\Services\MessageService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\{Request, Response};
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    protected $messageService;

    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    public function listAll()
    {
        try {
            $messages =  $this->messageService->getAll();
            return response()->json([
                'message' => 'Listagem realizada com sucesso',
                'data' => MessagesResource::collection($messages),
            ], 201);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'data' => false,
            ], 404);
        }
    }

    public function messagesIsActive()
    {
        try {
            $messages =  $this->messageService->getMessageIsActive();
            return response()->json([
                'message' => 'Listagem realizada com sucesso',
                'data' => MessagesResource::collection($messages),
            ], 201);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'data' => false,
            ], 500);
        }
    }

    public function messagesOnTimeIsActive()
    {
        try {
            $messages =  $this->messageService->messagesOnTimeIsActive();
            return response()->json([
                'message' => 'Listagem realizada com sucesso',
                'data' => MessagesResource::collection($messages),
            ], 201);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'data' => false,
            ], 500);
        }
    }

    public function unreadMessages(Request $request)
    {
        try {
            $validatedData = Validator::make($request->all(), [
                'user_id' => 'required|min:30',
            ]);

            if ($validatedData->fails()) {
                return response()->json($validatedData->errors(), 422);
            }

            $messages = $this->messageService->unreadMessages($request->user_id);

            return response()->json([
                'message' => 'Listagem realizada com sucesso',
                'data' => $messages,
            ], 201);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'data' => false,
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = Validator::make($request->all(), [
                'title' => 'required|min:20|max:150',
                'message' => 'required|min:50|max:255',
                'type' => 'required|integer',
                // 'status' => 'required',
                'start_date' => 'required|date',
                'end_date' => 'required|date',
                'user_id' => 'required'
            ]);

            if ($validatedData->fails()) {
                return response()->json($validatedData->errors(), 422);
            }

            $message = $this->messageService->create($request->all());
            return response()->json([
                'message' => 'Cadastro realizado com sucesso',
                'data' => new MessagesResource($message),
            ], 201);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'data' => false,
            ], 404);
        }
    }

    public function update(Request $request, int $id)
    {
        try {

            $validatedData = Validator::make($request->all(), [
                'title' => 'required|min:20|max:150',
                'message' => 'required|min:50|max:255',
                'type' => 'required|integer',
                // 'status' => 'required',
                'start_date' => 'required|date',
                'end_date' => 'required|date',
                'user_id' => 'required'
            ]);

            if ($validatedData->fails()) {
                return response()->json($validatedData->errors(), 422);
            }

            $message = $this->messageService->update($id, $request->all());
            return response()->json([
                'message' => 'Mensagem atualizada com sucesso!',
                'data' => new MessagesResource($message),
            ], 201);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'data' => false,
            ], 404);
        }

    }

    public function destroy(int $id)
    {
        try {
            $this->messageService->delete($id);
            return response()->json([
                'message' => 'Mensagem removida com sucesso!',
                'data' => [],
            ], 201);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'data' => false,
            ], 404);
        }

    }

    public function prioritizeMessage(int $id)
    {
        try {

            $message = $this->messageService->prioritizeMessage($id);

            return response()->json([
                'message' => 'Mensagem priorizada com sucesso',
                'data' => new MessagesResource($message),
            ], 201);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'data' => false,
            ], 500);
        }
    }
}
