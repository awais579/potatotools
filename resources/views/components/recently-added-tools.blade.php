@php
    $section = $section ?? [];
    $items = $section['items'] ?? [];
    $browseAll = $section['browse_all_link'] ?? [];
@endphp

<section class="pt-container pt-16">
    <div class="pt-soft-section relative bg-[#efe5d8] px-5 py-12 sm:px-10">
        <div class="mx-auto max-w-5xl">
            <div class="flex flex-row items-center gap-4 text-left">
                <div>
                    @if (!empty($section['eyebrow']))
                        <p class="text-xs font-semibold uppercase tracking-[0.08em] text-stone-500">{{ $section['eyebrow'] }}</p>
                    @endif
                    <h2 class="mt-2 text-4xl font-semibold text-stone-900">{{ $section['title'] ?? 'Recently Added Tools' }}</h2>
                    <p class="mt-2 max-w-2xl text-sm text-stone-600">{{ $section['description'] ?? '' }}</p>
                </div>
                <a
                    href="{{ $browseAll['url'] ?? '/tools' }}"
                    class="pt-link-arrow ml-auto inline-flex shrink-0 items-center gap-1.5 font-semibold text-primary transition-colors duration-200 focus-visible:rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary/40 focus-visible:ring-offset-2"
                    aria-label="{{ $browseAll['aria_label'] ?? 'Browse all tools' }}">
                    {{ $browseAll['label'] ?? 'Browse all tools' }}
                    <span class="pt-link-arrow-icon" aria-hidden="true">&rarr;</span>
                </a>
            </div>
        </div>

        <div class="mt-8 grid gap-5 md:grid-cols-2 lg:grid-cols-4">
            @foreach ($items as $item)
                <a
                    href="{{ $item['url'] ?? '#' }}"
                    aria-label="{{ $item['aria_label'] ?? 'Open tool' }}"
                    class="pt-soft-card pt-tool-card group block p-5 text-left transition-all duration-200 hover:-translate-y-0.5 hover:shadow-lg focus-visible:-translate-y-0.5 focus-visible:shadow-lg focus-visible:outline-none">
                    <div class="flex items-start justify-between gap-3">
                        <div class="pt-image-placeholder inline-flex w-fit shrink-0 rounded-2xl bg-white px-4 py-2 shadow-sm">
                            <i class="{{ $item['icon_class'] ?? 'fa-solid fa-tools' }} text-lg text-primary" aria-hidden="true"></i>
                        </div>
                        @if (!empty($item['badge']))
                            <span class="inline-flex items-center rounded-md bg-primary/10 px-2.5 py-1 text-[11px] font-semibold text-primary">
                                {{ $item['badge'] }}
                            </span>
                        @endif
                    </div>

                    <h3 class="mt-4 text-lg font-extrabold text-stone-900">{{ $item['title'] ?? '' }}</h3>
                    <p class="mt-2 text-sm leading-relaxed text-stone-600">{{ $item['description'] ?? '' }}</p>
                    <p class="mt-2 text-xs font-semibold text-stone-500">Category: {{ $item['category'] ?? '' }}</p>

                    <span class="pt-link-arrow mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-primary transition-colors duration-200">
                        Open Tool
                        <span class="pt-link-arrow-icon" aria-hidden="true">&rarr;</span>
                    </span>
                </a>
            @endforeach
        </div>
    </div>
</section>
