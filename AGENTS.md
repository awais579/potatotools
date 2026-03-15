# PotatoTools Agent Guide

Read this file before making any UI, Blade, Tailwind, or SEO-related changes in this repo.

## Project Stack
- Laravel app with Blade views.
- Tailwind CSS v4 via `resources/css/app.css`.
- Vite handles CSS/JS bundling.
- Main layout: `resources/views/layouts/app.blade.php`.
- Routes live in `routes/web.php`.

## Core UI Principle
- This project uses a Tailwind-first hybrid system.
- Use Tailwind utilities for layout, spacing, responsive behavior, and one-off page structure.
- Use shared `pt-*` classes only for repeated design patterns.
- Do not solve spacing issues with random page-level CSS overrides if utilities or shared classes can solve them.
- Every UI decision should aim for:
  - SEO-friendly structure
  - Google-friendly content clarity
  - crawler-friendly page structure
  - easy, clean, professional UI
  - clear value for technical and non-technical users

## Source Of Truth
- Design tokens live in `resources/css/app.css` under `@theme`.
- Shared UI primitives also live in `resources/css/app.css`.
- Keep `app.css` as the styling source of truth.
- Do not reintroduce duplicate colors, fonts, or spacing primitives in `tailwind.config.js`.

## Shared UI Primitives
Use these before inventing new classes:
- `pt-container`
- `pt-btn-primary`
- `pt-btn-secondary`
- `pt-card`
- `pt-card-elevated`
- `pt-chip`
- `pt-chip-static`
- `pt-input`
- `pt-input-tall`
- `pt-label`
- `pt-field`
- `pt-pill-group`
- `pt-result-stack`
- `pt-accordion`
- `pt-soft-section`
- `pt-soft-card`
- `pt-tool-card`
- `pt-link-arrow`
- `pt-image-placeholder`

If a pattern repeats across pages, promote it into a shared `pt-*` primitive instead of solving it locally again.

## Styling Rules
- Prefer utility classes for:
  - margin
  - padding
  - grid/flex layout
  - responsive changes
  - typography sizing
  - section spacing
- Prefer shared `pt-*` classes for:
  - buttons
  - inputs
  - labels
  - cards
  - soft sections
  - FAQ blocks
  - repeated link-arrow treatment
- Avoid page selectors that override shared primitive behavior like:
  - `.page .pt-label`
  - `.page .pt-input`
  - `.page .pt-btn-primary`
- Do not add hidden spacing resets that make Tailwind utilities feel broken.

## Page-Level CSS Policy
- Page-level `<style>` blocks are allowed only for truly unique layout or visualization cases.
- Good examples:
  - custom calculator gauge
  - unusual 2-column result/form layout
  - one-off decorative visual treatment
- Bad examples:
  - fixing label margins
  - fixing input padding
  - fixing button spacing
  - overriding chip hover globally for one page when a shared variant should exist

## New Page Structure
For new tool pages, follow this structure when possible:
1. `@section('title')`, `@section('description')`, `@section('canonical')`
2. Main page section with `pt-container`
3. Breadcrumb
4. H1 + short clean intro
5. Main form/result layout
6. “How it works” or supporting explanation
7. FAQ section
8. Related tools section if relevant

## SEO Rules
- Every page must have:
  - unique title
  - unique meta description
  - canonical URL
- Copy should be simple, direct, and crawler-friendly.
- Avoid filler text.
- Tool pages should clearly state:
  - what the tool does
  - what inputs are needed
  - what result the user gets
- If a UI/content decision is weak for SEO, ranking clarity, or intent match, stop and correct the structure before polishing visuals.
- Prefer one clear primary intent per page.
- Do not mix multiple strong intents on one page unless there is a very strong product reason.
- Write text as if it must satisfy both users and Google: clear, literal, relevant, and easy to scan.

## Copy Rules
- Write for technical and non-technical users both.
- Keep language simple and clean.
- Result areas should show result first, explanation second.
- Avoid cluttered helper copy around inputs.
- Labels should be short and literal.
- Placeholders should guide input format, not act like fake default values.
- Do not repeat the same message in the page intro, tool card, and helper text.
- On tool pages, keep above-the-fold copy minimal.
- If a line does not help action, trust, or SEO intent clarity, cut it.
- Prefer short, professional wording over descriptive marketing copy.

## Form Rules
- Use `pt-label` for labels.
- Wrap label + control in `pt-field` when vertical rhythm is needed.
- Use `pt-input` for standard controls.
- Use `pt-input-tall` when this tool UI requires larger controls.
- Do not prefill example values unless there is a strong product reason.
- Prefer placeholders over fake demo values in empty inputs.

## Interaction Rules
- Reuse `pt-link-arrow` for arrow links.
- Reuse `pt-tool-card` for linked cards.
- Use `pt-chip-static` for informational chips that should not feel interactive.
- If something is clickable, cursor and hover should make that obvious.
- If something is not clickable, it should not look interactive.

## Blade Conventions
- Keep Blade markup readable.
- Avoid large inline style attributes unless necessary for JS-driven visuals.
- Reuse shared components:
  - navbar
  - footer
  - FAQ accordion
  - home tool sections
- If a tool page needs a reusable section, extract a component instead of copying markup across pages.

## JS Rules For Tool Pages
- Keep tool logic inside page `@push('scripts')` if it is page-specific.
- Do not mix styling fixes into JS.
- JS should toggle states and results, not patch spacing/layout problems.

## When Adding New Shared Styles
- Add them to `resources/css/app.css`.
- Name them with `pt-` prefix.
- Make them reusable and behavior-based.
- Do not add a shared class that only exists for one page-specific spacing bug.

## Before Finishing Any UI Work
Check these:
- spacing utilities visibly work as expected
- no shared primitive is being silently overridden by page CSS
- mobile and desktop layout both hold up
- page still matches PotatoTools visual language
- build passes with `npm run build`

## Avoid
- Bootstrap migration
- mixing another design system
- duplicate theme definitions
- random inline CSS fixes
- one-off overrides for shared classes
- overly verbose or cluttered UI copy

## Goal
Keep PotatoTools consistent, clean, SEO-friendly, and easy to extend. New UI should feel like it belongs to the same product without needing visual cleanup afterward.

## Default Product Lens
Before finalizing any tool page, check it from these lenses:
- SEO expert: does the page match one clear search intent?
- UI expert: is the interface clean, easy, and visually calm?
- Google crawler: is the page structure obvious and content easy to parse?
- Non-technical user: can the user understand what to do without effort?
- Senior developer: is the solution maintainable and consistent with the shared system?
