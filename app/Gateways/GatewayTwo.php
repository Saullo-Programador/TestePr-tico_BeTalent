<?php

namespace App\Gateways;

use App\Gateways\Contracts\GatewayInterface;
use Illuminate\Support\Facades\Http;

class GatewayTwo implements GatewayInterface
{

    public function charge(array $data)
    {

        return Http::withHeaders([

            "Gateway-Auth-Token"=>"tk_f2198cc671b5289fa856",
            "Gateway-Auth-Secret"=>"3d15e8ed6131446ea7e3456728b1211f"

        ])->post("http://localhost:3002/transacoes",[

            "valor"=>$data['amount'],
            "nome"=>$data['name'],
            "email"=>$data['email'],
            "numeroCartao"=>$data['cardNumber'],
            "cvv"=>$data['cvv']

        ]);

    }

    public function refund(string $transactionId)
    {

        return Http::withHeaders([

            "Gateway-Auth-Token"=>"tk_f2198cc671b5289fa856",
            "Gateway-Auth-Secret"=>"3d15e8ed6131446ea7e3456728b1211f"

        ])->post("http://localhost:3002/transacoes/reembolso",[

            "id"=>$transactionId

        ]);

    }

}
