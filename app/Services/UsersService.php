<?php

namespace App\Services;

use App\Repositories\Contracts\UsersRepository;
use App\Services\Interfaces\CRUDServiceInterface;
use App\Services\Interfaces\UsersServiceInterface;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

class UsersService implements CRUDServiceInterface, UsersServiceInterface
{
    public function __construct(
        private UsersRepository $usersRepository
    ) {
    }

    public function create(array $inputs): Model
    {
        return $this->usersRepository->save($inputs);
    }

    public function read(int $id): Model
    {
        $user =  $this->usersRepository->findById($id);
        if (!$user)
            throw new Exception("User not found!",Response::HTTP_BAD_REQUEST);
        return $user;
    }

    public function update(int $id, array $inputs): bool
    {
        $user = $this->read($id);
        return $this->usersRepository->update($user, $inputs);
    }

    public function delete(int $id): bool
    {
        $user = $this->read($id);
        return $this->usersRepository->delete($user);
    }

   
}
