## 1. Tests (write first)

- [x] 1.1 Write test: `PackResource::fromArray()` hydrates from a raw array
- [x] 1.2 Write test: `OpCardsClient::packs()` returns a `PackResource[]` from the API
- [x] 1.3 Write test: `OpCardsClient::packs()` returns empty array when data is empty
- [x] 1.4 Write test: `OpCardsClient::pack(string $id)` returns a single `PackResource`
- [x] 1.5 Write test: `OpCardsClient::pack(string $id)` propagates `NotFoundException` on 404

## 2. Implementation

- [x] 2.1 Add `PackResource::fromArray(array $data): self` static factory
- [x] 2.2 Add `OpCardsClient::packs(): array` — GET `/packs`, hydrate via `PackResource::fromArray()`
- [x] 2.3 Add `OpCardsClient::pack(string $id): PackResource` — GET `/packs/{id}`, hydrate via `PackResource::fromArray()`
