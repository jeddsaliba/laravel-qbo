<?php

namespace Pns\LaravelQbo\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use QuickBooksOnline\API\DataService\DataService;

class Controller extends BaseController
{
    protected $_qboConfig;
    protected $_dataService;
    protected $_OAuth2LoginHelper;
    protected $_authUrl;

    public function __construct(
        \Pns\LaravelQbo\Models\QboConfig $QboConfig
    ) {
        $this->_qboConfig = $QboConfig;
        $this->_configArray = [
            'auth_mode' => config('auth_mode'),
            'ClientID' => config('client_id'),
            'ClientSecret' => config('client_secret'),
            'RedirectURI' => config('redirect_uri'),
            'scope' => config('scope'),
            'baseUrl' => config('base_url'),
            'accessTokenKey' => null,
            'refreshTokenKey' => null,
            'QBORealmID' => null
        ];
        $this->_dataService = DataService::Configure($this->_configArray);
        $this->_OAuth2LoginHelper = $this->_dataService->getOAuth2LoginHelper();
        $this->_authUrl = $this->_OAuth2LoginHelper->getAuthorizationCodeURL();
    }
    function refreshToken($request) {
        $config = $this->_qboConfig::find(1);
        $this->_configArray['QBORealmID'] = $config->realm_id;
        $this->_configArray['accessTokenKey'] = $config->access_token;
        $this->_configArray['refreshTokenKey'] = $config->refresh_token;
        $this->_dataService = DataService::Configure($this->_configArray);
        
        $this->_OAuth2LoginHelper = $this->_dataService->getOAuth2LoginHelper();
        $refreshedAccessTokenObj = $this->_OAuth2LoginHelper->refreshAccessTokenWithRefreshToken($config->refresh_token);
        $error = $this->_OAuth2LoginHelper->getLastError();
        if ($error) {

        } else {
            $this->_dataService->updateOAuth2Token($refreshedAccessTokenObj);
            $accessToken = [
                'access_token' => $refreshedAccessTokenObj->getAccessToken(),
                'refresh_token' => $refreshedAccessTokenObj->getRefreshToken(),
                'x_refresh_token_expires_in' => $refreshedAccessTokenObj->getRefreshTokenExpiresAt(),
                'expires_in' => $refreshedAccessTokenObj->getAccessTokenExpiresAt()
            ];
            $save = $this->_qboConfig->save($request, $accessToken);
            $this->_configArray['accessTokenKey'] = $refreshedAccessTokenObj->getAccessToken();
            $this->_dataService = DataService::Configure($this->_configArray);
        }
    }
}