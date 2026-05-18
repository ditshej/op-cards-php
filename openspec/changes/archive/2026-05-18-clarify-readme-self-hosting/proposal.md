## Why

The README currently implies that `op-cards.ditshej.ch` is a publicly accessible API that consumers can call. In reality the package is a PHP SDK that must be pointed at the user's **own** self-hosted instance of [`one-piece-cards-api`](https://github.com/ditshej/one-piece-cards-api). A reader who doesn't already know this architecture will assume they can install the Composer package and start making requests without running any backend — which is wrong.

Concrete problems in the current text:

- The lead-in says "PHP SDK for the One Piece TCG card API" without explaining that the API must be self-hosted.
- The configuration table shows `https://op-cards.ditshej.ch/api/` as the example URI without noting it is the maintainer's private instance, not a shared endpoint.
- The Laravel `.env` example repeats the same URI with no disclaimer.
- The connection between "install this SDK" and "run your own API server" is never stated.

## What Changes

- **`README.md`** — rewritten intro, new "How it works" section, updated configuration table and Laravel `.env` example.

## Capabilities

### Modified Capabilities

- `readme`: The existing readme capability is extended to convey the self-hosting model. The public method surface, filter documentation, and error handling sections are unchanged.

## Non-goals

- No changes to any PHP source file, test, or configuration.
- No change to specs other than the `readme` spec.
- No introduction of a separate hosting guide or architecture diagram.
- Does not document how to install or run `one-piece-cards-api` itself — that belongs in that repo.
