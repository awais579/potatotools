@php
    $section = $section ?? [];
    $points = $section['points'] ?? [];
    $cta = $section['cta'] ?? [];
    $secondary = $section['secondary_link'] ?? [];
@endphp

<section class="pt-container mt-10 pt-6 pb-6">
    <div class="pt-soft-section relative bg-[#efe5d8] px-5 py-12 sm:px-10">
        <div class="text-left">
            @if (!empty($section['eyebrow']))
                <p class="text-xs font-semibold uppercase tracking-[0.08em] text-stone-500">
                    {{ $section['eyebrow'] }}
                </p>
            @endif

            <h2 class="mt-2 text-4xl font-semibold text-stone-900">
                {{ $section['title'] ?? 'Request a Potato Tool' }}
            </h2>

            <p class="mt-2 max-w-2xl text-sm leading-relaxed text-stone-600">
                {{ $section['description'] ?? "Can't find the tool you need? Tell us what would save you time, and we may build it next." }}
            </p>

            <ul class="mt-6 grid max-w-3xl gap-3 text-sm text-stone-700">
                @foreach ($points as $point)
                    <li class="flex items-start gap-3.5">
                        <span class="mt-0.5 inline-flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-primary/10 text-primary">
                            <i class="fa-solid fa-check text-xs" aria-hidden="true"></i>
                        </span>
                        <span>{{ $point }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="pt-card mt-8 p-6 sm:p-7 md:p-8">
            <div class="max-w-2xl">
                <p class="text-xs font-semibold uppercase tracking-[0.08em] text-stone-500">
                    {{ $section['panel_eyebrow'] ?? 'HAVE AN IDEA?' }}
                </p>

                <h3 class="mt-2 text-2xl font-semibold text-stone-900">
                    {{ $section['panel_title'] ?? 'Suggest your next tool' }}
                </h3>

                <p class="mt-2 text-sm leading-relaxed text-stone-600">
                    {{ $section['panel_description'] ?? 'Tell us what you need and where you plan to use it. We review requests regularly.' }}
                </p>

                <div class="mt-6 flex flex-wrap items-center gap-3">
                    <a
                        href="{{ $cta['url'] ?? '#' }}"
                        class="pt-btn-primary px-6 py-3"
                        aria-label="{{ $cta['aria_label'] ?? 'Request a tool' }}">
                        {{ $cta['label'] ?? 'Request a Tool' }}
                    </a>

                    @if (!empty($secondary['label']) && !empty($secondary['url']))
                        <a
                            href="{{ $secondary['url'] }}"
                            class="pt-link-arrow inline-flex items-center gap-1.5 text-sm font-semibold text-primary transition-colors duration-200 focus-visible:rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary/40 focus-visible:ring-offset-2"
                            aria-label="{{ $secondary['aria_label'] ?? $secondary['label'] }}">
                            {{ $secondary['label'] }}
                            <span class="pt-link-arrow-icon" aria-hidden="true">&rarr;</span>
                        </a>
                    @endif
                </div>

                @if (!empty($section['microcopy']))
                    <p class="mt-3 text-xs text-stone-500">
                        {{ $section['microcopy'] }}
                    </p>
                @endif
            </div>
        </div>
    </div>
</section>
