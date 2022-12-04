<?php

namespace App\Services;

use App\Services\Interfaces\CRUDServiceInterface;
use App\Services\Interfaces\ServicesServiceInterface;

class ServicesService implements CRUDServiceInterface, ServicesServiceInterface
{

    public function __construct(
        private  $categoriesRepo
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
        if (!$category)
            return false;
        return  $this->categoriesRepo->update($category, $inputs);
    }

    public function delete(int $id)
    {
        $category = $this->categoriesRepo->findById($id);
        if (!$category)
            return false;
        return $this->categoriesRepo->delete($category);
    }

    public function all()
    {
        return $this->categoriesRepo->all();
    }
}
