<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface MessageRepositoryInterface
{
    public function getAll(int $companyId): Collection;

    public function getAllIsActive(int $companyId): Collection;

    public function unreadMessages(string $user_id): Collection;

    public function messagesOnTimeIsActive(int $companyId): Collection;

    public function findByMessagePrioritize(int $companyId): ?Model;

    public function create(array $data): Model;

    public function findById(int $id): ?Model;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;

    public function deprioritizeAllMessage(int $companyId): bool;

    public function prioritizeMessage(int $id, int $companyId): Model;

    public function checkDisplayedMessage($messageId): bool;

    public function checkIfMessageIsActive($messageId, $companyId): bool;

}
