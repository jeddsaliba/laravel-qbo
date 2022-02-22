<?php

namespace Pns\LaravelQbo\Http\Controllers;

use Illuminate\Http\Request;

class QboCustomerController extends Controller
{
    public function store(Request $request)
    {
        $this->refreshToken($request);
        $store = $this->_qboCustomer->store($this->_dataService, $request);
        if (!$store->status) {
            return (object)[
                'status' => false,
                'message' => $store->message
            ];
        }
        return (object)[
            'status' => true,
            'message' => $store->message,
            'customerInfo' => $store->customerInfo
        ];
    }
    public function show(Request $request, $id)
    {
        $this->refreshToken($request);
        $customerInfo = $this->_dataService->FindbyId('customer', $id);
        $error = $this->_dataService->getLastError();
        if ($error) {
            return (object)[
                'status' => false,
                'message' => $error->getIntuitErrorMessage()
            ];
        }
        return (object)[
            'status' => true,
            'message' => 'Customer found.',
            'customerInfo' => $customerInfo
        ];
    }
    public function list(Request $request)
    {
        $page = $request->page ? $request->page : 1;
        $limit = $request->limit ? $request->limit : 10;
        $this->refreshToken($request);
        $list = $this->_dataService->FindAll('Customer', $page, $limit);
        $error = $this->_dataService->getLastError();
        if ($error) {
            return (object)[
                'message' => $error->getIntuitErrorMessage()
            ];
        }
        return (object)[
            'message' => 'Customers list found.',
            'customerList' => $list
        ];
    }
    public function listAll(Request $request)
    {
        $this->refreshToken($request);
        $list = $this->_dataService->FindAll('Customer');
        $error = $this->_dataService->getLastError();
        if ($error) {
            return (object)[
                'status' => false,
                'message' => $error->getIntuitErrorMessage()
            ];
        }
        return (object)[
            'status' => true,
            'message' => 'Customers found.',
            'customerList' => $list
        ];
    }
}
