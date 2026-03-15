<?php

namespace App\Gateways;

use App\Gateways\Contracts\GatewayInterface;
use Illuminate\Support\Facades\Http;

class GatewayOne implements GatewayInterface
{

    private $token;

    public function authenticate()
    {

        $response = Http::post('http://localhost:3001/login',[
            "email"=>"dev@betalent.tech",
            "token"=>"FEC9BB078BF338F464F96B48089EB498"
        ]);

        $this->token = $response['access_token'];

    }

    public function charge(array $data)
    {

        $this->authenticate();

        return Http::withToken($this->token)
            ->post('http://localhost:3001/transactions',[
                "amount"=>$data['amount'],
                "name"=>$data['name'],
                "email"=>$data['email'],
                "cardNumber"=>$data['cardNumber'],
                "cvv"=>$data['cvv']
            ]);

    }

    public function refund(string $transactionId)
    {

        return Http::withToken($this->token)
            ->post("http://localhost:3001/transactions/$transactionId/charge_back");

    }

}
