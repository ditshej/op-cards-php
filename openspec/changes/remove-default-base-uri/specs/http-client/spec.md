## MODIFIED Requirements

### Requirement: Client accepts API token and base URI

`OpCardsClient` SHALL be constructed with both an API token string and a base URI string. Both parameters are required — omitting either SHALL result in a PHP fatal error. An optional `GuzzleHttp\ClientInterface` MAY be injected as the third argument.

#### Scenario: Instantiate with token and base URI
- **WHEN** `new OpCardsClient('my-token', 'https://my-instance.example.com/api/')` is called
- **THEN** a valid client instance is returned

#### Scenario: Instantiate without base URI fails
- **WHEN** `new OpCardsClient('my-token')` is called
- **THEN** PHP throws an `ArgumentCountError`

#### Scenario: Instantiate with custom Guzzle client
- **WHEN** `new OpCardsClient('my-token', 'https://my-instance.example.com/api/', $mockClient)` is called
- **THEN** the injected client is used for all HTTP requests
