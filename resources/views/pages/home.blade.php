@extends('layouts.app')

@section('title', 'PotatoTools - Simple online converters and calculators')
@section('description', 'Use clean, practical calculators and converters. Start with the Height Converter and get instant accurate results.')
@section('canonical', route('home'))

@section('content')
    <section class="pt-container py-12 lg:py-16">
        <div class="grid items-center gap-8 lg:grid-cols-[minmax(0,1fr)_minmax(420px,0.96fr)] xl:gap-10">
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
                    <a href="{{ route('tools.height-converter') }}" class="pt-btn-primary px-6 py-3">Start Using Tools</a>
                    <a href="#pick-potato" class="pt-btn-secondary px-6 py-3">Browse All Tools</a>
                </div>
                <div class="mt-6 inline-flex items-center gap-3 rounded-full bg-white/70 px-4 py-2 shadow-sm">
                    <span class="inline-flex items-center -space-x-1.5">
                        <img
                            src="{{ asset('images/potato.png') }}"
                            alt="PotatoTools mascot"
                            class="h-7 w-7 rounded-full border-2 border-white object-cover bg-[#f6d57c]"
                            loading="lazy"
                            decoding="async">
                        <img
                            src="{{ asset('images/pick_a_potato.png') }}"
                            alt="Pick a Potato illustration"
                            class="h-7 w-7 rounded-full border-2 border-white object-cover bg-[#f1c356]"
                            loading="lazy"
                            decoding="async">
                        <img
                            src="{{ asset('images/peel_a_potato.png') }}"
                            alt="Peel a Potato illustration"
                            class="h-7 w-7 rounded-full border-2 border-white object-cover bg-[#e3af2f]"
                            loading="lazy"
                            decoding="async">
                    </span>
                    <span class="text-xs font-semibold text-stone-600">Trusted by thousands of users worldwide.!</span>
                </div>
            </div>

            <div class="relative w-full max-w-[30rem] lg:ml-auto lg:mr-0">
                <div class="pt-soft-card relative p-5">
                    <div class="h-[360px] w-full overflow-hidden rounded-2xl border border-stone-200/70 bg-white">
                        <img
                            src="{{ asset('images/hero-section.png') }}"
                            alt="PotatoTools hero mascot"
                            class="h-full w-full object-cover"
                            loading="eager"
                            decoding="async">
                    </div>
                    <div class="absolute -right-2 -top-5 rotate-[11deg] rounded-2xl border border-stone-200/80 bg-white px-4 py-3 text-[11px] font-semibold text-accent shadow-sm">
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
                    <p class="mt-4 max-w-xl text-sm leading-relaxed text-stone-600">
                        Every tool is designed to feel direct and understandable. You should know what to enter, what result you will get, and what to do next without needing technical knowledge.
                    </p>
                    <p class="mt-3 max-w-xl text-sm leading-relaxed text-stone-600">
                        We focus on clean layouts, simple wording, and fast answers so the experience feels useful from the first click.
                    </p>

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

    <section class="pt-container mt-8 pb-4">
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">
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
        <div class="pt-soft-section relative overflow-hidden bg-[#efe5d8] px-5 py-12 sm:px-8 lg:px-10">
            <div class="absolute right-8 top-8 hidden h-40 w-40 rounded-full bg-white/35 blur-3xl lg:block" aria-hidden="true"></div>
            <div class="grid gap-8 xl:grid-cols-[minmax(0,1fr)_minmax(260px,0.72fr)] xl:items-center">
                <div class="relative z-10">
                    <p class="text-xs font-semibold uppercase tracking-[0.08em] text-stone-500">HOW IT WORKS</p>
                    <h2 class="mt-3 max-w-3xl text-4xl font-semibold text-stone-900">From Problem to Result in 3 Clear Steps</h2>
                    <p class="mt-3 max-w-2xl text-sm leading-relaxed text-stone-600 sm:text-base">
                        PotatoTools keeps the flow simple: choose the right tool, enter your details, and get the answer instantly without extra setup.
                    </p>

                    <div class="mt-7 flex flex-col gap-2 sm:flex-row sm:items-center">
                        <p class="text-sm text-stone-600">Want to explore everything?</p>
                        <a
                            href="{{ url('/tools') }}"
                            aria-label="Browse all tools"
                            class="pt-link-arrow inline-flex items-center gap-1.5 text-lg font-semibold text-primary transition-colors duration-200 focus-visible:rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary/40 focus-visible:ring-offset-2">
                            Browse all tools
                            <span class="pt-link-arrow-icon" aria-hidden="true">&rarr;</span>
                        </a>
                    </div>
                </div>

                <div class="relative z-10">
                    <div class="relative flex justify-center xl:justify-end">
                        <img
                            src="{{ asset('images/how_it_works_section.png') }}"
                            alt="Potato mascot showing the simple tool flow"
                            class="h-48 w-auto object-contain sm:h-56"
                            loading="lazy"
                            decoding="async">
                    </div>
                </div>
            </div>

            <div class="relative z-10 mt-10 grid grid-cols-1 gap-5 lg:grid-cols-3">
                <article class="pt-soft-card relative overflow-hidden border-stone-200/80 bg-white/90 p-6 transition-all duration-200 hover:-translate-y-1 hover:shadow-lg">
                    <div>
                        <span class="inline-flex items-center rounded-full border border-primary/25 bg-primary/10 px-3 py-1.5 text-xs font-semibold leading-none tracking-[0.08em] text-primary">STEP 01</span>
                    </div>
                    <h3 class="mt-5 text-xl font-extrabold text-stone-900">Pick the right tool</h3>
                    <p class="mt-2 text-sm leading-relaxed text-stone-600">Start with the tool that matches your task so you get a focused result instead of digging through unnecessary options.</p>
                    <div class="mt-5 inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.12em] text-stone-500">
                        <i class="fa-solid fa-magnifying-glass text-primary" aria-hidden="true"></i>
                        Find what fits
                    </div>
                </article>

                <article class="pt-soft-card relative overflow-hidden border-stone-200/80 bg-white/90 p-6 transition-all duration-200 hover:-translate-y-1 hover:shadow-lg">
                    <div>
                        <span class="inline-flex items-center rounded-full border border-primary/25 bg-primary/10 px-3 py-1.5 text-xs font-semibold leading-none tracking-[0.08em] text-primary">STEP 02</span>
                    </div>
                    <h3 class="mt-5 text-xl font-extrabold text-stone-900">Enter your details</h3>
                    <p class="mt-2 text-sm leading-relaxed text-stone-600">Use clear inputs, dropdowns, and guided fields to enter only the information the tool actually needs.</p>
                    <div class="mt-5 inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.12em] text-stone-500">
                        <i class="fa-solid fa-keyboard text-primary" aria-hidden="true"></i>
                        Keep it simple
                    </div>
                </article>

                <article class="pt-soft-card relative overflow-hidden border-stone-200/80 bg-white/90 p-6 transition-all duration-200 hover:-translate-y-1 hover:shadow-lg">
                    <div>
                        <span class="inline-flex items-center rounded-full border border-primary/25 bg-primary/10 px-3 py-1.5 text-xs font-semibold leading-none tracking-[0.08em] text-primary">STEP 03</span>
                    </div>
                    <h3 class="mt-5 text-xl font-extrabold text-stone-900">Get the result instantly</h3>
                    <p class="mt-2 text-sm leading-relaxed text-stone-600">Your answer appears right away in a clean format so you can use it, copy it, or move on without extra steps.</p>
                    <div class="mt-5 inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.12em] text-stone-500">
                        <i class="fa-solid fa-bolt text-primary" aria-hidden="true"></i>
                        Ready to use
                    </div>
                </article>
            </div>
        </div>
    </section>
    @include('components.tool-request', ['section' => $homePageData['tool_request'] ?? []])
    @include('components.faqs.accordion', [
        'section' => $homePageData['faqs']['home'] ?? [],
        'sectionClass' => 'pt-container mt-10 pt-6 pb-6',
        'wrapperClass' => 'relative bg-transparent py-12',
        'contentClass' => 'mx-auto max-w-5xl',
        'titleClass' => 'mt-2 text-4xl font-semibold text-stone-900',
        'itemsWrapperClass' => 'mt-8 space-y-3',
        'enableSchema' => true,
    ])
@endsection
