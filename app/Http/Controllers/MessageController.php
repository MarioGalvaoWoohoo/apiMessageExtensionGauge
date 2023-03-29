<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageRequest;
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

    public function index()
    {
        try {
            $messages =  $this->messageService->getAll();
            return response()->json([
                'message' => 'Listagem realizada com sucesso',
                'data' => $messages,
            ], 201);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'data' => false,
            ], 404);
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = Validator::make($request->all(), [
                'title' => 'required|min:20|max:150',
                'message' => 'required|min:50|max:255',
                // 'notify' => 'required',
                // 'status' => 'required',
                'initial_display' => 'required|date',
                'final_display' => 'required|date',
                'user_id' => 'required'
            ]);

            if ($validatedData->fails()) {
                return response()->json($validatedData->errors(), 422);
            }

            $message = $this->messageService->create($request->all());
            return response()->json([
                'message' => 'Cadastro realizado com sucesso',
                'data' => $message,
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
            $this->messageService->findById($id);

            $validatedData = Validator::make($request->all(), [
                'title' => 'required|min:20|max:150',
                'message' => 'required|min:50|max:255',
                // 'notify' => 'required',
                // 'status' => 'required',
                'initial_display' => 'required|date',
                'final_display' => 'required|date',
                'user_id' => 'required'
            ]);

            if ($validatedData->fails()) {
                return response()->json($validatedData->errors(), 422);
            }

            $message = $this->messageService->update($id, $request->all());
            return response()->json([
                'message' => 'Mensagem atualizada com sucesso!',
                'data' => $message,
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
            $this->messageService->findById($id);
            $this->messageService->delete($id);
            return response()->json([
                'message' => 'Mensagem removida com sucesso!',
                'data' => [],
            ], 204);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'data' => false,
            ], 404);
        }

    }
}
