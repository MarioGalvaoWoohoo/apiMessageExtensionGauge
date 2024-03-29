<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface CompanyRepositoryInterface
{
    public function getAll(): Collection;

    public function create(array $data): Model;

    public function findById(int $id): ?Model;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;
}
