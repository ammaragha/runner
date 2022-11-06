<?php

namespace App\Services;

use App\Repositories\Contracts\CategoriesRepository;
use App\Services\Interfaces\CategoriesServiceInterface;
use App\Services\Interfaces\CRUDServiceInterface;

class CategoriesService implements CRUDServiceInterface, CategoriesServiceInterface
{

    public function __construct(
        private CategoriesRepository $categoriesRepo
    ) {
    }

    public function create(array $inputs)
    {
        return  $this->categoriesRepo->save($inputs);
    }

    public function read(int $id)
    {
        return $this->categoriesRepo->findById($id);
    }

    public function update(int $id, array $inputs)
    {
        $category = $this->categoriesRepo->findById($id);
        return  $this->categoriesRepo->update($category, $inputs);
    }

    public function delete(int $id)
    {
        $category = $this->categoriesRepo->findById($id);
        return $this->categoriesRepo->delete($category);
    }
}
