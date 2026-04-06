## ADDED Requirements

### Requirement: CardResource can be hydrated from a raw array

`CardResource::fromArray(array $data): self` SHALL construct a `CardResource` from an associative array using the API field names as keys. Optional fields absent from the array SHALL default to `null`.

#### Scenario: Hydrate from complete array
- **WHEN** `CardResource::fromArray([...all fields...])` is called with all fields present
- **THEN** a `CardResource` with all properties set to the given values is returned

#### Scenario: Hydrate with missing optional fields
- **WHEN** `CardResource::fromArray([...required fields only...])` is called without optional fields
- **THEN** a `CardResource` is returned with nullable properties set to `null`
