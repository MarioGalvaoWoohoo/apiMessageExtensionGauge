<?php

namespace App\Repositories;

use App\Http\Resources\MessagesWithStatusIfReadResource;
use App\Models\Message;
use App\Models\MessageViewed;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MessageRepository implements MessageRepositoryInterface
{
    protected $model;

    public function __construct(Message $model)
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

    public function update(int $id, array $data): bool
    {
        return $this->model->find($id)->update($data);
    }

    public function delete(int $id): bool
    {
        return $this->model->find($id)->delete();
    }

    public function getAllIsActive(): Collection
    {
        return $this->model->where('status', 1)->get();
    }

    public function unreadMessages(string $userId): Collection
    {
        $now = Carbon::now();

        $messages = $this->model
            ->select('id', 'title', 'message', 'type', 'start_date', 'end_date')
            ->whereRaw('? between start_date and end_date', [$now])
            ->where('status', 1)
            ->with(['messages_viewed' => function ($query) use ($userId) {
                $query->where('unknown_user', $userId);
            }])
            ->get()
            ->map(function ($message) {
                $isRead = $message['is_read'] || !empty($message['messages_viewed']);
                unset($message['messages_viewed']);
                return array_merge($message->toArray(), ['is_read' => $isRead]);
            });

        return new Collection($messages);
    }

    public function messagesOnTimeIsActive(): Collection
    {
        $now = Carbon::now();
        return new Collection(
            $this->model
            ->where('status', 1)
            ->whereRaw('? between start_date and end_date', [$now])
            ->get()
        );
    }
}
