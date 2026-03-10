@extends('layouts.app')

@section('title', 'PotatoTools - Simple online converters and calculators')
@section('description', 'Use clean, practical calculators and converters. Start with the Height Calculator and get instant accurate results.')
@section('canonical', route('home'))

@section('content')
    <section class="pt-container py-12 lg:py-16">
        <div class="grid items-center gap-10 lg:grid-cols-2">
            <div>
                <p class="mb-5 inline-flex items-center gap-2 rounded-full border border-accent/25 bg-accent/10 px-4 py-2 text-xs font-semibold text-accent">
                    <span class="h-2 w-2 rounded-full bg-accent"></span>
                    No login • No signup • 100% private
                </p>
                <h1 class="max-w-md text-4xl font-semibold leading-[1.05] text-stone-900 sm:text-5xl">
                    Powerful online tools as easy as <span class="text-primary">peeling a potato!</span>
                </h1>
                <p class="mt-5 max-w-md text-base text-stone-600">
                    PotatoTools was built on one simple idea — powerful tools should be easy for everyone. We create fast, professional, and user-friendly online tools that solve your tasks instantly. No login. No signup. No complexity.
                </p>
                <div class="mt-7 flex flex-wrap gap-3">
                    <a href="{{ route('tools.height-calculator') }}" class="pt-btn-primary px-6 py-3">Start Using Tools</a>
                    <a href="#pick-potato" class="pt-btn-secondary px-6 py-3">Browse All Tools</a>
                </div>
                <div class="mt-6 inline-flex items-center gap-3 rounded-full bg-white/70 px-4 py-2 shadow-sm">
                    <span class="inline-flex items-center -space-x-1.5">
                        <span class="h-5 w-5 rounded-full border border-white bg-[#f6d57c]"></span>
                        <span class="h-5 w-5 rounded-full border border-white bg-[#f1c356]"></span>
                        <span class="h-5 w-5 rounded-full border border-white bg-[#e3af2f]"></span>
                    </span>
                    <span class="text-xs font-semibold text-stone-600">Trusted by thousands of users worldwide.!</span>
                </div>
            </div>

            <div class="relative mx-auto w-full max-w-md">
                <div class="pt-soft-card relative p-5">
                    <div class="h-[360px] w-full overflow-hidden rounded-2xl border border-stone-200/70 bg-white">
                        <img
                            src="{{ asset('images/hero-section.png') }}"
                            alt="PotatoTools hero mascot"
                            class="h-full w-full object-cover"
                            loading="eager"
                            decoding="async">
                    </div>
                    <div class="absolute -top-4 right-4 rotate-[8deg] rounded-2xl border border-stone-200/80 bg-white px-4 py-3 text-[11px] font-semibold text-accent shadow-sm">
                        Instant results
                    </div>
                    <div class="absolute -bottom-6 left-5 flex w-52 items-center gap-2 rounded-2xl border border-stone-200/80 bg-white px-3 py-3 shadow-sm">
                        <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-primary/15 text-xs font-bold text-primary">OK</span>
                        <div>
                            <p class="text-sm font-semibold text-stone-800">I'm Tater!</p>
                            <p class="text-xs text-stone-500">Let's solve your task the easy way.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @php
        $homePageData = $homePageData ?? [];
    @endphp

    @include('components.home.browse-tools-by-category', ['section' => $homePageData['browse_tools_by_category'] ?? []])
    @include('components.home.popular-tools', ['section' => $homePageData['popular_tools'] ?? []])
    @include('components.home.tools-grid', ['section' => $homePageData['tools_grid'] ?? []])
    @include('components.recently-added-tools', ['section' => $homePageData['recently_added_tools'] ?? []])

    
    <section class="pt-container mt-12 pt-12">
        <div class="pt-soft-section relative bg-[#efe5d8] px-5 py-12 sm:px-10">
            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-2">
                <div class="text-left">
                    <p class="text-xs font-semibold uppercase tracking-[0.08em] text-stone-500">WHY CHOOSE POTATOTOOLS</p>
                    <h2 class="mt-2 text-4xl font-semibold text-stone-900">Why Choose PotatoTools?</h2>
                    <p class="mt-2 max-w-xl text-sm leading-relaxed text-stone-600">Fast, private, and easy-to-use online tools — no login, no complexity.</p>

                    <ul class="mt-6 space-y-3 text-sm text-stone-700">
                        <li class="flex items-start gap-3">
                            <span class="mt-0.5 inline-flex h-6 w-6 items-center justify-center rounded-full bg-primary/10 text-primary">
                                <i class="fa-solid fa-bolt text-xs" aria-hidden="true"></i>
                            </span>
                            <span>Instant results in seconds</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="mt-0.5 inline-flex h-6 w-6 items-center justify-center rounded-full bg-primary/10 text-primary">
                                <i class="fa-solid fa-eye-slash text-xs" aria-hidden="true"></i>
                            </span>
                            <span>Privacy-first: no tracking, no data stored</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="mt-0.5 inline-flex h-6 w-6 items-center justify-center rounded-full bg-primary/10 text-primary">
                                <i class="fa-solid fa-star text-xs" aria-hidden="true"></i>
                            </span>
                            <span>Free tools you can use anytime</span>
                        </li>
                    </ul>

                    <div class="mt-6">
                        <a
                            href="{{ url('/tools') }}"
                            aria-label="Browse all tools"
                            class="pt-link-arrow inline-flex items-center gap-1.5 font-semibold text-primary transition-colors duration-200 focus-visible:rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary/40 focus-visible:ring-offset-2">
                            Browse all tools
                            <span class="pt-link-arrow-icon" aria-hidden="true">&rarr;</span>
                        </a>
                        <p class="mt-1 text-xs text-stone-500">No signup required.</p>
                    </div>
                </div>

                <div class="p-4 sm:p-5">
                    <img
                        src="{{ asset('images/why_choose_us.png') }}"
                        alt="Why choose PotatoTools visual"
                        class="h-full w-full object-cover"
                        loading="lazy"
                        decoding="async">
                </div>
            </div>
        </div>
    </section>

    <section class="pt-container mt-10 pt-6 pb-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            
            <article class="pt-soft-card p-6 text-left transition-all duration-200 hover:-translate-y-1 hover:shadow-lg">
                <div class="pt-image-placeholder inline-flex w-fit shrink-0 rounded-2xl bg-white px-3 py-1.5 shadow-sm">
                    <i class="fa-solid fa-bolt text-base text-primary"></i>
                </div>
                <h3 class="mt-3 text-base font-extrabold text-stone-900">Fast</h3>
                <p class="mt-1 text-sm text-stone-600">Processed in milliseconds</p>
            </article>

            <article class="pt-soft-card p-6 text-left transition-all duration-200 hover:-translate-y-1 hover:shadow-lg">
                <div class="pt-image-placeholder inline-flex w-fit shrink-0 rounded-2xl bg-white px-3 py-1.5 shadow-sm">
                    <i class="fa-solid fa-shield-halved text-base text-primary"></i>
                </div>
                <h3 class="mt-3 text-base font-extrabold text-stone-900">Secure</h3>
                <p class="mt-1 text-sm text-stone-600">Industry-standard security</p>
            </article>

            <article class="pt-soft-card p-6 text-left transition-all duration-200 hover:-translate-y-1 hover:shadow-lg">
                <div class="pt-image-placeholder inline-flex w-fit shrink-0 rounded-2xl bg-white px-3 py-1.5 shadow-sm">
                    <i class="fa-solid fa-eye-slash text-base text-primary"></i>
                </div>
                <h3 class="mt-3 text-base font-extrabold text-stone-900">No Data Stored</h3>
                <p class="mt-1 text-sm text-stone-600">We never see your input</p>
            </article>

            <article class="pt-soft-card p-6 text-left transition-all duration-200 hover:-translate-y-1 hover:shadow-lg">
                <div class="pt-image-placeholder inline-flex w-fit shrink-0 rounded-2xl bg-white px-3 py-1.5 shadow-sm">
                    <i class="fa-solid fa-star text-base text-primary"></i>
                </div>
                <h3 class="mt-3 text-base font-extrabold text-stone-900">Free Forever</h3>
                <p class="mt-1 text-sm text-stone-600">No trial, no credit card</p>
            </article>

        </div>
    </section>

    <section class="pt-container pt-16 pb-4">
        <div class="pt-soft-section relative bg-[#efe5d8] px-5 py-12 sm:px-10">
            <div class="mx-auto max-w-5xl">
                <p class="text-xs font-semibold uppercase tracking-[0.08em] text-stone-500">HOW IT WORKS</p>
                <h2 class="mt-2 text-4xl font-semibold text-stone-900">From Problem to Result in 3 Simple Steps</h2>
                <p class="mt-2 max-w-3xl text-sm text-stone-600">Pick a tool, solve your task, and get instant results — no login, no complexity.</p>

                <div class="mt-6 flex flex-col gap-2 sm:flex-row sm:items-center">
                    <p class="text-sm text-stone-600">Want to explore everything?</p>
                    <a
                        href="{{ url('/tools') }}"
                        aria-label="Browse all tools"
                        class="pt-link-arrow inline-flex items-center gap-1.5 font-semibold text-primary transition-colors duration-200 focus-visible:rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary/40 focus-visible:ring-offset-2 sm:ml-auto">
                        Browse all tools
                        <span class="pt-link-arrow-icon" aria-hidden="true">&rarr;</span>
                    </a>
                </div>
            </div>

            <div class="mt-10 grid grid-cols-1 items-stretch gap-5 md:grid-cols-3">
                <article class="pt-soft-card flex h-full flex-col p-5 text-left transition-all duration-200 hover:-translate-y-0.5 hover:shadow-lg focus-within:-translate-y-0.5 focus-within:shadow-lg sm:p-6">
                    <div class="flex items-center justify-between gap-3">
                        <span class="inline-flex items-center rounded-full border border-primary/25 bg-primary/10 px-3 py-1.5 text-xs font-semibold leading-none tracking-[0.08em] text-primary">01</span>
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-primary/10 text-primary">
                            <i class="fa-solid fa-magnifying-glass text-xs" aria-hidden="true"></i>
                        </span>
                    </div>
                    <h3 class="mt-4 text-lg font-extrabold text-stone-900">Pick a Potato</h3>
                    <p class="mt-2 text-sm leading-relaxed text-stone-600">Choose the perfect tool for your task.</p>
                </article>

                <article class="pt-soft-card flex h-full flex-col p-5 text-left transition-all duration-200 hover:-translate-y-0.5 hover:shadow-lg focus-within:-translate-y-0.5 focus-within:shadow-lg sm:p-6">
                    <div class="flex items-center justify-between gap-3">
                        <span class="inline-flex items-center rounded-full border border-primary/25 bg-primary/10 px-3 py-1.5 text-xs font-semibold leading-none tracking-[0.08em] text-primary">02</span>
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-primary/10 text-primary">
                            <i class="fa-solid fa-keyboard text-xs" aria-hidden="true"></i>
                        </span>
                    </div>
                    <h3 class="mt-4 text-lg font-extrabold text-stone-900">Peel the Problem</h3>
                    <p class="mt-2 text-sm leading-relaxed text-stone-600">Enter details and let the tool do the work.</p>
                </article>

                <article class="pt-soft-card flex h-full flex-col p-5 text-left transition-all duration-200 hover:-translate-y-0.5 hover:shadow-lg focus-within:-translate-y-0.5 focus-within:shadow-lg sm:p-6">
                    <div class="flex items-center justify-between gap-3">
                        <span class="inline-flex items-center rounded-full border border-primary/25 bg-primary/10 px-3 py-1.5 text-xs font-semibold leading-none tracking-[0.08em] text-primary">03</span>
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-primary/10 text-primary">
                            <i class="fa-solid fa-bolt text-xs" aria-hidden="true"></i>
                        </span>
                    </div>
                    <h3 class="mt-4 text-lg font-extrabold text-stone-900">Get Instant Results</h3>
                    <p class="mt-2 text-sm leading-relaxed text-stone-600">Copy, download, or use results instantly.</p>
                </article>
            </div>
        </div>
    </section>
    @include('components.tool-request', ['section' => $homePageData['tool_request'] ?? []])
    @include('components.faqs.accordion', [
        'section' => $homePageData['faqs']['home'] ?? [],
        'sectionClass' => 'pt-container mt-10 pt-6 pb-6',
        'wrapperClass' => 'relative bg-transparent px-5 py-12 sm:px-10',
        'contentClass' => 'mx-auto max-w-5xl',
        'titleClass' => 'mt-2 text-4xl font-semibold text-stone-900',
        'itemsWrapperClass' => 'mt-8 space-y-3',
        'enableSchema' => true,
    ])
@endsection
