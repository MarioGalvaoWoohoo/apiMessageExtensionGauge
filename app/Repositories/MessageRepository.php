<?php

namespace App\Repositories;

use App\Models\Message;
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

        $unreadMessages = Message::leftJoin('messages_viewed', function ($join) use ($userId) {
            $join->on('messages.id', '=', 'messages_viewed.message_id')
                ->where('messages_viewed.unknown_user', '=', $userId);
            })
            ->select('messages.*',
                DB::raw('(CASE WHEN messages_viewed.id IS NULL THEN FALSE ELSE TRUE END) as is_read'))
            ->whereRaw('? between start_date and end_date', [$now])
            ->where('status', 1)
            ->get();

        return new Collection($unreadMessages);
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
