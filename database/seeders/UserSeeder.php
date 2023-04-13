<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{

    protected $model;

    public function __construct(User $model)
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
        // $this->model->create([
        //     'name' => 'Admin Gauge',
        //     'email' => 'admin_gauge_message@gauge.com.br',
        //     'password' => Hash::make('Gauge@2023'),
        //     'session_id' => '0'
        // ]);

        $this->model->create([
            'name' => 'Mario George',
            'email' => 'mario.galvao.woohoo@gmail.com.br',
            'password' => Hash::make('M@rio1986'),
            'session_id' => '0'
        ]);
    }
}
