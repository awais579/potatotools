@extends('layouts.app')

@section('title', 'Age Calculator - Exact years, months and days')
@section('description', 'Calculate exact age in years, months, and days. See total days lived and time until your next birthday instantly.')
@section('canonical', route('tools.age-calculator'))

@section('content')
    <section id="age-tool-page" class="pt-container pt-8 pb-10 sm:pt-10 sm:pb-12 lg:pt-12 lg:pb-14">
        <nav aria-label="Breadcrumb" class="text-xs text-stone-500">
            <ol class="flex flex-wrap items-center gap-2">
                <li><a href="{{ route('home') }}" class="hover:text-primary">Home</a></li>
                <li aria-hidden="true">&gt;</li>
                <li><a href="{{ route('home') }}#pick-potato" class="hover:text-primary">Tools</a></li>
                <li aria-hidden="true">&gt;</li>
                <li aria-current="page" class="font-semibold text-primary">Age Calculator</li>
            </ol>
        </nav>

        <div class="mt-5">
            <div class="pt-page-title-row">
                <span class="pt-page-title-icon" aria-hidden="true">
                    <i class="fa-solid fa-calendar-days"></i>
                </span>
                <h1 class="text-3xl font-semibold text-stone-900 sm:text-5xl">Age Calculator</h1>
            </div>
            <p class="mt-4 max-w-2xl text-sm leading-relaxed text-stone-600 sm:text-base">
                Calculate exact age in years, months, and days with a simple date-based calculator.
            </p>

            <div class="mt-5 flex flex-wrap gap-2">
                <span class="pt-chip pt-chip-static"><i class="fa-solid fa-calendar-check text-accent" aria-hidden="true"></i> Exact calendar math</span>
                <span class="pt-chip pt-chip-static"><i class="fa-solid fa-hourglass-half text-accent" aria-hidden="true"></i> Years, months, days</span>
                <span class="pt-chip pt-chip-static"><i class="fa-solid fa-arrows-rotate text-accent" aria-hidden="true"></i> Today or custom date</span>
                <span class="pt-chip pt-chip-static"><i class="fa-solid fa-shield-halved text-accent" aria-hidden="true"></i> Free to use</span>
            </div>
        </div>

        <div class="mt-6 grid gap-5 md:grid-cols-[minmax(0,1.05fr)_minmax(320px,0.95fr)] xl:gap-6">
            <section class="pt-card pt-card-elevated p-5 sm:p-6 lg:p-7">
                <div class="rounded-3xl border border-stone-200/70 bg-white px-4 py-4 sm:px-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-stone-500">Enter Dates</p>
                    <h2 class="mt-2 text-2xl font-semibold text-stone-900">Add your date of birth</h2>
                </div>

                <form id="age-form" class="mt-6 space-y-6" novalidate>
                    <div class="grid gap-6">
                        <div class="pt-field">
                            <label for="birth-date" class="pt-label">Date of Birth<span class="pt-required-mark" aria-hidden="true">*</span></label>
                            <div class="pt-date-field">
                                <input
                                    id="birth-date"
                                    type="text"
                                    class="pt-date-input pt-input pt-input-tall"
                                    placeholder="dd/mm/yyyy"
                                    data-pt-datepicker
                                    required>
                                <button type="button" class="pt-date-trigger" data-pt-datepicker-open="birth-date" aria-label="Open date of birth calendar">
                                    <i class="fa-regular fa-calendar" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>

                        <div class="pt-field">
                            <label for="as-of-date" class="pt-label">Calculate Age On</label>
                            <div class="pt-date-field">
                                <input
                                    id="as-of-date"
                                    type="text"
                                    class="pt-date-input pt-input pt-input-tall"
                                    placeholder="dd/mm/yyyy"
                                    data-pt-datepicker
                                    data-pt-datepicker-default="today">
                                <button type="button" class="pt-date-trigger" data-pt-datepicker-open="as-of-date" aria-label="Open calculation date calendar">
                                    <i class="fa-regular fa-calendar" aria-hidden="true"></i>
                                </button>
                            </div>
                            <p class="text-xs text-stone-500">Leave this date as today or choose any other day.</p>
                        </div>
                    </div>

                    <p id="age-error" class="hidden rounded-xl border border-red-200 bg-red-50 px-3 py-2 text-xs font-semibold text-red-700"></p>

                    <button type="submit" class="pt-btn-primary w-full py-3.5 text-base">
                        Calculate Age
                        <i class="fa-solid fa-calendar-days" aria-hidden="true"></i>
                    </button>
                </form>
            </section>

            <div class="pt-result-stack">
                <section class="pt-card pt-card-elevated p-5 sm:p-6 lg:p-7" aria-live="polite">
                    <p class="text-[11px] font-semibold uppercase tracking-[0.15em] text-accent">Calculated Age</p>
                    <p class="mt-4 text-sm font-medium text-stone-500">Your age appears here after you enter the dates.</p>

                    <div class="mt-6 grid gap-3 sm:grid-cols-3">
                        <article class="rounded-2xl border border-stone-200/70 bg-potato-beige/45 px-4 py-5 text-center">
                            <p id="age-years" class="text-4xl font-semibold leading-none text-stone-900 sm:text-5xl">--</p>
                            <p class="mt-3 text-[11px] font-semibold uppercase tracking-[0.15em] text-stone-500">Years</p>
                        </article>
                        <article class="rounded-2xl border border-stone-200/70 bg-potato-beige/45 px-4 py-5 text-center">
                            <p id="age-months" class="text-4xl font-semibold leading-none text-stone-900 sm:text-5xl">--</p>
                            <p class="mt-3 text-[11px] font-semibold uppercase tracking-[0.15em] text-stone-500">Months</p>
                        </article>
                        <article class="rounded-2xl border border-stone-200/70 bg-potato-beige/45 px-4 py-5 text-center">
                            <p id="age-days" class="text-4xl font-semibold leading-none text-stone-900 sm:text-5xl">--</p>
                            <p class="mt-3 text-[11px] font-semibold uppercase tracking-[0.15em] text-stone-500">Days</p>
                        </article>
                    </div>

                    <div class="mt-6 grid gap-3 sm:grid-cols-2">
                        <article class="rounded-2xl border border-stone-200/70 bg-white/90 px-4 py-4">
                            <p class="inline-flex items-center gap-2 text-[11px] font-semibold uppercase tracking-[0.15em] text-stone-500">
                                <span>Total Days Lived</span>
                                <i class="fa-regular fa-clock text-stone-400" aria-hidden="true"></i>
                            </p>
                            <p id="total-days-lived" class="mt-2 text-2xl font-semibold text-stone-900">--</p>
                        </article>
                        <article class="rounded-2xl border border-stone-200/70 bg-white/90 px-4 py-4">
                            <p class="inline-flex items-center gap-2 text-[11px] font-semibold uppercase tracking-[0.15em] text-stone-500">
                                <span>Next Birthday</span>
                                <i class="fa-solid fa-cake-candles text-stone-400" aria-hidden="true"></i>
                            </p>
                            <p id="next-birthday" class="mt-2 text-2xl font-semibold text-stone-900">--</p>
                        </article>
                    </div>
                </section>

                <details class="pt-card pt-card-elevated px-4 py-3 sm:px-5 sm:py-4">
                    <summary class="flex cursor-pointer items-center justify-between gap-3 text-sm font-semibold text-stone-800">
                        <span>How age is calculated</span>
                        <i class="fa-solid fa-chevron-down text-xs text-stone-400" aria-hidden="true"></i>
                    </summary>
                    <div class="mt-3 space-y-2 text-xs leading-relaxed text-stone-600 sm:text-sm">
                        <p>The calculator compares your date of birth with the selected date.</p>
                        <p>It uses real month lengths, leap years, and the actual calendar difference between both dates.</p>
                        <p>If you do not choose a second date, the calculation uses today.</p>
                    </div>
                </details>
            </div>
        </div>
    </section>

    <section class="pt-container pt-16 pb-6 sm:pt-20">
        <div class="pt-soft-section bg-[#efe5d8] px-5 py-8 sm:px-8 sm:py-10">
            <div class="max-w-4xl">
                <p class="text-xs font-semibold uppercase tracking-[0.08em] text-stone-500">Age Report</p>
                <h2 class="mt-2 text-3xl font-semibold text-stone-900 sm:text-4xl">How this age calculator works</h2>
                <p class="mt-3 text-sm leading-relaxed text-stone-700 sm:text-base">
                    This page measures the exact time between your date of birth and a selected date. It does not estimate health,
                    maturity, or biological age. It only calculates date-based age.
                </p>
            </div>

            <div class="mt-6 grid gap-4 md:grid-cols-3">
                <article class="pt-soft-card p-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-stone-500">What It Shows</p>
                    <h3 class="mt-3 text-lg font-semibold text-stone-900">Exact age breakdown</h3>
                    <p class="mt-2 text-sm leading-relaxed text-stone-600">
                        You get age in years, months, and days, plus total days lived and time until the next birthday.
                    </p>
                </article>

                <article class="pt-soft-card p-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-stone-500">Why It Is Reliable</p>
                    <h3 class="mt-3 text-lg font-semibold text-stone-900">Uses real calendar dates</h3>
                    <p class="mt-2 text-sm leading-relaxed text-stone-600">
                        The result comes from actual date math, including leap years and different month lengths.
                    </p>
                </article>

                <article class="pt-soft-card p-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-stone-500">When To Use It</p>
                    <h3 class="mt-3 text-lg font-semibold text-stone-900">Today or any chosen date</h3>
                    <p class="mt-2 text-sm leading-relaxed text-stone-600">
                        You can calculate current age or see the exact age on any past or future date.
                    </p>
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
                    <span>Does this calculator account for leap years?</span>
                    <span class="faq-plus text-xl leading-none text-stone-500">+</span>
                </summary>
                <p class="mt-3 text-sm text-stone-600">
                    Yes. The result uses real calendar dates, so leap years and month lengths are handled automatically.
                </p>
            </details>
            <details class="pt-faq pt-accordion">
                <summary class="flex items-center justify-between gap-3">
                    <span>Can I calculate age on a future date?</span>
                    <span class="faq-plus text-xl leading-none text-stone-500">+</span>
                </summary>
                <p class="mt-3 text-sm text-stone-600">
                    Yes. Choose any future date in the second field to see the exact age on that day.
                </p>
            </details>
            <details class="pt-faq pt-accordion">
                <summary class="flex items-center justify-between gap-3">
                    <span>What is chronological age?</span>
                    <span class="faq-plus text-xl leading-none text-stone-500">+</span>
                </summary>
                <p class="mt-3 text-sm text-stone-600">
                    Chronological age is the time that has passed since birth. It is a date-based measurement, not a health score.
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
            <a href="{{ route('tools.height-converter') }}" class="pt-soft-card pt-tool-card block p-5">
                <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-primary/10 text-primary">
                    <i class="fa-solid fa-ruler-vertical" aria-hidden="true"></i>
                </span>
                <h3 class="text-xl font-semibold text-stone-900">Height Converter</h3>
                <p class="mt-2 text-sm text-stone-600">Convert between centimeters, meters, feet, and inches.</p>
                <span class="pt-link-arrow mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-primary">
                    Open Tool
                    <span class="pt-link-arrow-icon" aria-hidden="true">&rarr;</span>
                </span>
            </a>

            <a href="{{ route('tools.snow-day-calculator') }}" class="pt-soft-card pt-tool-card block p-5">
                <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-primary/10 text-primary">
                    <i class="fa-solid fa-snowflake" aria-hidden="true"></i>
                </span>
                <h3 class="text-xl font-semibold text-stone-900">Snow Day Calculator</h3>
                <p class="mt-2 text-sm text-stone-600">Check school closure chances from weather conditions.</p>
                <span class="pt-link-arrow mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-primary">
                    Open Tool
                    <span class="pt-link-arrow-icon" aria-hidden="true">&rarr;</span>
                </span>
            </a>

            <article class="pt-soft-card p-5">
                <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-primary/10 text-primary">
                    <i class="fa-solid fa-weight-scale" aria-hidden="true"></i>
                </span>
                <h3 class="text-xl font-semibold text-stone-900">BMI Calculator</h3>
                <p class="mt-2 text-sm text-stone-600">Calculate body mass index with a simple weight and height input.</p>
                <button type="button" class="pt-btn-secondary mt-4" disabled>Coming soon</button>
            </article>

            <article class="pt-soft-card p-5">
                <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-primary/10 text-primary">
                    <i class="fa-solid fa-ruler-combined" aria-hidden="true"></i>
                </span>
                <h3 class="text-xl font-semibold text-stone-900">Unit Converter</h3>
                <p class="mt-2 text-sm text-stone-600">Convert common everyday units with a clear and simple calculator.</p>
                <button type="button" class="pt-btn-secondary mt-4" disabled>Coming soon</button>
            </article>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        (() => {
            const dayMs = 24 * 60 * 60 * 1000;
            const form = document.getElementById('age-form');
            const birthDateInput = document.getElementById('birth-date');
            const asOfDateInput = document.getElementById('as-of-date');
            const ageError = document.getElementById('age-error');

            const ageYears = document.getElementById('age-years');
            const ageMonths = document.getElementById('age-months');
            const ageDays = document.getElementById('age-days');
            const totalDaysLived = document.getElementById('total-days-lived');
            const nextBirthday = document.getElementById('next-birthday');

            const numberFormatter = new Intl.NumberFormat('en-US');

            const resetResults = () => {
                ageYears.textContent = '--';
                ageMonths.textContent = '--';
                ageDays.textContent = '--';
                totalDaysLived.textContent = '--';
                nextBirthday.textContent = '--';
            };

            const getYmd = (date) => ({
                year: date.getFullYear(),
                month: date.getMonth(),
                day: date.getDate(),
            });

            const toUtcMs = (date) => {
                const { year, month, day } = getYmd(date);
                return Date.UTC(year, month, day);
            };

            const parseDate = (value) => {
                if (!value) {
                    return null;
                }

                const normalizedValue = value.includes('/') ? value.split('/').reverse().join('-') : value;
                const parts = normalizedValue.split('-').map(Number);
                if (parts.length !== 3 || parts.some((part) => !Number.isFinite(part))) {
                    return null;
                }
                const [year, month, day] = parts;
                const parsed = new Date(year, month - 1, day);
                if (
                    parsed.getFullYear() !== year ||
                    parsed.getMonth() !== month - 1 ||
                    parsed.getDate() !== day
                ) {
                    return null;
                }
                return parsed;
            };

            const formatDateInput = (date) => {
                const day = String(date.getDate()).padStart(2, '0');
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const year = date.getFullYear();
                return `${day}/${month}/${year}`;
            };

            const getSafeBirthday = (birthDate, year) => {
                const month = birthDate.getMonth();
                const day = birthDate.getDate();
                const birthday = new Date(year, month, day);

                if (birthday.getMonth() !== month) {
                    return new Date(year, month + 1, 0);
                }

                return birthday;
            };

            const getAgeBreakdown = (birthDate, targetDate) => {
                if (toUtcMs(targetDate) < toUtcMs(birthDate)) {
                    return null;
                }

                let years = targetDate.getFullYear() - birthDate.getFullYear();
                let months = targetDate.getMonth() - birthDate.getMonth();
                let days = targetDate.getDate() - birthDate.getDate();

                if (days < 0) {
                    const prevMonthDays = new Date(
                        targetDate.getFullYear(),
                        targetDate.getMonth(),
                        0
                    ).getDate();
                    days += prevMonthDays;
                    months -= 1;
                }

                if (months < 0) {
                    months += 12;
                    years -= 1;
                }

                return { years, months, days };
            };

            const showError = (message) => {
                ageError.textContent = message;
                ageError.classList.remove('hidden');
            };

            const hideError = () => {
                ageError.textContent = '';
                ageError.classList.add('hidden');
            };

            const calculate = () => {
                const birthDate = parseDate(birthDateInput.value);
                const asOfDate = parseDate(asOfDateInput.value) || new Date();

                if (!birthDate) {
                    showError('Please enter a valid date of birth.');
                    return;
                }

                const age = getAgeBreakdown(birthDate, asOfDate);
                if (!age) {
                    showError('Calculate date must be on or after date of birth.');
                    return;
                }
                hideError();

                ageYears.textContent = String(age.years);
                ageMonths.textContent = String(age.months);
                ageDays.textContent = String(age.days);

                const totalDays = Math.floor((toUtcMs(asOfDate) - toUtcMs(birthDate)) / dayMs);
                totalDaysLived.textContent = numberFormatter.format(totalDays);

                let upcomingBirthday = getSafeBirthday(birthDate, asOfDate.getFullYear());
                if (toUtcMs(upcomingBirthday) < toUtcMs(asOfDate)) {
                    upcomingBirthday = getSafeBirthday(birthDate, asOfDate.getFullYear() + 1);
                }

                const birthdayCountdown = Math.floor((toUtcMs(upcomingBirthday) - toUtcMs(asOfDate)) / dayMs);
                nextBirthday.textContent = birthdayCountdown === 0
                    ? 'Today'
                    : `${numberFormatter.format(birthdayCountdown)} Days`;
            };

            if (!asOfDateInput.value) {
                const today = new Date();

                if (asOfDateInput._flatpickr) {
                    asOfDateInput._flatpickr.setDate(today, true, 'd/m/Y');
                } else {
                    asOfDateInput.value = formatDateInput(today);
                }
            }

            resetResults();

            form.addEventListener('submit', (event) => {
                event.preventDefault();
                calculate();
            });

            const handleInputChange = () => {
                hideError();
                resetResults();
            };

            birthDateInput.addEventListener('input', handleInputChange);
            birthDateInput.addEventListener('change', handleInputChange);
            asOfDateInput.addEventListener('input', handleInputChange);
            asOfDateInput.addEventListener('change', handleInputChange);
        })();
    </script>
@endpush
