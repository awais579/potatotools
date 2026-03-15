@extends('layouts.app')

@section('title', 'Snow Day Calculator - Predict school closure chances')
@section('description', 'Estimate snow day probability using snowfall, temperature, wind, and school type inputs. Fast and simple prediction for planning ahead.')
@section('canonical', route('tools.snow-day-calculator'))

@section('content')
    @php
        $homePageData = $homePageData ?? [];
    @endphp

    <section class="pt-container py-10 sm:py-12">
        <nav aria-label="Breadcrumb" class="text-xs text-stone-500">
            <ol class="flex flex-wrap items-center gap-2">
                <li><a href="{{ route('home') }}" class="hover:text-primary">Home</a></li>
                <li aria-hidden="true">&gt;</li>
                <li><a href="{{ route('home') }}#pick-potato" class="hover:text-primary">Tools</a></li>
                <li aria-hidden="true">&gt;</li>
                <li class="font-semibold text-stone-700">Snow Day Calculator</li>
            </ol>
        </nav>

        <h1 class="mt-4 text-3xl font-semibold text-stone-900 sm:text-4xl">
            Snow Day Calculator
            <i class="fa-solid fa-snowflake text-primary" aria-hidden="true"></i>
        </h1>
        <p class="mt-2 max-w-3xl text-sm text-stone-600">
            Predict the probability of school closure due to snow with our potato-powered model.
        </p>

        <div class="mt-8 grid gap-5 md:grid-cols-2">
            <form id="snow-form" class="pt-card pt-card-elevated p-5 sm:p-6">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-gear text-primary" aria-hidden="true"></i>
                    <h2 class="text-2xl font-semibold text-stone-900">Enter Conditions</h2>
                </div>

                <div class="mt-5 space-y-4">
                    <div class="pt-field">
                        <label for="city" class="pt-label">City / Location</label>
                        <input id="city" type="text" class="pt-input" placeholder="e.g. Minneapolis, MN">
                    </div>

                    <div class="pt-field">
                        <label for="school-type" class="pt-label">School Type</label>
                        <select id="school-type" class="pt-input">
                            <option value="elementary" selected>Elementary School</option>
                            <option value="middle">Middle School</option>
                            <option value="high">High School</option>
                            <option value="district">Public District (General)</option>
                            <option value="college">College / University</option>
                        </select>
                    </div>

                    <div class="grid gap-3 sm:grid-cols-3">
                        <div class="pt-field">
                            <label for="snow-in" class="pt-label">Snow (in)</label>
                            <input id="snow-in" type="number" min="0" max="60" step="0.1" value="0" class="pt-input">
                        </div>
                        <div class="pt-field">
                            <label for="temp-f" class="pt-label">Temp (F)</label>
                            <input id="temp-f" type="number" min="-40" max="60" step="0.1" value="32" class="pt-input">
                        </div>
                        <div class="pt-field">
                            <label for="wind-mph" class="pt-label">Wind (mph)</label>
                            <input id="wind-mph" type="number" min="0" max="80" step="0.1" value="10" class="pt-input">
                        </div>
                    </div>
                </div>

                <p id="snow-error" class="mt-4 hidden rounded-xl border border-red-200 bg-red-50 px-3 py-2 text-xs font-semibold text-red-700"></p>

                <button type="submit" class="pt-btn-primary mt-6 w-full py-3 text-base">Predict Snow Day</button>
            </form>

            <section class="pt-card pt-card-elevated flex flex-col items-center p-5 text-center sm:p-6">
                <h2 class="text-2xl font-semibold text-stone-900">Snow Day Probability</h2>

                <div id="snow-gauge" class="snow-gauge mt-6" style="--value: 0;">
                    <div class="snow-gauge-inner">
                        <p id="snow-percent" class="text-6xl font-semibold leading-none text-stone-900">0%</p>
                    </div>
                </div>

                <p id="snow-status" class="mt-5 inline-flex items-center gap-2 rounded-full bg-emerald-100 px-4 py-2 text-sm font-semibold text-emerald-700">
                    <i class="fa-solid fa-circle-check text-xs" aria-hidden="true"></i>
                    Low chance of school closure
                </p>

                <img
                    src="{{ asset('images/potato.png') }}"
                    alt="Snow day mascot"
                    class="mt-6 h-24 w-24 object-contain"
                    loading="lazy"
                    decoding="async">
            </section>
        </div>
    </section>

    <section class="pt-container py-4">
        <h2 class="text-center text-3xl font-semibold text-stone-900">How it Works</h2>
        <div class="mt-5 grid gap-4 md:grid-cols-3">
            <article class="rounded-3xl border border-stone-200/70 bg-[#efe4d7] p-5">
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-white text-primary">
                    <i class="fa-solid fa-snowflake" aria-hidden="true"></i>
                </span>
                <h3 class="mt-4 text-xl font-semibold text-stone-900">Snow Accumulation</h3>
                <p class="mt-2 text-sm text-stone-600">
                    Higher expected snow generally increases closure probability for most schools and districts.
                </p>
            </article>
            <article class="rounded-3xl border border-stone-200/70 bg-[#efe4d7] p-5">
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-white text-primary">
                    <i class="fa-solid fa-temperature-low" aria-hidden="true"></i>
                </span>
                <h3 class="mt-4 text-xl font-semibold text-stone-900">Temperature & Ice</h3>
                <p class="mt-2 text-sm text-stone-600">
                    Colder conditions increase icing risk, making roads and sidewalks less safe for travel.
                </p>
            </article>
            <article class="rounded-3xl border border-stone-200/70 bg-[#efe4d7] p-5">
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-white text-primary">
                    <i class="fa-solid fa-wind" aria-hidden="true"></i>
                </span>
                <h3 class="mt-4 text-xl font-semibold text-stone-900">Wind & Visibility</h3>
                <p class="mt-2 text-sm text-stone-600">
                    Strong winds can reduce visibility and cause drifting, which can push decisions toward closure.
                </p>
            </article>
        </div>
    </section>

    <section class="pt-container py-8">
        <div class="flex items-center justify-between gap-4">
            <h2 class="text-3xl font-semibold text-stone-900">Related Potato Tools</h2>
            <a href="{{ route('home') }}#pick-potato" class="pt-link-arrow inline-flex items-center gap-1.5 text-sm font-semibold text-primary hover:text-primary/80">
                View all tools
                <span class="pt-link-arrow-icon" aria-hidden="true">&rarr;</span>
            </a>
        </div>

        <div class="mt-5 grid gap-4 md:grid-cols-2">
            <article class="pt-soft-card pt-tool-card p-5">
                <div class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-primary/10 text-primary">
                    <i class="fa-solid fa-calendar-days" aria-hidden="true"></i>
                </div>
                <h3 class="mt-3 text-xl font-semibold text-stone-900">Chronological Age Calculator</h3>
                <p class="mt-2 text-sm text-stone-600">Calculate exact age in years, months, and days in one click.</p>
                <a href="{{ route('tools.age-calculator') }}" class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-primary">
                    Open Tool
                    <span aria-hidden="true">&rarr;</span>
                </a>
            </article>

            <article class="pt-soft-card pt-tool-card p-5">
                <div class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-amber-100 text-amber-700">
                    <i class="fa-solid fa-paw" aria-hidden="true"></i>
                </div>
                <h3 class="mt-3 text-xl font-semibold text-stone-900">Random Animal Generator</h3>
                <p class="mt-2 text-sm text-stone-600">Discover a random animal in one click for fun and learning.</p>
                <button type="button" class="pt-btn-secondary mt-4" disabled>Coming soon</button>
            </article>
        </div>
    </section>

    @include('components.faqs.accordion', [
        'section' => $homePageData['faqs']['snow_day_calculator'] ?? [],
        'sectionClass' => 'pt-container pb-8',
        'titleClass' => 'text-3xl font-semibold text-stone-900',
        'itemsWrapperClass' => 'mt-5 space-y-3',
    ])
@endsection

@push('head')
    <style>
        .snow-gauge {
            --value: 0;
            position: relative;
            display: inline-grid;
            place-items: center;
            width: 210px;
            height: 210px;
            border-radius: 50%;
            background: conic-gradient(#c6862d calc(var(--value) * 1%), #e5e7eb 0);
        }

        .snow-gauge::before {
            content: "";
            position: absolute;
            inset: 12px;
            border-radius: 50%;
            background: #fff;
        }

        .snow-gauge-inner {
            position: relative;
            z-index: 1;
        }

    </style>
@endpush

@push('scripts')
    <script>
        (() => {
            const form = document.getElementById('snow-form');
            const schoolType = document.getElementById('school-type');
            const snowIn = document.getElementById('snow-in');
            const tempF = document.getElementById('temp-f');
            const windMph = document.getElementById('wind-mph');
            const errorBox = document.getElementById('snow-error');

            const gauge = document.getElementById('snow-gauge');
            const percentEl = document.getElementById('snow-percent');
            const statusEl = document.getElementById('snow-status');

            const clamp = (value, min, max) => Math.min(max, Math.max(min, value));

            const schoolWeight = {
                elementary: 8,
                middle: 5,
                high: 2,
                district: 6,
                college: -4,
            };

            const setStatus = (probability) => {
                statusEl.className = 'mt-5 inline-flex items-center gap-2 rounded-full px-4 py-2 text-sm font-semibold';
                if (probability >= 75) {
                    statusEl.classList.add('bg-emerald-100', 'text-emerald-700');
                    statusEl.innerHTML = '<i class="fa-solid fa-circle-check text-xs" aria-hidden="true"></i> High chance of school closure';
                    return;
                }

                if (probability >= 45) {
                    statusEl.classList.add('bg-amber-100', 'text-amber-700');
                    statusEl.innerHTML = '<i class="fa-solid fa-triangle-exclamation text-xs" aria-hidden="true"></i> Moderate chance of school closure';
                    return;
                }

                statusEl.classList.add('bg-stone-200', 'text-stone-700');
                statusEl.innerHTML = '<i class="fa-solid fa-circle-info text-xs" aria-hidden="true"></i> Low chance of school closure';
            };

            const showError = (message) => {
                errorBox.textContent = message;
                errorBox.classList.remove('hidden');
            };

            const hideError = () => {
                errorBox.textContent = '';
                errorBox.classList.add('hidden');
            };

            const calculate = () => {
                const snow = parseFloat(snowIn.value);
                const temp = parseFloat(tempF.value);
                const wind = parseFloat(windMph.value);

                if (!Number.isFinite(snow) || !Number.isFinite(temp) || !Number.isFinite(wind)) {
                    showError('Please enter valid numeric values for snow, temperature, and wind.');
                    return;
                }

                hideError();

                const snowFactor = clamp(snow, 0, 60) * 2.1;
                const tempFactor = clamp(32 - temp, -20, 60) * 1.2;
                const windFactor = clamp(wind, 0, 80) * 0.55;
                const typeFactor = schoolWeight[schoolType.value] ?? 0;

                const raw = 8 + snowFactor + tempFactor + windFactor + typeFactor;
                const probability = Math.round(clamp(raw, 0, 100));

                gauge.style.setProperty('--value', String(probability));
                percentEl.textContent = `${probability}%`;
                setStatus(probability);
            };

            form.addEventListener('submit', (event) => {
                event.preventDefault();
                calculate();
            });

            [schoolType, snowIn, tempF, windMph].forEach((element) => {
                element.addEventListener('input', calculate);
                element.addEventListener('change', calculate);
            });

            calculate();
        })();
    </script>
@endpush
