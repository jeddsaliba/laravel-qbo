<?php

namespace Pns\LaravelQbo\Http\Controllers;

use Illuminate\Http\Request;

class QboInvoiceController extends Controller
{
    public function store(Request $request)
    {
        $this->refreshToken($request);
        $store = $this->_qboInvoice->store($this->_dataService, $request);
        if (!$store['status']) {
            return [
                'message' => $store['message']
            ];
        }
        return [
            'message' => $store['message'],
            'invoiceInfo' => $store['invoiceInfo']
        ];
    }
    public function show(Request $request, $id)
    {
        $this->refreshToken($request);
        $invoiceInfo = $this->_dataService->FindbyId('invoice', $id);
        $error = $this->_dataService->getLastError();
        if ($error) {
            return [
                'message' => $error->getIntuitErrorMessage()
            ];
        } else {
            return [
                'message' => 'Invoice found.',
                'invoiceInfo' => $invoiceInfo
            ];
        }
    }
    public function list(Request $request)
    {
        $page = $request->page ? $request->page : 1;
        $limit = $request->limit ? $request->limit : 10;
        $this->refreshToken($request);
        $list = $this->_dataService->FindAll('Invoice', $page, $limit);
        $error = $this->_dataService->getLastError();
        if ($error) {
            return [
                'message' => $error->getIntuitErrorMessage()
            ];
        } else {
            return [
                'message' => 'Invoice list found.',
                'invoiceList' => $list
            ];
        }
    }
    public function listAll(Request $request)
    {
        $this->refreshToken($request);
        $list = $this->_dataService->FindAll('Invoice');
        $error = $this->_dataService->getLastError();
        if ($error) {
            return [
                'message' => $error->getIntuitErrorMessage()
            ];
        }
        return [
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
            return response(['message' => $error->getIntuitErrorMessage()], HttpServiceProvider::BAD_REQUEST);
        }
        $sendMail = $this->_dataService->SendEmail($invoice, $request->email);
        $error = $this->_dataService->getLastError();
        if ($error) {
            return [
                'message' => $error->getIntuitErrorMessage()
            ];
        }
        return [
            'message' => 'Invoice sent.',
            'invoiceInfo' => $invoice
        ];
    }
    public function deleteInvoice(Request $request, $id)
    {
        $this->refreshToken($request);
        $invoice = $this->_dataService->FindbyId('invoice', $id);
        $this->_qboInvoice->whereQboId($id)->delete();
        $error = $this->_dataService->getLastError();
        if ($error) {
            return [
                'message' => $error->getIntuitErrorMessage()
            ];
        }
        $deleteInvoice = $this->_dataService->Delete($invoice);
        $error = $this->_dataService->getLastError();
        if ($error) {
            return [
                'message' => $error->getIntuitErrorMessage()
            ];
        }
        return [
            'message' => 'Invoice deleted.'
        ];
    }
}
