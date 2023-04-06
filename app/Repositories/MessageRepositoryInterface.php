<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface MessageRepositoryInterface
{
    public function getAll(): Collection;

    public function getAllIsActive(): Collection;

    public function unreadMessages(string $user_id): Collection;

    public function messagesOnTimeIsActive(): Collection;

    public function create(array $data): Model;

    public function findById(int $id): ?Model;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;
}
