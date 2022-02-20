<?php

namespace Pns\LaravelQbo\Http\Controllers;

use Illuminate\Http\Request;

class QboCompanyController extends Controller
{
    public function show(Request $request) {
        $this->refreshToken($request);
        $companyInfo = $this->_dataService->getCompanyInfo();
        $error = $this->_dataService->getLastError();
          if ($error) {
              return response(['message' => $error->getIntuitErrorMessage()], 500);
          } else {
            return response(['message' => 'QuickBooks Online SDK.', 'payload' => [
                'companyInfo' => $companyInfo
            ]], 200);
        }
    }
}
