## Context

`op-cards-php` is a public Composer package with no documentation. The SDK has a framework-agnostic core (`OpCardsClient`, `CardFilter`, typed resources, and a typed exception hierarchy) and optional Laravel integration (ServiceProvider, Facade, config publishing). The README must reflect the final public surface once all preceding changes (8–12) are merged.

## Goals / Non-Goals

**Goals:**
- Provide a single authoritative document a developer can read to go from zero to working integration.
- Cover both standalone PHP and Laravel usage paths clearly.
- Document `CardFilter` with illustrative code examples.
- Include a plain-language note about API stability (no stable v1 yet).

**Non-Goals:**
- No contributing guide, changelog, or code of conduct.
- No internal architecture documentation.
- No API reference beyond the public method signatures already on `OpCardsClient`.

## Decisions

**Single flat `README.md` over a docs/ folder**
The SDK surface is small. A single file is sufficient and keeps discovery friction at zero — GitHub renders it on the repository landing page automatically.

**Document environment variables, not constructor arguments**
Both `OPCARDS_TOKEN` and `OPCARDS_BASE_URI` are required. Documenting them as env vars matches the Laravel config pattern and signals that secrets should not be hardcoded, even for standalone usage where the caller reads them from the environment manually.

**Show `CardFilter` with a chained example**
A short fluent chain (`CardFilter::new()->color('red')->attribute('Runner')`) communicates intent faster than prose. One example per common use case is enough.

**Stability note over a formal versioning table**
Both the SDK and the upstream `one-piece-cards-api` are in active development. A short prose note ("no stable v1; breaking changes may occur") is more honest and easier to maintain than a compatibility matrix.

## Risks / Trade-offs

[Risk] README describes the final SDK state but is written before all changes are merged.
→ The proposal explicitly marks this change as dependent on changes 8–12. Implementation is deferred until those are complete.

[Risk] Code examples go stale if method signatures change.
→ Examples are kept minimal (method name + one or two arguments) so they remain valid across minor refactors.

## Open Questions

- Should `allCards()` be documented with a pagination note, or is the name self-explanatory enough? To be resolved during implementation once the method's behaviour is finalised.
