<?php

namespace Pns\LaravelQbo\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QboInvoice extends Model
{
    use HasFactory;

    protected $table = 'qbo_invoices';

    protected $fillable = [
        'reference_id',
        'qbo_id',
        'qbo_customer_id',
        'qbo_invoice_no',
        'qbo_print_status',
        'qbo_due_date',
        'qbo_email_status',
        'qbo_invoice_link',
        'qbo_total_amount',
        'qbo_paid_amount',
        'qbo_balance_amount'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function store($request, $id) {
        $store = QboInvoice::updateOrCreate([
            'qbo_id' => $id
        ], [
            'reference_id' =>  $request->reference_id,
            'qbo_id' =>  $request->qbo_id,
            'qbo_customer_id' => $request->qbo_customer_id,
            'qbo_invoice_no' => $request->qbo_invoice_no,
            'qbo_print_status' => $request->qbo_print_status,
            'qbo_due_date' => $request->qbo_due_date,
            'qbo_email_status' => $request->qbo_email_status,
            'qbo_invoice_link' => $request->qbo_invoice_link,
            'qbo_total_amount' => $request->qbo_total_amount,
            'qbo_paid_amount' => $request->qbo_paid_amount,
            'qbo_balance_amount' => $request->qbo_balance_amount
        ]);
        return $store;
    }
}
