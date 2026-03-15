@extends('layouts.app')

@section('title', 'Chronological Age Calculator - Exact years, months and days')
@section('description', 'Calculate exact chronological age in years, months, and days. Get total days lived and countdown to next birthday instantly.')
@section('canonical', route('tools.age-calculator'))

@section('content')
    <section class="pt-container py-10 sm:py-12">
        <nav aria-label="Breadcrumb" class="text-xs text-stone-500">
            <ol class="flex flex-wrap items-center gap-2">
                <li><a href="{{ route('home') }}" class="hover:text-primary">Home</a></li>
                <li aria-hidden="true">&gt;</li>
                <li><a href="{{ route('home') }}#pick-potato" class="hover:text-primary">Tools</a></li>
                <li aria-hidden="true">&gt;</li>
                <li class="font-semibold text-stone-700">Chronological Age</li>
            </ol>
        </nav>

        <div class="mt-4 flex items-start gap-3">
            <span class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-primary/15 text-primary">
                <i class="fa-solid fa-calendar-days text-lg" aria-hidden="true"></i>
            </span>
            <div>
                <h1 class="text-3xl font-semibold text-stone-900 sm:text-4xl">Chronological Age Calculator</h1>
                <p class="mt-2 max-w-3xl text-sm text-stone-600">
                    Calculate exact age in years, months and days instantly with potato precision.
                </p>
            </div>
        </div>

        <div class="mt-8 grid gap-5 md:grid-cols-2">
            <form id="age-form" class="pt-card pt-card-elevated p-5 sm:p-6">
                <div class="flex items-center gap-2">
                    <i class="fa-regular fa-pen-to-square text-accent" aria-hidden="true"></i>
                    <h2 class="text-2xl font-semibold text-stone-900">Enter Dates</h2>
                </div>

                <div class="mt-5 space-y-4">
                    <div class="pt-field">
                        <label for="birth-date" class="pt-label">Date of Birth</label>
                        <input
                            id="birth-date"
                            type="date"
                            class="pt-date-input pt-input"
                            required>
                    </div>

                    <div class="pt-field">
                        <label for="as-of-date" class="pt-label">Calculate Age On (Optional)</label>
                        <input
                            id="as-of-date"
                            type="date"
                            class="pt-date-input pt-input">
                        <p class="text-xs text-stone-500">
                            Defaults to today if left blank.
                        </p>
                    </div>
                </div>

                <p id="age-error" class="mt-4 hidden rounded-xl border border-red-200 bg-red-50 px-3 py-2 text-xs font-semibold text-red-700"></p>

                <button type="submit" class="pt-btn-primary mt-6 w-full py-3 text-base">
                    <i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
                    Calculate Age
                </button>
            </form>

            <section class="pt-card pt-card-elevated relative overflow-hidden p-5 sm:p-6">
                <div class="absolute right-5 top-5 inline-flex h-10 w-10 items-center justify-center rounded-full bg-accent/15 text-accent">
                    <i class="fa-solid fa-seedling" aria-hidden="true"></i>
                </div>

                <h2 class="text-2xl font-semibold text-stone-900">Your Age</h2>
                <p class="mt-1 text-sm text-stone-500">Detailed breakdown of your time on Earth.</p>

                <div class="mt-6 grid gap-3 sm:grid-cols-3">
                    <article class="rounded-2xl border border-stone-200/70 bg-[#f8f5ef] p-4 text-center">
                        <p id="age-years" class="text-4xl font-semibold leading-none text-primary">0</p>
                        <p class="mt-2 text-xs font-semibold uppercase tracking-[0.12em] text-stone-500">Years</p>
                    </article>
                    <article class="rounded-2xl border border-stone-200/70 bg-[#f8f5ef] p-4 text-center">
                        <p id="age-months" class="text-4xl font-semibold leading-none text-primary">0</p>
                        <p class="mt-2 text-xs font-semibold uppercase tracking-[0.12em] text-stone-500">Months</p>
                    </article>
                    <article class="rounded-2xl border border-stone-200/70 bg-[#f8f5ef] p-4 text-center">
                        <p id="age-days" class="text-4xl font-semibold leading-none text-primary">0</p>
                        <p class="mt-2 text-xs font-semibold uppercase tracking-[0.12em] text-stone-500">Days</p>
                    </article>
                </div>

                <div class="mt-4 grid gap-3 sm:grid-cols-2">
                    <article class="rounded-2xl border border-stone-200/70 bg-white p-4">
                        <div class="flex items-center gap-3">
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-accent/15 text-accent">
                                <i class="fa-solid fa-stopwatch" aria-hidden="true"></i>
                            </span>
                            <div>
                                <p id="total-days-lived" class="text-xl font-semibold text-stone-900">0</p>
                                <p class="text-xs font-semibold uppercase tracking-[0.12em] text-stone-500">Total days lived</p>
                            </div>
                        </div>
                    </article>
                    <article class="rounded-2xl border border-stone-200/70 bg-white p-4">
                        <div class="flex items-center gap-3">
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-primary/15 text-primary">
                                <i class="fa-solid fa-cake-candles" aria-hidden="true"></i>
                            </span>
                            <div>
                                <p id="next-birthday" class="text-xl font-semibold text-stone-900">-</p>
                                <p class="text-xs font-semibold uppercase tracking-[0.12em] text-stone-500">Next birthday</p>
                            </div>
                        </div>
                    </article>
                </div>

                <img
                    src="{{ asset('images/potato.png') }}"
                    alt="Potato mascot"
                    class="pointer-events-none absolute -bottom-4 right-2 h-16 w-16 object-contain opacity-95"
                    loading="lazy"
                    decoding="async">
            </section>
        </div>
    </section>

    <section class="pt-container py-2">
        <div class="rounded-3xl border border-stone-200/70 bg-[#efe4d7] p-6 sm:p-8">
            <h2 class="text-3xl font-semibold text-stone-900">How it works</h2>
            <p class="mt-4 text-sm leading-7 text-stone-700">
                Chronological age is the amount of time that has passed from your birth to a selected date. Unlike biological age,
                which reflects how your body performs, chronological age is a date-based measurement.
            </p>
            <p class="mt-4 text-sm leading-7 text-stone-700">
                This calculator compares your date of birth against a target date, then computes years, months, and days using real
                calendar month lengths and leap years.
            </p>
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
        <div class="mt-5 grid gap-4 md:grid-cols-3">
            <article class="pt-soft-card pt-tool-card p-5">
                <div class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-blue-100 text-blue-600">
                    <i class="fa-solid fa-ruler-vertical" aria-hidden="true"></i>
                </div>
                <h3 class="mt-3 text-xl font-semibold text-stone-900">Height Converter</h3>
                <p class="mt-2 text-sm text-stone-600">Convert between centimeters, meters, feet, and inches instantly.</p>
                <a href="{{ route('tools.height-converter') }}" class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-primary">
                    Open Tool
                    <span aria-hidden="true">&rarr;</span>
                </a>
            </article>

            <article class="pt-soft-card pt-tool-card p-5">
                <div class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-cyan-100 text-cyan-700">
                    <i class="fa-solid fa-snowflake" aria-hidden="true"></i>
                </div>
                <h3 class="mt-3 text-xl font-semibold text-stone-900">Snow Day Calculator</h3>
                <p class="mt-2 text-sm text-stone-600">Predict school closure possibilities from weather conditions.</p>
                <a href="{{ route('tools.snow-day-calculator') }}" class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-primary">
                    Open Tool
                    <span aria-hidden="true">&rarr;</span>
                </a>
            </article>

            <article class="pt-soft-card pt-tool-card p-5">
                <div class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-700">
                    <i class="fa-solid fa-seedling" aria-hidden="true"></i>
                </div>
                <h3 class="mt-3 text-xl font-semibold text-stone-900">Grow a Garden</h3>
                <p class="mt-2 text-sm text-stone-600">Calculate planting dates and harvest windows for your zone.</p>
                <button type="button" class="pt-btn-secondary mt-4" disabled>Coming soon</button>
            </article>
        </div>
    </section>

    <section class="pt-container pb-8">
        <h2 class="text-3xl font-semibold text-stone-900">Frequently Asked Questions</h2>
        <div class="mt-5 space-y-3">
            <details class="pt-faq pt-accordion">
                <summary class="flex items-center justify-between gap-3">
                    <span>Does the calculator account for leap years?</span>
                    <span class="faq-plus text-xl leading-none text-stone-500">+</span>
                </summary>
                <p class="mt-3 text-sm text-stone-600">
                    Yes. The date math uses real calendar dates, so leap-day years are handled automatically.
                </p>
            </details>
            <details class="pt-faq pt-accordion">
                <summary class="flex items-center justify-between gap-3">
                    <span>What is the difference between chronological and biological age?</span>
                    <span class="faq-plus text-xl leading-none text-stone-500">+</span>
                </summary>
                <p class="mt-3 text-sm text-stone-600">
                    Chronological age is based on your birth date; biological age reflects physical health and lifestyle.
                </p>
            </details>
            <details class="pt-faq pt-accordion">
                <summary class="flex items-center justify-between gap-3">
                    <span>Can I calculate age on a future date?</span>
                    <span class="faq-plus text-xl leading-none text-stone-500">+</span>
                </summary>
                <p class="mt-3 text-sm text-stone-600">
                    Yes. Set the optional date field to any future day and the calculator will show your age for that date.
                </p>
            </details>
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
                const parts = value.split('-').map(Number);
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
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
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
                asOfDateInput.value = formatDateInput(new Date());
            }

            form.addEventListener('submit', (event) => {
                event.preventDefault();
                calculate();
            });

            birthDateInput.addEventListener('change', calculate);
            asOfDateInput.addEventListener('change', calculate);
        })();
    </script>
@endpush
