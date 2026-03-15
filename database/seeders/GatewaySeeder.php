<?php

namespace Database\Seeders;
use App\Models\Gateway;
use Illuminate\Database\Seeder;

class GatewaySeeder extends Seeder
{

    public function run()
    {

        Gateway::create([
            "name" => "App\Gateways\GatewayOne",
            "priority" => 1
        ]);

        Gateway::create([
            "name" => "App\Gateways\GatewayTwo",
            "priority" => 2
        ]);
    }
}
