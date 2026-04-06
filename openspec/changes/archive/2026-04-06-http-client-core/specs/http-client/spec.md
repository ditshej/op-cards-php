## ADDED Requirements

### Requirement: Client accepts API token and base URI

`OpCardsClient` SHALL be constructed with an API token string. An optional `GuzzleHttp\ClientInterface` MAY be injected; when omitted, a default Guzzle client is created with the production base URI.

#### Scenario: Instantiate with token only
- **WHEN** `new OpCardsClient('my-token')` is called
- **THEN** a valid client instance is returned with the token stored internally

#### Scenario: Instantiate with custom Guzzle client
- **WHEN** `new OpCardsClient('my-token', $mockClient)` is called
- **THEN** the injected client is used for all HTTP requests

---

### Requirement: Requests include Bearer-token authorization header

Every outbound HTTP request SHALL include an `Authorization: Bearer <token>` header.

#### Scenario: Authorization header is set on each request
- **WHEN** a request is made via the client
- **THEN** the `Authorization` header equals `Bearer <configured-token>`

---

### Requirement: Successful JSON responses are returned as PHP arrays

When the API returns a 2xx response with a JSON body, the client SHALL decode the body and return a PHP array.

#### Scenario: 200 OK with JSON body
- **WHEN** the API responds with HTTP 200 and a valid JSON body
- **THEN** the client returns the decoded array

---

### Requirement: HTTP 401 maps to AuthenticationException

When the API returns HTTP 401, the client SHALL throw `Ditshej\OpCards\Exceptions\AuthenticationException`.

#### Scenario: 401 response throws AuthenticationException
- **WHEN** the API responds with HTTP 401
- **THEN** `AuthenticationException` is thrown

---

### Requirement: HTTP 404 maps to NotFoundException

When the API returns HTTP 404, the client SHALL throw `Ditshej\OpCards\Exceptions\NotFoundException`.

#### Scenario: 404 response throws NotFoundException
- **WHEN** the API responds with HTTP 404
- **THEN** `NotFoundException` is thrown

---

### Requirement: HTTP 429 maps to RateLimitException

When the API returns HTTP 429, the client SHALL throw `Ditshej\OpCards\Exceptions\RateLimitException`.

#### Scenario: 429 response throws RateLimitException
- **WHEN** the API responds with HTTP 429
- **THEN** `RateLimitException` is thrown

---

### Requirement: Other 4xx and 5xx responses map to ApiException

When the API returns any non-mapped 4xx or 5xx status code, the client SHALL throw `Ditshej\OpCards\Exceptions\ApiException`.

#### Scenario: 500 response throws ApiException
- **WHEN** the API responds with HTTP 500
- **THEN** `ApiException` is thrown

#### Scenario: 422 response throws ApiException
- **WHEN** the API responds with HTTP 422
- **THEN** `ApiException` is thrown
