@extends('layouts.app')

@section('title', 'Height Converter - Convert cm, m, ft and inches')
@section('description', 'Convert height units between centimeters, meters, feet, inches, and feet plus inches. Choose both units and get the main result plus all common height formats instantly.')
@section('canonical', route('tools.height-converter'))

@section('content')
    @php
        $homePageData = $homePageData ?? [];
    @endphp

    <section id="height-tool-page" class="pt-container pt-8 pb-10 sm:pt-10 sm:pb-12 lg:pt-12 lg:pb-14">
        <nav aria-label="Breadcrumb" class="text-xs text-stone-500">
            <ol class="flex flex-wrap items-center gap-2">
                <li><a href="{{ route('home') }}" class="hover:text-primary">Home</a></li>
                <li aria-hidden="true">&gt;</li>
                <li><a href="{{ route('home') }}#pick-potato" class="hover:text-primary">Tools</a></li>
                <li aria-hidden="true">&gt;</li>
                <li aria-current="page" class="font-semibold text-primary">Height Converter</li>
            </ol>
        </nav>

        <div class="mt-5">
            <h1 class="text-3xl font-semibold text-stone-900 sm:text-5xl">Height Converter</h1>
            <p class="mt-4 max-w-2xl text-sm leading-relaxed text-stone-600 sm:text-base">
                Convert height units and see the result in all common formats.
            </p>

            <div class="mt-5 flex flex-wrap gap-2">
                <span class="pt-chip pt-chip-static"><i class="fa-solid fa-circle-check text-accent" aria-hidden="true"></i> Exact conversion math</span>
                <span class="pt-chip pt-chip-static"><i class="fa-solid fa-ruler-combined text-accent" aria-hidden="true"></i> Metric + Imperial</span>
                <span class="pt-chip pt-chip-static"><i class="fa-solid fa-arrows-left-right text-accent" aria-hidden="true"></i> Two-way conversion</span>
                <span class="pt-chip pt-chip-static"><i class="fa-solid fa-shield-halved text-accent" aria-hidden="true"></i> Free to use</span>
            </div>
        </div>

        <div class="mt-6 grid gap-5 md:grid-cols-[minmax(0,1.08fr)_minmax(320px,0.92fr)] xl:gap-6">
            <section class="pt-card pt-card-elevated p-5 sm:p-6 lg:p-7">
                <div class="rounded-3xl border border-stone-200/70 bg-white px-4 py-4 sm:px-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-stone-500">Convert Height Units</p>
                    <h2 class="mt-2 text-2xl font-semibold text-stone-900">Enter your height and choose units</h2>
                </div>

                <form id="convertForm" class="mt-6 space-y-6" novalidate>
                    <div class="grid gap-6 md:grid-cols-2">
                        <div class="pt-field md:col-span-2">
                            <label for="convertValue" class="pt-label">Value</label>
                            <input
                                id="convertValue"
                                type="number"
                                min="0"
                                step="0.01"
                                inputmode="decimal"
                                class="pt-input pt-input-tall"
                                placeholder="Enter value">
                        </div>

                        <div class="pt-field">
                            <label for="convertSource" class="pt-label">Convert From</label>
                            <select id="convertSource" class="pt-input pt-input-tall">
                                <option value="cm" selected>Centimeters (cm)</option>
                                <option value="m">Meters (m)</option>
                                <option value="ft">Feet (ft)</option>
                                <option value="in">Inches (in)</option>
                            </select>
                        </div>

                        <div class="pt-field">
                            <label for="convertTarget" class="pt-label">Convert To</label>
                            <select id="convertTarget" class="pt-input pt-input-tall">
                                <option value="ftin" selected>Feet + Inches (ft/in)</option>
                                <option value="cm">Centimeters (cm)</option>
                                <option value="m">Meters (m)</option>
                                <option value="ft">Feet (ft)</option>
                                <option value="in">Inches (in)</option>
                            </select>
                        </div>
                    </div>

                    <button type="button" id="swapUnits" class="pt-btn-secondary w-full lg:w-auto">
                        Swap Units
                    </button>

                    <p id="convertError" class="hidden rounded-xl border border-red-200 bg-red-50 px-3 py-2 text-xs font-semibold text-red-700"></p>

                    <button type="submit" class="pt-btn-primary w-full cursor-pointer py-3.5 text-base">
                        Convert Height
                        <i class="fa-solid fa-repeat" aria-hidden="true"></i>
                    </button>
                </form>
            </section>

            <div class="pt-result-stack">
                <section class="pt-card pt-card-elevated relative p-5 sm:p-6 lg:p-7" aria-live="polite">
                    <button
                        type="button"
                        id="copyResult"
                        class="absolute right-5 top-5 inline-flex h-10 w-10 cursor-pointer items-center justify-center rounded-full border border-stone-200/70 bg-white text-stone-500 opacity-0 pointer-events-none transition hover:border-primary/40 hover:text-primary focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary/30"
                        aria-label="Copy converted height"
                        aria-hidden="true"
                        title="Copy result">
                        <i class="fa-regular fa-copy" aria-hidden="true"></i>
                    </button>

                    <p id="resultLabel" class="text-[11px] font-semibold uppercase tracking-[0.15em] text-accent">Converted Height</p>
                    <p id="resultSource" class="mt-4 text-sm font-medium text-stone-500">Enter a height to see the result.</p>

                    <div class="mt-5 flex flex-wrap items-end gap-3">
                        <p id="mainResultValue" class="text-5xl font-semibold leading-none text-stone-900 sm:text-7xl">--</p>
                        <span id="mainResultUnit" class="pb-2 text-2xl font-semibold text-stone-400 sm:text-3xl"></span>
                    </div>

                    <p id="resultSubline" class="mt-4 hidden text-base font-medium text-stone-700 sm:text-lg"></p>
                    <p id="resultHint" class="mt-4 text-sm leading-relaxed text-stone-500">
                        Choose the unit you have, choose the unit you want, then convert.
                    </p>

                    <div class="mt-6 rounded-2xl border border-stone-200/70 bg-potato-beige/45 p-4">
                        <p class="text-[11px] font-semibold uppercase tracking-[0.15em] text-stone-500">All Common Formats</p>
                        <dl class="mt-4 grid gap-3 sm:grid-cols-2 xl:grid-cols-3">
                            <div class="rounded-2xl border border-stone-200/70 bg-white/85 px-4 py-3">
                                <dt class="text-[11px] font-semibold uppercase tracking-[0.14em] text-stone-500">Centimeters</dt>
                                <dd id="convCm" class="mt-2 text-lg font-semibold text-stone-900">--</dd>
                            </div>
                            <div class="rounded-2xl border border-stone-200/70 bg-white/85 px-4 py-3">
                                <dt class="text-[11px] font-semibold uppercase tracking-[0.14em] text-stone-500">Meters</dt>
                                <dd id="convM" class="mt-2 text-lg font-semibold text-stone-900">--</dd>
                            </div>
                            <div class="rounded-2xl border border-stone-200/70 bg-white/85 px-4 py-3">
                                <dt class="text-[11px] font-semibold uppercase tracking-[0.14em] text-stone-500">Feet + Inches</dt>
                                <dd id="convFi" class="mt-2 text-lg font-semibold text-stone-900">--</dd>
                            </div>
                            <div class="rounded-2xl border border-stone-200/70 bg-white/85 px-4 py-3">
                                <dt class="text-[11px] font-semibold uppercase tracking-[0.14em] text-stone-500">Feet</dt>
                                <dd id="convFt" class="mt-2 text-lg font-semibold text-stone-900">--</dd>
                            </div>
                            <div class="rounded-2xl border border-stone-200/70 bg-white/85 px-4 py-3">
                                <dt class="text-[11px] font-semibold uppercase tracking-[0.14em] text-stone-500">Inches</dt>
                                <dd id="convIn" class="mt-2 text-lg font-semibold text-stone-900">--</dd>
                            </div>
                        </dl>
                    </div>
                </section>

                <details class="pt-card pt-card-elevated px-4 py-3 sm:px-5 sm:py-4">
                    <summary class="flex cursor-pointer items-center justify-between gap-3 text-sm font-semibold text-stone-800">
                        <span>Exact conversion formula</span>
                        <i class="fa-solid fa-chevron-down text-xs text-stone-400" aria-hidden="true"></i>
                    </summary>
                    <div class="mt-3 space-y-2 text-xs leading-relaxed text-stone-600 sm:text-sm">
                        <p><strong>1 inch = 2.54 centimeters</strong></p>
                        <p><strong>1 foot = 12 inches</strong></p>
                        <p><strong>1 meter = 100 centimeters</strong></p>
                        <p>These are exact standard conversion factors, so this tool does not estimate. It converts.</p>
                    </div>
                </details>
            </div>
        </div>
    </section>

    <section class="pt-container pt-16 pb-6 sm:pt-20">
        <div class="pt-soft-section bg-[#efe5d8] px-5 py-8 sm:px-8 sm:py-10">
            <div class="max-w-4xl">
                <p class="text-xs font-semibold uppercase tracking-[0.08em] text-stone-500">Conversion Report</p>
                <h2 class="mt-2 text-3xl font-semibold text-stone-900 sm:text-4xl">How this height converter works</h2>
                <p class="mt-3 text-sm leading-relaxed text-stone-700 sm:text-base">
                    This page converts height from one unit to another using exact unit math. It does not predict height, estimate growth,
                    or calculate age. It simply changes the value you enter into the unit format you select.
                </p>
            </div>

            <div class="mt-6 grid gap-4 md:grid-cols-3">
                <article class="pt-soft-card p-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-stone-500">What It Does</p>
                    <h3 class="mt-3 text-lg font-semibold text-stone-900">Converts units both ways</h3>
                    <p class="mt-2 text-sm leading-relaxed text-stone-600">
                        You can convert centimeters, meters, feet, inches, or feet and inches into the exact format you need.
                    </p>
                </article>

                <article class="pt-soft-card p-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-stone-500">Why It Is Trustworthy</p>
                    <h3 class="mt-3 text-lg font-semibold text-stone-900">Uses exact standard factors</h3>
                    <p class="mt-2 text-sm leading-relaxed text-stone-600">
                        Height conversion is fixed math. The result comes from exact constants like 1 inch = 2.54 cm and 1 foot = 12 inches.
                    </p>
                </article>

                <article class="pt-soft-card p-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-stone-500">Why We Show More</p>
                    <h3 class="mt-3 text-lg font-semibold text-stone-900">All major formats stay visible</h3>
                    <p class="mt-2 text-sm leading-relaxed text-stone-600">
                        After the main conversion, we also show the same value in other common formats so non-technical users do not have to convert again.
                    </p>
                </article>
            </div>
        </div>
    </section>

    @include('components.faqs.accordion', [
        'section' => $homePageData['faqs']['height_calculator'] ?? [],
        'sectionClass' => 'pt-container pt-16 pb-8 sm:pt-20',
        'titleClass' => 'text-center text-3xl font-semibold text-stone-900',
        'descriptionClass' => 'mt-2 text-center text-sm text-stone-600',
        'itemsWrapperClass' => 'mt-6 space-y-3',
        'enableSchema' => true,
    ])

    <section class="pt-container pt-16 pb-12 sm:pt-20">
        <div class="flex items-center justify-between gap-4">
            <h2 class="text-3xl font-semibold text-stone-900">Related Tools</h2>
            <a
                href="{{ route('home') }}#pick-potato"
                aria-label="Browse all tools"
                class="pt-link-arrow inline-flex items-center gap-1.5 text-sm font-semibold text-primary transition-colors duration-200 focus-visible:rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary/40 focus-visible:ring-offset-2">
                Browse all
                <span class="pt-link-arrow-icon" aria-hidden="true">&rarr;</span>
            </a>
        </div>

        <div class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <a
                href="{{ route('tools.age-calculator') }}"
                class="pt-soft-card pt-tool-card block p-4"
                aria-label="Open Age Calculator tool">
                <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-primary/10 text-primary">
                    <i class="fa-solid fa-calendar-days" aria-hidden="true"></i>
                </span>
                <h3 class="mt-3 text-base font-semibold text-stone-900">Age Calculator</h3>
                <p class="mt-2 text-xs leading-relaxed text-stone-600">Calculate precise age in years, months, and days.</p>
                <span class="pt-link-arrow mt-3 inline-flex items-center gap-1.5 text-sm font-semibold text-primary">
                    Open Tool
                    <span class="pt-link-arrow-icon" aria-hidden="true">&rarr;</span>
                </span>
            </a>

            <article class="pt-soft-card p-4">
                <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-primary/10 text-primary">
                    <i class="fa-solid fa-weight-scale" aria-hidden="true"></i>
                </span>
                <h3 class="mt-3 text-base font-semibold text-stone-900">BMI Calculator</h3>
                <p class="mt-2 text-xs leading-relaxed text-stone-600">Healthy weight range analysis for adults.</p>
                <button type="button" class="pt-btn-secondary mt-3" disabled>Coming soon</button>
            </article>

            <article class="pt-soft-card p-4">
                <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-primary/10 text-primary">
                    <i class="fa-solid fa-scale-balanced" aria-hidden="true"></i>
                </span>
                <h3 class="mt-3 text-base font-semibold text-stone-900">Weight Converter</h3>
                <p class="mt-2 text-xs leading-relaxed text-stone-600">Convert between kg, lb, and stone instantly.</p>
                <button type="button" class="pt-btn-secondary mt-3" disabled>Coming soon</button>
            </article>

            <article class="pt-soft-card p-4">
                <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-primary/10 text-primary">
                    <i class="fa-solid fa-ruler-combined" aria-hidden="true"></i>
                </span>
                <h3 class="mt-3 text-base font-semibold text-stone-900">Unit Converter</h3>
                <p class="mt-2 text-xs leading-relaxed text-stone-600">Length, area, and volume unit conversion made simple.</p>
                <button type="button" class="pt-btn-secondary mt-3" disabled>Coming soon</button>
            </article>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        (() => {
            const form = document.getElementById('convertForm');
            if (!form) {
                return;
            }

            const convertValue = document.getElementById('convertValue');
            const convertSource = document.getElementById('convertSource');
            const convertTarget = document.getElementById('convertTarget');
            const swapUnits = document.getElementById('swapUnits');
            const convertError = document.getElementById('convertError');
            const copyResult = document.getElementById('copyResult');

            const resultSource = document.getElementById('resultSource');
            const mainResultValue = document.getElementById('mainResultValue');
            const mainResultUnit = document.getElementById('mainResultUnit');
            const resultSubline = document.getElementById('resultSubline');
            const resultHint = document.getElementById('resultHint');

            let currentCopyValue = '';

            const convCm = document.getElementById('convCm');
            const convM = document.getElementById('convM');
            const convFi = document.getElementById('convFi');
            const convFt = document.getElementById('convFt');
            const convIn = document.getElementById('convIn');

            const unitLabels = {
                cm: 'Centimeters (cm)',
                m: 'Meters (m)',
                ft: 'Feet (ft)',
                in: 'Inches (in)',
                ftin: 'Feet + Inches (ft/in)',
            };

            const placeholderByUnit = {
                cm: 'Enter centimeters',
                m: 'Enter meters',
                ft: 'Enter feet',
                in: 'Enter inches',
            };

            const normalizeSourceUnit = (unit) => {
                if (unit === 'ftin') {
                    return 'ft';
                }

                return placeholderByUnit[unit] ? unit : 'cm';
            };

            const toNumber = (value) => {
                const parsed = parseFloat(value);
                return Number.isFinite(parsed) ? parsed : null;
            };

            const cmToFeetInches = (cm) => {
                const totalInches = cm / 2.54;
                const feet = Math.floor(totalInches / 12);
                const inches = totalInches - (feet * 12);
                return { feet, inches };
            };

            const formatFeetInches = (cm) => {
                const converted = cmToFeetInches(cm);
                return `${converted.feet}' ${converted.inches.toFixed(1)}"`;
            };

            const formatSourceValue = (source, value) => {
                if (source === 'cm') {
                    return `${value.toFixed(1)} cm`;
                }

                if (source === 'm') {
                    return `${value.toFixed(2)} m`;
                }

                if (source === 'ft') {
                    return `${value.toFixed(2)} ft`;
                }

                return `${value.toFixed(2)} in`;
            };

            const updateSourceUi = () => {
                convertSource.value = normalizeSourceUnit(convertSource.value);
                convertValue.placeholder = placeholderByUnit[convertSource.value] || 'Enter value';
            };

            const showConvertError = (message) => {
                convertError.textContent = message;
                convertError.classList.remove('hidden');
            };

            const hideConvertError = () => {
                convertError.textContent = '';
                convertError.classList.add('hidden');
            };

            const resetCopyState = () => {
                currentCopyValue = '';
                copyResult.classList.add('opacity-0', 'pointer-events-none');
                copyResult.setAttribute('aria-hidden', 'true');
                copyResult.setAttribute('aria-label', 'Copy converted height');
                copyResult.setAttribute('title', 'Copy result');
                copyResult.innerHTML = '<i class="fa-regular fa-copy" aria-hidden="true"></i>';
            };

            const showCopiedState = () => {
                copyResult.setAttribute('aria-label', 'Copied');
                copyResult.setAttribute('title', 'Copied');
                copyResult.innerHTML = '<i class="fa-solid fa-check" aria-hidden="true"></i>';

                window.setTimeout(() => {
                    if (!currentCopyValue) {
                        return;
                    }

                    copyResult.setAttribute('aria-label', 'Copy converted height');
                    copyResult.setAttribute('title', 'Copy result');
                    copyResult.innerHTML = '<i class="fa-regular fa-copy" aria-hidden="true"></i>';
                }, 1400);
            };

            const setEmptyState = () => {
                resultSource.textContent = 'Enter a height to see the result.';
                mainResultValue.textContent = '--';
                mainResultUnit.textContent = '';
                resultSubline.textContent = '';
                resultSubline.classList.add('hidden');
                resultHint.classList.remove('hidden');
                resetCopyState();
                convCm.textContent = '--';
                convM.textContent = '--';
                convFi.textContent = '--';
                convFt.textContent = '--';
                convIn.textContent = '--';
            };

            const cmToTarget = (cm, target) => {
                if (target === 'cm') {
                    return { value: cm.toFixed(1), unit: 'cm' };
                }

                if (target === 'm') {
                    return { value: (cm / 100).toFixed(2), unit: 'm' };
                }

                if (target === 'ft') {
                    return { value: (cm / 30.48).toFixed(2), unit: 'ft' };
                }

                if (target === 'in') {
                    return { value: (cm / 2.54).toFixed(2), unit: 'in' };
                }

                return { value: formatFeetInches(cm), unit: '' };
            };

            const renderConversion = (cmValue, sourceValue) => {
                const target = convertTarget.value;
                const primaryResult = cmToTarget(cmValue, target);
                const sourceSummary = formatSourceValue(convertSource.value, sourceValue);

                resultSource.textContent = `From ${sourceSummary}`;
                mainResultValue.textContent = primaryResult.value;
                mainResultUnit.textContent = primaryResult.unit;
                resultSubline.textContent = `Shown in ${unitLabels[target]}`;
                resultSubline.classList.remove('hidden');
                resultHint.classList.add('hidden');
                currentCopyValue = [primaryResult.value, primaryResult.unit].filter(Boolean).join(' ').trim();
                copyResult.classList.remove('opacity-0', 'pointer-events-none');
                copyResult.setAttribute('aria-hidden', 'false');
                copyResult.setAttribute('aria-label', 'Copy converted height');
                copyResult.setAttribute('title', 'Copy result');
                copyResult.innerHTML = '<i class="fa-regular fa-copy" aria-hidden="true"></i>';

                convCm.textContent = `${cmValue.toFixed(1)} cm`;
                convM.textContent = `${(cmValue / 100).toFixed(2)} m`;
                convFi.textContent = formatFeetInches(cmValue);
                convFt.textContent = `${(cmValue / 30.48).toFixed(2)} ft`;
                convIn.textContent = `${(cmValue / 2.54).toFixed(2)} in`;
            };

            const runConversion = () => {
                hideConvertError();

                const source = convertSource.value;
                const inputValue = toNumber(convertValue.value);

                if (inputValue === null || inputValue < 0) {
                    showConvertError('Please enter a valid height value.');
                    return;
                }

                let cmValue = null;
                if (source === 'cm') {
                    cmValue = inputValue;
                } else if (source === 'm') {
                    cmValue = inputValue * 100;
                } else if (source === 'ft') {
                    cmValue = inputValue * 30.48;
                } else {
                    cmValue = inputValue * 2.54;
                }

                renderConversion(cmValue, inputValue);
            };

            convertSource.addEventListener('change', updateSourceUi);

            swapUnits.addEventListener('click', () => {
                const currentSource = convertSource.value;
                convertSource.value = normalizeSourceUnit(convertTarget.value);
                convertTarget.value = currentSource;
                updateSourceUi();
            });

            copyResult.addEventListener('click', async () => {
                if (!currentCopyValue) {
                    return;
                }

                try {
                    await navigator.clipboard.writeText(currentCopyValue);
                    showCopiedState();
                } catch (error) {
                    const helper = document.createElement('textarea');
                    helper.value = currentCopyValue;
                    helper.setAttribute('readonly', '');
                    helper.style.position = 'absolute';
                    helper.style.left = '-9999px';
                    document.body.appendChild(helper);
                    helper.select();
                    document.execCommand('copy');
                    document.body.removeChild(helper);
                    showCopiedState();
                }
            });

            form.addEventListener('submit', (event) => {
                event.preventDefault();
                runConversion();
            });

            setEmptyState();
            updateSourceUi();
        })();
    </script>
@endpush
