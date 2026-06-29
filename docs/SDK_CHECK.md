# SDK Check

This package was checked for Composer readiness and namespace consistency.

## Current package configuration

- Composer package: `adenion/blog2social-api-php-sdk`
- Repository: `https://github.com/adenion/blog2social-api-php-sdk`
- License: `MIT`
- Runtime namespace: `Adenion\Blog2Social\Sdk\`
- Test namespace: `Adenion\Blog2Social\Sdk\Tests\`
- PHP requirement: `>=8.1`

## Development dependencies

`phpunit/phpunit` is required only for the test suite.

The test classes in `tests/` extend `PHPUnit\Framework\TestCase`, so `phpunit/phpunit` must remain in `require-dev` if the repository should keep `composer test`.

It is not a runtime dependency and is not installed for production usage when Composer is run with `--no-dev`.

## Installation command

```bash
composer require adenion/blog2social-api-php-sdk
```
