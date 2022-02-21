<?php

namespace Pns\LaravelQbo\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use QuickBooksOnline\API\Facades\Customer;

class QboCustomer extends Model
{
    use HasFactory;

    protected $table = 'qbo_customers';

    protected $fillable = [
        'reference_id',
        'qbo_id',
        'qbo_display_name',
        'qbo_title',
        'qbo_given_name',
        'qbo_middle_name',
        'qbo_suffix',
        'qbo_family_name',
        'qbo_mobile_no',
        'qbo_phone_no',
        'qbo_email_address',
        'qbo_notes',
        'qbo_website',
        'qbo_active',
        'qbo_company_name',
        'qbo_balance',
        'qbo_is_project'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function store($dataService, $request)
    {
        $customer = Customer::create([
            /* "BillAddr" => [
               "Line1" =>  $request->billing_address_line_1,
               "City" =>  $request->billing_address_city,
               "Country" =>  $request->billing_address_country,
               "CountrySubDivisionCode" =>  $request->billing_address_sub_division_code,
               "PostalCode" => $request->billing_address_postal_code
           ], */
            "Notes" => $request->qbo_notes,
            "Title" => $request->qbo_title,
            "GivenName" => $request->qbo_given_name,
            "MiddleName" => $request->qbo_middle_name,
            "FamilyName" => $request->qbo_family_name,
            "Suffix" => $request->qbo_suffix,
            "FullyQualifiedName" => $request->qbo_given_name . " " . $request->qbo_family_name,
            "CompanyName" => $request->qbo_company_name,
            "DisplayName" => $request->qbo_given_name . " " . $request->qbo_family_name,
            "Mobile" => [
                "FreeFormNumber" => $request->qbo_mobile_no,
            ],
            "PrimaryPhone" => [
               "FreeFormNumber" => $request->qbo_phone_no,
            ],
            "PrimaryEmailAddr" => [
               "Address" => $request->qbo_email_address,
            ],
            "Balance" => $request->qbo_balance,
            "Active" => $request->qbo_active,
            "WebAddr" => $request->qbo_website,
            "IsProject" => $request->qbo_is_project
        ]);
        $store = $dataService->Add($customer);
        $error = $dataService->getLastError();
        if ($error) {
            return [
                'status' => false,
                'message' => $error->getIntuitErrorMessage()
            ];
        }
        var_dump($store);die;
        $customer = QboCustomer::updateOrCreate(
            [
                'qbo_id' => $store->Id
            ], [
                'reference_id' => $request->reference_id,
                'qbo_id' => $store->Id,
                'qbo_display_name',
        'qbo_title',
        'qbo_given_name',
        'qbo_middle_name',
        'qbo_suffix',
        'qbo_family_name',
        'qbo_mobile_no',
        'qbo_phone_no',
        'qbo_email_address',
        'qbo_notes',
        'qbo_website',
        'qbo_active',
        'qbo_company_name',
        'qbo_balance',
        'qbo_is_project'
            ]
        );
        if (!$customer) {
            return [
                'status' => false,
                'message' => 'Could not save customer. Please try again.',
            ];
        }
        return [
            'status' => true,
            'message' => 'Customer created.',
            'customerInfo' => $store
        ];
    }
}
