<?php

namespace Pns\LaravelQbo\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use QuickBooksOnline\API\Facades\Payment;

class QboPayment extends Model
{
    use HasFactory;

    protected $table = 'qbo_payments';

    protected $fillable = [
        'reference_id',
        'qbo_id',
        'qbo_invoice_id',
        'qbo_customer_id',
        'qbo_paid_amount'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'reference_id' => 'integer',
        'qbo_id' => 'integer',
        'qbo_invoice_id' => 'integer',
        'qbo_customer_id' => 'integer',
        'qbo_paid_amount' => 'decimal: 2'
    ];

    public function store($dataService, $request) {

        $items = [];

        $payment = Payment::create([
            "TotalAmt" => $request->total_amount, 
            "CustomerRef"=> [
                "value"=> $request->qbo_customer_id,
            ]
        ]);
        $store = $dataService->Add($payment);
        $error = $dataService->getLastError();
        if ($error) {
            return (object)[
                'status' => false,
                'message' => $error->getIntuitErrorMessage()
            ];
        }
        $payment = QboPayment::updateOrCreate([
            'qbo_id' => $store->Id
        ], [
            'reference_id' =>  $request->reference_id,
            'qbo_id' =>  $store->Id,
            'qbo_customer_id' => $store->CustomerRef,
            'qbo_total_amount' => $store->TotalAmt
        ]);
        if (!$payment) {
            return (object)[
                'status' => false,
                'message' => 'Could not save payment. Please try again.'
            ];
        }
        return (object)[
            'status' => true,
            'message' => 'Payment created.',
            'paymentInfo' => $store
        ];
    }
}
