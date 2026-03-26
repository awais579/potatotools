@extends('layouts.app')

@section('title', 'Snow Day Calculator - Local weather history school closure estimate')
@section('description', 'Estimate snow day probability using forecast weather plus recent local weather history, storm timing, and school policy inputs.')
@section('canonical', route('tools.snow-day-calculator'))

@php
    $snowMethodologyOwner = data_get($snowDayMethodology ?? [], 'owner', 'PotatoTools Editorial and Engineering Team');
    $snowMethodologyUpdated = data_get($snowDayMethodology ?? [], 'last_updated', '2026-03-24');
    $snowValidationRecords = data_get($snowDayValidation ?? [], 'records', []);
    $snowValidationCount = is_array($snowValidationRecords) ? count($snowValidationRecords) : 0;
@endphp

@push('head')
    <script type="application/ld+json">{!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'WebApplication',
        'name' => 'PotatoTools Snow Day Calculator',
        'applicationCategory' => 'EducationalApplication',
        'operatingSystem' => 'Web',
        'isAccessibleForFree' => true,
        'url' => route('tools.snow-day-calculator'),
        'description' => 'Estimate school closure chance using forecast weather, local winter history, timing, ice, and school policy inputs.',
        'dateModified' => $snowMethodologyUpdated,
        'author' => [
            '@type' => 'Organization',
            'name' => $snowMethodologyOwner,
        ],
        'publisher' => [
            '@type' => 'Organization',
            'name' => 'PotatoTools',
        ],
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endpush

@section('content')
    <section id="snow-tool-page" class="pt-container pt-8 pb-10 sm:pt-10 sm:pb-12 lg:pt-12 lg:pb-14">
        <nav aria-label="Breadcrumb" class="text-xs text-stone-500">
            <ol class="flex flex-wrap items-center gap-2">
                <li><a href="{{ route('home') }}" class="hover:text-primary">Home</a></li>
                <li aria-hidden="true">&gt;</li>
                <li><a href="{{ route('home') }}#pick-potato" class="hover:text-primary">Tools</a></li>
                <li aria-hidden="true">&gt;</li>
                <li aria-current="page" class="font-semibold text-primary">Snow Day Calculator</li>
            </ol>
        </nav>

        <div class="mt-5">
            <div class="pt-page-title-row">
                <span class="pt-page-title-icon" aria-hidden="true">
                    <i class="fa-solid fa-snowflake"></i>
                </span>
                <h1 class="text-3xl font-semibold text-stone-900 sm:text-5xl">Snow Day Calculator</h1>
            </div>
            <p class="mt-4 max-w-2xl text-sm leading-relaxed text-stone-600 sm:text-base">
                Estimate school closure chance with forecast weather, the last five years of nearby winter history, storm timing, and school policy inputs.
            </p>

            <div class="mt-5 flex flex-wrap gap-2">
                <span class="pt-chip pt-chip-static"><i class="fa-solid fa-scale-balanced text-accent" aria-hidden="true"></i> History-adjusted model</span>
                <span class="pt-chip pt-chip-static"><i class="fa-solid fa-school text-accent" aria-hidden="true"></i> School closure estimate</span>
                <span class="pt-chip pt-chip-static"><i class="fa-solid fa-clock-rotate-left text-accent" aria-hidden="true"></i> Local winter history</span>
                <span class="pt-chip pt-chip-static"><i class="fa-solid fa-circle-info text-accent" aria-hidden="true"></i> Estimate only</span>
            </div>
        </div>

        <div class="mt-6 grid gap-5 md:grid-cols-[minmax(0,1.05fr)_minmax(320px,0.95fr)] xl:gap-6">
            <section id="snow-form-card" class="pt-card pt-card-elevated relative p-5 sm:p-6 lg:p-7" aria-busy="false">
                <div class="rounded-3xl border border-stone-200/70 bg-white px-4 py-4 sm:px-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-stone-500">Forecast Inputs</p>
                    <h2 class="mt-2 text-2xl font-semibold text-stone-900">Enter the winter conditions</h2>
                </div>

                <form id="snow-form" class="mt-6 space-y-6" novalidate>
                    <div class="grid gap-6 md:grid-cols-2">
                        <div class="pt-field md:col-span-2">
                            <label for="location-query" class="pt-label">ZIP Code</label>
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                                <input
                                    id="location-query"
                                    type="text"
                                    inputmode="numeric"
                                    autocomplete="postal-code"
                                    maxlength="5"
                                    class="pt-input pt-input-tall"
                                    placeholder="Enter 5-digit ZIP code">
                                <button
                                    id="fetch-weather"
                                    type="button"
                                    class="pt-btn-secondary min-h-[3.25rem] shrink-0 justify-center px-5 text-sm font-semibold sm:w-auto">
                                    Fetch Weather
                                </button>
                            </div>
                        </div>

                        <div class="pt-field md:col-span-2">
                            <p id="detected-location" class="hidden rounded-2xl border border-stone-200/70 bg-white px-4 py-3 text-sm leading-relaxed text-stone-600"></p>
                        </div>

                        <div class="pt-field">
                            <label for="temp-f" class="pt-label">Morning Temperature (F)<span class="pt-required-mark" aria-hidden="true">*</span></label>
                            <input
                                id="temp-f"
                                type="number"
                                min="-40"
                                max="50"
                                step="0.1"
                                inputmode="decimal"
                                class="pt-input pt-input-tall"
                                placeholder="Enter temperature"
                                required>
                        </div>

                        <div class="pt-field">
                            <label for="snow-in" class="pt-label">Forecast Snow (inches)<span class="pt-required-mark" aria-hidden="true">*</span></label>
                            <input
                                id="snow-in"
                                type="number"
                                min="0"
                                max="30"
                                step="0.1"
                                inputmode="decimal"
                                class="pt-input pt-input-tall"
                                placeholder="Enter snow amount"
                                required>
                        </div>

                        <div class="pt-field">
                            <div class="pt-label-row">
                                <label for="ice-in" class="pt-label mb-0">Estimated Ice (inches)<span class="pt-required-mark" aria-hidden="true">*</span></label>
                                <button
                                    type="button"
                                    class="pt-info-trigger"
                                    data-pt-tooltip="Suggested from freezing-weather signals. Review and adjust if needed."
                                    aria-label="How is estimated ice calculated?">
                                    <i class="fa-solid fa-info" aria-hidden="true"></i>
                                </button>
                            </div>
                            <input
                                id="ice-in"
                                type="number"
                                min="0"
                                max="1"
                                step="0.01"
                                inputmode="decimal"
                                class="pt-input pt-input-tall"
                                placeholder="Review estimated ice"
                                required>
                        </div>

                        <div class="pt-field">
                            <label for="wind-mph" class="pt-label">Wind Speed (mph)<span class="pt-required-mark" aria-hidden="true">*</span></label>
                            <input
                                id="wind-mph"
                                type="number"
                                min="0"
                                max="80"
                                step="0.1"
                                inputmode="decimal"
                                class="pt-input pt-input-tall"
                                placeholder="Enter wind speed"
                                required>
                        </div>

                        <div class="pt-field pt-select-shell">
                            <div class="pt-label-row">
                                <label for="school-type" class="pt-label mb-0">School Type<span class="pt-required-mark" aria-hidden="true">*</span></label>
                                <button
                                    type="button"
                                    class="pt-info-trigger"
                                    data-pt-tooltip="Choose the type of school you are estimating for."
                                    aria-label="What does school type mean?">
                                    <i class="fa-solid fa-info" aria-hidden="true"></i>
                                </button>
                            </div>
                            <select id="school-type" class="pt-input pt-input-tall" data-pt-select required>
                                <option value="" selected disabled>Choose school type</option>
                                <option value="elementary">Elementary School</option>
                                <option value="middle">Middle School</option>
                                <option value="high">High School</option>
                                <option value="district">Public District</option>
                                <option value="college">College / University</option>
                            </select>
                        </div>

                        <div class="pt-field pt-select-shell">
                            <div class="pt-label-row">
                                <label for="district-strictness" class="pt-label mb-0">District Strictness<span class="pt-required-mark" aria-hidden="true">*</span></label>
                                <button
                                    type="button"
                                    class="pt-info-trigger"
                                    data-pt-tooltip="Lenient closes more easily. Strict stays open longer."
                                    aria-label="What does district strictness mean?">
                                    <i class="fa-solid fa-info" aria-hidden="true"></i>
                                </button>
                            </div>
                            <select id="district-strictness" class="pt-input pt-input-tall" data-pt-select required>
                                <option value="" selected disabled>Choose strictness</option>
                                <option value="lenient">Lenient</option>
                                <option value="normal">Normal</option>
                                <option value="strict">Strict</option>
                            </select>
                        </div>

                        <div class="pt-field pt-select-shell">
                            <div class="pt-label-row">
                                <label for="storm-timing" class="pt-label mb-0">Storm Timing<span class="pt-required-mark" aria-hidden="true">*</span></label>
                                <button
                                    type="button"
                                    class="pt-info-trigger"
                                    data-pt-tooltip="Choose when the worst weather is expected."
                                    aria-label="What does storm timing mean?">
                                    <i class="fa-solid fa-info" aria-hidden="true"></i>
                                </button>
                            </div>
                            <select id="storm-timing" class="pt-input pt-input-tall" data-pt-select required>
                                <option value="" selected disabled>Choose timing</option>
                                <option value="overnight">Overnight before school</option>
                                <option value="commute">Morning commute hours</option>
                                <option value="school-hours">During school hours</option>
                                <option value="after-school">After school</option>
                            </select>
                        </div>
                    </div>

                    <p class="rounded-2xl border border-stone-200/70 bg-potato-beige/35 px-4 py-3 text-xs leading-relaxed text-stone-600">
                        Weather fetch uses the ZIP code and then shows the detected location before filling the forecast inputs. Estimated ice stays editable, and school policy inputs remain heuristic signals until broader validation is available.
                    </p>

                    <p id="snow-form-error" class="hidden rounded-xl border border-red-200 bg-red-50 px-3 py-2 text-xs font-semibold text-red-700"></p>

                    <button type="submit" class="pt-btn-primary w-full py-3.5 text-base">
                        Estimate Snow Day
                        <i class="fa-solid fa-snowflake" aria-hidden="true"></i>
                    </button>
                </form>

                <div id="weather-autofill-overlay" class="pt-form-overlay" aria-hidden="true" hidden>
                    <div class="pt-form-overlay-panel">
                        @include('components.loading-indicator', [
                            'id' => 'weather-autofill-loading',
                            'label' => 'Fetching weather data...',
                            'class' => 'text-sm text-stone-600',
                            'hidden' => false,
                        ])
                    </div>
                </div>
            </section>

            <div class="pt-result-stack">
                <section class="pt-card pt-card-elevated p-5 sm:p-6 lg:p-7" aria-live="polite">
                    <p class="text-[11px] font-semibold uppercase tracking-[0.15em] text-accent">Snow Day Estimate</p>
                    <p id="resultDate" class="mt-4 text-sm font-medium text-stone-500">Forecast target date will appear here after weather is fetched.</p>
                    <p id="resultHint" class="mt-2 text-sm font-medium text-stone-500">Enter the forecast details, then run the estimate.</p>

                    <div class="mt-5 flex flex-wrap items-end gap-3">
                        <p id="snow-percent" class="text-5xl font-semibold leading-none text-stone-900 sm:text-7xl">--</p>
                        <span class="pb-2 text-2xl font-semibold text-stone-400 sm:text-3xl">chance</span>
                    </div>

                    <p id="snow-summary" class="mt-4 text-base font-medium text-stone-700 sm:text-lg">No estimate yet</p>
                    <p id="summaryMeaning" class="mt-2 text-sm leading-relaxed text-stone-500">
                        The result meaning will appear here after you run the estimate.
                    </p>
                    <p class="mt-3 text-sm leading-relaxed text-stone-500">
                        This tool gives a history-adjusted estimate. It does not issue official school closure decisions.
                    </p>

                    <div class="mt-6 rounded-2xl border border-stone-200/70 bg-potato-beige/45 p-4">
                        <p class="text-[11px] font-semibold uppercase tracking-[0.15em] text-stone-500">Score Breakdown</p>
                        <p class="mt-2 text-xs leading-relaxed text-stone-500">Each box is a normalized risk score from 0 to 100, not a raw weather unit.</p>
                        <dl class="mt-4 grid gap-3 sm:grid-cols-2 xl:grid-cols-3">
                            <div class="rounded-2xl border border-stone-200/70 bg-white/85 px-4 py-3">
                                <dt class="text-[11px] font-semibold uppercase tracking-[0.14em] text-stone-500">Snow Score</dt>
                                <dd id="score-snow" class="mt-2 text-lg font-semibold text-stone-900">--</dd>
                            </div>
                            <div class="rounded-2xl border border-stone-200/70 bg-white/85 px-4 py-3">
                                <dt class="text-[11px] font-semibold uppercase tracking-[0.14em] text-stone-500">Ice Score</dt>
                                <dd id="score-ice" class="mt-2 text-lg font-semibold text-stone-900">--</dd>
                            </div>
                            <div class="rounded-2xl border border-stone-200/70 bg-white/85 px-4 py-3">
                                <dt class="text-[11px] font-semibold uppercase tracking-[0.14em] text-stone-500">Timing Score</dt>
                                <dd id="score-timing" class="mt-2 text-lg font-semibold text-stone-900">--</dd>
                            </div>
                            <div class="rounded-2xl border border-stone-200/70 bg-white/85 px-4 py-3">
                                <dt class="text-[11px] font-semibold uppercase tracking-[0.14em] text-stone-500">Temperature Score</dt>
                                <dd id="score-temp" class="mt-2 text-lg font-semibold text-stone-900">--</dd>
                            </div>
                            <div class="rounded-2xl border border-stone-200/70 bg-white/85 px-4 py-3">
                                <dt class="text-[11px] font-semibold uppercase tracking-[0.14em] text-stone-500">Wind Score</dt>
                                <dd id="score-wind" class="mt-2 text-lg font-semibold text-stone-900">--</dd>
                            </div>
                            <div class="rounded-2xl border border-stone-200/70 bg-white/85 px-4 py-3">
                                <dt class="text-[11px] font-semibold uppercase tracking-[0.14em] text-stone-500">School Policy Score</dt>
                                <dd id="score-policy" class="mt-2 text-lg font-semibold text-stone-900">--</dd>
                            </div>
                        </dl>
                    </div>
                </section>

                <details class="pt-card pt-card-elevated px-4 py-3 sm:px-5 sm:py-4">
                    <summary class="flex cursor-pointer items-center justify-between gap-3 text-sm font-semibold text-stone-800">
                        <span>Formula and weights</span>
                        <i class="fa-solid fa-chevron-down text-xs text-stone-400" aria-hidden="true"></i>
                    </summary>
                    <div class="mt-3 space-y-3 text-xs leading-relaxed text-stone-600 sm:text-sm">
                        <p><strong>Final score</strong> = (Snow x 0.30) + (Ice x 0.25) + (Timing x 0.15) + (Temperature x 0.10) + (Wind x 0.10) + (School Policy x 0.10)</p>
                        <p>After you fetch weather, snow, temperature, and wind are normalized against the last five years of nearby winter weather for that location instead of one fixed national threshold.</p>
                        <p>Estimated ice is a suggested input built from freezing-weather signals. Timing, school type, and district strictness are still practical heuristic inputs, not official district rules.</p>
                    </div>
                </details>
            </div>
        </div>
    </section>

    <section class="pt-container pt-16 pb-6 sm:pt-20">
        <div class="pt-soft-section bg-[#efe5d8] px-5 py-8 sm:px-8 sm:py-10">
            <div class="max-w-4xl">
                <p class="text-xs font-semibold uppercase tracking-[0.08em] text-stone-500">Trust Report</p>
                <h2 class="mt-2 text-3xl font-semibold text-stone-900 sm:text-4xl">How this snow day calculator works</h2>
                <p class="mt-3 text-sm leading-relaxed text-stone-700 sm:text-base">
                    This page uses a <strong>PotatoTools history-adjusted score model</strong>. It is not an official school district formula and it is not an exact prediction.
                    The tool compares forecast snow, temperature, and wind against the last five years of nearby winter weather for the same location, then combines that with timing, ice,
                    and school policy inputs.
                </p>
            </div>

            <div class="mt-6 grid gap-4 md:grid-cols-3">
                <article class="pt-soft-card p-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-stone-500">What It Uses</p>
                    <h3 class="mt-3 text-lg font-semibold text-stone-900">Forecast plus local weather history</h3>
                    <p class="mt-2 text-sm leading-relaxed text-stone-600">
                        The fetched location adds a local winter baseline, so the same snowfall can score differently in a snow-heavy area versus a snow-light area.
                    </p>
                </article>

                <article class="pt-soft-card p-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-stone-500">Why It Is More Defensible</p>
                    <h3 class="mt-3 text-lg font-semibold text-stone-900">It avoids one-size-fits-all thresholds</h3>
                    <p class="mt-2 text-sm leading-relaxed text-stone-600">
                        Public winter guidance highlights snow, wind, ice, and temperature, but local rarity matters too. This version adjusts for recent nearby winters instead of using only fixed cutoffs.
                    </p>
                </article>

                <article class="pt-soft-card p-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-stone-500">What It Still Does Not Use</p>
                    <h3 class="mt-3 text-lg font-semibold text-stone-900">No official district closure feed</h3>
                    <p class="mt-2 text-sm leading-relaxed text-stone-600">
                        This tool does not have district-by-district historical closure records. School type and district strictness still act as user-supplied policy signals, not official district data.
                    </p>
                </article>
            </div>

            <div class="mt-6 rounded-2xl border border-stone-200/70 bg-white/85 p-5">
                <p class="text-xs font-semibold uppercase tracking-[0.12em] text-stone-500">Public references used for this model</p>
                <ul class="mt-3 space-y-2 text-sm leading-relaxed text-stone-600">
                    <li>
                        <a href="https://open-meteo.com/en/docs/historical-weather-api" target="_blank" rel="noopener noreferrer" class="text-primary hover:underline">
                            Open-Meteo Historical Weather API
                        </a>
                        : provides the nearby historical weather data used to calibrate snow, temperature, and wind against the selected location.
                    </li>
                    <li>
                        <a href="https://www.ncdc.noaa.gov/cdo-web/" target="_blank" rel="noopener noreferrer" class="text-primary hover:underline">
                            NOAA Climate Data Online
                        </a>
                        : supports the idea that historical weather baselines are a valid way to contextualize present-day weather severity.
                    </li>
                    <li>
                        <a href="https://www.weather.gov/arx/wintersafety" target="_blank" rel="noopener noreferrer" class="text-primary hover:underline">
                            National Weather Service Winter Safety
                        </a>
                        : shows why snow amount, ice, wind, and visibility matter when winter travel becomes dangerous.
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <section class="pt-container pt-16 pb-6 sm:pt-20">
        <div class="pt-soft-section bg-white px-5 py-8 shadow-sm ring-1 ring-stone-200/70 sm:px-8 sm:py-10">
            <div class="max-w-4xl">
                <p class="text-xs font-semibold uppercase tracking-[0.08em] text-stone-500">Methodology And Trust</p>
                <h2 class="mt-2 text-3xl font-semibold text-stone-900 sm:text-4xl">Authorship, validation, and model transparency</h2>
                <p class="mt-3 text-sm leading-relaxed text-stone-700 sm:text-base">
                    This snow day calculator is maintained by <strong>{{ $snowMethodologyOwner }}</strong>. The current model version publishes its weighting logic,
                    public weather sources, known limitations, and a starter benchmark set of real public district notices so users can review how the estimate is framed.
                </p>
            </div>

            <div class="mt-6 grid gap-4 md:grid-cols-3">
                <article class="pt-soft-card p-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-stone-500">Author / Owner</p>
                    <h3 class="mt-3 text-lg font-semibold text-stone-900">{{ $snowMethodologyOwner }}</h3>
                    <p class="mt-2 text-sm leading-relaxed text-stone-600">
                        Last updated {{ $snowMethodologyUpdated }}. This model is published as an estimate tool, not an official district decision system.
                    </p>
                </article>

                <article class="pt-soft-card p-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-stone-500">Validation Coverage</p>
                    <h3 class="mt-3 text-lg font-semibold text-stone-900">{{ $snowValidationCount }} public district notices</h3>
                    <p class="mt-2 text-sm leading-relaxed text-stone-600">
                        The linked validation page publishes hand-audited closure, delay, and remote-learning notices used as transparent benchmark cases.
                    </p>
                </article>

                <article class="pt-soft-card p-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-stone-500">Read The Evidence</p>
                    <h3 class="mt-3 text-lg font-semibold text-stone-900">Methodology and results pages</h3>
                    <div class="mt-3 flex flex-col gap-3">
                        <a href="{{ route('tools.snow-day-calculator.methodology') }}" class="pt-link-arrow inline-flex items-center gap-1.5 text-sm font-semibold text-primary">
                            Read methodology
                            <span class="pt-link-arrow-icon" aria-hidden="true">&rarr;</span>
                        </a>
                        <a href="{{ route('tools.snow-day-calculator.validation') }}" class="pt-link-arrow inline-flex items-center gap-1.5 text-sm font-semibold text-primary">
                            View validation results
                            <span class="pt-link-arrow-icon" aria-hidden="true">&rarr;</span>
                        </a>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <section class="pt-container pt-16 pb-8 sm:pt-20">
        <div class="flex items-center justify-between gap-4">
            <h2 class="text-3xl font-semibold text-stone-900">Frequently Asked Questions</h2>
        </div>
        <div class="mt-6 space-y-3">
            <details class="pt-faq pt-accordion">
                <summary class="flex items-center justify-between gap-3">
                    <span>Is this an exact prediction?</span>
                    <span class="faq-plus text-xl leading-none text-stone-500">+</span>
                </summary>
                <p class="mt-3 text-sm text-stone-600">
                    No. This page gives a history-adjusted estimate based on the inputs you enter and the local weather baseline we can fetch. Real closure decisions still depend on local school administrators.
                </p>
            </details>
            <details class="pt-faq pt-accordion">
                <summary class="flex items-center justify-between gap-3">
                    <span>Why is there no single official snow day formula?</span>
                    <span class="faq-plus text-xl leading-none text-stone-500">+</span>
                </summary>
                <p class="mt-3 text-sm text-stone-600">
                    Different schools, districts, road systems, and local climates behave differently. The same snowfall can cause a closure in one area and not in another.
                </p>
            </details>
            <details class="pt-faq pt-accordion">
                <summary class="flex items-center justify-between gap-3">
                    <span>Why do school type and strictness matter?</span>
                    <span class="faq-plus text-xl leading-none text-stone-500">+</span>
                </summary>
                <p class="mt-3 text-sm text-stone-600">
                    Elementary schools, colleges, and public districts do not all respond the same way to winter weather. Local policy still changes the final estimate because this tool does not have official district closure feeds.
                </p>
            </details>
            <details class="pt-faq pt-accordion">
                <summary class="flex items-center justify-between gap-3">
                    <span>What if I do not know the exact weather forecast?</span>
                    <span class="faq-plus text-xl leading-none text-stone-500">+</span>
                </summary>
                <p class="mt-3 text-sm text-stone-600">
                    Use your best estimate from a weather forecast. This version is still a manual-input model, so the quality of the estimate depends on the quality of the forecast data you enter.
                </p>
            </details>
        </div>
    </section>

    <section class="pt-container pt-16 pb-12 sm:pt-20">
        <div class="flex items-center justify-between gap-4">
            <h2 class="text-3xl font-semibold text-stone-900">Related Tools</h2>
            <a
                href="{{ route('home') }}#pick-potato"
                class="pt-link-arrow inline-flex items-center gap-1.5 text-sm font-semibold text-primary">
                Browse all
                <span class="pt-link-arrow-icon" aria-hidden="true">&rarr;</span>
            </a>
        </div>

        <div class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <a href="{{ route('tools.age-calculator') }}" class="pt-soft-card pt-tool-card block p-5">
                <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-primary/10 text-primary">
                    <i class="fa-solid fa-calendar-days" aria-hidden="true"></i>
                </span>
                <h3 class="mt-3 text-xl font-semibold text-stone-900">Age Calculator</h3>
                <p class="mt-2 text-sm text-stone-600">Calculate exact age in years, months, and days.</p>
                <span class="pt-link-arrow mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-primary">
                    Open Tool
                    <span class="pt-link-arrow-icon" aria-hidden="true">&rarr;</span>
                </span>
            </a>

            <a href="{{ route('tools.height-converter') }}" class="pt-soft-card pt-tool-card block p-5">
                <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-primary/10 text-primary">
                    <i class="fa-solid fa-ruler-vertical" aria-hidden="true"></i>
                </span>
                <h3 class="mt-3 text-xl font-semibold text-stone-900">Height Converter</h3>
                <p class="mt-2 text-sm text-stone-600">Convert between centimeters, meters, feet, and inches.</p>
                <span class="pt-link-arrow mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-primary">
                    Open Tool
                    <span class="pt-link-arrow-icon" aria-hidden="true">&rarr;</span>
                </span>
            </a>

            <article class="pt-soft-card p-5">
                <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-primary/10 text-primary">
                    <i class="fa-solid fa-weight-scale" aria-hidden="true"></i>
                </span>
                <h3 class="mt-3 text-xl font-semibold text-stone-900">BMI Calculator</h3>
                <p class="mt-2 text-sm text-stone-600">Calculate body mass index with a simple weight and height input.</p>
                <button type="button" class="pt-btn-secondary mt-4" disabled>Coming soon</button>
            </article>

            <article class="pt-soft-card p-5">
                <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-primary/10 text-primary">
                    <i class="fa-solid fa-ruler-combined" aria-hidden="true"></i>
                </span>
                <h3 class="mt-3 text-xl font-semibold text-stone-900">Unit Converter</h3>
                <p class="mt-2 text-sm text-stone-600">Convert common everyday units with a clear and simple calculator.</p>
                <button type="button" class="pt-btn-secondary mt-4" disabled>Coming soon</button>
            </article>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('snow-form');
            const formCard = document.getElementById('snow-form-card');
            const locationQuery = document.getElementById('location-query');
            const fetchWeatherButton = document.getElementById('fetch-weather');
            const detectedLocation = document.getElementById('detected-location');
            const schoolType = document.getElementById('school-type');
            const districtStrictness = document.getElementById('district-strictness');
            const stormTiming = document.getElementById('storm-timing');
            const tempF = document.getElementById('temp-f');
            const snowIn = document.getElementById('snow-in');
            const iceIn = document.getElementById('ice-in');
            const windMph = document.getElementById('wind-mph');
            const weatherAutofillOverlay = document.getElementById('weather-autofill-overlay');
            const weatherAutofillLoading = document.getElementById('weather-autofill-loading');
            const formErrorBox = document.getElementById('snow-form-error');
            const notify = window.ptNotify;

            const percentEl = document.getElementById('snow-percent');
            const resultDateEl = document.getElementById('resultDate');
            const summaryEl = document.getElementById('snow-summary');
            const summaryMeaningEl = document.getElementById('summaryMeaning');
            const hintEl = document.getElementById('resultHint');
            const scoreSnow = document.getElementById('score-snow');
            const scoreIce = document.getElementById('score-ice');
            const scoreTiming = document.getElementById('score-timing');
            const scoreTemp = document.getElementById('score-temp');
            const scoreWind = document.getElementById('score-wind');
            const scorePolicy = document.getElementById('score-policy');

            const clamp = (value, min, max) => Math.min(max, Math.max(min, value));
            const roundTo = (value, decimals) => {
                if (!Number.isFinite(value)) {
                    return '';
                }

                return value.toFixed(decimals);
            };

            const schoolTypeScores = {
                elementary: 100,
                middle: 85,
                high: 75,
                district: 90,
                college: 45,
            };

            const strictnessScores = {
                lenient: 100,
                normal: 70,
                strict: 40,
            };

            const timingScores = {
                overnight: 100,
                commute: 90,
                'school-hours': 60,
                'after-school': 25,
            };

            let autofillAbortController = null;
            let isAutofillLoading = false;
            let historicalBaseline = null;
            let forecastTargetDate = null;
            let forecastLocationLabel = '';

            const hideDetectedLocation = () => {
                if (!detectedLocation) {
                    return;
                }

                detectedLocation.textContent = '';
                detectedLocation.classList.add('hidden');
            };

            const showDetectedLocation = (label) => {
                if (!detectedLocation || !label) {
                    return;
                }

                detectedLocation.textContent = `Weather found for: ${label}`;
                detectedLocation.classList.remove('hidden');
            };

            const clearFetchedLocation = () => {
                forecastTargetDate = null;
                forecastLocationLabel = '';
                historicalBaseline = null;
                hideDetectedLocation();
            };

            const resetResults = () => {
                percentEl.textContent = '--';
                resultDateEl.textContent = forecastTargetDate
                    ? `Forecast target date: ${forecastTargetDate}${forecastLocationLabel ? ` for ${forecastLocationLabel}` : ''}`
                    : 'Forecast target date will appear here after weather is fetched.';
                summaryEl.textContent = 'No estimate yet';
                summaryMeaningEl.textContent = 'The result meaning will appear here after you run the estimate.';
                hintEl.textContent = 'Enter the forecast details, then run the estimate.';
                scoreSnow.textContent = '--';
                scoreIce.textContent = '--';
                scoreTiming.textContent = '--';
                scoreTemp.textContent = '--';
                scoreWind.textContent = '--';
                scorePolicy.textContent = '--';
            };

            const showToastError = (message) => {
                notify?.error(message);
            };

            const hideToastError = () => {
                notify?.dismissCurrent();
            };

            const showFormError = (message) => {
                if (!formErrorBox) {
                    return;
                }

                formErrorBox.textContent = message;
                formErrorBox.classList.remove('hidden');
            };

            const hideFormError = () => {
                if (!formErrorBox) {
                    return;
                }

                formErrorBox.textContent = '';
                formErrorBox.classList.add('hidden');
            };

            const setWeatherAutofillLoading = (isLoading) => {
                isAutofillLoading = isLoading;

                if (formCard) {
                    formCard.setAttribute('aria-busy', isLoading ? 'true' : 'false');
                }

                if (fetchWeatherButton) {
                    fetchWeatherButton.disabled = isLoading;
                    fetchWeatherButton.setAttribute('aria-disabled', isLoading ? 'true' : 'false');
                    fetchWeatherButton.textContent = isLoading ? 'Fetching...' : 'Fetch Weather';
                }

                if (weatherAutofillOverlay) {
                    weatherAutofillOverlay.hidden = !isLoading;
                    weatherAutofillOverlay.setAttribute('aria-hidden', isLoading ? 'false' : 'true');
                }

                if (!weatherAutofillLoading) {
                    return;
                }

                weatherAutofillLoading.hidden = !isLoading;
                weatherAutofillLoading.setAttribute('aria-hidden', isLoading ? 'false' : 'true');
            };

            const joinLabels = (labels) => {
                if (labels.length <= 1) {
                    return labels[0] || '';
                }

                if (labels.length === 2) {
                    return `${labels[0]} and ${labels[1]}`;
                }

                return `${labels.slice(0, -1).join(', ')}, and ${labels[labels.length - 1]}`;
            };

            const getTempScore = (temp) => {
                if (temp <= 10) return 100;
                if (temp <= 20) return 85;
                if (temp <= 32) return 65;
                if (temp <= 36) return 35;
                return 10;
            };

            const formatIsoDate = (date) => {
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');

                return `${year}-${month}-${day}`;
            };

            const formatHumanDate = (value) => {
                const parsed = parseIsoDate(value);

                if (!parsed) {
                    return value || '';
                }

                return parsed.toLocaleDateString('en-US', {
                    month: 'long',
                    day: 'numeric',
                    year: 'numeric',
                });
            };

            const getCircularDayDistance = (dateString, referenceDate) => {
                const sampleDate = new Date(`${dateString}T00:00:00`);

                if (Number.isNaN(sampleDate.getTime())) {
                    return Number.POSITIVE_INFINITY;
                }

                const baseYear = 2001;
                const sampleBase = new Date(baseYear, sampleDate.getMonth(), sampleDate.getDate());
                const referenceBase = new Date(baseYear, referenceDate.getMonth(), referenceDate.getDate());
                const dayDiff = Math.abs(Math.round((sampleBase.getTime() - referenceBase.getTime()) / (24 * 60 * 60 * 1000)));

                return Math.min(dayDiff, 365 - dayDiff);
            };

            const getPercentileScore = (values, target) => {
                const filtered = values.filter(Number.isFinite).sort((a, b) => a - b);

                if (!filtered.length || !Number.isFinite(target)) {
                    return null;
                }

                const count = filtered.filter((value) => value <= target).length;

                return Math.round(clamp((count / filtered.length) * 100, 0, 100));
            };

            const getColdPercentileScore = (values, target) => {
                const invertedValues = values.filter(Number.isFinite).map((value) => value * -1);

                if (!invertedValues.length || !Number.isFinite(target)) {
                    return null;
                }

                return getPercentileScore(invertedValues, target * -1);
            };

            const getHistoricalAdjustedWeatherScores = (snow, temp, wind) => {
                if (!historicalBaseline) {
                    return null;
                }

                const snowScore = getPercentileScore(historicalBaseline.snowValues, snow);
                const tempScore = getColdPercentileScore(historicalBaseline.tempValues, temp);
                const windScore = getPercentileScore(historicalBaseline.windValues, wind);

                if (![snowScore, tempScore, windScore].every(Number.isFinite)) {
                    return null;
                }

                return {
                    snow: snowScore,
                    temp: tempScore,
                    wind: windScore,
                };
            };

            const getSummary = (probability) => {
                if (probability >= 80) {
                    return 'Very high closure risk';
                }
                if (probability >= 60) {
                    return 'High closure risk';
                }
                if (probability >= 40) {
                    return 'Moderate closure risk';
                }
                if (probability >= 20) {
                    return 'Low closure risk';
                }
                return 'Very low closure risk';
            };

            const getSummaryMeaning = (probability) => {
                if (probability >= 80) {
                    return 'Closure looks strongly likely if the forecast holds.';
                }
                if (probability >= 60) {
                    return 'Many districts would seriously consider closing in these conditions.';
                }
                if (probability >= 40) {
                    return 'Closure is possible, but a delay or staying open is still plausible.';
                }
                if (probability >= 20) {
                    return 'Closure looks less likely unless conditions worsen.';
                }
                return 'Closure looks unlikely under the current inputs.';
            };

            const parseIsoDate = (value) => {
                if (!value) {
                    return null;
                }

                const parsed = new Date(`${value}T00:00:00`);

                return Number.isNaN(parsed.getTime()) ? null : parsed;
            };

            const freezingWeatherCodes = new Set([56, 57, 66, 67]);

            const estimateIceFromMorningEntries = (entries = []) => {
                if (!entries.length) {
                    return 0;
                }

                const subFreezingEntries = entries.filter((entry) => Number.isFinite(entry.temp) && entry.temp <= 32);

                if (!subFreezingEntries.length) {
                    return 0;
                }

                const freezingCodeEntries = subFreezingEntries.filter((entry) => freezingWeatherCodes.has(entry.weatherCode));
                const totalRain = subFreezingEntries.reduce((sum, entry) => sum + (Number.isFinite(entry.rain) ? entry.rain : 0), 0);
                const totalPrecipitation = subFreezingEntries.reduce((sum, entry) => sum + (Number.isFinite(entry.precipitation) ? entry.precipitation : 0), 0);
                const totalSnowfall = subFreezingEntries.reduce((sum, entry) => sum + (Number.isFinite(entry.snowfall) ? entry.snowfall : 0), 0);
                const lowFreezingLevelEntries = subFreezingEntries.filter((entry) => Number.isFinite(entry.freezingLevelHeight) && entry.freezingLevelHeight <= 400);

                let estimatedIce = 0;

                if (freezingCodeEntries.length) {
                    estimatedIce = (totalRain || totalPrecipitation) * 0.85;
                } else if (totalRain > 0) {
                    estimatedIce = totalRain * 0.45;
                } else if (totalPrecipitation > 0 && totalSnowfall === 0) {
                    estimatedIce = totalPrecipitation * 0.25;
                }

                if (lowFreezingLevelEntries.length >= 2 && estimatedIce > 0) {
                    estimatedIce *= 1.15;
                }

                return clamp(estimatedIce, 0, 1);
            };

            const getMorningForecast = (hourly = {}) => {
                const times = Array.isArray(hourly.time) ? hourly.time : [];
                const temperatures = Array.isArray(hourly.temperature_2m) ? hourly.temperature_2m : [];
                const snowfall = Array.isArray(hourly.snowfall) ? hourly.snowfall : [];
                const windSpeeds = Array.isArray(hourly.wind_speed_10m) ? hourly.wind_speed_10m : (Array.isArray(hourly.windspeed_10m) ? hourly.windspeed_10m : []);
                const rain = Array.isArray(hourly.rain) ? hourly.rain : [];
                const precipitation = Array.isArray(hourly.precipitation) ? hourly.precipitation : [];
                const weatherCodes = Array.isArray(hourly.weather_code) ? hourly.weather_code : [];
                const freezingLevelHeights = Array.isArray(hourly.freezing_level_height) ? hourly.freezing_level_height : [];

                if (!times.length || !temperatures.length || !snowfall.length || !windSpeeds.length) {
                    return null;
                }

                const morningBuckets = new Map();

                times.forEach((time, index) => {
                    const hour = Number.parseInt(String(time).slice(11, 13), 10);

                    if (!Number.isFinite(hour) || hour < 6 || hour > 9) {
                        return;
                    }

                    const dateKey = String(time).slice(0, 10);

                    if (!morningBuckets.has(dateKey)) {
                        morningBuckets.set(dateKey, []);
                    }

                    morningBuckets.get(dateKey).push({
                        temp: Number.parseFloat(temperatures[index]),
                        snowfall: Number.parseFloat(snowfall[index]),
                        wind: Number.parseFloat(windSpeeds[index]),
                        rain: Number.parseFloat(rain[index]),
                        precipitation: Number.parseFloat(precipitation[index]),
                        weatherCode: Number.parseInt(weatherCodes[index], 10),
                        freezingLevelHeight: Number.parseFloat(freezingLevelHeights[index]),
                    });
                });

                const firstMorningEntry = [...morningBuckets.entries()][0];
                const firstMorningDate = firstMorningEntry?.[0] ?? '';
                const firstMorning = firstMorningEntry?.[1];

                if (!firstMorning?.length) {
                    return null;
                }

                const avg = (values) => {
                    const filtered = values.filter(Number.isFinite);

                    if (!filtered.length) {
                        return null;
                    }

                    return filtered.reduce((sum, value) => sum + value, 0) / filtered.length;
                };

                const sum = (values) => values.filter(Number.isFinite).reduce((total, value) => total + value, 0);

                return {
                    dateKey: firstMorningDate,
                    temperatureF: avg(firstMorning.map((entry) => entry.temp)),
                    snowfallInches: sum(firstMorning.map((entry) => entry.snowfall)),
                    windMphValue: avg(firstMorning.map((entry) => entry.wind)),
                    estimatedIceInches: estimateIceFromMorningEntries(firstMorning),
                };
            };

            const fetchHistoricalBaseline = async (latitude, longitude, referenceDateValue = null) => {
                const referenceDate = parseIsoDate(referenceDateValue) || new Date();
                const endDate = new Date(referenceDate);
                endDate.setDate(endDate.getDate() - 1);

                const startDate = new Date(endDate);
                startDate.setFullYear(startDate.getFullYear() - 5);

                const archiveUrl = `https://archive-api.open-meteo.com/v1/archive?latitude=${encodeURIComponent(latitude)}&longitude=${encodeURIComponent(longitude)}&start_date=${encodeURIComponent(formatIsoDate(startDate))}&end_date=${encodeURIComponent(formatIsoDate(endDate))}&daily=temperature_2m_min,snowfall_sum,wind_speed_10m_max&temperature_unit=fahrenheit&wind_speed_unit=mph&precipitation_unit=inch&timezone=auto`;
                const archiveResponse = await fetch(archiveUrl);

                if (!archiveResponse.ok) {
                    throw new Error(`Archive failed with status ${archiveResponse.status}`);
                }

                const archiveData = await archiveResponse.json();
                const daily = archiveData?.daily || {};
                const times = Array.isArray(daily.time) ? daily.time : [];
                const snowfall = Array.isArray(daily.snowfall_sum) ? daily.snowfall_sum : [];
                const minTemps = Array.isArray(daily.temperature_2m_min) ? daily.temperature_2m_min : [];
                const maxWinds = Array.isArray(daily.wind_speed_10m_max) ? daily.wind_speed_10m_max : [];

                if (!times.length || !snowfall.length || !minTemps.length || !maxWinds.length) {
                    return null;
                }

                const seasonalIndexes = times
                    .map((time, index) => ({ time, index }))
                    .filter(({ time }) => getCircularDayDistance(time, referenceDate) <= 45);

                if (seasonalIndexes.length < 30) {
                    return null;
                }

                const snowValues = seasonalIndexes.map(({ index }) => Number.parseFloat(snowfall[index])).filter(Number.isFinite);
                const tempValues = seasonalIndexes.map(({ index }) => Number.parseFloat(minTemps[index])).filter(Number.isFinite);
                const windValues = seasonalIndexes.map(({ index }) => Number.parseFloat(maxWinds[index])).filter(Number.isFinite);

                if (snowValues.length < 30 || tempValues.length < 30 || windValues.length < 30) {
                    return null;
                }

                return {
                    snowValues,
                    tempValues,
                    windValues,
                    sampleCount: seasonalIndexes.length,
                };
            };

            const applyAutofill = (forecast) => {
                if (!forecast) {
                    return;
                }

                const temperatureF = forecast.temperatureF;
                const snowfallInches = forecast.snowfallInches;
                const windMphValue = forecast.windMphValue;
                const estimatedIce = forecast.estimatedIceInches;
                forecastTargetDate = formatHumanDate(forecast.dateKey);

                if (Number.isFinite(temperatureF)) {
                    tempF.value = roundTo(temperatureF, 1);
                }

                if (Number.isFinite(snowfallInches)) {
                    snowIn.value = roundTo(snowfallInches, 1);
                }

                if (Number.isFinite(windMphValue)) {
                    windMph.value = roundTo(windMphValue, 1);
                }

                iceIn.value = roundTo(clamp(estimatedIce, 0, 1), 2);
                hideFormError();
                hideToastError();
                resetResults();
            };

            const normalizeZip = (rawValue) => String(rawValue || '').replace(/\D/g, '').slice(0, 5);

            const getZipValidationMessage = (zip) => {
                if (!zip) {
                    return 'Enter a 5-digit ZIP code to fetch weather data.';
                }

                if (!/^\d{5}$/.test(zip)) {
                    return 'Enter a valid 5-digit ZIP code.';
                }

                return '';
            };

            const getDetectedLocationLabel = (location) => {
                if (!location) {
                    return '';
                }

                return [
                    location.name,
                    location.admin1,
                    location.country,
                ].filter(Boolean).join(', ');
            };

            const fetchGeocodeLocation = async ({ zip, controller }) => {
                if (!zip) {
                    return null;
                }

                const query = zip;
                if (!query) {
                    return null;
                }

                const geocodeUrl = `https://geocoding-api.open-meteo.com/v1/search?name=${encodeURIComponent(query)}&count=10&language=en&format=json`;
                const geocodeResponse = await fetch(geocodeUrl, { signal: controller.signal });

                if (!geocodeResponse.ok) {
                    throw new Error(`Geocoding failed with status ${geocodeResponse.status}`);
                }

                const geocodeData = await geocodeResponse.json();

                if (!Array.isArray(geocodeData?.results)) {
                    return null;
                }

                return geocodeData.results.find((entry) => {
                    const postcodes = Array.isArray(entry?.postcodes)
                        ? entry.postcodes.map((postcode) => String(postcode).toUpperCase())
                        : [];
                    return postcodes.includes(zip);
                }) || geocodeData.results[0] || null;
            };

            const fetchWeatherAutofill = async (zip) => {
                if (isAutofillLoading) {
                    return;
                }

                clearFetchedLocation();

                if (autofillAbortController) {
                    autofillAbortController.abort();
                }

                const controller = new AbortController();
                autofillAbortController = controller;
                setWeatherAutofillLoading(true);

                try {
                    const location = await fetchGeocodeLocation({ zip, controller });

                    const latitude = Number.parseFloat(location?.latitude);
                    const longitude = Number.parseFloat(location?.longitude);

                    if (!Number.isFinite(latitude) || !Number.isFinite(longitude)) {
                        showToastError('We could not match that ZIP code. Check it and try again.');
                        return;
                    }

                    forecastLocationLabel = getDetectedLocationLabel(location);
                    showDetectedLocation(forecastLocationLabel);

                    const forecastUrl = `https://api.open-meteo.com/v1/forecast?latitude=${encodeURIComponent(latitude)}&longitude=${encodeURIComponent(longitude)}&hourly=temperature_2m,snowfall,wind_speed_10m,rain,precipitation,weather_code,freezing_level_height&temperature_unit=fahrenheit&windspeed_unit=mph&precipitation_unit=inch&timezone=auto`;
                    const forecastResponse = await fetch(forecastUrl, { signal: controller.signal });

                    if (!forecastResponse.ok) {
                        throw new Error(`Forecast failed with status ${forecastResponse.status}`);
                    }

                    const forecastData = await forecastResponse.json();
                    const morningForecast = getMorningForecast(forecastData?.hourly);

                    if (!morningForecast) {
                        showToastError('Forecast data is not available for that ZIP code right now. Try again or enter the forecast manually.');
                        return;
                    }

                    historicalBaseline = await fetchHistoricalBaseline(latitude, longitude, morningForecast.dateKey).catch((error) => {
                        console.error('Snow day historical baseline failed.', error);
                        return null;
                    });

                    applyAutofill(morningForecast);
                } catch (error) {
                    if (error?.name !== 'AbortError') {
                        console.error('Snow day weather autofill failed.', error);
                        showToastError('We could not fetch weather data right now. Please try again or enter the forecast manually.');
                    }
                } finally {
                    if (autofillAbortController === controller) {
                        autofillAbortController = null;
                        setWeatherAutofillLoading(false);
                    }
                }
            };

            const handleWeatherFetch = () => {
                const zip = normalizeZip(locationQuery?.value);
                locationQuery.value = zip;
                const validationMessage = getZipValidationMessage(zip);

                if (validationMessage) {
                    if (autofillAbortController) {
                        autofillAbortController.abort();
                        autofillAbortController = null;
                    }
                    setWeatherAutofillLoading(false);
                    clearFetchedLocation();
                    resetResults();
                    hideFormError();
                    showToastError(validationMessage);
                    return;
                }

                hideFormError();
                hideToastError();
                fetchWeatherAutofill(zip);
            };

            const calculate = () => {
                const missingSelects = [];

                if (!schoolType.value) {
                    missingSelects.push('school type');
                }

                if (!districtStrictness.value) {
                    missingSelects.push('district strictness');
                }

                if (!stormTiming.value) {
                    missingSelects.push('storm timing');
                }

                if (missingSelects.length) {
                    showFormError(`Please choose ${joinLabels(missingSelects)}.`);
                    return;
                }

                const missingNumbers = [];

                if (!tempF.value.trim()) {
                    missingNumbers.push('morning temperature');
                }

                if (!snowIn.value.trim()) {
                    missingNumbers.push('forecast snow');
                }

                if (!iceIn.value.trim()) {
                    missingNumbers.push('forecast ice');
                }

                if (!windMph.value.trim()) {
                    missingNumbers.push('wind speed');
                }

                if (missingNumbers.length) {
                    if (isAutofillLoading && locationQuery.value.trim()) {
                        showFormError('Weather data is still loading. Please wait a moment or enter the forecast manually.');
                        return;
                    }

                    showFormError(`Please enter ${joinLabels(missingNumbers)}.`);
                    return;
                }

                const snow = parseFloat(snowIn.value);
                const ice = parseFloat(iceIn.value);
                const temp = parseFloat(tempF.value);
                const wind = parseFloat(windMph.value);

                if (![snow, ice, temp, wind].every(Number.isFinite)) {
                    showFormError('Please enter valid numbers for snow, ice, temperature, and wind.');
                    return;
                }

                hideFormError();

                const historicalWeatherScores = getHistoricalAdjustedWeatherScores(snow, temp, wind);
                const normalizedSnow = historicalWeatherScores?.snow ?? Math.round(clamp((snow / 8) * 100, 0, 100));
                const normalizedIce = Math.round(clamp((ice / 0.25) * 100, 0, 100));
                const normalizedTiming = timingScores[stormTiming.value] ?? 0;
                const normalizedTemp = historicalWeatherScores?.temp ?? getTempScore(temp);
                const normalizedWind = historicalWeatherScores?.wind ?? Math.round(clamp((wind / 35) * 100, 0, 100));

                const schoolScore = schoolTypeScores[schoolType.value] ?? 0;
                const strictnessScore = strictnessScores[districtStrictness.value] ?? 0;
                const normalizedPolicy = Math.round((schoolScore * 0.6) + (strictnessScore * 0.4));

                const probability = Math.round(
                    (normalizedSnow * 0.30) +
                    (normalizedIce * 0.25) +
                    (normalizedTiming * 0.15) +
                    (normalizedTemp * 0.10) +
                    (normalizedWind * 0.10) +
                    (normalizedPolicy * 0.10)
                );

                percentEl.textContent = `${clamp(probability, 0, 100)}%`;
                summaryEl.textContent = getSummary(probability);
                summaryMeaningEl.textContent = getSummaryMeaning(probability);
                hintEl.textContent = historicalWeatherScores
                    ? `This estimate compares the forecast against ${historicalBaseline.sampleCount} nearby winter days from the last five years, then adds estimated ice, timing, and school policy heuristics.`
                    : 'This estimate uses generic fallback thresholds and editable heuristic inputs because no local winter baseline is loaded.';

                scoreSnow.textContent = `${normalizedSnow}`;
                scoreIce.textContent = `${normalizedIce}`;
                scoreTiming.textContent = `${normalizedTiming}`;
                scoreTemp.textContent = `${normalizedTemp}`;
                scoreWind.textContent = `${normalizedWind}`;
                scorePolicy.textContent = `${normalizedPolicy}`;
            };

            resetResults();

            form.addEventListener('submit', (event) => {
                event.preventDefault();
                calculate();
            });

            fetchWeatherButton.addEventListener('click', handleWeatherFetch);

            locationQuery.addEventListener('input', () => {
                locationQuery.value = normalizeZip(locationQuery.value);
                hideToastError();
                clearFetchedLocation();
                resetResults();
            });

            locationQuery.addEventListener('keydown', (event) => {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    handleWeatherFetch();
                }
            });

            [schoolType, districtStrictness, stormTiming, tempF, snowIn, iceIn, windMph].forEach((element) => {
                element.addEventListener('input', () => {
                    hideFormError();
                    resetResults();
                });
                element.addEventListener('change', () => {
                    hideFormError();
                    resetResults();
                });
            });
        });
    </script>
@endpush
