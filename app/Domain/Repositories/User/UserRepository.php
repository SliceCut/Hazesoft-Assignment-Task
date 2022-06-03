<?php

namespace App\Domain\Repositories\User;

use App\Domain\ObjectValues\UserObjectValue;
use App\Domain\Repositories\BaseRepository;
use App\Models\User;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    public function findUserBy(array $data)
    {
        return $this->findOneBy($data);
    }

    public function getUsers(array $select = ['*'], string $order = 'id', string $sort = 'desc')
    {
        return $this->all($select, $order, $sort);        
    }

    public function createNewUser(UserObjectValue $userObjectValue)
    {
        return $this->create($userObjectValue->toSql());
    }

    public function createUserToken(User $user)
    {
        return $user->createToken('authToken');
    }

    public function insertUsers(array $data)
    {
        return $this->insertMultiple($data);
    }
}