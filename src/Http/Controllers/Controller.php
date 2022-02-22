<?php

namespace Pns\LaravelQbo\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use QuickBooksOnline\API\DataService\DataService;

class Controller extends BaseController
{
    protected $_qboConfig;
    protected $_qboCustomer;
    protected $_qboInvoice;
    protected $_dataService;
    protected $_OAuth2LoginHelper;
    protected $_authUrl;

    public function __construct(
        \Pns\LaravelQbo\Models\QboConfig $QboConfig,
        \Pns\LaravelQbo\Models\QboCustomer $QboCustomer,
        \Pns\LaravelQbo\Models\QboInvoice $QboInvoice
    ) {
        $this->_qboConfig = $QboConfig;
        $this->_qboCustomer = $QboCustomer;
        $this->_qboInvoice = $QboInvoice;
        $this->_configArray = [
            'auth_mode' => config('qbo.auth_mode'),
            'ClientID' => config('qbo.client_id'),
            'ClientSecret' => config('qbo.client_secret'),
            'RedirectURI' => config('qbo.redirect_uri'),
            'scope' => config('qbo.scope'),
            'baseUrl' => config('qbo.base_url'),
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
            return (object)[
                'status' => false,
                'message' => $error->getIntuitErrorMessage()
            ];
        }
        $this->_dataService->updateOAuth2Token($refreshedAccessTokenObj);
        $error = $this->_dataService->getLastError();
        if ($error) {
            return (object)[
                'status' => false,
                'message' => $error->getIntuitErrorMessage()
            ];
        }
        $accessToken = [
            'access_token' => $refreshedAccessTokenObj->getAccessToken(),
            'refresh_token' => $refreshedAccessTokenObj->getRefreshToken(),
            'x_refresh_token_expires_in' => $refreshedAccessTokenObj->getRefreshTokenExpiresAt(),
            'expires_in' => $refreshedAccessTokenObj->getAccessTokenExpiresAt()
        ];
        $save = $this->_qboConfig->store($request, $accessToken);
        if (!$save) {
            return (object)[
                'status' => false,
                'message' => 'Could not save token. Please try again.'
            ];
        }
        $this->_configArray['accessTokenKey'] = $refreshedAccessTokenObj->getAccessToken();
        $this->_dataService = DataService::Configure($this->_configArray);
        return (object)[
            'status' => true,
            'message' => 'Token refreshed.',
            'accessToken' => $accessToken
        ];
    }
}