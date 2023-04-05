<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface MessageViewedRepositoryInterface
{
    public function getAll(): Collection;

    public function create(array $data): Model;

    public function findById(int $id): ?Model;

    public function checkIfUserViewedMessage(string $userHashFront, int $messageId): bool;
}
