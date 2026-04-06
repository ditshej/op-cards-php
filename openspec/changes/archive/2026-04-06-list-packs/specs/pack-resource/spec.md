## ADDED Requirements

### Requirement: PackResource can be hydrated from a raw array

`PackResource::fromArray(array $data): self` SHALL construct a `PackResource` from an associative array using the keys `id`, `name`, and `label`.

#### Scenario: Hydrate from complete array
- **WHEN** `PackResource::fromArray(['id' => 'OP01', 'name' => 'Romance Dawn', 'label' => 'OP-01'])` is called
- **THEN** a `PackResource` with `id = "OP01"`, `name = "Romance Dawn"`, `label = "OP-01"` is returned
