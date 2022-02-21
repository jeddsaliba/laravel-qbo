
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

You may follow the steps on how to get the environment variables here:
https://developer.intuit.com/app/developer/homepage

or follow the steps below

### Generating Environment Variables
Log in to your QuickBooks Online account at https://accounts.intuit.com

After logging in, go to https://developer.intuit.com/app/developer/sandbox in order to create a new sandbox company.

<img src="https://raw.github.com/jeddsaliba/laravel-qbo/master/src/assets/installation/step-1.JPG?sanitize=true"/>

Add a sandbox company.

<img src="https://raw.github.com/jeddsaliba/laravel-qbo/master/src/assets/installation/step-2.JPG?sanitize=true"/>

After creating a sandbox company, go to https://developer.intuit.com/app/developer/dashboard

<img src="https://raw.github.com/jeddsaliba/laravel-qbo/master/src/assets/installation/step-2.JPG?sanitize=true"/>

Create an app

<img src="https://raw.github.com/jeddsaliba/laravel-qbo/master/src/assets/installation/step-4.JPG?sanitize=true"/>

Complete the form in order to create a new app

<img src="https://raw.github.com/jeddsaliba/laravel-qbo/master/src/assets/installation/step-5.JPG?sanitize=true"/>




## Features

- Authentication
- Company Profile
    * View
- Invoice
    * Create
    * View
    * Delete
    * List
    * Send To Email
- Customer
    * Create
    * View
    * Delete
    * List
## Support
For support, email jeddsaliba@gmail.com or join our Slack channel.

*Fly high, butterfly! <img src="https://raw.github.com/jeddsaliba/laravel-qbo/master/src/assets/icons/butterfly.svg?sanitize=true" height="14">*