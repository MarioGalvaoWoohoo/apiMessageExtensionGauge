<?php

namespace App\Http\Controllers;

use App\Services\MessageViewedService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\{Request, Response};
use Illuminate\Support\Facades\Validator;

class MessageViewedController extends Controller
{
    protected $messageViewedService;

    public function __construct(MessageViewedService $messageViewedService)
    {
        $this->messageViewedService = $messageViewedService;
    }

    public function viewMessageByUser(Request $request)
    {
        try {
            $validatedData = Validator::make($request->all(), [
                'message_id' => 'required',
                'unknown_user' => 'required|string|min:30',
            ]);

            if ($validatedData->fails()) {
                return response()->json($validatedData->errors(), 422);
            }

            $messageviewed = $this->messageViewedService->viewMessageByUser($request->all());
            return response()->json([
                'message' => 'Mensagem visualizada com sucesso',
                'data' => $messageviewed,
            ], 201);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'data' => false,
            ], 404);
        }
    }

}
