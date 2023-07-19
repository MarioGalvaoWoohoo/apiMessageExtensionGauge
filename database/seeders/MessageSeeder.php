<?php

namespace Database\Seeders;

use App\Models\Message;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MessageSeeder extends Seeder
{

    protected $model;

    public function __construct(Message $model)
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
                "title" => "Mensagem Exemplo criada via seed para development",
                "message" => "Titulo da Mensagem Para melhorar o conteúdo melhorar o conteúdo melhorar o conteúdo",
                "type" => 1,
                "company_id" => 1,
                "start_date" => Carbon::today(),
                "end_date" => Carbon::today()->addDays(5),
                "user_id" => 1
            ]
        );
        $this->model->create(
            [
                "title" => "Mensagem Exemplo criada via seed para development",
                "message" => "Titulo da Mensagem Para melhorar o conteúdo melhorar o conteúdo melhorar o conteúdo",
                "type" => 2,
                "company_id" => 2,
                "start_date" => Carbon::today(),
                "end_date" => Carbon::today()->addDays(5),
                "user_id" => 1
            ],
        );
        $this->model->create(
            [
                "title" => "Mensagem Exemplo criada via seed para development",
                "message" => "Titulo da Mensagem Para melhorar o conteúdo melhorar o conteúdo melhorar o conteúdo",
                "type" => 3,
                "company_id" => 1,
                "start_date" => Carbon::today(),
                "end_date" => Carbon::today()->addDays(5),
                "user_id" => 1
            ],
        );
        $this->model->create(
            [
                "title" => "Mensagem Exemplo criada via seed para development",
                "message" => "Titulo da Mensagem Para melhorar o conteúdo melhorar o conteúdo melhorar o conteúdo",
                "type" => 1,
                "company_id" => 1,
                "start_date" => Carbon::today(),
                "end_date" => Carbon::today()->addDays(5),
                "user_id" => 1
            ],
        );
    }
}
