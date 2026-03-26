@extends('layouts.app')

@php
    $weights = data_get($methodology ?? [], 'weights', []);
    $dataSources = data_get($methodology ?? [], 'data_sources', []);
    $limitations = data_get($methodology ?? [], 'limitations', []);
    $nextSteps = data_get($methodology ?? [], 'next_steps', []);
    $owner = data_get($methodology ?? [], 'owner', 'PotatoTools Editorial and Engineering Team');
    $version = data_get($methodology ?? [], 'model_version', '2.0.0');
    $updated = data_get($methodology ?? [], 'last_updated', '2026-03-24');
    $summary = data_get($methodology ?? [], 'summary', '');
@endphp

@section('title', 'Snow Day Calculator Methodology - PotatoTools')
@section('description', 'Read the methodology behind the PotatoTools snow day calculator, including data sources, weights, assumptions, and known limitations.')
@section('canonical', route('tools.snow-day-calculator.methodology'))

@push('head')
    <script type="application/ld+json">{!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'TechArticle',
        'headline' => 'Snow Day Calculator Methodology',
        'author' => [
            '@type' => 'Organization',
            'name' => $owner,
        ],
        'publisher' => [
            '@type' => 'Organization',
            'name' => 'PotatoTools',
        ],
        'dateModified' => $updated,
        'mainEntityOfPage' => route('tools.snow-day-calculator.methodology'),
        'description' => 'Methodology for the PotatoTools snow day calculator, including local history normalization, weights, limits, and public references.',
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
                <li aria-current="page" class="font-semibold text-primary">Methodology</li>
            </ol>
        </nav>

        <div class="mt-5">
            <div class="pt-page-title-row">
                <span class="pt-page-title-icon" aria-hidden="true">
                    <i class="fa-solid fa-snowflake"></i>
                </span>
                <h1 class="text-3xl font-semibold text-stone-900 sm:text-5xl">Snow Day Calculator Methodology</h1>
            </div>
            <p class="mt-4 max-w-3xl text-sm leading-relaxed text-stone-600 sm:text-base">
                {{ $summary }}
            </p>

            <div class="mt-5 flex flex-wrap gap-2">
                <span class="pt-chip pt-chip-static"><i class="fa-solid fa-code-branch text-accent" aria-hidden="true"></i> Version {{ $version }}</span>
                <span class="pt-chip pt-chip-static"><i class="fa-solid fa-calendar-check text-accent" aria-hidden="true"></i> Updated {{ $updated }}</span>
                <span class="pt-chip pt-chip-static"><i class="fa-solid fa-building text-accent" aria-hidden="true"></i> {{ $owner }}</span>
            </div>
        </div>

        <div class="mt-8 grid gap-5 lg:grid-cols-[minmax(0,1.15fr)_minmax(280px,0.85fr)]">
            <section class="pt-card pt-card-elevated p-5 sm:p-6 lg:p-7">
                <p class="text-xs font-semibold uppercase tracking-[0.12em] text-stone-500">Model Design</p>
                <h2 class="mt-2 text-2xl font-semibold text-stone-900">How the score is built</h2>

                <div class="mt-6 space-y-4">
                    @foreach ($weights as $weight)
                        <article class="rounded-2xl border border-stone-200/70 bg-white px-4 py-4">
                            <div class="flex flex-wrap items-center justify-between gap-3">
                                <h3 class="text-lg font-semibold text-stone-900">{{ $weight['label'] ?? '' }}</h3>
                                <span class="rounded-full bg-primary/10 px-3 py-1 text-xs font-semibold text-primary">
                                    {{ isset($weight['weight']) ? number_format(($weight['weight'] * 100), 0) . '%' : '' }}
                                </span>
                            </div>
                            <p class="mt-2 text-sm leading-relaxed text-stone-600">{{ $weight['method'] ?? '' }}</p>
                        </article>
                    @endforeach
                </div>
            </section>

            <aside class="space-y-5">
                <section class="pt-card pt-card-elevated p-5 sm:p-6">
                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-stone-500">Public Sources</p>
                    <ul class="mt-4 space-y-3 text-sm text-stone-600">
                        @foreach ($dataSources as $source)
                            <li class="rounded-2xl border border-stone-200/70 bg-white px-4 py-4">
                                <p class="font-semibold text-stone-900">{{ $source['name'] ?? '' }}</p>
                                <p class="mt-1">{{ $source['role'] ?? '' }}</p>
                                <a href="{{ $source['url'] ?? '#' }}" target="_blank" rel="noopener noreferrer" class="mt-2 inline-flex items-center gap-1.5 text-sm font-semibold text-primary">
                                    Open source
                                    <span aria-hidden="true">&rarr;</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </section>

                <section class="pt-card pt-card-elevated p-5 sm:p-6">
                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-stone-500">Known Limits</p>
                    <ul class="mt-4 space-y-3 text-sm text-stone-600">
                        @foreach ($limitations as $item)
                            <li class="rounded-2xl border border-stone-200/70 bg-white px-4 py-3">{{ $item }}</li>
                        @endforeach
                    </ul>
                </section>
            </aside>
        </div>
    </section>

    <section class="pt-container pb-8 sm:pb-10">
        <div class="pt-soft-section bg-[#efe5d8] px-5 py-8 sm:px-8 sm:py-10">
            <p class="text-xs font-semibold uppercase tracking-[0.08em] text-stone-500">Validation Roadmap</p>
            <h2 class="mt-2 text-3xl font-semibold text-stone-900">What happens next</h2>
            <div class="mt-6 grid gap-4 md:grid-cols-3">
                @foreach ($nextSteps as $step)
                    <article class="pt-soft-card p-5">
                        <p class="text-sm leading-relaxed text-stone-700">{{ $step }}</p>
                    </article>
                @endforeach
            </div>

            <div class="mt-6 flex flex-wrap gap-3">
                <a href="{{ route('tools.snow-day-calculator.validation') }}" class="pt-btn-secondary">View validation page</a>
                <a href="{{ route('tools.snow-day-calculator') }}" class="pt-btn-primary">Back to calculator</a>
            </div>
        </div>
    </section>
@endsection
