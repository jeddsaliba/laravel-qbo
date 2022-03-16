<?php

namespace Pns\LaravelQbo\Http\Controllers;

use Illuminate\Http\Request;

class QboPaymentController extends Controller
{
    public function store(Request $request)
    {
        $this->refreshToken($request);
        $store = $this->_qboPayment->store($this->_dataService, $request);
        if (!$store->status) {
            return (object)[
                'status' => false,
                'message' => $store->message
            ];
        }
        $depositToInvoice = $this->_qboInvoice->deposit($this->_dataService, $request);
        if (!$depositToInvoice->status) {
            return (object)[
                'status' => false,
                'message' => $depositToInvoice->message
            ];
        }
        return (object)[
            'status' => true,
            'message' => $store->message,
            'paymentInfo' => $store->paymentInfo
        ];
    }
    public function show(Request $request, $id)
    {
        $this->refreshToken($request);
        $paymentInfo = $this->_dataService->FindbyId('payment', $id);
        $error = $this->_dataService->getLastError();
        if ($error) {
            return (object)[
                'status' => false,
                'message' => $error->getIntuitErrorMessage()
            ];
        }
        return (object)[
            'status' => true,
            'message' => 'Payment found.',
            'paymentInfo' => $paymentInfo
        ];
    }
    public function list(Request $request)
    {
        $page = $request->page ? $request->page : 1;
        $limit = $request->limit ? $request->limit : 10;
        $this->refreshToken($request);
        $list = $this->_dataService->FindAll('Payment', $page, $limit);
        $error = $this->_dataService->getLastError();
        if ($error) {
            return (object)[
                'status' => false,
                'message' => $error->getIntuitErrorMessage()
            ];
        }
        return (object)[
            'status' => true,
            'message' => 'Payment list found.',
            'paymentList' => $list
        ];
    }
    public function listAll(Request $request)
    {
        $this->refreshToken($request);
        $list = $this->_dataService->FindAll('Payment');
        $error = $this->_dataService->getLastError();
        if ($error) {
            return (object)[
                'status' => false,
                'message' => $error->getIntuitErrorMessage()
            ];
        }
        return (object)[
            'status' => true,
            'message' => 'Payments found.',
            'paymentList' => $list
        ];
    }
    public function sendMail(Request $request, $id)
    {
        $this->refreshToken($request);
        $payment = $this->_dataService->FindbyId('payment', $id);
        $error = $this->_dataService->getLastError();
        if ($error) {
            return (object)[
                'status' => false,
                'message' => $error->getIntuitErrorMessage()
            ];
        }
        $sendMail = $this->_dataService->SendEmail($payment, $request->email);
        $error = $this->_dataService->getLastError();
        if ($error) {
            return (object)[
                'status' => false,
                'message' => $error->getIntuitErrorMessage()
            ];
        }
        return (object)[
            'status' => true,
            'message' => 'Payment sent.',
            'paymentInfo' => $payment
        ];
    }
}
