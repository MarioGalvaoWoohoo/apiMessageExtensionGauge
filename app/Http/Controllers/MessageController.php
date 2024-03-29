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
use Illuminate\Validation\ValidationException;

class MessageController extends Controller
{
    protected $messageService;

    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    public function listAll(Request $request)
    {
        try {

            $companyId = $request->header('company');
            $messages =  $this->messageService->getAll($companyId);
            return response()->json([
                'message' => 'Listagem realizada com sucesso',
                'data' => MessagesResource::collection($messages),
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'data' => false,
            ], 404);
        }
    }

    public function messagesIsActive(Request $request)
    {
        try {
            $companyId = $request->header('company');

            $messages =  $this->messageService->getMessageIsActive($companyId);
            return response()->json([
                'message' => 'Listagem realizada com sucesso',
                'data' => MessagesResource::collection($messages),
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'data' => false,
            ], 500);
        }
    }

    public function messagesOnTimeIsActive(Request $request)
    {
        try {
            $companyId = $request->header('company');

            $messages =  $this->messageService->messagesOnTimeIsActive($companyId);
            return response()->json([
                'message' => 'Listagem realizada com sucesso',
                'data' => MessagesResource::collection($messages),
            ], 200);
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
            $company = $request->header('company');
            $validatedData = Validator::make($request->all(), [
                'user_id' => 'required|min:30',
            ]);

            if ($validatedData->fails()) {
                return response()->json($validatedData->errors(), 422);
            }

            $messages = $this->messageService->unreadMessages($request->user_id, $company);

            return response()->json([
                'message' => 'Listagem realizada com sucesso',
                'data' => $messages,
            ], 200);
        } catch (\Exception $e) {
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
                'title' => 'required|min:10',
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

            $request['company_id'] = $request->header('company');

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
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'data' => false,
            ], 404);
        }

    }

    public function prioritizeMessage(Request $request)
    {
        try {
            $companyId = $request->header('company');
            $validatedData = Validator::make($request->all(), [
                'messageId' => 'required|integer',
            ]);

            if ($validatedData->fails()) {
                return response()->json($validatedData->errors(), 422);
            }

            $message = $this->messageService->prioritizeMessage($request->all(), $companyId);

            return response()->json([
                'message' => 'Mensagem priorizada com sucesso',
                'data' => new MessagesResource($message),
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'data' => false,
            ], 422);
        }
    }

    public function viewMessagePriority(Request $request)
    {
        try {
            $companyId = $request->header('company');
            $message =  $this->messageService->getMessagePriority($companyId);

            return response()->json([
                'message' => 'Listagem realizada com sucesso',
                'data' => $message !== null ? new MessagesResource($message) : [],
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'data' => false,
            ], 500);
        }
    }

    public function deprioritizeMessage(Request $request)
    {
        try {
            $companyId = $request->header('company');
            return response()->json([
                'message' => 'Mensagem despriorizada com sucesso',
                'data' => $this->messageService->deprioritizeMessages($companyId),
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'data' => false,
            ], 500);
        }
    }
}
