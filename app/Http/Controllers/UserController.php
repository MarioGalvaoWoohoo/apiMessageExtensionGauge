<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    protected $userService;
    protected $authService;

    public function __construct(UserService $userService, AuthService $authService)
    {
        $this->userService = $userService;
        $this->authService = $authService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listAll()
    {
        try {
            $user =  $this->userService->getAll();
            return response()->json([
                'message' => 'Listagem realizada com sucesso',
                'data' => UserResource::collection($user),
            ], 201);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'data' => false,
            ], 404);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        try {
            $user =  $this->userService->findById($id);
            return response()->json([
                'message' => 'Listagem realizada com sucesso',
                'data' => new UserResource($user),
            ], 201);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'data' => false,
            ], 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

        $validatedData = Validator::make($request->all(), [
            'name' => 'required|max:150',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        if ($validatedData->fails()) {
            return response()->json($validatedData->errors(), 422);
        }

        $request['password'] = bcrypt($request->input('password'));

        $newUser = $this->userService->create($request->all());

        return response()->json([
            'message' => 'Cadastro realizado com sucesso',
            'data' => new UserResource($newUser)
        ], 201);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'data' => false,
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $this->userService->findById($id);

            $validatedData = Validator::make($request->all(), [
                'name' => 'required|max:150',
            ]);

            if ($validatedData->fails()) {
                return response()->json($validatedData->errors(), 422);
            }

            $message = $this->userService->update($id, $request->all());
            return response()->json([
                'message' => 'Usuário atualizado com sucesso!',
                'data' => new UserResource($message),
            ], 201);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'data' => false,
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->userService->delete($id);
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
