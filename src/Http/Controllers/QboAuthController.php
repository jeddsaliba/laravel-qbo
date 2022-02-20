<?php

namespace Pns\LaravelQbo\Http\Controllers;

use Illuminate\Http\Request;

class QboAuthController extends Controller
{
    public function auth()
    {
        return response(['message' => 'QuickBooks Online SDK.', 'payload' => [
            'authorizationCodeUrl' => $this->_authUrl
        ]], 200);
    }
    public function tokenSave(Request $request) {
        $accessToken = $this->_OAuth2LoginHelper->exchangeAuthorizationCodeForToken($request->code, $request->realmId);
        $this->_dataService->updateOAuth2Token($accessToken);

        $accessToken = [
            'access_token' => $accessToken->getAccessToken(),
            'refresh_token' => $accessToken->getRefreshToken(),
            'x_refresh_token_expires_in' => $accessToken->getRefreshTokenExpiresAt(),
            'expires_in' => $accessToken->getAccessTokenExpiresAt()
        ];
        $store = $this->_qboConfig->store($request, $accessToken);
        return response(['message' => 'QuickBooks Online SDK.', 'payload' => [
            'config' => $accessToken
        ]], 200);
    }
}