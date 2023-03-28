<?php

namespace App\Services;

use App\Models\Message;
use App\Repositories\RepositoryInterface;
use Illuminate\Support\Collection;

class MessageService
{
    protected $messageRepository;

    public function __construct(RepositoryInterface $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }

    public function getAll(): Collection
    {
        return $this->messageRepository->getAll();
    }

    public function create(array $data): Message
    {
        return $this->messageRepository->create($data);
    }

    public function update(int $id, array $data): Message
    {
        return $this->messageRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->messageRepository->delete($id);
    }
}
