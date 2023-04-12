<?php

namespace App\Services;

use App\Models\Message;
use Illuminate\Support\Collection;
use App\Repositories\MessageRepositoryInterface;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MessageService
{
    protected $messageRepository;

    public function __construct(MessageRepositoryInterface $messageRepository)
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

    public function checkIfMessageIsWithinTheDisplayPeriod(int $messageId)
    {
        $message = $this->messageRepository->checkDisplayedMessage($messageId);

        if (!$message) {
            throw new ModelNotFoundException('Mensagem fora do prazo de exibição. Mensagem priorizada deve esta dentro do prazo de exibição.');
        }

        return $message;
    }

    public function checkIfMessageIsActive(int $messageId)
    {
        $message = $this->messageRepository->checkIfMessageIsActive($messageId);

        if (!$message) {
            throw new ModelNotFoundException('Mensagem não esta ativa. Mensagem priorizada deve esta ativa.');
        }

        return $message;
    }

    public function findByMessagePrioritize(): Message
    {
        return $this->messageRepository->findByMessagePrioritize();
    }

    public function create($data): Message
    {
        return $this->messageRepository->create($data);
    }

    public function update(int $id, array $data): Message
    {
        $this->findById($id);
        if ($this->messageRepository->update($id, $data)){
            return $this->messageRepository->findById($id);
        }
    }

    public function delete(int $id): bool
    {
        $this->findById($id);
        return $this->messageRepository->delete($id);
    }

    public function getMessageIsActive(): Collection
    {
        return $this->messageRepository->getAllIsActive();
    }

    public function messagesOnTimeIsActive(): Collection
    {
        return $this->messageRepository->messagesOnTimeIsActive();
    }

    public function unreadMessages(string $userId): EloquentCollection
    {
        return $this->messageRepository->unreadMessages($userId);
    }

    public function prioritizeMessage(int $messageId): Message
    {
        $this->findById($messageId);
        $this->checkIfMessageIsActive($messageId);
        $this->checkIfMessageIsWithinTheDisplayPeriod($messageId);
        return $this->messageRepository->prioritizeMessage($messageId);
    }

}
