
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

Do a quick migration:

```bash
  php artisan migrate
```

### Environment Variables
In order to run this package, you will need to add the following environment variables to your .env file

`QBO_AUTH_MODE=oauth2`

`QBO_ATH_REQUEST_URL=https://appcenter.intuit.com/connect/oauth2`

`QBO_TOKEN_END_POINT_URL=https://oauth.platform.intuit.com/oauth2/v1/tokens/bearer`

`QBO_CLIENT_ID=`

`QBO_CLIENT_SECRET=`

`QBO_REDIRECT_URI=`

`QBO_SCOPE=com.intuit.quickbooks.accounting`

`QBO_BASE_URL=Development`

`QBO_COMPANY_ID=`

You may follow the steps on how to get the environment variables here:
https://developer.intuit.com/app/developer/homepage

or follow the steps below

### Generating Environment Variables
1. Log in to your QuickBooks Online account at https://accounts.intuit.com

2. After logging in, go to https://developer.intuit.com/app/developer/sandbox in order to create a new sandbox company.

<img src="https://raw.github.com/jeddsaliba/laravel-qbo/master/src/assets/installation/step-1.JPG?sanitize=true"/>

3. Add a sandbox company.

<img src="https://raw.github.com/jeddsaliba/laravel-qbo/master/src/assets/installation/step-2.JPG?sanitize=true"/>

4. After creating a sandbox company, copy the **Company ID** to be used in `QBO_COMPANY_ID` environment variable.

<img src="https://raw.github.com/jeddsaliba/laravel-qbo/master/src/assets/installation/step-3.JPG?sanitize=true"/>

5. Then, go to https://developer.intuit.com/app/developer/dashboard.

<img src="https://raw.github.com/jeddsaliba/laravel-qbo/master/src/assets/installation/step-4.JPG?sanitize=true"/>

6. Create an app.

<img src="https://raw.github.com/jeddsaliba/laravel-qbo/master/src/assets/installation/step-5.JPG?sanitize=true"/>

7. Complete the form in order to create a new app.

<img src="https://raw.github.com/jeddsaliba/laravel-qbo/master/src/assets/installation/step-6.JPG?sanitize=true"/>

8. Upon creation, you will be redirected to the Getting Started page for your app.

<img src="https://raw.github.com/jeddsaliba/laravel-qbo/master/src/assets/installation/step-7.JPG?sanitize=true"/>

9. Go to **Keys and credentials**. Copy the **Client ID** and **Client Secret** to `QBO_CLIENT_ID` and `QBO_CLIENT_SECRET` respectively.

<img src="https://raw.github.com/jeddsaliba/laravel-qbo/master/src/assets/installation/step-8.JPG?sanitize=true"/>

10. Scroll down to create or copy the **Redirect URI** to `QBO_REDIRECT_URI`.

<img src="https://raw.github.com/jeddsaliba/laravel-qbo/master/src/assets/installation/step-9.JPG?sanitize=true"/>


## Controllers

- `Authentication Controller => Pns/LaravelQbo/Http/Controllers/QboAuthController`

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