<?php

namespace App\Repositories;

use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class CompanyRepository implements CompanyRepositoryInterface
{
    protected $model;

    public function __construct(Company $model)
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

}
