QBO_AUTH_MODE=
QBO_ATH_REQUEST_URL=
QBO_TOKEN_END_POINT_URL=
QBO_CLIENT_ID=
QBO_CLIENT_SECRET=
QBO_REDIRECT_URI=
QBO_SCOPE=
QBO_BASE_URL=
QBO_COMPANY_ID=

php artisan vendor:publish --provider="Pns\LaravelQbo\Providers\LaravelQboServiceProvider" --tag="config"

php artisan vendor:publish --provider="Pns\LaravelQbo\Providers\LaravelQboServiceProvider" --tag="migrations"