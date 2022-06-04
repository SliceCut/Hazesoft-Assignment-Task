<?php

namespace Database\Seeders;

use App\Domain\Factories\CompanyFactory;
use App\Domain\Repositories\Company\CompanyRepositoryInterface;
use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    private CompanyRepositoryInterface $companyRepository;

    public function __construct(
        CompanyRepositoryInterface $companyRepository
    ) {
        $this->companyRepository = $companyRepository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companies = Company::factory()
            ->count(10)
            ->make()
            ->each(function ($row) {
                $this->companyRepository->createNewCompany(
                    CompanyFactory::make($row->toArray())
                );
            });
    }
}
