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
                            "DiscountPercent" => $item['discount_percent'] /* if PercentBased = true */
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
        $store = $this->_dataService->Add($invoice);
        $error = $this->_dataService->getLastError();
        if ($error) {
            return [
                'status' => false,
                'message' => $error->getIntuitErrorMessage()
            ];
        }
        return [
            'status' => true,
            'message' => 'Invoice created.',
            'invoiceInfo' => $invoice
        ];
        /* $store = QboInvoice::updateOrCreate([
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
        return $store; */
    }
}
