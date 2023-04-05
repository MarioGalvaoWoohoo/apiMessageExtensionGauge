<?php

namespace App\Repositories;

use App\Models\MessageViewed;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class MessageViewedRepository implements MessageViewedRepositoryInterface
{
    protected $model;

    public function __construct(MessageViewed $model)
    {
        $this->model = $model;
    }

    public function getAll(): Collection
    {
        return $this->model->all();
    }

    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    public function findById(int $id): ?Model
    {
        return $this->model->find($id);
    }

    public function checkIfUserViewedMessage(string $userHashFront, int $messageId): bool
    {
        $model = $this->model::where('unknown_user', $userHashFront)
                            ->where('message_id', $messageId)
                            ->first();

        return $model ? false : true;
    }

}
