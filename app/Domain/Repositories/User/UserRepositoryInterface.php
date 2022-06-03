<?php

namespace App\Domain\Repositories\User;

use App\Domain\ObjectValues\UserObjectValue;
use App\Models\User;

interface UserRepositoryInterface
{
    public function findUserBy(array $data);
    public function getUsers(
        array $select = ['*'],
        string $order = 'id',
        string $sort = 'desc'
    );
    public function createNewUser(UserObjectValue $userObjectValue);
    public function createUserToken(User $user);
    public function insertUsers(array $data);
}