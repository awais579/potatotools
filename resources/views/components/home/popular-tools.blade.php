@php
    $section = $section ?? [];
    $items = $section['items'] ?? [];
    $browseAll = $section['browse_all_link'] ?? [];
@endphp

<section class="pt-container pt-16">
    <div class="pt-soft-section relative bg-[#efe5d8] px-5 py-12 sm:px-10">
        <div class="mx-auto mb-8 max-w-5xl ">
            <div class="flex flex-row items-center gap-4 text-left">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.08em] text-stone-500">{{ $section['eyebrow'] ?? '' }}</p>
                    <h2 class="mt-2 text-4xl font-semibold text-stone-900">{{ $section['title'] ?? '' }}</h2>
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

        <div class="mt-8 grid gap-5 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($items as $item)
                <a
                    href="{{ $item['url'] ?? '#' }}"
                    aria-label="{{ $item['aria_label'] ?? 'Open tool' }}"
                    class="pt-soft-card pt-tool-card group block p-6 text-left transition-all duration-300 ease-out hover:-translate-y-1 hover:shadow-xl hover:ring-1 hover:ring-primary/20 focus-visible:-translate-y-1 focus-visible:shadow-xl focus-visible:ring-1 focus-visible:ring-primary/20 focus-visible:outline-none">
                    <div class="pt-image-placeholder inline-flex w-fit shrink-0 rounded-2xl bg-white px-6 py-3 shadow-sm transition-transform duration-300 ease-out group-hover:-translate-y-0.5 group-hover:scale-[1.03]">
                        <i class="{{ $item['icon_class'] ?? 'fa-solid fa-tools' }} text-xl text-primary" aria-hidden="true"></i>
                    </div>
                    <h3 class="mt-3 text-xl font-extrabold text-stone-900">{{ $item['title'] ?? '' }}</h3>
                    <p class="mt-2 max-w-[34ch] text-sm leading-relaxed text-stone-600">{{ $item['description'] ?? '' }}</p>
                    <p class="mt-2 max-w-[34ch] text-xs font-semibold text-stone-500">Category: {{ $item['category'] ?? '' }}</p>
                    <div class="mt-5 flex items-center justify-start gap-4">
                        <span class="pt-link-arrow inline-flex items-center gap-1.5 text-sm font-semibold text-primary transition-colors duration-200">
                            Open Tool
                            <span class="pt-link-arrow-icon" aria-hidden="true">&rarr;</span>
                        </span>
                    </div>
                    <p class="mt-1 text-xs font-semibold text-stone-500">{{ $item['badge'] ?? '' }}</p>
                </a>
            @endforeach
        </div>
    </div>
</section>
