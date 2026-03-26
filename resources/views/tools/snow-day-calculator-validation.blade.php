@extends('layouts.app')

@php
    $records = data_get($validation ?? [], 'records', []);
    $owner = data_get($validation ?? [], 'owner', 'PotatoTools Editorial and Engineering Team');
    $datasetName = data_get($validation ?? [], 'dataset_name', 'PotatoTools Snow Day Validation Set');
    $datasetVersion = data_get($validation ?? [], 'dataset_version', '2026-03-24');
    $coverageNote = data_get($validation ?? [], 'coverage_note', '');
    $closureCount = collect($records)->where('outcome', 'Closed')->count();
    $delayCount = collect($records)->filter(function ($record) {
        return str_contains(strtolower($record['outcome'] ?? ''), 'delay');
    })->count();
    $remoteCount = collect($records)->filter(function ($record) {
        return str_contains(strtolower($record['outcome'] ?? ''), 'virtual');
    })->count();
@endphp

@section('title', 'Snow Day Calculator Validation Results - PotatoTools')
@section('description', 'Review the public district notices used as a transparent benchmark set for the PotatoTools snow day calculator.')
@section('canonical', route('tools.snow-day-calculator.validation'))

@push('head')
    <script type="application/ld+json">{!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'Dataset',
        'name' => $datasetName,
        'description' => $coverageNote,
        'creator' => [
            '@type' => 'Organization',
            'name' => $owner,
        ],
        'dateModified' => $datasetVersion,
        'url' => route('tools.snow-day-calculator.validation'),
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
@endpush

@section('content')
    <section class="pt-container pt-8 pb-10 sm:pt-10 sm:pb-12 lg:pt-12 lg:pb-14">
        <nav aria-label="Breadcrumb" class="text-xs text-stone-500">
            <ol class="flex flex-wrap items-center gap-2">
                <li><a href="{{ route('home') }}" class="hover:text-primary">Home</a></li>
                <li aria-hidden="true">&gt;</li>
                <li><a href="{{ route('home') }}#pick-potato" class="hover:text-primary">Tools</a></li>
                <li aria-hidden="true">&gt;</li>
                <li><a href="{{ route('tools.snow-day-calculator') }}" class="hover:text-primary">Snow Day Calculator</a></li>
                <li aria-hidden="true">&gt;</li>
                <li aria-current="page" class="font-semibold text-primary">Validation Results</li>
            </ol>
        </nav>

        <div class="mt-5">
            <div class="pt-page-title-row">
                <span class="pt-page-title-icon" aria-hidden="true">
                    <i class="fa-solid fa-snowflake"></i>
                </span>
                <h1 class="text-3xl font-semibold text-stone-900 sm:text-5xl">Snow Day Validation Results</h1>
            </div>
            <p class="mt-4 max-w-3xl text-sm leading-relaxed text-stone-600 sm:text-base">
                {{ $coverageNote }}
            </p>

            <div class="mt-5 flex flex-wrap gap-2">
                <span class="pt-chip pt-chip-static"><i class="fa-solid fa-database text-accent" aria-hidden="true"></i> {{ count($records) }} audited notices</span>
                <span class="pt-chip pt-chip-static"><i class="fa-solid fa-calendar-check text-accent" aria-hidden="true"></i> Dataset {{ $datasetVersion }}</span>
                <span class="pt-chip pt-chip-static"><i class="fa-solid fa-building text-accent" aria-hidden="true"></i> {{ $owner }}</span>
            </div>
        </div>

        <div class="mt-8 grid gap-4 md:grid-cols-3">
            <article class="pt-soft-card p-5">
                <p class="text-xs font-semibold uppercase tracking-[0.12em] text-stone-500">Closures</p>
                <h2 class="mt-3 text-3xl font-semibold text-stone-900">{{ $closureCount }}</h2>
                <p class="mt-2 text-sm text-stone-600">Full closure notices in the benchmark set.</p>
            </article>
            <article class="pt-soft-card p-5">
                <p class="text-xs font-semibold uppercase tracking-[0.12em] text-stone-500">Delays</p>
                <h2 class="mt-3 text-3xl font-semibold text-stone-900">{{ $delayCount }}</h2>
                <p class="mt-2 text-sm text-stone-600">Delayed-opening notices in the benchmark set.</p>
            </article>
            <article class="pt-soft-card p-5">
                <p class="text-xs font-semibold uppercase tracking-[0.12em] text-stone-500">Remote Days</p>
                <h2 class="mt-3 text-3xl font-semibold text-stone-900">{{ $remoteCount }}</h2>
                <p class="mt-2 text-sm text-stone-600">Virtual-learning days used as travel-disruption references.</p>
            </article>
        </div>

        <section class="mt-8 pt-card pt-card-elevated overflow-hidden">
            <div class="border-b border-stone-200/70 px-5 py-4 sm:px-6">
                <p class="text-xs font-semibold uppercase tracking-[0.12em] text-stone-500">Benchmark Log</p>
                <h2 class="mt-2 text-2xl font-semibold text-stone-900">Public district notices</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm text-stone-700">
                    <thead class="bg-stone-50 text-xs font-semibold uppercase tracking-[0.12em] text-stone-500">
                        <tr>
                            <th class="px-5 py-4 sm:px-6">Date</th>
                            <th class="px-5 py-4 sm:px-6">District</th>
                            <th class="px-5 py-4 sm:px-6">Outcome</th>
                            <th class="px-5 py-4 sm:px-6">Expected Band</th>
                            <th class="px-5 py-4 sm:px-6">Reason</th>
                            <th class="px-5 py-4 sm:px-6">Source</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-200/70 bg-white">
                        @foreach ($records as $record)
                            <tr>
                                <td class="px-5 py-4 align-top sm:px-6">{{ $record['date'] ?? '' }}</td>
                                <td class="px-5 py-4 align-top sm:px-6">
                                    <p class="font-semibold text-stone-900">{{ $record['district'] ?? '' }}</p>
                                    <p class="mt-1 text-xs text-stone-500">{{ $record['state'] ?? '' }}</p>
                                </td>
                                <td class="px-5 py-4 align-top sm:px-6">{{ $record['outcome'] ?? '' }}</td>
                                <td class="px-5 py-4 align-top sm:px-6">{{ $record['target_band'] ?? '' }}</td>
                                <td class="px-5 py-4 align-top sm:px-6">{{ $record['reason'] ?? '' }}</td>
                                <td class="px-5 py-4 align-top sm:px-6">
                                    <a href="{{ $record['source_url'] ?? '#' }}" target="_blank" rel="noopener noreferrer" class="pt-link-arrow inline-flex items-center gap-1.5 text-sm font-semibold text-primary">
                                        Source
                                        <span class="pt-link-arrow-icon" aria-hidden="true">&rarr;</span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </section>

    <section class="pt-container pb-8 sm:pb-10">
        <div class="pt-soft-section bg-[#efe5d8] px-5 py-8 sm:px-8 sm:py-10">
            <p class="text-xs font-semibold uppercase tracking-[0.08em] text-stone-500">Scope Note</p>
            <h2 class="mt-2 text-3xl font-semibold text-stone-900">What this page does and does not prove</h2>
            <div class="mt-6 grid gap-4 md:grid-cols-2">
                <article class="pt-soft-card p-5">
                    <h3 class="text-lg font-semibold text-stone-900">What it adds</h3>
                    <p class="mt-2 text-sm leading-relaxed text-stone-600">
                        This page publishes real public district operating notices so users and search engines can see the benchmark cases behind the model review process.
                    </p>
                </article>
                <article class="pt-soft-card p-5">
                    <h3 class="text-lg font-semibold text-stone-900">What is still missing</h3>
                    <p class="mt-2 text-sm leading-relaxed text-stone-600">
                        This is a starter benchmark set, not a full nationwide closure-history feed. Larger backtesting still needs a broader district-level data pipeline.
                    </p>
                </article>
            </div>

            <div class="mt-6 flex flex-wrap gap-3">
                <a href="{{ route('tools.snow-day-calculator.methodology') }}" class="pt-btn-secondary">Read methodology</a>
                <a href="{{ route('tools.snow-day-calculator') }}" class="pt-btn-primary">Back to calculator</a>
            </div>
        </div>
    </section>
@endsection
