# laravel-service-provider Specification

## Purpose
TBD - created by archiving change laravel-integration. Update Purpose after archive.
## Requirements
### Requirement: ServiceProvider merges opcards config

`OpCardsServiceProvider::boot()` SHALL call `mergeConfigFrom()` for `config/opcards.php` under the `opcards` key, and `publishes()` with the `opcards-config` tag so consumers can override defaults.

### Requirement: ServiceProvider binds OpCardsClient as a singleton

`OpCardsServiceProvider::register()` SHALL bind `OpCardsClient::class` as a singleton in the service container, constructing it with `config('opcards.token')` and `config('opcards.base_uri')`.

#### Scenario: Client is resolvable after provider registration
- **WHEN** `OpCardsServiceProvider` is registered with an Illuminate container that has `opcards.token` set
- **THEN** `$container->make(OpCardsClient::class)` returns an `OpCardsClient` instance

#### Scenario: Same instance is returned on repeated resolution
- **WHEN** `OpCardsClient::class` is resolved twice from the container
- **THEN** both resolutions return the same object instance (singleton)

#### Scenario: base_uri is read from Laravel config
- **WHEN** `opcards.base_uri` is set to a custom value in the Laravel config
- **THEN** the resolved `OpCardsClient` uses that custom base URI

### Requirement: Blank token is rejected

`OpCardsServiceProvider::register()` SHALL throw `InvalidArgumentException` when `opcards.token` is blank or null.

#### Scenario: Blank token throws
- **WHEN** `opcards.token` is an empty string or null
- **THEN** resolving `OpCardsClient::class` from the container throws `InvalidArgumentException`

