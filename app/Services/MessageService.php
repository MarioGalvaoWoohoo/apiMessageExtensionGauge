<?php

namespace App\Services;

use App\Exceptions\CustomException;
use App\Models\Message;
use Illuminate\Support\Collection;
use App\Repositories\MessageRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

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
        try {
            $message = $this->messageRepository->findById($id);

            if (!$message) {
                throw new ValidationException('Não existe mensagem para o ID informado');
            }

            return $message;
        } catch (ValidationException $exception) {
            throw new CustomException([
                "error" => $exception->validator,
            ], $exception->status);
        }
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

    public function prioritizeMessage(array $data): Message
    {
        try {
            $messageId = $data['messageId'];

            $messageWithinPeriod = $this->messageRepository->checkDisplayedMessage($messageId);

            if (!$messageWithinPeriod) {
                throw new ValidationException('Mensagem fora do prazo de exibição ou inativa.');
            }

            return $this->messageRepository->prioritizeMessage($messageId);
        } catch (ValidationException $exception) {
            throw new CustomException([
                "error" => $exception->validator,
            ], $exception->status);
        }
    }

    public function deprioritizeMessages(): bool
    {
        return $this->messageRepository->deprioritizeAllMessage();
    }

    public function getMessagePriority(): ?Message
    {
        return $this->messageRepository->findByMessagePrioritize();
    }

}
