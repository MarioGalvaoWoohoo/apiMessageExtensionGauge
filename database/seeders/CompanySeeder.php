<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CompanySeeder extends Seeder
{

    protected $model;

    public function __construct(Company $model)
    {
        $this->model = $model;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->model->create(
            [
                'name_company' => 'Gauge',
            ]
        );
        $this->model->create(
            [
                'name_company' => 'EcGlobal',
            ]
        );
    }
}
