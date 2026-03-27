@extends('layouts.app')

@section('title', 'CSV to JSON Converter - Convert CSV files and text to JSON')
@section('description', 'Convert CSV to JSON instantly with live preview, file upload, delimiter detection, formatted output, and one-click copy or download.')
@section('canonical', route('tools.csv-to-json'))

@php
    $homePageData = $homePageData ?? [];
@endphp

@push('head')
    @vite('resources/js/tools/csv-to-json-converter.js')
    <script type="application/ld+json">{!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'WebApplication',
        'name' => 'PotatoTools CSV to JSON Converter',
        'applicationCategory' => 'DeveloperApplication',
        'operatingSystem' => 'Web',
        'isAccessibleForFree' => true,
        'url' => route('tools.csv-to-json'),
        'description' => 'Convert CSV files or pasted CSV text into formatted JSON with live browser-side preview and export.',
        'publisher' => [
            '@type' => 'Organization',
            'name' => 'PotatoTools',
        ],
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endpush

@section('content')
    <section id="csv-to-json-tool-page" class="pt-container pt-8 pb-10 sm:pt-10 sm:pb-12 lg:pt-12 lg:pb-14">
        <nav aria-label="Breadcrumb" class="text-xs text-stone-500">
            <ol class="flex flex-wrap items-center gap-2">
                <li><a href="{{ route('home') }}" class="hover:text-primary">Home</a></li>
                <li aria-hidden="true">&gt;</li>
                <li><a href="{{ route('home') }}#pick-potato" class="hover:text-primary">Tools</a></li>
                <li aria-hidden="true">&gt;</li>
                <li aria-current="page" class="font-semibold text-primary">CSV to JSON Converter</li>
            </ol>
        </nav>

        <div class="mt-5">
            <div class="pt-page-title-row">
                <span class="pt-page-title-icon" aria-hidden="true">
                    <i class="fa-solid fa-file-code"></i>
                </span>
                <h1 class="text-3xl font-semibold text-stone-900 sm:text-5xl">CSV to JSON Converter</h1>
            </div>
            <p class="mt-4 max-w-2xl text-sm leading-relaxed text-stone-600 sm:text-base">
                Upload a CSV file or paste CSV text to generate clean JSON instantly.
            </p>

            <div class="mt-5 flex flex-wrap gap-2">
                <span class="pt-chip pt-chip-static"><i class="fa-solid fa-bolt text-accent" aria-hidden="true"></i> Live conversion</span>
                <span class="pt-chip pt-chip-static"><i class="fa-solid fa-table-columns text-accent" aria-hidden="true"></i> CSV table preview</span>
                <span class="pt-chip pt-chip-static"><i class="fa-solid fa-wand-magic-sparkles text-accent" aria-hidden="true"></i> Auto-detect delimiter</span>
                <span class="pt-chip pt-chip-static"><i class="fa-solid fa-download text-accent" aria-hidden="true"></i> Copy or download JSON</span>
            </div>
        </div>

        <div id="csv-to-json-tool" class="mt-6 space-y-5 xl:space-y-6">
            <div class="grid gap-5 lg:grid-cols-[minmax(0,1.06fr)_minmax(320px,0.94fr)] xl:gap-6">
                <section id="csv-input-card" class="pt-card pt-card-elevated relative min-w-0 p-5 sm:p-6 lg:p-7">
                    <div class="rounded-3xl border border-stone-200/70 bg-white px-4 py-4 sm:px-5">
                        <p class="text-xs font-semibold uppercase tracking-[0.12em] text-stone-500">CSV Input</p>
                        <h2 class="mt-2 text-2xl font-semibold text-stone-900">Paste CSV or upload a file</h2>
                        <p class="mt-2 max-w-xl text-sm leading-relaxed text-stone-600">Choose an input method, set the separator if needed, then click Convert to JSON.</p>
                    </div>

                    <div class="mt-6 space-y-6">
                        <div class="flex flex-wrap items-center justify-between gap-3">
                            <div class="inline-flex rounded-full border border-stone-200 bg-potato-beige/25 p-1">
                                <button
                                    type="button"
                                    id="csv-tab-upload"
                                    class="csv-input-tab cursor-pointer rounded-full px-4 py-2 text-sm font-semibold transition"
                                    data-csv-input-tab="upload"
                                    aria-pressed="true">
                                    Upload
                                </button>
                                <button
                                    type="button"
                                    id="csv-tab-text"
                                    class="csv-input-tab cursor-pointer rounded-full px-4 py-2 text-sm font-semibold transition"
                                    data-csv-input-tab="text"
                                    aria-pressed="false">
                                    Text
                                </button>
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center justify-between gap-3 rounded-2xl border border-stone-200/70 bg-white px-4 py-3">
                            <div class="flex items-center gap-2">
                                <label for="csv-separator" class="whitespace-nowrap text-[11px] font-semibold uppercase tracking-[0.12em] text-stone-500">Delimiter</label>
                                <div class="pt-select-shell">
                                    <select id="csv-separator" class="pt-input min-w-[8.5rem]" data-pt-select>
                                        <option value="auto" selected>Auto-detect</option>
                                        <option value="comma">Comma</option>
                                        <option value="semicolon">Semi-colon</option>
                                        <option value="tab">Tab</option>
                                        <option value="pipe">Pipe</option>
                                    </select>
                                </div>
                            </div>
                            <p class="text-xs leading-relaxed text-stone-500">Choose how the CSV should be parsed before conversion.</p>
                        </div>

                        <div id="csv-panel-upload" data-csv-input-panel="upload" class="pt-field">
                            <div class="pt-label-row">
                                <label for="csv-file-input" class="pt-label mb-0">CSV File</label>
                                <span id="csv-file-badge" class="hidden rounded-full border border-stone-200 bg-white px-3 py-1 text-[11px] font-semibold text-stone-500"></span>
                            </div>

                            <label
                                id="csv-dropzone"
                                for="csv-file-input"
                                class="group flex min-h-[10rem] cursor-pointer flex-col items-center justify-center rounded-3xl border border-dashed border-stone-300 bg-potato-beige/25 px-5 py-5 text-center transition duration-200 hover:border-primary/50 hover:bg-white">
                                <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl border border-stone-200/70 bg-white text-lg text-primary shadow-sm transition duration-200 group-hover:border-primary/40">
                                    <i class="fa-solid fa-file-arrow-up" aria-hidden="true"></i>
                                </span>
                                <span class="mt-4 text-base font-semibold text-stone-900">Drop a CSV file here</span>
                                <span class="mt-2 text-sm leading-relaxed text-stone-600">Or click to browse.</span>
                                <span class="mt-3 inline-flex items-center gap-2 rounded-full border border-stone-200 bg-white px-3 py-1.5 text-xs font-semibold text-stone-600">
                                    <i class="fa-regular fa-folder-open text-primary" aria-hidden="true"></i>
                                    Choose CSV
                                </span>
                            </label>
                            <input id="csv-file-input" type="file" accept=".csv,text/csv,application/vnd.ms-excel" class="sr-only">

                            <div id="csv-file-state" class="mt-4 hidden rounded-2xl border border-stone-200/70 bg-white px-4 py-3">
                                <div class="flex flex-wrap items-center justify-between gap-3">
                                    <div class="min-w-0">
                                        <p class="text-[11px] font-semibold uppercase tracking-[0.12em] text-stone-500">Selected File</p>
                                        <p id="csv-file-state-name" class="mt-1 truncate text-sm font-semibold text-stone-900"></p>
                                    </div>
                                    <div class="flex flex-wrap items-center gap-2">
                                        <button type="button" id="replace-csv-file" class="pt-btn-secondary px-4 py-2 text-xs">
                                            <i class="fa-regular fa-folder-open" aria-hidden="true"></i>
                                            Replace
                                        </button>
                                        <button type="button" id="remove-csv-file" class="pt-btn-secondary px-4 py-2 text-xs">
                                            <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                                            Remove
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="csv-panel-text" data-csv-input-panel="text" class="hidden pt-field">
                            <div class="pt-label-row">
                                <label for="csv-source" class="pt-label mb-0">CSV Text</label>
                                <button type="button" id="clear-csv-input" class="pt-btn-secondary px-4 py-2 text-xs">Clear</button>
                            </div>
                            <textarea
                                id="csv-source"
                                class="pt-input min-h-[14rem] resize-y px-4 py-3 font-mono text-sm leading-6"
                                placeholder="first_name,last_name,country&#10;John,Smith,United States&#10;Aisha,Khan,Pakistan&#10;Oliver,Brown,United Kingdom"></textarea>
                        </div>

                        <div class="rounded-2xl border border-stone-200/70 bg-white px-4 py-4">
                            <div class="flex flex-wrap items-center justify-between gap-3">
                                <div class="flex flex-wrap gap-2 text-xs font-semibold">
                                    <span class="rounded-full border border-stone-200/70 bg-potato-beige/40 px-3 py-1.5 text-stone-600">Rows: <span id="csv-row-count">0</span></span>
                                    <span class="rounded-full border border-stone-200/70 bg-potato-beige/40 px-3 py-1.5 text-stone-600">Columns: <span id="csv-column-count">0</span></span>
                                    <span class="rounded-full border border-stone-200/70 bg-potato-beige/40 px-3 py-1.5 text-stone-600">Delimiter: <span id="csv-delimiter-label">Auto</span></span>
                                    <span id="csv-issue-chip" class="hidden rounded-full border border-red-200 bg-red-50 px-3 py-1.5 text-red-700">Issues: <span id="csv-issue-chip-count">0</span></span>
                                </div>
                            </div>
                        </div>

                        <p id="csv-inline-error" class="hidden rounded-xl border border-red-200 bg-red-50 px-3 py-2 text-xs font-semibold text-red-700"></p>
                    </div>

                    <div id="csv-convert-overlay" class="pt-form-overlay" aria-hidden="true" hidden>
                        <div class="pt-form-overlay-panel">
                            @include('components.loading-indicator', [
                                'id' => 'csv-convert-loading',
                                'label' => 'Converting CSV data...',
                                'class' => 'text-sm text-stone-600',
                                'hidden' => false,
                            ])
                        </div>
                    </div>
                </section>

                <section class="pt-card pt-card-elevated min-w-0 p-5 sm:p-6 lg:p-7" aria-live="polite">
                    <div class="flex flex-wrap items-start justify-between gap-4 border-b border-stone-200/70 pb-4">
                        <div class="max-w-xs">
                            <h2 class="text-2xl font-semibold text-stone-900">JSON Output</h2>
                            <p class="mt-1 text-sm leading-relaxed text-stone-500">Switch the output format, then copy or download the result.</p>
                        </div>

                        <div class="flex flex-wrap items-center justify-end gap-2">
                            <div class="inline-flex rounded-full border border-stone-200 bg-potato-beige/25 p-1">
                                <button
                                    type="button"
                                    id="json-format-pretty"
                                    class="json-format-toggle cursor-pointer rounded-full px-3 py-2 text-xs font-semibold transition"
                                    data-json-format-option="pretty"
                                    aria-pressed="true">
                                    Pretty JSON
                                </button>
                                <button
                                    type="button"
                                    id="json-format-minified"
                                    class="json-format-toggle cursor-pointer rounded-full px-3 py-2 text-xs font-semibold transition"
                                    data-json-format-option="minified"
                                    aria-pressed="false">
                                    Minified JSON
                                </button>
                            </div>

                            <button type="button" id="copy-json-output" class="pt-btn-secondary cursor-pointer px-4 py-2 disabled:cursor-not-allowed disabled:opacity-50" disabled>
                                <i class="fa-regular fa-copy" aria-hidden="true"></i>
                                Copy JSON
                            </button>
                            <button type="button" id="download-json-output" class="pt-btn-primary cursor-pointer px-4 py-2 disabled:cursor-not-allowed disabled:opacity-50" disabled>
                                <i class="fa-solid fa-download" aria-hidden="true"></i>
                                Download JSON
                            </button>
                        </div>
                    </div>

                    <div class="mt-5 rounded-2xl border border-stone-200/70 bg-potato-beige/25 p-4">
                        <div class="flex items-center justify-between gap-3 border-b border-stone-200/70 pb-3">
                            <div class="flex flex-wrap items-center gap-2">
                                <p class="text-sm font-semibold text-stone-700">Result</p>
                                <span class="inline-flex items-center gap-1.5 rounded-full border border-stone-200/70 bg-white px-2.5 py-1 text-[11px] font-semibold text-stone-500">
                                    <i class="fa-regular fa-pen-to-square text-primary/80" aria-hidden="true"></i>
                                    Editable output
                                </span>
                            </div>
                            <span id="json-output-state" class="text-xs font-medium text-stone-500"></span>
                        </div>

                        <div id="json-output-empty" class="flex min-h-[22rem] items-center justify-center px-4 py-8 text-center">
                            <div class="max-w-sm">
                                <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-white text-lg text-primary shadow-sm">
                                    <i class="fa-solid fa-file-code" aria-hidden="true"></i>
                                </span>
                                <p class="mt-4 text-base font-semibold text-stone-900">No JSON output yet</p>
                                <p class="mt-2 text-sm leading-relaxed text-stone-500">Paste CSV or upload a file to instantly generate JSON output.</p>
                            </div>
                        </div>

                        <textarea
                            id="json-output"
                            class="hidden mt-4 min-h-[30rem] w-full rounded-2xl border border-stone-200/70 bg-white px-4 py-4 font-mono text-sm leading-7 text-stone-800 outline-none ring-primary/20 focus:ring-2"
                            spellcheck="false"></textarea>
                    </div>
                </section>
            </div>

            <section class="pt-card pt-card-elevated min-w-0 p-5 sm:p-6 lg:p-7" aria-live="polite">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div class="max-w-2xl">
                        <p class="text-[11px] font-semibold uppercase tracking-[0.15em] text-accent">CSV Preview</p>
                        <h2 class="mt-2 text-2xl font-semibold text-stone-900">Quick preview before export</h2>
                        <p class="mt-2 text-sm leading-relaxed text-stone-600">Review the detected headers and first rows instantly. Open the full preview only when you need more detail.</p>
                    </div>

                    <button type="button" id="open-csv-preview" class="hidden cursor-pointer items-center gap-2 rounded-full border border-stone-200 bg-white px-4 py-2 text-xs font-semibold text-stone-700 shadow-sm transition hover:border-primary/45 hover:text-stone-900 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary/20">
                        <i class="fa-regular fa-eye text-primary" aria-hidden="true"></i>
                        View full preview
                    </button>
                </div>

                <div class="mt-5 overflow-hidden rounded-3xl border border-stone-200/70 bg-white">
                    <div id="csv-inline-preview-empty" class="px-5 py-10 text-center">
                        <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-potato-beige/50 text-lg text-primary">
                            <i class="fa-solid fa-table" aria-hidden="true"></i>
                        </span>
                        <p class="mt-4 text-base font-semibold text-stone-900">CSV preview will appear here</p>
                        <p class="mt-2 text-sm leading-relaxed text-stone-500">Upload a CSV file or paste CSV text to review the first rows immediately.</p>
                    </div>

                    <div id="csv-inline-preview-shell" class="hidden max-w-full overflow-auto">
                        <table class="w-full min-w-[56rem] border-separate border-spacing-0 text-left text-[13px] text-stone-700">
                            <thead id="csv-inline-preview-head" class="bg-stone-50/95 text-[11px] font-semibold uppercase tracking-[0.14em] text-stone-500"></thead>
                            <tbody id="csv-inline-preview-body" class="bg-white"></tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </section>

    <div id="csv-preview-modal" class="fixed inset-0 z-50 hidden" aria-hidden="true">
        <div id="csv-preview-modal-backdrop" class="absolute inset-0 bg-stone-950/45 backdrop-blur-[2px]"></div>

        <div class="relative flex min-h-full items-center justify-center p-4 sm:p-6">
            <section class="pt-card pt-card-elevated relative flex max-h-[90vh] w-full max-w-7xl flex-col overflow-hidden rounded-[2rem] bg-white" aria-live="polite" role="dialog" aria-modal="true" aria-labelledby="csv-preview-modal-title">
                <div class="flex flex-wrap items-start justify-between gap-4 border-b border-stone-200/70 px-5 py-4 sm:px-6">
                    <div class="max-w-2xl">
                        <p class="text-[11px] font-semibold uppercase tracking-[0.15em] text-accent">CSV Preview</p>
                        <h2 id="csv-preview-modal-title" class="mt-2 text-2xl font-semibold text-stone-900">Preview detected rows and headers</h2>
                        <p class="mt-2 text-sm leading-relaxed text-stone-600">Check the first rows before export.</p>
                    </div>

                    <div class="flex items-center gap-3">
                        <p id="csv-preview-note" class="text-xs leading-relaxed text-stone-500"></p>
                        <button type="button" id="close-csv-preview" class="inline-flex h-11 w-11 cursor-pointer items-center justify-center rounded-full border border-stone-200 bg-white text-stone-500 transition hover:border-primary/40 hover:text-primary focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary/20" aria-label="Close CSV preview">
                            <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>

                <div id="csv-preview-layout" class="grid min-h-0 flex-1 gap-4 overflow-hidden p-5 sm:p-6 xl:grid-cols-[minmax(0,1fr)_320px]">
                    <div class="min-w-0 overflow-hidden rounded-3xl border border-stone-200/70 bg-white">
                        <div id="csv-preview-empty" class="px-5 py-12 text-center">
                            <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-potato-beige/50 text-lg text-primary">
                                <i class="fa-solid fa-table" aria-hidden="true"></i>
                            </span>
                            <p class="mt-4 text-base font-semibold text-stone-900">CSV preview will appear here</p>
                        </div>

                        <div id="csv-preview-shell" class="hidden max-h-[60vh] max-w-full overflow-auto">
                            <table class="w-full min-w-[68rem] border-separate border-spacing-0 text-left text-[13px] text-stone-700">
                                <thead id="csv-preview-head" class="bg-stone-50/95 text-[11px] font-semibold uppercase tracking-[0.14em] text-stone-500 backdrop-blur"></thead>
                                <tbody id="csv-preview-body" class="bg-white"></tbody>
                            </table>
                        </div>

                        <div id="csv-preview-pagination" class="hidden border-t border-stone-200/70 px-4 py-3">
                            <div class="flex flex-wrap items-center justify-between gap-3">
                                <p id="csv-preview-page-summary" class="text-xs font-medium text-stone-500"></p>
                                <div class="flex items-center gap-2">
                                    <button type="button" id="csv-preview-first" class="pt-btn-secondary px-3 py-1.5 text-xs disabled:cursor-not-allowed disabled:opacity-50">
                                        <i class="fa-solid fa-angles-left" aria-hidden="true"></i>
                                        First
                                    </button>
                                    <button type="button" id="csv-preview-prev" class="pt-btn-secondary px-3 py-1.5 text-xs disabled:cursor-not-allowed disabled:opacity-50">
                                        <i class="fa-solid fa-chevron-left" aria-hidden="true"></i>
                                        Previous
                                    </button>
                                    <div id="csv-preview-page-buttons" class="flex items-center gap-1"></div>
                                    <button type="button" id="csv-preview-next" class="pt-btn-secondary px-3 py-1.5 text-xs disabled:cursor-not-allowed disabled:opacity-50">
                                        Next
                                        <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
                                    </button>
                                    <button type="button" id="csv-preview-last" class="pt-btn-secondary px-3 py-1.5 text-xs disabled:cursor-not-allowed disabled:opacity-50">
                                        Last
                                        <i class="fa-solid fa-angles-right" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <aside id="csv-issues-panel" class="hidden overflow-hidden rounded-3xl border border-red-200/80 bg-red-50/55 p-4 sm:p-5">
                        <div class="flex flex-wrap items-start justify-between gap-3">
                            <div>
                                <p class="text-[11px] font-semibold uppercase tracking-[0.15em] text-red-700">Validation Errors</p>
                                <h2 class="mt-2 text-lg font-semibold text-red-950">Review parsing issues</h2>
                            </div>
                            <span id="csv-issue-count" class="rounded-full border border-red-200 bg-white px-3 py-1.5 text-xs font-semibold text-red-700">0 issues</span>
                        </div>

                        <p id="csv-issue-summary" class="mt-4 text-sm leading-relaxed text-red-900/80">
                            No parsing issues yet. Upload a file or paste CSV text to validate it live.
                        </p>

                        <ul id="csv-issues-list" class="mt-4 max-h-[52vh] list-disc space-y-2 overflow-y-auto pl-5 pr-1 text-sm leading-relaxed text-red-900 marker:text-red-500"></ul>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <section class="pt-container pt-16 pb-6 sm:pt-20">
        <div class="pt-soft-section bg-[#efe5d8] px-5 py-8 sm:px-8 sm:py-10">
            <div class="max-w-4xl">
                <p class="text-xs font-semibold uppercase tracking-[0.08em] text-stone-500">How It Works</p>
                <h2 class="mt-2 text-3xl font-semibold text-stone-900 sm:text-4xl">How this CSV to JSON converter works</h2>
                <p class="mt-3 text-sm leading-relaxed text-stone-700 sm:text-base">
                    This tool reads CSV text in the browser, detects the table structure, converts rows into JSON objects, and lets you export the result immediately.
                </p>
            </div>

            <div class="mt-6 grid gap-4 md:grid-cols-3">
                <article class="pt-soft-card p-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-stone-500">Step 1</p>
                    <h3 class="mt-3 text-lg font-semibold text-stone-900">Add CSV data</h3>
                    <p class="mt-2 text-sm leading-relaxed text-stone-600">
                        Paste CSV directly or drop a file into the uploader. The page reads the file locally without a manual submit step.
                    </p>
                </article>

                <article class="pt-soft-card p-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-stone-500">Step 2</p>
                    <h3 class="mt-3 text-lg font-semibold text-stone-900">Review table structure</h3>
                    <p class="mt-2 text-sm leading-relaxed text-stone-600">
                        The parser auto-detects the delimiter, uses headers when available, and flags inconsistent rows in the CSV preview.
                    </p>
                </article>

                <article class="pt-soft-card p-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-stone-500">Step 3</p>
                    <h3 class="mt-3 text-lg font-semibold text-stone-900">Copy or download JSON</h3>
                    <p class="mt-2 text-sm leading-relaxed text-stone-600">
                        Adjust formatting and cleanup options, then copy the JSON text or download a ready-to-use <span class="font-mono">.json</span> file.
                    </p>
                </article>
            </div>
        </div>
    </section>

    @include('components.faqs.accordion', [
        'section' => $homePageData['faqs']['csv_to_json_converter'] ?? [],
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
            <article class="pt-soft-card p-4">
                <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-primary/10 text-primary">
                    <i class="fa-solid fa-broom" aria-hidden="true"></i>
                </span>
                <h3 class="mt-3 text-base font-semibold text-stone-900">CSV Cleaner</h3>
                <p class="mt-2 text-xs leading-relaxed text-stone-600">Standardize values and fix messy CSV data before export.</p>
                <button type="button" class="pt-btn-secondary mt-3" disabled>Coming soon</button>
            </article>

            <article class="pt-soft-card p-4">
                <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-primary/10 text-primary">
                    <i class="fa-solid fa-file-csv" aria-hidden="true"></i>
                </span>
                <h3 class="mt-3 text-base font-semibold text-stone-900">JSON to CSV Converter</h3>
                <p class="mt-2 text-xs leading-relaxed text-stone-600">Turn JSON arrays back into spreadsheet-ready CSV rows.</p>
                <button type="button" class="pt-btn-secondary mt-3" disabled>Coming soon</button>
            </article>

            <article class="pt-soft-card p-4">
                <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-primary/10 text-primary">
                    <i class="fa-solid fa-copy" aria-hidden="true"></i>
                </span>
                <h3 class="mt-3 text-base font-semibold text-stone-900">CSV Duplicate Remover</h3>
                <p class="mt-2 text-xs leading-relaxed text-stone-600">Remove duplicate rows from large CSV files with one clean pass.</p>
                <button type="button" class="pt-btn-secondary mt-3" disabled>Coming soon</button>
            </article>

            <article class="pt-soft-card p-4">
                <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-primary/10 text-primary">
                    <i class="fa-solid fa-key" aria-hidden="true"></i>
                </span>
                <h3 class="mt-3 text-base font-semibold text-stone-900">JWT Decoder</h3>
                <p class="mt-2 text-xs leading-relaxed text-stone-600">Decode token headers and payloads quickly while inspecting JSON output.</p>
                <button type="button" class="pt-btn-secondary mt-3" disabled>Coming soon</button>
            </article>
        </div>
    </section>
@endsection
