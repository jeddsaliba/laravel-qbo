<?php

namespace Pns\LaravelQbo\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use QuickBooksOnline\API\Facades\Invoice;

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

    public function store($dataService, $request) {

        $items = [];

        if ($request->items) {
            foreach ($request->items as $item) {
                if ($item['detail_type'] == 'SalesItemLineDetail') {
                    $items[] = [
                        "DetailType" => $item['detail_type'],
                        "Description" => $item['description'],
                        "Amount" => $item['qty'] * $item['unit_price'],
                        "SalesItemLineDetail" => [
                            "Qty" => $item['qty'],
                            "UnitPrice" => $item['unit_price']
                        ]
                    ];
                } else if ($item['detail_type'] == 'SubTotalLineDetail') {
                    $items[] = [
                        "DetailType" => $item['detail_type'],
                        "Amount" => $item['amount']
                    ];
                } else if ($item['detail_type'] == 'DiscountLineDetail') {
                    $items[] = [
                        "DetailType" => $item['detail_type'], 
                        "Amount" => $item['amount'], /* if PercentBased = false */
                        "DiscountLineDetail" => [
                            "PercentBased" => filter_var($item['percent_based'], FILTER_VALIDATE_BOOLEAN), 
                            "DiscountPercent" => $item['discount_percent'] ?? 0 /* if PercentBased = true */
                        ]  
                    ];
                }
            }
        }

        $invoice = Invoice::create([
            /* 'DocNumber' => $transaction_no, */
            "TotalAmt" => $request->total_amount,
            "Line" => $items,
            "CustomerRef"=> [
                "name" => $request->qbo_customer_display_name,
                "value"=> $request->qbo_customer_id,
            ],
            "BillEmail" => [
                "Address" => $request->qbo_customer_email_address,
            ]/* ,
            "DueDate" => // date here : 2022-10-19 */
        ]);
        $store = $dataService->Add($invoice);
        $error = $dataService->getLastError();
        if ($error) {
            return [
                'status' => false,
                'message' => $error->getIntuitErrorMessage()
            ];
        }
        return [
            'status' => true,
            'message' => 'Invoice created.',
            'invoiceInfo' => $store
        ];
        $invoice = QboInvoice::updateOrCreate([
            'qbo_id' => $store->Id
        ], [
            'reference_id' =>  $request->reference_id,
            'qbo_id' =>  $store->Id,
            'qbo_customer_id' => $store->CustomerRef->value ?? null,
            'qbo_invoice_no' => $store->DocNumber,
            'qbo_print_status' => $store->PrintStatus,
            'qbo_due_date' => $store->DueDate,
            'qbo_email_status' => $store->EmailStatus,
            'qbo_invoice_link' => $store->InvoiceLink,
            'qbo_total_amount' => $store->TotalAmt,
            'qbo_paid_amount' => $store->Deposit,
            'qbo_balance_amount' => $store->Balance
        ]);
    }
}
