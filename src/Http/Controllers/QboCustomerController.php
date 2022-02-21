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
                'message' => 'QuickBooks Online SDK.',
                'customerList' => $list
            ];
        }
    }
}
