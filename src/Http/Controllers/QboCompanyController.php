<?php

namespace Pns\LaravelQbo\Http\Controllers;

use Illuminate\Http\Request;

class QboCompanyController extends Controller
{
    public function show(Request $request)
    {
        $this->refreshToken($request);
        $companyInfo = $this->_dataService->getCompanyInfo();
        $error = $this->_dataService->getLastError();
        if ($error) {
            return [
                'message' => $error->getIntuitErrorMessage()
            ];
        }
        return [
            'message' => 'Company found.',
            'companyInfo' => $companyInfo
        ];
    }
}
