## 1. Tests (write first)

- [ ] 1.1 Write test: `CardResource::fromArray()` hydrates from a complete array
- [ ] 1.2 Write test: `CardResource::fromArray()` sets nullable fields to null when absent
- [ ] 1.3 Write test: `OpCardsClient::cards()` returns `data` (CardResource[]) and `meta`
- [ ] 1.4 Write test: `OpCardsClient::cards()` returns empty `data` array when API returns none
- [ ] 1.5 Write test: `OpCardsClient::cards()` forwards query parameters to the request
- [ ] 1.6 Write test: `OpCardsClient::card(string $id)` returns a single `CardResource`
- [ ] 1.7 Write test: `OpCardsClient::card(string $id)` propagates `NotFoundException` on 404

## 2. Implementation

- [ ] 2.1 Add `CardResource::fromArray(array $data): self` static factory
- [ ] 2.2 Add `OpCardsClient::cards(?array $query = null): array` — GET `/cards`, hydrate via `CardResource::fromArray()`
- [ ] 2.3 Add `OpCardsClient::card(string $id): CardResource` — GET `/cards/{id}`, hydrate via `CardResource::fromArray()`
