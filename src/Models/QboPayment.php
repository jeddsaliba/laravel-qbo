<?php

namespace Pns\LaravelQbo\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use QuickBooksOnline\API\Facades\Payment;

class QboPayment extends Model
{
    use HasFactory;

    public function store($dataService, $request) {

        $items = [];

        $payment = Payment::create([
            "TotalAmt" => $request->total_amount, 
            "CustomerRef"=> [
                "value"=> $request->qbo_customer_id,
            ]
        ]);
        $store = $dataService->Add($invoice);
        $error = $dataService->getLastError();
        if ($error) {
            return (object)[
                'status' => false,
                'message' => $error->getIntuitErrorMessage()
            ];
        }
        return (object)[
            'status' => true,
            'message' => 'Invoice created.',
            'invoiceInfo' => $store
        ];
    }
}
