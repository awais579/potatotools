@extends('layouts.app')

@section('title', 'Snow Day Calculator - Weighted school closure estimate')
@section('description', 'Estimate snow day probability using a weighted score model based on forecast snow, ice, timing, temperature, wind, school type, and district strictness.')
@section('canonical', route('tools.snow-day-calculator'))

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
            <h1 class="text-3xl font-semibold text-stone-900 sm:text-5xl">Snow Day Calculator</h1>
            <p class="mt-4 max-w-2xl text-sm leading-relaxed text-stone-600 sm:text-base">
                Estimate school closure chance with a weighted score model based on snow, ice, timing, temperature, wind, and school policy inputs.
            </p>

            <div class="mt-5 flex flex-wrap gap-2">
                <span class="pt-chip pt-chip-static"><i class="fa-solid fa-scale-balanced text-accent" aria-hidden="true"></i> Weighted score model</span>
                <span class="pt-chip pt-chip-static"><i class="fa-solid fa-school text-accent" aria-hidden="true"></i> School closure estimate</span>
                <span class="pt-chip pt-chip-static"><i class="fa-solid fa-cloud-snow text-accent" aria-hidden="true"></i> Snow + ice + wind</span>
                <span class="pt-chip pt-chip-static"><i class="fa-solid fa-circle-info text-accent" aria-hidden="true"></i> Estimate only</span>
            </div>
        </div>

        <div class="mt-6 grid gap-5 md:grid-cols-[minmax(0,1.05fr)_minmax(320px,0.95fr)] xl:gap-6">
            <section class="pt-card pt-card-elevated p-5 sm:p-6 lg:p-7">
                <div class="rounded-3xl border border-stone-200/70 bg-white px-4 py-4 sm:px-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-stone-500">Forecast Inputs</p>
                    <h2 class="mt-2 text-2xl font-semibold text-stone-900">Enter the winter conditions</h2>
                </div>

                <form id="snow-form" class="mt-6 space-y-6" novalidate>
                    <div class="grid gap-6 md:grid-cols-2">
                        <div class="pt-field">
                            <label for="school-type" class="pt-label">School Type</label>
                            <select id="school-type" class="pt-input pt-input-tall" required>
                                <option value="" selected disabled>Choose school type</option>
                                <option value="elementary">Elementary School</option>
                                <option value="middle">Middle School</option>
                                <option value="high">High School</option>
                                <option value="district">Public District</option>
                                <option value="college">College / University</option>
                            </select>
                        </div>

                        <div class="pt-field">
                            <label for="district-strictness" class="pt-label">District Strictness</label>
                            <select id="district-strictness" class="pt-input pt-input-tall" required>
                                <option value="" selected disabled>Choose strictness</option>
                                <option value="lenient">Lenient</option>
                                <option value="normal">Normal</option>
                                <option value="strict">Strict</option>
                            </select>
                        </div>

                        <div class="pt-field">
                            <label for="storm-timing" class="pt-label">Storm Timing</label>
                            <select id="storm-timing" class="pt-input pt-input-tall" required>
                                <option value="" selected disabled>Choose timing</option>
                                <option value="overnight">Overnight before school</option>
                                <option value="commute">Morning commute hours</option>
                                <option value="school-hours">During school hours</option>
                                <option value="after-school">After school</option>
                            </select>
                        </div>

                        <div class="pt-field">
                            <label for="temp-f" class="pt-label">Morning Temperature (F)</label>
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
                            <label for="snow-in" class="pt-label">Forecast Snow (inches)</label>
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
                            <label for="ice-in" class="pt-label">Forecast Ice (inches)</label>
                            <input
                                id="ice-in"
                                type="number"
                                min="0"
                                max="1"
                                step="0.01"
                                inputmode="decimal"
                                class="pt-input pt-input-tall"
                                placeholder="Enter ice amount"
                                required>
                        </div>

                        <div class="pt-field md:col-span-2">
                            <label for="wind-mph" class="pt-label">Wind Speed (mph)</label>
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
                    </div>

                    <p id="snow-error" class="hidden rounded-xl border border-red-200 bg-red-50 px-3 py-2 text-xs font-semibold text-red-700"></p>

                    <button type="submit" class="pt-btn-primary w-full py-3.5 text-base">
                        Estimate Snow Day
                        <i class="fa-solid fa-snowflake" aria-hidden="true"></i>
                    </button>
                </form>
            </section>

            <div class="pt-result-stack">
                <section class="pt-card pt-card-elevated p-5 sm:p-6 lg:p-7" aria-live="polite">
                    <p class="text-[11px] font-semibold uppercase tracking-[0.15em] text-accent">Snow Day Estimate</p>
                    <p id="resultHint" class="mt-4 text-sm font-medium text-stone-500">Enter the forecast details, then run the estimate.</p>

                    <div class="mt-5 flex flex-wrap items-end gap-3">
                        <p id="snow-percent" class="text-5xl font-semibold leading-none text-stone-900 sm:text-7xl">--</p>
                        <span class="pb-2 text-2xl font-semibold text-stone-400 sm:text-3xl">chance</span>
                    </div>

                    <p id="snow-summary" class="mt-4 text-base font-medium text-stone-700 sm:text-lg">No estimate yet</p>
                    <p class="mt-3 text-sm leading-relaxed text-stone-500">
                        This tool gives a weighted estimate. It does not issue official school closure decisions.
                    </p>

                    <div class="mt-6 rounded-2xl border border-stone-200/70 bg-potato-beige/45 p-4">
                        <p class="text-[11px] font-semibold uppercase tracking-[0.15em] text-stone-500">Score Breakdown</p>
                        <dl class="mt-4 grid gap-3 sm:grid-cols-2 xl:grid-cols-3">
                            <div class="rounded-2xl border border-stone-200/70 bg-white/85 px-4 py-3">
                                <dt class="text-[11px] font-semibold uppercase tracking-[0.14em] text-stone-500">Snow</dt>
                                <dd id="score-snow" class="mt-2 text-lg font-semibold text-stone-900">--</dd>
                            </div>
                            <div class="rounded-2xl border border-stone-200/70 bg-white/85 px-4 py-3">
                                <dt class="text-[11px] font-semibold uppercase tracking-[0.14em] text-stone-500">Ice</dt>
                                <dd id="score-ice" class="mt-2 text-lg font-semibold text-stone-900">--</dd>
                            </div>
                            <div class="rounded-2xl border border-stone-200/70 bg-white/85 px-4 py-3">
                                <dt class="text-[11px] font-semibold uppercase tracking-[0.14em] text-stone-500">Timing</dt>
                                <dd id="score-timing" class="mt-2 text-lg font-semibold text-stone-900">--</dd>
                            </div>
                            <div class="rounded-2xl border border-stone-200/70 bg-white/85 px-4 py-3">
                                <dt class="text-[11px] font-semibold uppercase tracking-[0.14em] text-stone-500">Temperature</dt>
                                <dd id="score-temp" class="mt-2 text-lg font-semibold text-stone-900">--</dd>
                            </div>
                            <div class="rounded-2xl border border-stone-200/70 bg-white/85 px-4 py-3">
                                <dt class="text-[11px] font-semibold uppercase tracking-[0.14em] text-stone-500">Wind</dt>
                                <dd id="score-wind" class="mt-2 text-lg font-semibold text-stone-900">--</dd>
                            </div>
                            <div class="rounded-2xl border border-stone-200/70 bg-white/85 px-4 py-3">
                                <dt class="text-[11px] font-semibold uppercase tracking-[0.14em] text-stone-500">School Policy</dt>
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
                        <p>Each factor is first normalized to a 0-100 scale. The final result is then rounded to a 0-100 percentage.</p>
                        <p>School Policy combines school type and district strictness. This keeps the model simple, explainable, and honest about what it is doing.</p>
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
                    This page uses a <strong>PotatoTools weighted score model</strong>. It is not an official school district formula and it is not an exact prediction.
                    We built it from public snow-day predictor patterns and from winter travel risk factors that weather agencies commonly highlight, such as snow, ice, wind,
                    temperature, and timing.
                </p>
            </div>

            <div class="mt-6 grid gap-4 md:grid-cols-3">
                <article class="pt-soft-card p-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-stone-500">Who Made This Formula</p>
                    <h3 class="mt-3 text-lg font-semibold text-stone-900">PotatoTools built this model</h3>
                    <p class="mt-2 text-sm leading-relaxed text-stone-600">
                        This page does not copy an official national formula because there is no single nationwide snow-day standard. The weighted score model on this page is our own implementation.
                    </p>
                </article>

                <article class="pt-soft-card p-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-stone-500">Why These Inputs</p>
                    <h3 class="mt-3 text-lg font-semibold text-stone-900">They match public winter risk factors</h3>
                    <p class="mt-2 text-sm leading-relaxed text-stone-600">
                        Public snow-day sites describe factor-based prediction methods, and National Weather Service winter guidance repeatedly highlights snow, ice, wind, and visibility as meaningful travel risks.
                    </p>
                </article>

                <article class="pt-soft-card p-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-stone-500">Where It Is Acceptable</p>
                    <h3 class="mt-3 text-lg font-semibold text-stone-900">Useful as a planning estimate</h3>
                    <p class="mt-2 text-sm leading-relaxed text-stone-600">
                        A weighted estimate is acceptable for planning and comparing weather scenarios. It should not be treated as an official closure notice from a school or district.
                    </p>
                </article>
            </div>

            <div class="mt-6 rounded-2xl border border-stone-200/70 bg-white/85 p-5">
                <p class="text-xs font-semibold uppercase tracking-[0.12em] text-stone-500">Public references used for this model</p>
                <ul class="mt-3 space-y-2 text-sm leading-relaxed text-stone-600">
                    <li>
                        <a href="https://www.snowdaycalculator.com/about.php" target="_blank" rel="noopener noreferrer" class="text-primary hover:underline">
                            Snow Day Calculator About
                        </a>
                        : describes a custom formula and says predictions use timing, strength of storm, wind, temperature, ice forecasts, and school/location history.
                    </li>
                    <li>
                        <a href="https://www.snowdaycalculator.com/manual.php" target="_blank" rel="noopener noreferrer" class="text-primary hover:underline">
                            Snow Day Calculator Manual Version
                        </a>
                        : shows the kinds of manual inputs public users enter into a snow-day model.
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
                    No. This page gives a weighted estimate based on the inputs you enter. Real closure decisions still depend on local school administrators.
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
                    Elementary schools, colleges, and public districts do not all respond the same way to winter weather. Local policy changes the final estimate.
                </p>
            </details>
            <details class="pt-faq pt-accordion">
                <summary class="flex items-center justify-between gap-3">
                    <span>What if I do not know the exact weather forecast?</span>
                    <span class="faq-plus text-xl leading-none text-stone-500">+</span>
                </summary>
                <p class="mt-3 text-sm text-stone-600">
                    Use your best estimate from a weather forecast. This version is a manual-input model, so the quality of the estimate depends on the quality of the forecast data you enter.
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
        (() => {
            const form = document.getElementById('snow-form');
            const schoolType = document.getElementById('school-type');
            const districtStrictness = document.getElementById('district-strictness');
            const stormTiming = document.getElementById('storm-timing');
            const tempF = document.getElementById('temp-f');
            const snowIn = document.getElementById('snow-in');
            const iceIn = document.getElementById('ice-in');
            const windMph = document.getElementById('wind-mph');
            const errorBox = document.getElementById('snow-error');

            const percentEl = document.getElementById('snow-percent');
            const summaryEl = document.getElementById('snow-summary');
            const hintEl = document.getElementById('resultHint');
            const scoreSnow = document.getElementById('score-snow');
            const scoreIce = document.getElementById('score-ice');
            const scoreTiming = document.getElementById('score-timing');
            const scoreTemp = document.getElementById('score-temp');
            const scoreWind = document.getElementById('score-wind');
            const scorePolicy = document.getElementById('score-policy');

            const clamp = (value, min, max) => Math.min(max, Math.max(min, value));

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

            const resetResults = () => {
                percentEl.textContent = '--';
                summaryEl.textContent = 'No estimate yet';
                hintEl.textContent = 'Enter the forecast details, then run the estimate.';
                scoreSnow.textContent = '--';
                scoreIce.textContent = '--';
                scoreTiming.textContent = '--';
                scoreTemp.textContent = '--';
                scoreWind.textContent = '--';
                scorePolicy.textContent = '--';
            };

            const showError = (message) => {
                errorBox.textContent = message;
                errorBox.classList.remove('hidden');
            };

            const hideError = () => {
                errorBox.textContent = '';
                errorBox.classList.add('hidden');
            };

            const getTempScore = (temp) => {
                if (temp <= 10) return 100;
                if (temp <= 20) return 85;
                if (temp <= 32) return 65;
                if (temp <= 36) return 35;
                return 10;
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

            const calculate = () => {
                if (!schoolType.value || !districtStrictness.value || !stormTiming.value) {
                    showError('Please choose school type, district strictness, and storm timing.');
                    return;
                }

                const snow = parseFloat(snowIn.value);
                const ice = parseFloat(iceIn.value);
                const temp = parseFloat(tempF.value);
                const wind = parseFloat(windMph.value);

                if (![snow, ice, temp, wind].every(Number.isFinite)) {
                    showError('Please enter valid numbers for snow, ice, temperature, and wind.');
                    return;
                }

                hideError();

                const normalizedSnow = Math.round(clamp((snow / 8) * 100, 0, 100));
                const normalizedIce = Math.round(clamp((ice / 0.25) * 100, 0, 100));
                const normalizedTiming = timingScores[stormTiming.value] ?? 0;
                const normalizedTemp = getTempScore(temp);
                const normalizedWind = Math.round(clamp((wind / 35) * 100, 0, 100));

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
                hintEl.textContent = 'This estimate is based on the weighted contribution of each forecast factor below.';

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

            [schoolType, districtStrictness, stormTiming, tempF, snowIn, iceIn, windMph].forEach((element) => {
                element.addEventListener('input', () => {
                    hideError();
                    resetResults();
                });
                element.addEventListener('change', () => {
                    hideError();
                    resetResults();
                });
            });
        })();
    </script>
@endpush
