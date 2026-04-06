# card-filter Specification

## Purpose
TBD - created by archiving change card-filter. Update Purpose after archive.
## Requirements
### Requirement: CardFilter builds query parameters fluently

`CardFilter` SHALL provide fluent setter methods that each return `$this`, and a `toQuery(): array` method that returns only the parameters that were explicitly set.

#### Scenario: Empty filter produces empty query
- **WHEN** `(new CardFilter)->toQuery()` is called with no methods invoked
- **THEN** an empty array is returned

#### Scenario: Single filter method sets the correct key
- **WHEN** `(new CardFilter)->pack('OP01')->toQuery()` is called
- **THEN** `['pack_id' => 'OP01']` is returned

#### Scenario: Multiple filter methods produce all set keys
- **WHEN** `(new CardFilter)->color('Red')->rarity('L')->toQuery()` is called
- **THEN** `['color' => 'Red', 'rarity' => 'L']` is returned

#### Scenario: costBetween sets cost_min and cost_max
- **WHEN** `(new CardFilter)->costBetween(3, 7)->toQuery()` is called
- **THEN** `['cost_min' => 3, 'cost_max' => 7]` is returned

#### Scenario: powerBetween sets power_min and power_max
- **WHEN** `(new CardFilter)->powerBetween(4000, 8000)->toQuery()` is called
- **THEN** `['power_min' => 4000, 'power_max' => 8000]` is returned

#### Scenario: altArt bool is cast to int for the query
- **WHEN** `(new CardFilter)->altArt(true)->toQuery()` is called
- **THEN** `['alt_art' => 1]` is returned

#### Scenario: All methods are chainable
- **WHEN** all methods are called in a single chain
- **THEN** `toQuery()` returns all the corresponding keys

#### Scenario: page() sets the page key
- **WHEN** `(new CardFilter)->page(2)->toQuery()` is called
- **THEN** `['page' => 2]` is returned

### Requirement: cost() accepts variadic integers and emits scalar or array

`cost()` SHALL accept zero or more `int` arguments. When exactly one value is passed it SHALL emit a scalar integer under the `cost` key. When two or more values are passed it SHALL emit a PHP array under the `cost` key. When zero values are passed it SHALL not include `cost` in the returned query array.

#### Scenario: cost() single value emits scalar
- **WHEN** `(new CardFilter)->cost(5)->toQuery()` is called
- **THEN** `['cost' => 5]` is returned

#### Scenario: cost() multiple values emits array
- **WHEN** `(new CardFilter)->cost(3, 5, 7)->toQuery()` is called
- **THEN** `['cost' => [3, 5, 7]]` is returned

#### Scenario: cost() with no arguments omits cost key
- **WHEN** `(new CardFilter)->cost()->toQuery()` is called
- **THEN** the returned array does not contain the `cost` key
