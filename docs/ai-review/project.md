# AI release review: project checklist

Points for this project, in addition to `docs/ai-review/base.md`.
A point marked "blocking" blocks the release like a blocking finding in the
base checklist.

- Blocking: the public API of the library stays backwards compatible, or the break is listed in `CHANGELOG.md` as a breaking change together with a major version bump.
- Blocking: the core has no Laravel dependency; Laravel code lives only in `src/Laravel/`.
- No real HTTP call in tests; use mocked Guzzle handlers.
