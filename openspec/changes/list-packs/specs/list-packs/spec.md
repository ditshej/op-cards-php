## ADDED Requirements

### Requirement: Client can list all packs

`OpCardsClient::packs()` SHALL send a GET request to `/packs` and return an array of `PackResource` instances hydrated from the `data` key of the response.

#### Scenario: Successful packs listing
- **WHEN** `$client->packs()` is called and the API returns `{"data": [{"id":"OP01","name":"Romance Dawn","label":"OP-01"}]}`
- **THEN** an array containing one `PackResource` with `id = "OP01"`, `name = "Romance Dawn"`, `label = "OP-01"` is returned

#### Scenario: Empty packs list
- **WHEN** `$client->packs()` is called and the API returns `{"data": []}`
- **THEN** an empty array is returned

---

### Requirement: Client can fetch a single pack by ID

`OpCardsClient::pack(string $id)` SHALL send a GET request to `/packs/{id}` and return a single `PackResource` hydrated from the `data` key of the response.

#### Scenario: Successful single pack fetch
- **WHEN** `$client->pack('OP01')` is called and the API returns `{"data": {"id":"OP01","name":"Romance Dawn","label":"OP-01"}}`
- **THEN** a `PackResource` with `id = "OP01"` is returned

#### Scenario: Pack not found
- **WHEN** `$client->pack('UNKNOWN')` is called and the API responds with HTTP 404
- **THEN** `NotFoundException` is thrown
