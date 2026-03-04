# Integration Tests

This directory contains simple integration tests for the VocaTIonal project.

## Test Structure

- `DatabaseTest.php` - Simple database functionality tests
- `WebServiceTest.php` - Simple web service functionality tests

## Running Tests

To run integration tests locally:

```bash
# Start Docker services first
cd vocational
./docker-start.sh start

# Run tests (optional, these are just placeholders)
cd ..
vendor/bin/phpunit tests/Integration/

# Or run specific test
vendor/bin/phpunit tests/Integration/DatabaseTest.php
```

## Test Notes

These tests are simple placeholders and don't require complex setup. They can be expanded later if needed.

## Adding New Tests

When adding new integration tests:
1. Keep them simple and focused
2. Don't require complex external dependencies
3. Use basic assertions
4. Follow the existing pattern
