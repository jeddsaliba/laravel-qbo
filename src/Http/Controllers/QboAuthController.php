<?php

namespace Pns\LaravelQbo\Http\Controllers;

use Illuminate\Http\Request;

class QboAuthController extends Controller
{
    public function auth()
    {
        return (object)[
            'status' => true,
            'authorizationCodeUrl' => $this->_authUrl
        ];
    }
    public function tokenSave(Request $request) {
        $accessToken = $this->_OAuth2LoginHelper->exchangeAuthorizationCodeForToken($request->code, $request->realmId);
        $this->_dataService->updateOAuth2Token($accessToken);
        $error = $this->_dataService->getLastError();
        if ($error) {
            return (object)[
                'status' => false,
                'message' => $error->getIntuitErrorMessage()
            ];
        }
        $accessToken = [
            'access_token' => $accessToken->getAccessToken(),
            'refresh_token' => $accessToken->getRefreshToken(),
            'x_refresh_token_expires_in' => $accessToken->getRefreshTokenExpiresAt(),
            'expires_in' => $accessToken->getAccessTokenExpiresAt()
        ];
        $store = $this->_qboConfig->store($request, $accessToken);
        if (!$store) {
            return (object)[
                'status' => false,
                'message' => 'Could not save token. Please try again.'
            ];
        }
        return (object)[
            'status' => true,
            'message' => 'Token refreshed.',
            'accessToken' => $accessToken
        ];
    }
}