<?php

namespace App\Services;

use App\Exceptions\CustomException;
use App\Models\Company;
use App\Repositories\CompanyRepositoryInterface;
use Illuminate\Support\Collection;
use Exception;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CompanyService
{
    protected $companyRepository;

    public function __construct(CompanyRepositoryInterface $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function getAll(): Collection
    {
        return $this->companyRepository->getAll();
    }

    public function findById(int $id): Company
    {
        try {
            $company = $this->companyRepository->findById($id);

            if (!$company) {
                throw new ValidationException('Não existe empresa para o ID informado');
            }

            return $company;
        } catch (ValidationException $exception) {
            throw new CustomException([
                "error" => $exception->validator,
            ], $exception->status);
        }
    }

    public function create($data): Company
    {
        return $this->companyRepository->create($data);
    }

    public function update(int $id, array $data): Company
    {
        $this->findById($id);
        if ($this->companyRepository->update($id, $data)){
            return $this->companyRepository->findById($id);
        }
    }

    public function delete(int $id): bool
    {
        $this->findById($id);
        return $this->companyRepository->delete($id);
    }
}
