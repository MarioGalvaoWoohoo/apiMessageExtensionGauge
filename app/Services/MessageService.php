<?php

namespace App\Services;

use App\Models\Message;
use Illuminate\Support\Collection;
use App\Repositories\RepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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

    public function findById(int $id): Message
    {
        $message = $this->messageRepository->findById($id);

        if (!$message) {
            throw new ModelNotFoundException('Não existe mensagem para o ID informado');
        }

        return $message;
    }

    public function create($data): Message
    {
        return $this->messageRepository->create($data);
    }

    public function update(int $id, array $data): Message
    {
        if ($this->messageRepository->update($id, $data)){
            return $this->messageRepository->findById($id);
        }

        return false;
    }

    public function delete(int $id): bool
    {
        return $this->messageRepository->delete($id);
    }

    public function getMessageIsActive(): Collection
    {
        return $this->messageRepository->getAllIsActive();
    }

    public function getMessageOnTimeIsActive(): Collection
    {
        return $this->messageRepository->getMessagesOnTimeIsActive();
    }
}
