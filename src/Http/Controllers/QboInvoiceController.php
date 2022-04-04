<?php

namespace Pns\LaravelQbo\Http\Controllers;

use Illuminate\Http\Request;

class QboInvoiceController extends Controller
{
    public function store(Request $request)
    {
        $this->refreshToken($request);
        $store = $this->_qboInvoice->store($this->_dataService, $request);
        if (!$store->status) {
            return (object)[
                'status' => false,
                'message' => $store->message
            ];
        }
        return (object)[
            'status' => true,
            'message' => $store->message,
            'invoiceInfo' => $store->invoiceInfo
        ];
    }
    public function show(Request $request, $id)
    {
        $this->refreshToken($request);
        $invoiceInfo = $this->_dataService->FindbyId('invoice', $id);
        $error = $this->_dataService->getLastError();
        if ($error) {
            return (object)[
                'status' => false,
                'message' => $error->getIntuitErrorMessage()
            ];
        }
        return (object)[
            'status' => true,
            'message' => 'Invoice found.',
            'invoiceInfo' => $invoiceInfo
        ];
    }
    public function list(Request $request)
    {
        $page = $request->page ? $request->page : 1;
        $limit = $request->limit ? $request->limit : 10;
        $this->refreshToken($request);
        $list = $this->_dataService->FindAll('Invoice', $page, $limit);
        $error = $this->_dataService->getLastError();
        if ($error) {
            return (object)[
                'status' => false,
                'message' => $error->getIntuitErrorMessage()
            ];
        }
        return (object)[
            'status' => true,
            'message' => 'Invoice list found.',
            'invoiceList' => $list
        ];
    }
    public function listAll(Request $request)
    {
        $this->refreshToken($request);
        $list = $this->_dataService->FindAll('Invoice');
        $error = $this->_dataService->getLastError();
        if ($error) {
            return (object)[
                'status' => false,
                'message' => $error->getIntuitErrorMessage()
            ];
        }
        return (object)[
            'status' => true,
            'message' => 'Invoices found.',
            'invoiceList' => $list
        ];
    }
    public function sendMail(Request $request, $id)
    {
        $this->refreshToken($request);
        $invoice = $this->_dataService->FindbyId('invoice', $id);
        $error = $this->_dataService->getLastError();
        if ($error) {
            return (object)[
                'status' => false,
                'message' => $error->getIntuitErrorMessage()
            ];
        }
        $sendMail = $this->_dataService->SendEmail($invoice, $request->email);
        $error = $this->_dataService->getLastError();
        if ($error) {
            return (object)[
                'status' => false,
                'message' => $error->getIntuitErrorMessage()
            ];
        }
        return (object)[
            'status' => true,
            'message' => 'Invoice sent.',
            'invoiceInfo' => $invoice
        ];
    }
    public function deleteInvoice(Request $request, $id)
    {
        $this->refreshToken($request);
        $invoice = $this->_qboInvoice->create([
            "Id" => $id
        ]);
        $invoice = $this->_dataService->FindbyId('invoice', $id);
        $this->_qboInvoice->whereQboId($id)->delete();
        $error = $this->_dataService->getLastError();
        if ($error) {
            return (object)[
                'status' => false,
                'message' => $error->getIntuitErrorMessage()
            ];
        }
        $deleteInvoice = $this->_dataService->Delete($invoice);
        $error = $this->_dataService->getLastError();
        if ($error) {
            return (object)[
                'status' => false,
                'message' => $error->getIntuitErrorMessage()
            ];
        }
        return (object)[
            'status' => true,
            'message' => 'Invoice deleted.'
        ];
    }
    public function downloadInvoice(Request $request, $id)
    {
        $this->refreshToken($request);
        $downloadInvoice = $this->_qboInvoice->downloadInvoice($this->_dataService, $id);
        if (!$downloadInvoice->status) {
            return (object)[
                'status' => false,
                'message' => $downloadInvoice->message
            ];
        }
        return (object)[
            'status' => true,
            'message' => $downloadInvoice->message,
            'invoiceInfo' => $downloadInvoice->invoiceInfo
        ];
    }
}
