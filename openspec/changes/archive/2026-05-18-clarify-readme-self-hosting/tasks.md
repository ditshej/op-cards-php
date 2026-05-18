## 1. Update README.md

- [x] 1.1 Rewrite the lead-in sentence (line 5) to say "self-hostable" and "your own instance"
- [x] 1.2 Add "How it works" section after the intro explaining the two-component architecture (API server + this SDK) and noting that `op-cards.ditshej.ch` is the maintainer's private instance
- [x] 1.3 Update `OPCARDS_TOKEN` description: "Bearer token for API authentication" → "Bearer token issued by your API instance"
- [x] 1.4 Update `OPCARDS_BASE_URI` description and example: append "the maintainer's instance — replace with yours" after `https://op-cards.ditshej.ch/api/`
- [x] 1.5 Annotate the Laravel `.env` example block with a comment or sentence noting the URI is the maintainer's instance

## 2. Review

- [x] 2.1 Read the full README as a first-time reader and confirm: the self-hosting requirement is clear before reaching the Installation section
- [x] 2.2 Confirm every `op-cards.ditshej.ch` occurrence has the private-instance annotation
- [x] 2.3 Confirm no method documentation, filter table, or error handling section was inadvertently altered
