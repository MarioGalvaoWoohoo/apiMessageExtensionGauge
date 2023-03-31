<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Collection;
use App\Repositories\userRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAll(): Collection
    {
        return $this->userRepository->getAll();
    }

    public function findById(int $id): User
    {
        $user = $this->userRepository->findById($id);

        if (!$user) {
            throw new ModelNotFoundException('Não existe usuário para o ID informado');
        }

        return $user;
    }

    public function findByEmail(string $email): User
    {
        $user = $this->userRepository->getByEmail($email);

        if (!$user) {
            throw new ModelNotFoundException('Não existe usuário para o email informado');
        }

        return $user;
    }

    public function create($data): User
    {
        return $this->userRepository->create($data);
    }

    public function update(int $id, array $data): User
    {
        if ($this->userRepository->update($id, $data)){
            return $this->userRepository->findById($id);
        }

        return false;
    }

    public function delete(int $id): bool
    {
        $this->findById($id);
        return $this->userRepository->delete($id);
    }

}
