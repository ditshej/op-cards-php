## Context

`op-cards-php` is a framework-agnostic PHP SDK for self-hosted instances of the [`one-piece-cards-api`](https://github.com/ditshej/one-piece-cards-api) HTTP API. Consumers must run their own instance of that API before this SDK is useful. The maintainer's instance at `op-cards.ditshej.ch` is private and not a public endpoint.

## Goals / Non-Goals

**Goals:**

- A first-time reader understands within the first 15 lines that they need to host the API themselves.
- The distinction between the API project and the SDK project is explicit.
- Every occurrence of `op-cards.ditshej.ch` is annotated as the maintainer's private instance.
- No public method documentation is altered.

**Non-Goals:**

- No hosting instructions for `one-piece-cards-api`.
- No code changes.
- No new specs beyond updating the `readme` spec.

## Decisions

**New "How it works" section immediately after the intro**
A short numbered list ("1. host the API, 2. install this SDK") answers the prerequisite question before the reader reaches Installation. This is the most impactful change because it front-loads the mental model.

**Reframe the lead-in sentence**
Replace "PHP SDK for the One Piece TCG card API" with wording that includes "self-hostable" and "your own instance". This sets expectations from the very first line.

**Annotate `op-cards.ditshej.ch` in place, not replace it**
The user decided to keep the real hostname (it signals this is a working, non-toy project) but append a note ("the maintainer's instance — replace with yours"). This applies to the configuration table and the Laravel `.env` example.

**Update `OPCARDS_TOKEN` description**
"Bearer token for API authentication" → "Bearer token issued by your API instance". The adjective "your" reinforces that the token comes from the consumer's own server.

## Risks / Trade-offs

[Risk] Inline hostname annotations (`— the maintainer's instance`) make the configuration table slightly wider and may feel noisy.
→ Acceptable: clarity over aesthetics. The annotation is a one-liner and disappears once the reader replaces the URI.

[Risk] "How it works" section adds a prerequisite that may deter users who just want to see code.
→ Acceptable: better to be honest upfront than to confuse readers who copy-paste config values and wonder why requests fail.

## Open Questions

None — all decisions confirmed with the user during planning.
