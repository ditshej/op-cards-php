---
name: pest-testing
description: "Use this skill for Pest PHP testing in framework-agnostic PHP libraries. Trigger whenever any test is being written, edited, fixed, or refactored — including TDD workflows, adding assertions, datasets, and architecture tests. Covers: it()/expect() syntax, datasets, custom expectations, arch(), and all Pest 4 features. Do not use for application code, Laravel-specific patterns, or non-test PHP code."
license: MIT
metadata:
  author: ditshej
---

# Pest Testing 4 (PHP Libraries)

## Basic Usage

### Running Tests

- Run all tests: `vendor/bin/pest --compact`
- Run with filter: `vendor/bin/pest --compact --filter=testName`
- Run single file: `vendor/bin/pest --compact tests/SomeTest.php`

### Test Structure

```php
it('does something', function () {
    expect(true)->toBeTrue();
});
```

### TDD Workflow

Write the test first, then implement. Commit order:
1. Failing test
2. Implementation that makes it pass

## Assertions

Use specific, descriptive assertions:

```php
expect($result)->toBe('expected value');
expect($object)->toBeInstanceOf(SomeClass::class);
expect($array)->toHaveCount(3);
expect($value)->toBeNull();
expect($string)->toContain('substring');
expect($number)->toBeGreaterThan(0);
```

## Datasets

Use datasets for repetitive tests:

```php
it('parses card id', function (string $input, string $expected) {
    expect(CardId::from($input)->value)->toBe($expected);
})->with([
    'standard' => ['OP01-001', 'OP01-001'],
    'leader'   => ['OP01-L01', 'OP01-L01'],
]);
```

## Custom Expectations

Define in `tests/Pest.php`:

```php
expect()->extend('toBeValidCardId', function () {
    return $this->toMatch('/^[A-Z]{2}\d{2}-\d{3}$/');
});
```

## Architecture Tests

Use `arch()` to enforce code conventions:

```php
arch('exceptions extend base exception')
    ->expect('Ditshej\OpCards\Exceptions')
    ->toExtend(\Exception::class);

arch('resources are readonly')
    ->expect('Ditshej\OpCards\Resources')
    ->toBeReadonly();

arch('no framework dependencies in core')
    ->expect('Ditshej\OpCards')
    ->not->toUse('Illuminate\*');
```

## Common Pitfalls

- Not running tests before committing (pre-commit hook handles this)
- Using `assertEquals` instead of `expect()->toBe()`
- Forgetting datasets for repetitive validation tests
- Writing implementation before the test
