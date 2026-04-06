## MODIFIED Requirements

### Requirement: Client accepts API token and base URI

`OpCardsClient` SHALL be constructed with an API token string and an optional base URI string. When `$baseUri` is omitted, it defaults to `'https://op-cards.ditshej.ch/api/'`. An optional `GuzzleHttp\ClientInterface` MAY be injected as the third argument; when omitted, a default Guzzle client is created with the given base URI.

#### Scenario: Instantiate with token only
- **WHEN** `new OpCardsClient('my-token')` is called
- **THEN** a valid client instance is returned using the default base URI

#### Scenario: Instantiate with custom base URI
- **WHEN** `new OpCardsClient('my-token', 'https://my-instance.example.com/api/')` is called
- **THEN** outbound requests use `https://my-instance.example.com/api/` as the base

#### Scenario: Instantiate with custom Guzzle client
- **WHEN** `new OpCardsClient('my-token', 'https://op-cards.ditshej.ch/api/', $mockClient)` is called
- **THEN** the injected client is used for all HTTP requests
