<?php

namespace App\Gateways\Contracts;

interface GatewayInterface
{
    public function charge(array $data);

    public function refund(string $transactionId);
}
