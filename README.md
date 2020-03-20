# Laravel S3 Browser Based Uploads

[![Latest Version on Packagist](https://img.shields.io/packagist/v/hassan/laravel-s3-browser-based-uploads.svg?style=flat-square)](https://packagist.org/packages/hassan/laravel-s3-browser-based-uploads)
[![Build Status](https://badgen.net/travis/dhassanali/laravel-s3-browser-based-uploads/master)](https://travis-ci.org/dhassanali/laravel-s3-browser-based-uploads)
[![Total Downloads](https://poser.pugx.org/hassan/laravel-s3-browser-based-uploads/d/total.svg)](https://packagist.org/packages/hassan/laravel-s3-browser-based-uploads)
[![License](https://badgen.net/packagist/license/hassan/laravel-s3-browser-based-uploads)](https://packagist.org/packages/hassan/laravel-s3-browser-based-uploads)


Upload files to AWS S3 Directly from Browser

## Installation

- 1 Install the package via composer:

```bash
composer require hassan/laravel-s3-browser-based-uploads
```

- 2 Publish the config file of the package.

```bash
php artisan vendor:publish --provider="Hassan\S3BrowserBasedUploads\ServiceProvider" --tag=config
```
- 3 add your AWS settings

```bash
AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=
AWS_BUCKET=
```

## Usage

``` php
use Hassan\S3BrowserBasedUploads\Facades\S3BrowserBasedUploads;

S3BrowserBasedUploads::getEndpointUrl()

S3BrowserBasedUploads::getFields()

// with another connection
S3BrowserBasedUploads::connection('another')->getFields();
```

## Example

``` javascript
const formData = new FormData();

@foreach(S3BrowserBasedUploads::getFields() as $key => $value)
    formData.append('{{ $key }}', '{{ $value }}');
@endforeach

formData.append('Content-Type', file.type);
formData.append('file', file, file.name);

const request = new XMLHttpRequest();
request.open('POST', "{{ S3BrowserBasedUploads::getEndpointUrl() }}");
request.send(formData);
```
Check out [the demo with Filepond](demo.blade.php)


Or Using Credentials Routes

```
// use Hassan\S3BrowserBasedUploads\S3BrowserBasedUploads;

public function boot()
{
    S3BrowserBasedUploads::routes();
}
```

### Security

If you discover any security related issues, please email hello@hassan-ali.me instead of using the issue tracker.
