<?php

namespace App\Repositories;

use App\Models\Message;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

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

    public function getMessagesOnTimeIsActive(): Collection
    {
        $now = Carbon::now();

        return $this->model->whereRaw('? between initial_display and final_display', [$now])->where('status', 1)->get();
    }
}
