<?php

namespace App\Services;

use App\Models\Message;
use App\Repositories\RepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use InvalidArgumentException;
use stdClass;

use function PHPUnit\Framework\isNull;

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

    public function create(array $data): Message
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
}
