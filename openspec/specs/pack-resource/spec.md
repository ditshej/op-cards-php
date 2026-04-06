# pack-resource Specification

## Purpose
TBD - created by archiving change card-and-pack-resources. Update Purpose after archive.
## Requirements
### Requirement: PackResource is a typed readonly DTO

`PackResource` SHALL be a readonly PHP class with constructor-promoted properties matching the pack API response fields.

Fields (all required, always present):
- `id` (string)
- `name` (string)
- `label` (string)

#### Scenario: Construct with all fields
- **WHEN** `new PackResource('OP01', 'Romance Dawn', 'OP-01')` is called
- **THEN** `id`, `name`, and `label` are accessible and hold the given values

#### Scenario: Properties are immutable
- **WHEN** an attempt is made to assign a new value to any property after construction
- **THEN** a PHP error is thrown (readonly violation)

### Requirement: PackResource can be hydrated from a raw array

`PackResource::fromArray(array $data): self` SHALL construct a `PackResource` from an associative array using the keys `id`, `name`, and `label`.

#### Scenario: Hydrate from complete array
- **WHEN** `PackResource::fromArray(['id' => 'OP01', 'name' => 'Romance Dawn', 'label' => 'OP-01'])` is called
- **THEN** a `PackResource` with `id = "OP01"`, `name = "Romance Dawn"`, `label = "OP-01"` is returned

