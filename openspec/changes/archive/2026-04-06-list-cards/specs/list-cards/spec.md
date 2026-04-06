## ADDED Requirements

### Requirement: Client can list cards with pagination metadata

`OpCardsClient::cards(?array $query = null)` SHALL send a GET request to `/cards` (with optional query parameters) and return an array with keys `data` (array of `CardResource`) and `meta` (raw pagination array from the API).

#### Scenario: Successful cards listing
- **WHEN** `$client->cards()` is called and the API returns `{"data": [...], "meta": {"current_page":1,"last_page":2,"per_page":25,"total":50}}`
- **THEN** the return value has key `data` containing an array of `CardResource` instances, and key `meta` containing the raw meta array

#### Scenario: Empty cards list
- **WHEN** `$client->cards()` is called and the API returns `{"data": [], "meta": {...}}`
- **THEN** `data` is an empty array

#### Scenario: Query parameters are forwarded
- **WHEN** `$client->cards(['pack_id' => 'OP01'])` is called
- **THEN** the outbound request URI contains `pack_id=OP01`

---

### Requirement: Client can fetch a single card by ID

`OpCardsClient::card(string $id)` SHALL send a GET request to `/cards/{id}` and return a single `CardResource` hydrated from the `data` key of the response.

#### Scenario: Successful single card fetch
- **WHEN** `$client->card('OP01-001')` is called and the API returns `{"data": {...}}`
- **THEN** a `CardResource` with the correct `id` is returned

#### Scenario: Card not found
- **WHEN** `$client->card('UNKNOWN')` is called and the API responds with HTTP 404
- **THEN** `NotFoundException` is thrown
