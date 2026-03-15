<?php

namespace App\Services;

use App\Models\Gateway;

class PaymentService
{

    public function charge(array $data)
    {

        $gateways = Gateway::where("is_active", true)
            ->orderBy("priority")
            ->get();

        foreach ($gateways as $gateway) {

            try {

                $service = app($gateway->name);

                $response = $service->charge($data);

                if ($response->successful()) {

                    return [

                        "gateway" => $gateway,
                        "response" => $response->json()

                    ];
                }
            } catch (\Exception $e) {

                continue;
            }
        }

        throw new \Exception("Todos os gateways falharam");
    }
}
