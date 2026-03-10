@extends('layouts.app')

@section('title', 'Height Calculator — Convert cm to feet & inches instantly')
@section('description', 'Convert height between centimeters and feet/inches instantly with accurate formulas, common conversion chips, FAQ, and related tools.')
@section('canonical', route('tools.height-calculator'))

@section('content')
    @php
        $homePageData = $homePageData ?? [];
    @endphp

    <section class="pt-container py-10 sm:py-12">
        <h1 class="text-3xl font-semibold text-stone-900 sm:text-4xl">
            Height Calculator
        </h1>
        <p class="mt-2 max-w-2xl text-sm text-stone-600">
            Convert centimeters and feet/inches both ways instantly.
        </p>

        <div id="height-converter" class="pt-card mt-6 p-4 sm:p-6">
            <div class="mb-4 inline-flex rounded-full border border-stone-200/70 bg-white p-1">
                <button type="button" class="tab-btn rounded-full px-4 py-2 text-sm font-semibold" data-tab="cm">
                    Centimeters to Feet/Inches
                </button>
                <button type="button" class="tab-btn rounded-full px-4 py-2 text-sm font-semibold" data-tab="ft">
                    Feet/Inches to Centimeters
                </button>
            </div>

            <div id="panel-cm" class="tab-panel grid gap-4 md:grid-cols-2">
                <div>
                    <label for="cmInput" class="pt-label">Centimeters</label>
                    <input id="cmInput" type="number" min="0" step="0.01" class="pt-input" value="170" placeholder="Enter cm">
                </div>
                <div class="rounded-xl border border-stone-200/60 bg-potato-beige/70 p-4">
                    <p class="text-xs font-semibold uppercase tracking-wide text-stone-500">Quick note</p>
                    <p class="mt-2 text-sm text-stone-700">
                        1 inch = 2.54 cm and 1 foot = 12 inches.
                    </p>
                </div>
            </div>

            <div id="panel-ft" class="tab-panel hidden grid gap-4 md:grid-cols-2">
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="feetInput" class="pt-label">Feet</label>
                        <input id="feetInput" type="number" min="0" step="1" class="pt-input" value="5" placeholder="Feet">
                    </div>
                    <div>
                        <label for="inchInput" class="pt-label">Inches</label>
                        <input id="inchInput" type="number" min="0" step="0.01" class="pt-input" value="7" placeholder="Inches">
                    </div>
                </div>
                <div class="rounded-xl border border-stone-200/60 bg-potato-beige/70 p-4">
                    <p class="text-xs font-semibold uppercase tracking-wide text-stone-500">Quick note</p>
                    <p class="mt-2 text-sm text-stone-700">
                        Total inches = (feet × 12) + inches.
                    </p>
                </div>
            </div>

            <div class="mt-6 grid gap-3 md:grid-cols-3">
                <article class="rounded-xl border border-stone-200/70 bg-white p-4">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-stone-500">Centimeters</p>
                            <p id="cmResult" class="mt-1 text-2xl font-semibold text-stone-900">170.00 cm</p>
                        </div>
                        <button class="copy-btn rounded-lg border border-stone-200 px-2 py-1 text-xs font-semibold text-stone-600 hover:text-primary" data-copy-target="cmResult" title="Copy result">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="9" y="9" width="13" height="13" rx="2"></rect>
                                <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                            </svg>
                        </button>
                    </div>
                </article>
                <article class="rounded-xl border border-stone-200/70 bg-white p-4">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-stone-500">Feet & Inches</p>
                            <p id="fiResult" class="mt-1 text-2xl font-semibold text-stone-900">5 ft 6.93 in</p>
                        </div>
                        <button class="copy-btn rounded-lg border border-stone-200 px-2 py-1 text-xs font-semibold text-stone-600 hover:text-primary" data-copy-target="fiResult" title="Copy result">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="9" y="9" width="13" height="13" rx="2"></rect>
                                <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                            </svg>
                        </button>
                    </div>
                </article>
                <article class="rounded-xl border border-stone-200/70 bg-white p-4">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-stone-500">Total Inches</p>
                            <p id="inResult" class="mt-1 text-2xl font-semibold text-stone-900">66.93 in</p>
                        </div>
                        <button class="copy-btn rounded-lg border border-stone-200 px-2 py-1 text-xs font-semibold text-stone-600 hover:text-primary" data-copy-target="inResult" title="Copy result">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="9" y="9" width="13" height="13" rx="2"></rect>
                                <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                            </svg>
                        </button>
                    </div>
                </article>
            </div>

            <div class="mt-6">
                <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-stone-500">Common conversions</p>
                <div class="flex flex-wrap gap-2">
                    <button type="button" class="pt-chip conversion-chip" data-cm="152.4">152.4 cm (5'0")</button>
                    <button type="button" class="pt-chip conversion-chip" data-cm="160">160 cm (5'3")</button>
                    <button type="button" class="pt-chip conversion-chip" data-cm="167.64">167.64 cm (5'6")</button>
                    <button type="button" class="pt-chip conversion-chip" data-cm="172.72">172.72 cm (5'8")</button>
                    <button type="button" class="pt-chip conversion-chip" data-cm="182.88">182.88 cm (6'0")</button>
                </div>
            </div>
        </div>
    </section>

    <section class="pt-container py-4">
        <div class="pt-card p-5 sm:p-6">
            <h2 class="text-2xl font-semibold text-stone-900">How to convert height</h2>
            <div class="mt-4 grid gap-4 md:grid-cols-2">
                <div class="rounded-xl border border-stone-200/70 bg-white p-4">
                    <p class="text-sm font-semibold text-stone-900">Constants</p>
                    <ul class="mt-2 space-y-2 text-sm text-stone-600">
                        <li>1 inch = 2.54 cm</li>
                        <li>1 foot = 12 inches</li>
                    </ul>
                </div>
                <div class="rounded-xl border border-stone-200/70 bg-white p-4">
                    <p class="text-sm font-semibold text-stone-900">Formulas</p>
                    <ul class="mt-2 space-y-2 text-sm text-stone-600">
                        <li>cm to inches: <code>in = cm / 2.54</code></li>
                        <li>feet: <code>ft = floor(in / 12)</code></li>
                        <li>inches remainder: <code>in = totalIn - (ft * 12)</code></li>
                        <li>feet/inches to cm: <code>cm = ((ft * 12) + in) * 2.54</code></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    @include('components.faqs.accordion', [
        'section' => $homePageData['faqs']['height_calculator'] ?? [],
        'sectionClass' => 'pt-container py-8',
        'titleClass' => 'text-2xl font-semibold text-stone-900',
        'itemsWrapperClass' => 'mt-4 space-y-3',
    ])

    <section class="pt-container pb-8">
        <h2 class="text-2xl font-semibold text-stone-900">Related tools</h2>
        <div class="mt-4 flex flex-wrap gap-3">
            <button type="button" class="pt-btn-secondary" disabled>BMI Calculator (Coming soon)</button>
            <button type="button" class="pt-btn-secondary" disabled>Weight Converter (Coming soon)</button>
            <button type="button" class="pt-btn-secondary" disabled>Length Converter (Coming soon)</button>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        (() => {
            const cmInput = document.getElementById('cmInput');
            const feetInput = document.getElementById('feetInput');
            const inchInput = document.getElementById('inchInput');
            const cmResult = document.getElementById('cmResult');
            const fiResult = document.getElementById('fiResult');
            const inResult = document.getElementById('inResult');
            const tabButtons = document.querySelectorAll('.tab-btn');
            const tabPanels = document.querySelectorAll('.tab-panel');

            const round = (value) => Number(value).toFixed(2);
            const setActiveTab = (tab) => {
                tabButtons.forEach((btn) => {
                    const isActive = btn.dataset.tab === tab;
                    btn.classList.toggle('bg-primary', isActive);
                    btn.classList.toggle('text-white', isActive);
                    btn.classList.toggle('text-stone-700', !isActive);
                });

                tabPanels.forEach((panel) => panel.classList.add('hidden'));
                document.getElementById(`panel-${tab}`).classList.remove('hidden');
            };

            const updateFromCm = () => {
                const cm = parseFloat(cmInput.value);
                if (!Number.isFinite(cm) || cm < 0) {
                    return;
                }

                const totalInches = cm / 2.54;
                const feet = Math.floor(totalInches / 12);
                const inches = totalInches - (feet * 12);

                cmResult.textContent = `${round(cm)} cm`;
                fiResult.textContent = `${feet} ft ${round(inches)} in`;
                inResult.textContent = `${round(totalInches)} in`;
            };

            const updateFromFeetInches = () => {
                const feet = parseFloat(feetInput.value || '0');
                const inches = parseFloat(inchInput.value || '0');

                if (!Number.isFinite(feet) || !Number.isFinite(inches) || feet < 0 || inches < 0) {
                    return;
                }

                const totalInches = (feet * 12) + inches;
                const cm = totalInches * 2.54;
                const normalizedFeet = Math.floor(totalInches / 12);
                const normalizedInches = totalInches - (normalizedFeet * 12);

                cmResult.textContent = `${round(cm)} cm`;
                fiResult.textContent = `${normalizedFeet} ft ${round(normalizedInches)} in`;
                inResult.textContent = `${round(totalInches)} in`;
                cmInput.value = round(cm);
            };

            tabButtons.forEach((btn) => {
                btn.addEventListener('click', () => setActiveTab(btn.dataset.tab));
            });

            document.querySelectorAll('.conversion-chip').forEach((chip) => {
                chip.addEventListener('click', () => {
                    cmInput.value = chip.dataset.cm;
                    setActiveTab('cm');
                    updateFromCm();
                });
            });

            cmInput.addEventListener('input', updateFromCm);
            feetInput.addEventListener('input', updateFromFeetInches);
            inchInput.addEventListener('input', updateFromFeetInches);

            document.querySelectorAll('.copy-btn').forEach((btn) => {
                btn.addEventListener('click', async () => {
                    const target = document.getElementById(btn.dataset.copyTarget);
                    if (!target) {
                        return;
                    }
                    try {
                        await navigator.clipboard.writeText(target.textContent.trim());
                        btn.classList.add('text-accent');
                        setTimeout(() => btn.classList.remove('text-accent'), 800);
                    } catch (error) {
                        console.error(error);
                    }
                });
            });

            setActiveTab('cm');
            updateFromCm();
        })();
    </script>
@endpush
