# Laravel S3 Browser Based Uploads

[![Latest Version on Packagist](https://img.shields.io/packagist/v/hassan/laravel-s3-browser-based-uploads.svg?style=flat-square)](https://packagist.org/packages/hassan/laravel-s3-browser-based-uploads)
[![Total Downloads](https://img.shields.io/packagist/dt/hassan/laravel-s3-browser-based-uploads.svg?style=flat-square)](https://packagist.org/packages/hassan/laravel-s3-browser-based-uploads)

Upload files to AWS S3 Directly from Browser

## Installation

You can install the package via composer:

```bash
composer require hassan/laravel-s3-browser-based-uploads
```

## Usage

``` php
use Hassan\S3BrowserBasedUploads\Facades\S3BrowserBasedUploads;

S3BrowserBasedUploads::getEndpointUrl()

S3BrowserBasedUploads::getFields()
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

### Security

If you discover any security related issues, please email hello@hassan-ali.me instead of using the issue tracker.