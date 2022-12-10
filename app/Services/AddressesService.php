<?php

namespace App\Services;

use App\Repositories\Contracts\AddressesRepository;
use App\Services\Interfaces\AddressesServiceInterface;
use App\Services\Interfaces\CRUDServiceInterface;
use Exception;
use Illuminate\Database\Eloquent\Model;

class AddressesService implements CRUDServiceInterface, AddressesServiceInterface
{
    public function __construct(
        private AddressesRepository $addressesRepository
    ) {
    }

    public function create(array $inputs): Model
    {
        return $this->addressesRepository->save($inputs);
    }

    public function read(int $id): Model
    {
        $address = $this->addressesRepository->findById($id);
        if (!$address)
            throw new Exception("Address not found");
        return $address;
    }

    public function update(int $id, array $inputs): bool
    {
        $address = $this->read($id);
        return $this->addressesRepository->update($address, $inputs);
    }

    public function delete(int $id): bool
    {
        $address = $this->read($id);
        return $this->addressesRepository->delete($address);
    }
}
