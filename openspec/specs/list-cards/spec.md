# list-cards Specification

## Purpose
TBD - created by archiving change list-cards. Update Purpose after archive.
## Requirements
### Requirement: Client can list cards with pagination metadata

`OpCardsClient::cards(?CardFilter $filter = null)` SHALL send a GET request to `/cards`. When `$filter` is provided, its `toQuery()` array SHALL be forwarded as query parameters. When `null`, no query parameters are added.

#### Scenario: Successful cards listing
- **WHEN** `$client->cards()` is called and the API returns `{"data": [...], "meta": {...}}`
- **THEN** the return value has key `data` containing an array of `CardResource` instances, and key `meta` containing the raw meta array

#### Scenario: Empty cards list
- **WHEN** `$client->cards()` is called and the API returns `{"data": [], "meta": {...}}`
- **THEN** `data` is an empty array

#### Scenario: Filter query parameters are forwarded
- **WHEN** `$client->cards((new CardFilter)->pack('OP01'))` is called
- **THEN** the outbound request URI contains `pack_id=OP01`

### Requirement: Client can fetch a single card by ID

`OpCardsClient::card(string $id)` SHALL send a GET request to `/cards/{id}` and return a single `CardResource` hydrated from the `data` key of the response.

#### Scenario: Successful single card fetch
- **WHEN** `$client->card('OP01-001')` is called and the API returns `{"data": {...}}`
- **THEN** a `CardResource` with the correct `id` is returned

#### Scenario: Card not found
- **WHEN** `$client->card('UNKNOWN')` is called and the API responds with HTTP 404
- **THEN** `NotFoundException` is thrown

