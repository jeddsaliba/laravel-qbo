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
        'qbo_invoice_no',
        'qbo_invoice_link',
        'qbo_total_amount',
        'qbo_paid_amount',
        'qbo_balance_amount'
    ];

    protected $appends = [
        'qbo_invoice_pdf'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public $qboId;

    public function getQboIdAttribute($value){
        $this->qboId = $value;
        return $value;
    }

    public function getQboInvoicePdfAttribute($value) {
        $qbo_link = NULL;
        if ($this->qboId) {
            $qbo_link = "https://c50.sandbox.qbo.intuit.com/qbo50/v4/companies/".config('qbo.company_id')."/transactions/".$this->qboId.".pdf";
        }
        return $qbo_link;
    }

    public function store($request, $id) {
        $store = QuickBooksOnlineInvoice::updateOrCreate([
            'reference_id' => $id
        ], [
            'reference_id' =>  $id,
            'qbo_id' =>  $request->qbo_id,
            'qbo_invoice_no' => $request->qbo_invoice_no,
            'qbo_invoice_link' => $request->qbo_invoice_link,
            'qbo_total_amount' => $request->qbo_total_amount,
            'qbo_paid_amount' => $request->qbo_paid_amount,
            'qbo_balance_amount' => $request->qbo_balance_amount
        ]);
        return $store;
    }
}
