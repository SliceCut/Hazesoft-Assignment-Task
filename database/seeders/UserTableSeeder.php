<?php

namespace Database\Seeders;

use App\Domain\Factories\UserFactory;
use App\Domain\Repositories\User\UserRepositoryInterface;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    public function __construct(
        UserRepositoryInterface $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            [
                'id' => 1,
                'name' => 'Hazesoft',
                'email' => 'hazesoft@gmail.com',
                'password' => Hash::make('admin123')
            ]
        ];

        $this->userRepository->insertUsers($items);
    }
}
