@php
    $section = $section ?? [];
    $items = $section['items'] ?? [];

    $sectionClass = $sectionClass ?? 'pt-container pb-8';
    $wrapperClass = $wrapperClass ?? '';
    $contentClass = $contentClass ?? '';
    $eyebrowClass = $eyebrowClass ?? 'text-xs font-semibold uppercase tracking-[0.08em] text-stone-500';
    $titleClass = $titleClass ?? 'text-3xl font-semibold text-stone-900';
    $descriptionClass = $descriptionClass ?? 'mt-2 max-w-3xl text-sm text-stone-600';
    $itemsWrapperClass = $itemsWrapperClass ?? 'mt-5 space-y-3';
    $openFirst = array_key_exists('open_first', $section) ? (bool) $section['open_first'] : true;
    $enableSchema = $enableSchema ?? false;

    $schemaQuestions = [];
    foreach ($items as $faqItem) {
        $question = $faqItem['question'] ?? '';
        $answer = $faqItem['answer'] ?? '';

        if ($question === '' || $answer === '') {
            continue;
        }

        $schemaQuestions[] = [
            '@type' => 'Question',
            'name' => $question,
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => $answer,
            ],
        ];
    }
@endphp

<section class="{{ $sectionClass }}">
    <div class="{{ $wrapperClass }}">
        <div class="{{ $contentClass }}">
            @if (!empty($section['eyebrow']))
                <p class="{{ $eyebrowClass }}">{{ $section['eyebrow'] }}</p>
            @endif

            <h2 class="{{ $titleClass }}">{{ $section['title'] ?? 'Frequently Asked Questions' }}</h2>

            @if (!empty($section['description']))
                <p class="{{ $descriptionClass }}">{{ $section['description'] }}</p>
            @endif

            <div class="{{ $itemsWrapperClass }}">
                @foreach ($items as $index => $faqItem)
                    <details class="pt-faq pt-accordion" @if($openFirst && $index === 0) open @endif>
                        <summary class="flex items-center justify-between gap-3">
                            <span>{{ $faqItem['question'] ?? '' }}</span>
                            <span class="faq-plus text-xl leading-none text-stone-500">+</span>
                        </summary>
                        <p class="mt-3 text-sm text-stone-600">
                            {{ $faqItem['answer'] ?? '' }}
                        </p>
                    </details>
                @endforeach
            </div>

            @if ($enableSchema && count($schemaQuestions) > 0)
                <script type="application/ld+json">{!! json_encode(['@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => $schemaQuestions], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
            @endif
        </div>
    </div>
</section>

@once
    @push('head')
        <style>
            .pt-faq summary {
                list-style: none;
            }

            .pt-faq summary::-webkit-details-marker {
                display: none;
            }

            .pt-faq summary .faq-plus {
                transition: transform 0.2s ease;
            }

            .pt-faq[open] summary .faq-plus {
                transform: rotate(45deg);
            }
        </style>
    @endpush
@endonce
