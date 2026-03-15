@php
    $section = $section ?? [];
    $points = $section['points'] ?? [];
    $cta = $section['cta'] ?? [];
    $secondary = $section['secondary_link'] ?? [];
@endphp

<section class="pt-container mt-10 pt-6 pb-6">
    <div class="pt-soft-section relative overflow-hidden bg-[#efe5d8] px-5 py-12 sm:px-8 lg:px-10">
        <div class="absolute -right-10 top-10 hidden h-44 w-44 rounded-full bg-white/35 blur-3xl lg:block" aria-hidden="true"></div>

        <div class="grid gap-8 xl:grid-cols-[minmax(0,1.05fr)_minmax(320px,0.95fr)] xl:items-start">
            <div class="relative z-10 text-left">
                @if (!empty($section['eyebrow']))
                    <p class="text-xs font-semibold uppercase tracking-[0.08em] text-stone-500">
                        {{ $section['eyebrow'] }}
                    </p>
                @endif

                <h2 class="mt-2 max-w-3xl text-4xl font-semibold text-stone-900">
                    {{ $section['title'] ?? 'Request a Potato Tool' }}
                </h2>

                <p class="mt-3 max-w-2xl text-sm leading-relaxed text-stone-600 sm:text-base">
                    {{ $section['description'] ?? "Can't find the tool you need? Tell us what would save you time, and we may build it next." }}
                </p>

                <div class="mt-6 max-w-2xl space-y-3 text-sm leading-relaxed text-stone-600">
                    <p>
                        Share the exact tool you need for real-world work, content, or everyday tasks. The clearer your idea is, the better chance it has of becoming a useful PotatoTool.
                    </p>
                    <p>
                        Good requests explain what the tool should do, who it is for, and what kind of output would make the result immediately useful.
                    </p>
                    @if (!empty($points))
                        <ul class="space-y-2 pt-1">
                            @foreach ($points as $point)
                                <li class="flex items-start gap-2.5">
                                    <i class="fa-solid fa-check mt-1 text-[12px] text-primary" aria-hidden="true"></i>
                                    <span>{{ $point }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="mt-6 inline-flex items-center gap-2 rounded-full border border-stone-200/80 bg-white/75 px-4 py-2 text-xs font-semibold uppercase tracking-[0.12em] text-stone-600">
                    <i class="fa-solid fa-envelope-open-text text-primary" aria-hidden="true"></i>
                    Share your idea in under a minute
                </div>
            </div>

            <div class="relative z-10">
                <div class="pt-card border-stone-200/80 bg-white/92 p-6 sm:p-7 md:p-8">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.08em] text-stone-500">
                                {{ $section['panel_eyebrow'] ?? 'HAVE AN IDEA?' }}
                            </p>

                            <h3 class="mt-2 text-3xl font-semibold text-stone-900">
                                {{ $section['panel_title'] ?? 'Suggest your next tool' }}
                            </h3>
                        </div>
                        <span class="inline-flex h-11 w-11 items-center justify-center rounded-2xl bg-primary/10 text-primary">
                            <i class="fa-solid fa-lightbulb" aria-hidden="true"></i>
                        </span>
                    </div>

                    <p class="mt-4 text-sm leading-relaxed text-stone-600">
                        {{ $section['panel_description'] ?? 'Tell us what you need and where you plan to use it. We review requests regularly.' }}
                    </p>

                    <div class="mt-6 overflow-hidden rounded-3xl border border-stone-200/80 bg-[#fffaf3] p-4">
                        <div class="grid gap-4 sm:grid-cols-[minmax(0,1fr)_140px] sm:items-center">
                            <div>
                                <p class="text-[11px] font-bold uppercase tracking-[0.14em] text-stone-500">Build Better Requests</p>
                                <ul class="mt-3 space-y-2 text-sm text-stone-700">
                                    <li class="flex items-start gap-2">
                                        <i class="fa-solid fa-check text-[12px] text-primary mt-1" aria-hidden="true"></i>
                                        <span>What the tool should do</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i class="fa-solid fa-check text-[12px] text-primary mt-1" aria-hidden="true"></i>
                                        <span>Who will use it and why</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i class="fa-solid fa-check text-[12px] text-primary mt-1" aria-hidden="true"></i>
                                        <span>What kind of output you need</span>
                                    </li>
                                </ul>
                            </div>
                            <img
                                src="{{ asset('images/request-a-tool.png') }}"
                                alt="Request a new tool illustration"
                                class="mx-auto h-28 w-auto object-contain sm:mx-0 sm:ml-auto"
                                loading="lazy"
                                decoding="async">
                        </div>
                    </div>

                    <div class="mt-6 flex flex-wrap items-center justify-end gap-3">
                        <a
                            href="{{ $cta['url'] ?? '#' }}"
                            class="pt-btn-primary px-6 py-3"
                            aria-label="{{ $cta['aria_label'] ?? 'Request a tool' }}">
                            <i class="fa-solid fa-paper-plane" aria-hidden="true"></i>
                            {{ $cta['label'] ?? 'Request a Tool' }}
                        </a>
                    </div>

                    @if (!empty($section['microcopy']))
                        <p class="mt-4 text-right text-xs text-stone-500">
                            {{ $section['microcopy'] }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
