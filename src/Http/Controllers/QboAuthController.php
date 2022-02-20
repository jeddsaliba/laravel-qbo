<?php

namespace Pns\LaravelQbo\Http\Controllers;

use Illuminate\Http\Request;

class QboAuthController extends Controller
{
    public function auth()
    {
        return [
            'authorizationCodeUrl' => $this->_authUrl
        ];
    }
    public function tokenSave(Request $request) {
        $accessToken = $this->_OAuth2LoginHelper->exchangeAuthorizationCodeForToken($request->code, $request->realmId);
        $this->_dataService->updateOAuth2Token($accessToken);
        $error = $this->_dataService->getLastError();
        if ($error) {
            return [
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
            return [
                'message' => 'Could not save token. Please try again.'
            ];
        }
        return [
            'message' => 'Token refreshed.',
            'accessToken' => $accessToken
        ];
    }
}