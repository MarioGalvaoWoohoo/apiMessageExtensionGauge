<?php

namespace App\Services;

use App\Models\Message;
use App\Models\MessageViewed;
use App\Repositories\MessageRepositoryInterface;
use App\Repositories\MessageViewedRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MessageViewedService
{
    protected $messageViewedRepository;
    protected $messageRepository;

    public function __construct(
        MessageViewedRepositoryInterface $messageViewedRepository,
        MessageRepositoryInterface $messageRepository
    )
    {
        $this->messageViewedRepository = $messageViewedRepository;
        $this->messageRepository = $messageRepository;
    }

    public function findById(int $id): Message
    {
        $message = $this->messageRepository->findById($id);

        if (!$message) {
            throw new ModelNotFoundException('Não existe mensagem para o ID informado');
        }

        return $message;
    }

    public function viewMessageByUser($data): MessageViewed
    {
        $this->findById($data['message_id']);

        if (!$this->messageViewedRepository->checkIfUserViewedMessage($data['unknown_user'], $data['message_id'])) {
            throw new ModelNotFoundException('Mensagem já consta como visualizada pelo usuário');
        }

        return $this->messageViewedRepository->create($data);
    }

}
