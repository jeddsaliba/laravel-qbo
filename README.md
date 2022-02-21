
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


## How To Use

### Download Postman API

Download the Postman API Collection [here](https://jeddsaliba.github.io/laravel-qbo/src/assets/postman/QuickBooks_Online_API_v1.0.0.postman_collection).

### Authentication

Use this in order to authenticate and refresh the access token.

**Controller**

```bash
  \Pns\LaravelQbo\Http\Controllers\QboAuthController
```

**Authenticate Token**

Postman URL:

```bash
  {{url}}/qbo/authorize
```

Response:

```bash
  {
    "authorizationCodeUrl": "https://appcenter.intuit.com/connect/oauth2?client_id=ABEP4t682b0kTjxo8G6yuJGftr506G6oZ5DsOMP0b2MbSHdWP2&scope=com.intuit.quickbooks.accounting&redirect_uri=https%3A%2F%2Fdeveloper.intuit.com%2Fv2%2FOAuth2Playground%2FRedirectUrl&response_type=code&state=DATTK"
  }
```

**Refresh Token**

Postman URL:

```bash
  {{url}}/qbo/token-save
```

Request:

```bash
  {
    "code": "AB11645453718yt4XS3Ngih24yMxDSQYXYG4Hpy2oR6lNkC87L",
    "realmId": "4620816365213659530" 
  }
```

Response:

```bash
  {
    "message": "Token refreshed.",
    "accessToken": {
      "access_token": "eyJlbmMiOiJBMTI4Q0JDLUhTMjU2IiwiYWxnIjoiZGlyIn0..GpEotUwWZJnVEbrOGYSLcg.AdIOfTVbSs73d8-b0wgmFnbgIPbrUKWoIW6_9FJQ27lKWO5xXy5VykvAyUEd_PUpBLhpXfhnnXMkvO_75YecvducgHCHlFy9NdBGfy1WCpkZ8OZQTKIdC1Up4FrsPurK7eAqY8y1-eJNcgARK4TyLtwy14dWeIvZXe3v3uHFtsSz5BsiGj8mC1o9MoKdvFep6BgOtBeZu_nacr7qcPlTXAztWNLLExhZtzSlJqMMMcjErHJ0SOpCZfauba_KrzCT5m0GBmyHvT-maV4EbseiK_hjhdegh0T1kkznxZK92j3tPfqCeAGL3IxJQT2iJlpgyGmTTotX2Mnoz6OPPykxN-8SRh8itzOdqPquQ-P4eqXI-XtnIiHzWBhyi-jvTAfGWuTYx5ohKOQKGvOiyDV4xbqkYw-XNbwsGLtF9EUY-Z8HWk6waj5g07O_-WxOY8lOlhJ4u7lkMaCLm6KMSHLNhfwRykp81wlxac80IQF8_InBseH1jVfShP89WMgYdGzuoy-8hY9jXwBgDudVm5uoqhQiIMaLbZQ1_V1XuHs9-1pBsLtq4KjoabTCJ3lma_cv-wff0plsXDaQFih-StmyWWvBZYRzRPvWbloTsGDEt8WxIANUd2AWZhZFwfJIxkgTpfLnDEySg2QyV-LoNjFU_FAYulFGn1-V6b7JBBYTEJkZXssVGRcy62zGzw_K0Y5DlJUnesbShcAA9rwrA7L430DPi_yYLm472-OKWjhM9OaeR2f6QcrsUxuhj96XcwQd.CynAG529fBQbeDV7OY7WRw",
      "refresh_token": "AB116541797850qjxumAQNzUirNxrOs9C8Sj0U1o59iT0Ev2o2",
      "x_refresh_token_expires_in": "2022/06/02 14:23:05",
      "expires_in": "2022/02/21 15:23:05"
    }
  }
```

### Company

Use this in order to get and update your company profile.

**Controller**

```bash
  \Pns\LaravelQbo\Http\Controllers\QboCompanyController
```

**Get Company Profile**

Postman URL:

```bash
  {{url}}/qbo/company
```

Response:

```bash
  {
    "authorizationCodeUrl": "https://appcenter.intuit.com/connect/oauth2?client_id=ABEP4t682b0kTjxo8G6yuJGftr506G6oZ5DsOMP0b2MbSHdWP2&scope=com.intuit.quickbooks.accounting&redirect_uri=https%3A%2F%2Fdeveloper.intuit.com%2Fv2%2FOAuth2Playground%2FRedirectUrl&response_type=code&state=DATTK"
  }
```

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