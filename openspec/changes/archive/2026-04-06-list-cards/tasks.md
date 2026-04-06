## 1. Tests (write first)

- [x] 1.1 Write test: `CardResource::fromArray()` hydrates from a complete array
- [x] 1.2 Write test: `CardResource::fromArray()` sets nullable fields to null when absent
- [x] 1.3 Write test: `OpCardsClient::cards()` returns `data` (CardResource[]) and `meta`
- [x] 1.4 Write test: `OpCardsClient::cards()` returns empty `data` array when API returns none
- [x] 1.5 Write test: `OpCardsClient::cards()` forwards query parameters to the request
- [x] 1.6 Write test: `OpCardsClient::card(string $id)` returns a single `CardResource`
- [x] 1.7 Write test: `OpCardsClient::card(string $id)` propagates `NotFoundException` on 404

## 2. Implementation

- [x] 2.1 Add `CardResource::fromArray(array $data): self` static factory
- [x] 2.2 Add `OpCardsClient::cards(?array $query = null): array` — GET `/cards`, hydrate via `CardResource::fromArray()`
- [x] 2.3 Add `OpCardsClient::card(string $id): CardResource` — GET `/cards/{id}`, hydrate via `CardResource::fromArray()`
