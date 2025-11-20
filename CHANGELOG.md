# Changelog

All notable changes to `laravel-s3-browser-based-uploads` will be documented in this file.

## [2.0.0] - 2025-01-20

### Breaking Changes
- **Minimum PHP version raised to 8.1** (from 7.2.5)
- **Laravel 9+ required** (dropped support for Laravel 5.8, 6.x, 7.x, 8.x)
- **Flysystem v3 required** (upgraded from v1)
- Factory now creates S3Client directly from config instead of using Flysystem adapter methods

### Migration Guide
If upgrading from 1.x:
1. Upgrade to PHP 8.1 or higher
2. Upgrade to Laravel 9 or higher
3. Run: `composer require league/flysystem-aws-s3-v3 "^3.0" --with-all-dependencies`
4. No code changes required in your application

### Added
- **Security: Expiration time validation** - Maximum 12 hours enforced
- **Security: Rate limiting** - Default 60 requests/minute on credentials endpoint
- **Security: Enhanced documentation** - Path traversal warnings, CORS setup, IAM permissions
- Comprehensive config file documentation with security warnings
- Additional config examples: `secure_images` and `documents`
- CORS configuration documentation in README
- Known limitations documentation (IAM Identity Center incompatibility)
- CLAUDE.md for AI-assisted development

### Fixed
- Typo in test method name (`test_meke_connection` → `test_make_connection`)
- Type hints in test classes for PHP 8.1+ compatibility
- Flysystem v3 API compatibility in Factory

### Changed
- Updated all dependencies to modern versions
- PHPUnit configuration updated to v9.6 schema
- README completely rewritten with security best practices
- Config file includes extensive inline documentation

### Improved
- Better PHPDoc annotations on Facade
- More robust S3Client creation with support for custom endpoints
- Path-style endpoint support for MinIO/custom S3 implementations

## [1.0.0] - 2020

Initial release supporting Laravel 5.8-8.x and PHP 7.2+
