<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;


interface UserRepositoryInterface
{
    public function getAll(): Collection;

    public function create(array $data): User;

    public function findById(int $id): ?User;

    public function getByEmail(string $email): ?User;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;


}
