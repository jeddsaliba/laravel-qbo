
# Laravel QuickBooks Online API
This is a Laravel package for integrating QuickBooks Online API.
## Getting Started
Below are the steps in order to integrate QuickBooks Online API to your Laravel project.
## Installation
Install the package using composer:

```bash
  composer require pns/laravel-qbo
```

Export the configuration file:

```bash
  php artisan vendor:publish --provider="Pns\LaravelQbo\Providers\LaravelQboServiceProvider" --tag="config"
```

Export the migration files:

```bash
  php artisan vendor:publish --provider="Pns\LaravelQbo\Providers\LaravelQboServiceProvider" --tag="migrations"
```
### Environment Variables
In order to run this package, you will need to add the following environment variables to your .env file

`QBO_AUTH_MODE`

`QBO_ATH_REQUEST_URL`

`QBO_TOKEN_END_POINT_URL`

`QBO_CLIENT_ID`

`QBO_CLIENT_SECRET`

`QBO_REDIRECT_URI`

`QBO_SCOPE`

`QBO_BASE_URL`

`QBO_COMPANY_ID`
## Features

- Authentication
- Company Profile
    * View
    * Update
- Invoice
    * Generate
    * Send To Email
- Customer
    * Create
    * Update
    * View
    * Delete
## Support
For support, email jeddsaliba@gmail.com or join our Slack channel.

<img src="https://raw.github.com/jeddsaliba/laravel-qbo/master/src/assets/icons/butterfly.svg?sanitize=true" width="100">

FLY HIGH BUTTERFLY!