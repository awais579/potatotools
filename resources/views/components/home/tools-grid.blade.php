@php
    $section = $section ?? [];
    $categories = $section['categories'] ?? [];
    $browseAll = $section['browse_all_link'] ?? [];
@endphp

<section class="pt-container pt-16">
    <div class="relative py-12">
        <div class="flex flex-row items-center gap-4 text-left">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.08em] text-stone-500">{{ $section['eyebrow'] ?? '' }}</p>
                <h2 class="mt-2 text-4xl font-semibold text-stone-900">{{ $section['title'] ?? '' }}</h2>
                <p class="max-w-2xl text-sm text-stone-600">{{ $section['description'] ?? '' }}</p>
            </div>
            <a
                href="{{ $browseAll['url'] ?? '/tools' }}"
                class="pt-link-arrow ml-auto inline-flex shrink-0 items-center gap-1.5 font-semibold text-primary transition-colors duration-200 focus-visible:rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary/40 focus-visible:ring-offset-2"
                aria-label="{{ $browseAll['aria_label'] ?? 'Browse all tools' }}">
                {{ $browseAll['label'] ?? 'Browse all tools' }}
                <span class="pt-link-arrow-icon" aria-hidden="true">&rarr;</span>
            </a>
        </div>

        <div class="mt-12 space-y-12">
            @foreach ($categories as $index => $category)
                <div class="{{ $index > 0 ? 'mt-12 border-stone-200/70 pt-12' : '' }} text-left">
                    <div class="flex flex-row items-center gap-3">
                        <div>
                            <h3 class="text-2xl font-semibold text-stone-900">{{ $category['title'] ?? '' }}</h3>
                            <p class="mt-1 max-w-2xl text-sm text-stone-600">{{ $category['description'] ?? '' }}</p>
                        </div>
                    </div>

                    <div class="mt-7 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                        @foreach (($category['tools'] ?? []) as $tool)
                            <a
                                href="{{ $tool['url'] ?? '#' }}"
                                aria-label="{{ $tool['aria_label'] ?? 'Open tool' }}"
                                class="pt-soft-card pt-tool-card block p-5 text-left transition-all duration-200 hover:-translate-y-0.5 hover:shadow-lg focus-visible:-translate-y-0.5 focus-visible:shadow-lg focus-visible:outline-none">
                                <div class="pt-image-placeholder inline-flex w-fit shrink-0 rounded-2xl bg-white px-4 py-2 shadow-sm">
                                    <i class="{{ $tool['icon_class'] ?? 'fa-solid fa-tools' }} text-lg text-primary" aria-hidden="true"></i>
                                </div>
                                <h4 class="mt-4 text-lg font-extrabold text-stone-900">{{ $tool['title'] ?? '' }}</h4>
                                <p class="mt-2 max-w-[34ch] text-sm leading-relaxed text-stone-600">{{ $tool['description'] ?? '' }}</p>
                                <span class="pt-link-arrow mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-primary transition-colors duration-200">
                                    Open Tool
                                    <span class="pt-link-arrow-icon" aria-hidden="true">&rarr;</span>
                                </span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
