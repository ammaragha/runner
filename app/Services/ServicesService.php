<?php

namespace App\Services;

use App\Models\Service;
use App\Services\Interfaces\CRUDServiceInterface;
use App\Services\Interfaces\ServicesServiceInterface;
use App\Repositories\Contracts\ServicesRepository;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

class ServicesService implements CRUDServiceInterface, ServicesServiceInterface
{

    public function __construct(
        private  ServicesRepository $serviceRepo
    ) {
    }

    public function create(array $inputs): Service
    {
        return  $this->serviceRepo->save($inputs);
    }

    public function read(int $id): Service
    {
        $service = $this->serviceRepo->findById($id);
        if (!$service)
            throw new Exception("Service not found", Response::HTTP_NOT_FOUND);
        return $service;
    }

    public function update(int $id, array $inputs): bool
    {
        $service = $this->read($id);
        return  $this->serviceRepo->update($service, $inputs);
    }

    public function delete(int $id): bool
    {
        $service = $this->read($id);
        return $this->serviceRepo->delete($service);
    }

    public function all(): Collection
    {
        return $this->serviceRepo->all();
    }

    public function pagination(int $perPage, string $orderField, string $orderType)
    {
        return $this->serviceRepo->pagination($perPage, $orderField, $orderType);
    }

    public function search(string $searchKey, string $searchValue, string $orderField, string $orderType)
    {
        $services = $this->serviceRepo->search($searchKey, $searchValue, $orderField, $orderType);
        return $services;
    }
}
