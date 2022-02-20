<?php

return [
    'auth_mode' => env('QBO_AUTH_MODE', NULL),
    'request_url' => env('QBO_ATH_REQUEST_URL', NULL),
    'end_point_url' => env('QBO_TOKEN_END_POINT_URL', NULL),
    'client_id' => env('QBO_CLIENT_ID', NULL),
    'client_secret' => env('QBO_CLIENT_SECRET', NULL),
    'redirect_uri' => env('QBO_REDIRECT_URI', NULL),
    'scope' => env('QBO_SCOPE', NULL),
    'base_url' => env('QBO_BASE_URL', NULL),
    'company_id' => env('QBO_COMPANY_ID', NULL)
];

?>