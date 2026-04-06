## ADDED Requirements

### Requirement: CardResource is a typed readonly DTO

`CardResource` SHALL be a readonly PHP class with constructor-promoted properties matching the card API response fields.

Required fields (always present):
- `id` (string)
- `pack_id` (string)
- `card_set` (string)
- `name` (string)
- `rarity` (string)
- `category` (string)
- `colors` (array)
- `attributes` (array)
- `types` (array)

Optional fields (nullable):
- `cost` (?int)
- `power` (?int)
- `effect` (?string)
- `trigger` (?string)
- `img_url` (?string)
- `alt_art_variant` (?string)

#### Scenario: Construct with all fields
- **WHEN** `new CardResource(...)` is called with all required and optional fields
- **THEN** every property is accessible and holds the given value

#### Scenario: Construct with nullable fields as null
- **WHEN** `new CardResource(...)` is called with nullable fields set to `null`
- **THEN** the instance is created and nullable properties return `null`

#### Scenario: Properties are immutable
- **WHEN** an attempt is made to assign a new value to any property after construction
- **THEN** a PHP error is thrown (readonly violation)
