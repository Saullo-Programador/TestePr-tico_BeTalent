<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionProducts;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PurchaseController extends Controller
{

    public function purchase(Request $request)
    {

        $request->validate([
            "name" => "required",
            "email" => "required|email",
            "cardNumber" => "required",
            "cvv" => "required",
            "products" => "required|array|min:1",
            "products.*.id" => "required|integer",
            "products.*.quantity" => "required|integer|min:1"
        ]);

        return DB::transaction(function () use ($request) {

            $products = $request->products;
            $amount = 0;

            foreach ($products as $item) {

                $product = Product::findOrFail($item['id']);
                $amount += $product->amount * $item['quantity'];
            }

            $client = Client::create([
                "name" => $request->name,
                "email" => $request->email
            ]);

            try {

                $payment = app(PaymentService::class)->charge([
                    "amount" => $amount,
                    "name" => $request->name,
                    "email" => $request->email,
                    "cardNumber" => $request->cardNumber,
                    "cvv" => $request->cvv
                ]);
            } catch (\Exception $e) {

                Log::error("Payment failed: " . $e->getMessage());
                $payment = ["id" => null];
            }

            $transaction = Transaction::create([
                "client_id" => $client->id,
                "gateway_id" => 1,
                "external_id" => $payment["id"] ?? null,
                "status" => $payment["id"] ? "success" : "failed",
                "amount" => $amount,
                "card_last_numbers" => substr($request->cardNumber, -4)
            ]);

            foreach ($products as $item) {

                TransactionProducts::create([
                    "transaction_id" => $transaction->id,
                    "product_id" => $item["id"],
                    "quantity" => $item["quantity"]
                ]);
            }

            return response()->json([
                "status" => $payment["id"] ? "success" : "failed",
                "amount" => $amount
            ]);
        });
    }
}
