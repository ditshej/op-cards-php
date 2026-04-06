## 1. Tests (write first)

- [ ] 1.1 Write test: `PackResource::fromArray()` hydrates from a raw array
- [ ] 1.2 Write test: `OpCardsClient::packs()` returns a `PackResource[]` from the API
- [ ] 1.3 Write test: `OpCardsClient::packs()` returns empty array when data is empty
- [ ] 1.4 Write test: `OpCardsClient::pack(string $id)` returns a single `PackResource`
- [ ] 1.5 Write test: `OpCardsClient::pack(string $id)` propagates `NotFoundException` on 404

## 2. Implementation

- [ ] 2.1 Add `PackResource::fromArray(array $data): self` static factory
- [ ] 2.2 Add `OpCardsClient::packs(): array` — GET `/packs`, hydrate via `PackResource::fromArray()`
- [ ] 2.3 Add `OpCardsClient::pack(string $id): PackResource` — GET `/packs/{id}`, hydrate via `PackResource::fromArray()`
