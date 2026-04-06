## ADDED Requirements

### Requirement: ServiceProvider binds OpCardsClient as a singleton

`OpCardsServiceProvider::register()` SHALL bind `OpCardsClient::class` as a singleton in the service container, constructing it with the value of the `OPCARDS_TOKEN` environment variable.

#### Scenario: Client is resolvable after provider registration
- **WHEN** `OpCardsServiceProvider` is registered with an Illuminate container
- **THEN** `$container->make(OpCardsClient::class)` returns an `OpCardsClient` instance

#### Scenario: Same instance is returned on repeated resolution
- **WHEN** `OpCardsClient::class` is resolved twice from the container
- **THEN** both resolutions return the same object instance (singleton)
