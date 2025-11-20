# Laravel S3 Browser Based Uploads

[![Latest Version on Packagist](https://img.shields.io/packagist/v/hassan/laravel-s3-browser-based-uploads.svg?style=flat-square)](https://packagist.org/packages/hassan/laravel-s3-browser-based-uploads)
[![Build Status](https://badgen.net/travis/dhassanali/laravel-s3-browser-based-uploads/master)](https://travis-ci.org/dhassanali/laravel-s3-browser-based-uploads)
[![Total Downloads](https://poser.pugx.org/hassan/laravel-s3-browser-based-uploads/d/total.svg)](https://packagist.org/packages/hassan/laravel-s3-browser-based-uploads)
[![License](https://badgen.net/packagist/license/hassan/laravel-s3-browser-based-uploads)](https://packagist.org/packages/hassan/laravel-s3-browser-based-uploads)

Upload files to AWS S3 directly from the browser using presigned POST requests, reducing server load and bandwidth usage.

## Requirements

- PHP 8.1 or higher
- Laravel 9.x, 10.x, or 11.x
- AWS S3 bucket with appropriate permissions

## Installation

### 1. Install the package via composer

```bash
composer require hassan/laravel-s3-browser-based-uploads
```

For Laravel 9+, you may need to install Flysystem dependencies:

```bash
composer require league/flysystem-aws-s3-v3 "^3.0" --with-all-dependencies
```

### 2. Publish the config file

```bash
php artisan vendor:publish --provider="Hassan\S3BrowserBasedUploads\ServiceProvider" --tag=config
```

### 3. Configure your AWS credentials

Add your AWS settings to `.env`:

```bash
AWS_ACCESS_KEY_ID=your-access-key-id
AWS_SECRET_ACCESS_KEY=your-secret-access-key
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=your-bucket-name
```

### 4. Configure S3 CORS (Required!)

For browser uploads to work, you **must** configure CORS on your S3 bucket. Add this CORS configuration in your AWS S3 Console:

```json
[
    {
        "AllowedHeaders": ["*"],
        "AllowedMethods": ["POST"],
        "AllowedOrigins": ["https://yourdomain.com"],
        "ExposeHeaders": ["ETag"],
        "MaxAgeSeconds": 3000
    }
]
```

**Important**: Replace `https://yourdomain.com` with your actual domain(s). For local development, you may add `http://localhost:8000` or use `["*"]` (not recommended for production).

## Usage

### Basic Usage

```php
use Hassan\S3BrowserBasedUploads\Facades\S3BrowserBasedUploads;

// Get the S3 endpoint URL
$endpointUrl = S3BrowserBasedUploads::getEndpointUrl();

// Get the presigned POST fields
$fields = S3BrowserBasedUploads::getFields();

// Use a different connection
$fields = S3BrowserBasedUploads::connection('secure_images')->getFields();
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


### Using Credentials Routes

You can optionally register a route that returns the credentials as JSON:

```php
// In your RouteServiceProvider or routes/web.php
use Hassan\S3BrowserBasedUploads\S3BrowserBasedUploads;

public function boot()
{
    // Registers GET route: /s3_browser_based_uploads/credentials
    S3BrowserBasedUploads::routes();

    // With custom options (e.g., authentication middleware)
    S3BrowserBasedUploads::routes([
        'middleware' => ['auth', 'throttle:60,1'],
        'prefix' => 'api/uploads',
    ]);
}
```

This creates an endpoint that returns:
```json
{
    "url": "https://your-bucket.s3.amazonaws.com",
    "fields": {
        "key": "tmp/images/${filename}",
        "policy": "eyJ...",
        "x-amz-algorithm": "AWS4-HMAC-SHA256",
        "x-amz-credential": "...",
        "x-amz-date": "...",
        "x-amz-signature": "..."
    }
}
```

## Security Considerations

### ⚠️ Important Security Warnings

1. **Filename Sanitization**: Using `${filename}` in your config can expose you to path traversal attacks. Consider:
   ```php
   // In your backend before generating credentials
   'key' => 'uploads/' . Str::uuid() . '.' . $extension
   ```

2. **File Size Limits**: Always set `content-length-range` in your config to prevent abuse:
   ```php
   ['content-length-range', 1, 10485760] // 1 byte to 10MB
   ```

3. **Content-Type Validation**: Restrict file types using conditions:
   ```php
   ['starts-with', '$Content-Type', 'image/'] // Images only
   ['eq', '$Content-Type', 'application/pdf'] // PDFs only
   ```

4. **Short Expiration Times**: Use short-lived URLs (1-15 minutes recommended):
   ```php
   'expiration_time' => '+5 minutes'
   ```

5. **Rate Limiting**: The credentials endpoint includes default rate limiting (60 requests/minute). Adjust as needed.

6. **HTTPS Only**: Always use HTTPS in production to prevent credential interception.

7. **Bucket Permissions**: Set appropriate S3 bucket policies and ACLs. Avoid public write access.

### AWS IAM Permissions

Your AWS IAM user needs these S3 permissions:

```json
{
    "Version": "2012-10-17",
    "Statement": [
        {
            "Effect": "Allow",
            "Action": [
                "s3:PutObject",
                "s3:PutObjectAcl"
            ],
            "Resource": "arn:aws:s3:::your-bucket-name/*"
        }
    ]
}
```

### Known Limitations

- Does not work with AWS IAM Identity Center credentials (use standard IAM credentials)
- Maximum expiration time is capped at 12 hours for security
- Requires CORS configuration on S3 bucket

### Security Disclosure

If you discover any security related issues, please email hello@hassan-ali.me instead of using the issue tracker.
