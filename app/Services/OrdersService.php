<?php

namespace App\Services;

use App\Repositories\Contracts\AddressesRepository;
use App\Repositories\Contracts\OrdersRepository;
use App\Repositories\Contracts\UsersRepository;
use App\Services\Interfaces\CRUDServiceInterface;
use App\Services\Interfaces\OrdersServiceInterface;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class OrdersService implements CRUDServiceInterface, OrdersServiceInterface
{
    public function __construct(
        private OrdersRepository $ordersRepository,
        private AddressesRepository $addressesRepository,
        private UsersRepository $usersRepository
    ) {
    }

    public function create(array $inputs): Model
    {
        return $this->ordersRepository->save($inputs);
    }

    public function read(int $id): Model
    {
        $order =  $this->ordersRepository->findById($id);
        if (!$order)
            throw new Exception("Order not found!", Response::HTTP_BAD_REQUEST);
        return $order;
    }

    public function update(int $id, array $inputs): bool
    {
        $order = $this->read($id);
        return $this->ordersRepository->update($order, $inputs);
    }

    public function delete(int $id): bool
    {
        $order = $this->read($id);
        return $this->ordersRepository->delete($order);
    }

    public function findRunner(array $inputs): LengthAwarePaginator
    {
        $address_id = $inputs['address_id'];
        $address = $this->addressesRepository->findById($address_id);
        
        $inputs['state'] = $address->state;
        $users = $this->usersRepository->getRunnerUsersForOrder("id","ASC",$inputs);

        return $users->paginate(5,["users.*"]);
    }
}
