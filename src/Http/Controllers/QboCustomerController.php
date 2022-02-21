<?php

namespace Pns\LaravelQbo\Http\Controllers;

use Illuminate\Http\Request;

class QboCustomerController extends Controller
{
    public function store(Request $request)
    {
        $this->refreshToken($request);
        $store = $this->_qboCustomer->store($this->_dataService, $request);
        if (!$store['status']) {
            return [
                'message' => $store['message']
            ];
        }
        return [
            'message' => $store['message'],
            'customerInfo' => $store['customerInfo']
        ];
    }
    public function show(Request $request, $id)
    {
        $this->refreshToken($request);
        $customerInfo = $this->_dataService->FindbyId('customer', $id);
        $error = $this->_dataService->getLastError();
        if ($error) {
            return [
                'message' => $error->getIntuitErrorMessage()
            ];
        } else {
            return [
                'message' => 'Customer found.',
                'customerInfo' => $customerInfo
            ];
        }
    }
    public function list(Request $request)
    {
        $page = $request->page ? $request->page : 1;
        $limit = $request->limit ? $request->limit : 10;
        $this->refreshToken($request);
        $list = $this->_dataService->FindAll('Customer', $page, $limit);
        $error = $this->_dataService->getLastError();
        if ($error) {
            return [
                'message' => $error->getIntuitErrorMessage()
            ];
        } else {
            return [
                'message' => 'Customers list found.',
                'customerList' => $list
            ];
        }
    }
    public function listAll(Request $request)
    {
        $this->refreshToken($request);
        $list = $this->_dataService->FindAll('Customer');
        $error = $this->_dataService->getLastError();
        if ($error) {
            return [
                'message' => $error->getIntuitErrorMessage()
            ];
        }
        foreach ($list as $item) {
            /* var_dump($item);die; */
            /* $this->_qboCustomer->updateOrCreate(
                [
                    'qbo_id' => $item->Id
                ],
                [
                    'qbo_given_name' => $item->GivenName,
                    'qbo_family_name' => $item->FamilyName ? $item->FamilyName : $item->GivenName,
                    'qbo_phone_no' => $mobile_number,
                    'qbo_email_address' => $email,
                    'reference_id' => $customer->id,
                    'qbo_id' => $item->Id
                ]
            ); */
        }
        return [
            'message' => 'Customers found.',
            'customerList' => $list
        ];
    }
}
