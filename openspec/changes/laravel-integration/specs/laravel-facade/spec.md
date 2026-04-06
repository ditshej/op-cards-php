## ADDED Requirements

### Requirement: Facade accessor returns the OpCardsClient container key

`OpCards::getFacadeAccessor()` SHALL return `OpCardsClient::class` as the container binding key.

#### Scenario: Facade accessor returns correct key
- **WHEN** the protected `getFacadeAccessor()` method is called on `OpCards`
- **THEN** it returns `Ditshej\OpCards\OpCardsClient`
