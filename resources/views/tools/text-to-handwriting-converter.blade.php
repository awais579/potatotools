@extends('layouts.app')

@section('title', 'Text to Handwriting Converter - Turn Text Into Handwritten Pages')
@section('description', 'Turn typed text into handwriting-style pages. Pick a paper style, choose a handwriting font, preview the result live, and download PNG or PDF instantly.')
@section('canonical', route('tools.text-to-handwriting-converter'))

@php
    $homePageData = $homePageData ?? [];

    $paperOptions = [
        [
            'id' => 'black-lined-paper',
            'label' => 'Black Lined Paper',
            'description' => 'Dark ruled page',
            'src' => asset('images/Black Lined Paper.jpg'),
            'template' => [
                'width' => 794,
                'height' => 1123,
                'marginX' => 105,
                'startX' => 122,
                'startY' => 90,
                'drawStartY' => 106,
                'lineHeight' => 31.5625,
                'linesPerPage' => 33,
                'maxWidth' => 640,
                'fontSize' => 27,
                'letterSpacing' => 0,
            ],
        ],
        [
            'id' => 'blue-lined-paper',
            'label' => 'Blue Lined Paper',
            'description' => 'Blue notebook-style page',
            'src' => asset('images/Blue Lined Paper.jpg'),
            'template' => [
                'width' => 794,
                'height' => 1123,
                'marginX' => 125,
                'startX' => 142,
                'startY' => 122,
                'lineHeight' => 33,
                'linesPerPage' => 31,
                'maxWidth' => 622,
                'fontSize' => 28,
                'letterSpacing' => 0,
            ],
        ],
        [
            'id' => 'gray-lined-paper',
            'label' => 'Gray Lined Paper',
            'description' => 'Soft gray ruled page',
            'src' => asset('images/Gray Lined Paper.jpg'),
            'template' => [
                'width' => 794,
                'height' => 1123,
                'marginX' => 105,
                'startX' => 122,
                'startY' => 115,
                'lineHeight' => 31.5625,
                'linesPerPage' => 33,
                'maxWidth' => 640,
                'fontSize' => 27,
                'letterSpacing' => 0,
            ],
        ],
    ];

    $fontOptions = [
        ['id' => 'amatic-sc', 'label' => 'Amatic SC', 'scripts' => 'Hebrew', 'family' => '"Amatic SC", cursive', 'load' => '"Amatic SC"'],
        ['id' => 'architects-daughter', 'label' => 'Architects Daughter', 'scripts' => 'Latin', 'family' => '"Architects Daughter", cursive', 'load' => '"Architects Daughter"'],
        ['id' => 'aref-ruqaa-ink', 'label' => 'Aref Ruqaa Ink', 'scripts' => 'Arabic', 'family' => '"Aref Ruqaa Ink", serif', 'load' => '"Aref Ruqaa Ink"'],
        ['id' => 'atma', 'label' => 'Atma (বাংলা)', 'scripts' => 'Latin, Bengali', 'family' => '"Atma", cursive', 'load' => '"Atma"'],
        ['id' => 'caveat', 'label' => 'Caveat', 'scripts' => 'Latin, Cyrillic', 'family' => '"Caveat", cursive', 'load' => '"Caveat"'],
        ['id' => 'cedarville-cursive', 'label' => 'Cedarville Cursive', 'scripts' => 'Latin', 'family' => '"Cedarville Cursive", cursive', 'load' => '"Cedarville Cursive"'],
        ['id' => 'comic-neue', 'label' => 'Comic Neue', 'scripts' => 'Latin', 'family' => '"Comic Neue", cursive', 'load' => '"Comic Neue"'],
        ['id' => 'crafty-girls', 'label' => 'Crafty Girls', 'scripts' => 'Latin', 'family' => '"Crafty Girls", cursive', 'load' => '"Crafty Girls"'],
        ['id' => 'dancing-script', 'label' => 'Dancing Script', 'scripts' => 'Latin, Vietnamese', 'family' => '"Dancing Script", cursive', 'load' => '"Dancing Script"'],
        ['id' => 'dawning-of-a-new-day', 'label' => 'Dawning of a New Day', 'scripts' => 'Latin', 'family' => '"Dawning of a New Day", cursive', 'load' => '"Dawning of a New Day"'],
        ['id' => 'dekko', 'label' => 'Dekko (देवनागरी)', 'scripts' => 'Latin, Devanagari', 'family' => '"Dekko", cursive', 'load' => '"Dekko"'],
        ['id' => 'fondamento', 'label' => 'Fondamento', 'scripts' => 'Latin', 'family' => '"Fondamento", cursive', 'load' => '"Fondamento"'],
        ['id' => 'gloria-hallelujah', 'label' => 'Gloria Hallelujah', 'scripts' => 'Latin', 'family' => '"Gloria Hallelujah", cursive', 'load' => '"Gloria Hallelujah"'],
        ['id' => 'gochi-hand', 'label' => 'Gochi Hand', 'scripts' => 'Latin', 'family' => '"Gochi Hand", cursive', 'load' => '"Gochi Hand"'],
        ['id' => 'handlee', 'label' => 'Handlee', 'scripts' => 'Latin', 'family' => '"Handlee", cursive', 'load' => '"Handlee"'],
        ['id' => 'homemade-apple', 'label' => 'Homemade Apple', 'scripts' => 'Latin', 'family' => '"Homemade Apple", cursive', 'load' => '"Homemade Apple"'],
        ['id' => 'ibm-plex-sans-arabic', 'label' => 'IBM Plex Sans Arabic (عربي)', 'scripts' => 'Arabic', 'family' => '"IBM Plex Sans Arabic", sans-serif', 'load' => '"IBM Plex Sans Arabic"'],
        ['id' => 'indie-flower', 'label' => 'Indie Flower', 'scripts' => 'Latin', 'family' => '"Indie Flower", cursive', 'load' => '"Indie Flower"'],
        ['id' => 'itim', 'label' => 'Itim (แบบไทย)', 'scripts' => 'Latin, Thai, Vietnamese', 'family' => '"Itim", cursive', 'load' => '"Itim"'],
        ['id' => 'kalam', 'label' => 'Kalam', 'scripts' => 'Latin, Devanagari', 'family' => '"Kalam", cursive', 'load' => '"Kalam"'],
        ['id' => 'klee-one', 'label' => 'Klee One (日本)', 'scripts' => 'Latin, Japanese', 'family' => '"Klee One", cursive', 'load' => '"Klee One"'],
        ['id' => 'lateef', 'label' => 'Lateef', 'scripts' => 'Arabic', 'family' => '"Lateef", serif', 'load' => '"Lateef"'],
        ['id' => 'ma-shan-zheng', 'label' => 'Ma Shan Zheng (中国人)', 'scripts' => 'Latin, Chinese', 'family' => '"Ma Shan Zheng", cursive', 'load' => '"Ma Shan Zheng"'],
        ['id' => 'mali', 'label' => 'Mali (แบบไทย)', 'scripts' => 'Latin, Thai, Vietnamese', 'family' => '"Mali", cursive', 'load' => '"Mali"'],
        ['id' => 'mansalva', 'label' => 'Mansalva', 'scripts' => 'Latin, Greek, Vietnamese', 'family' => '"Mansalva", cursive', 'load' => '"Mansalva"'],
        ['id' => 'meddon', 'label' => 'Meddon', 'scripts' => 'Latin', 'family' => '"Meddon", cursive', 'load' => '"Meddon"'],
        ['id' => 'nanum-pen-script', 'label' => 'Nanum Pen Script (한글)', 'scripts' => 'Latin, Korean', 'family' => '"Nanum Pen Script", cursive', 'load' => '"Nanum Pen Script"'],
        ['id' => 'nothing-you-could-do', 'label' => 'Nothing You Could Do', 'scripts' => 'Latin', 'family' => '"Nothing You Could Do", cursive', 'load' => '"Nothing You Could Do"'],
        ['id' => 'noto-nastaliq-urdu', 'label' => 'Noto Nastaliq Urdu (اردو)', 'scripts' => 'Urdu', 'family' => '"Noto Nastaliq Urdu", serif', 'load' => '"Noto Nastaliq Urdu"'],
        ['id' => 'noto-sans-arabic', 'label' => 'Noto Sans Arabic (عربي)', 'scripts' => 'Arabic', 'family' => '"Noto Sans Arabic", sans-serif', 'load' => '"Noto Sans Arabic"'],
        ['id' => 'pacifico', 'label' => 'Pacifico', 'scripts' => 'Latin, Cyrillic, Vietnamese', 'family' => '"Pacifico", cursive', 'load' => '"Pacifico"'],
        ['id' => 'pangolin', 'label' => 'Pangolin', 'scripts' => 'Latin, Cyrillic, Vietnamese', 'family' => '"Pangolin", cursive', 'load' => '"Pangolin"'],
        ['id' => 'patrick-hand', 'label' => 'Patrick Hand', 'scripts' => 'Latin, Vietnamese', 'family' => '"Patrick Hand", cursive', 'load' => '"Patrick Hand"'],
        ['id' => 'permanent-marker', 'label' => 'Permanent Marker', 'scripts' => 'Latin', 'family' => '"Permanent Marker", cursive', 'load' => '"Permanent Marker"'],
        ['id' => 'satisfy', 'label' => 'Satisfy', 'scripts' => 'Latin', 'family' => '"Satisfy", cursive', 'load' => '"Satisfy"'],
        ['id' => 'schoolbell', 'label' => 'Schoolbell', 'scripts' => 'Latin', 'family' => '"Schoolbell", cursive', 'load' => '"Schoolbell"'],
        ['id' => 'shadows-into-light', 'label' => 'Shadows Into Light', 'scripts' => 'Latin', 'family' => '"Shadows Into Light", cursive', 'load' => '"Shadows Into Light"'],
        ['id' => 'sunshiney', 'label' => 'Sunshiney', 'scripts' => 'Latin', 'family' => '"Sunshiney", cursive', 'load' => '"Sunshiney"'],
        ['id' => 'swanky-and-moo-moo', 'label' => 'Swanky and Moo Moo', 'scripts' => 'Latin', 'family' => '"Swanky and Moo Moo", cursive', 'load' => '"Swanky and Moo Moo"'],
    ];

    $fontSizePresets = collect(range(20, 30))
        ->map(fn ($px) => ['id' => (string) $px, 'label' => "{$px} px"])
        ->all();

    $alignmentPresets = [
        ['id' => 'narrow', 'label' => 'More Writing Space'],
        ['id' => 'standard', 'label' => 'Standard'],
        ['id' => 'wide', 'label' => 'Wider Left Margin'],
    ];

@endphp

@push('head')
    @vite('resources/js/tools/text-to-handwriting-converter.js')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amatic+SC:wght@400;700&family=Aref+Ruqaa+Ink:wght@400;700&family=Architects+Daughter&family=Atma:wght@300;400;500;600;700&family=Caveat:wght@400;600;700&family=Cedarville+Cursive&family=Comic+Neue:wght@300;400;700&family=Crafty+Girls&family=Dancing+Script:wght@400;500;600;700&family=Dawning+of+a+New+Day&family=Dekko&family=Fondamento:ital@0;1&family=Gloria+Hallelujah&family=Gochi+Hand&family=Handlee&family=Homemade+Apple&family=IBM+Plex+Sans+Arabic:wght@400;500;600;700&family=Indie+Flower&family=Itim&family=Kalam:wght@300;400;700&family=Klee+One:wght@400;600&family=Lateef:wght@400;500;600;700&family=Ma+Shan+Zheng&family=Mali:wght@200;300;400;500;600;700&family=Mansalva&family=Meddon&family=Nanum+Pen+Script&family=Nothing+You+Could+Do&family=Noto+Nastaliq+Urdu:wght@400;500;600;700&family=Noto+Sans+Arabic:wght@400;500;600;700&family=Pacifico&family=Pangolin&family=Patrick+Hand&family=Permanent+Marker&family=Satisfy&family=Schoolbell&family=Shadows+Into+Light&family=Sunshiney&family=Swanky+and+Moo+Moo&display=swap" rel="stylesheet">

    <style>
        #handwriting-tool-page canvas {
            display: block;
        }

        #handwriting-tool-page .tool-shell {
            position: relative;
            z-index: 20;
        }

        #handwriting-tool-page .workspace-stack {
            display: grid;
            gap: 1.25rem;
        }

        #handwriting-tool-page .preview-scroll-shell {
            overflow: hidden;
            border-radius: 1.5rem;
            background:
                radial-gradient(circle at top, rgba(255, 255, 255, 0.45), transparent 42%),
                linear-gradient(180deg, rgba(96, 64, 32, 0.12), rgba(96, 64, 32, 0.03));
        }

        #handwriting-tool-page .preview-canvas-frame {
            display: block;
            width: min(100%, 49.625rem);
            margin-inline: auto;
            border-radius: 1.35rem;
            border: 1px solid rgba(214, 211, 209, 0.9);
            background: #fff;
            padding: 0.75rem;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.7);
        }

        #handwriting-tool-page .preview-canvas {
            display: block;
            width: 100%;
            max-width: 100%;
            height: auto;
            background: #fff;
            border-radius: 1rem;
        }

        #handwriting-tool-page .preview-note {
            color: rgb(87 83 78);
            font-size: 0.78rem;
            line-height: 1.5;
        }

        #handwriting-tool-page .advanced-settings summary {
            list-style: none;
            cursor: pointer;
        }

        #handwriting-tool-page .advanced-settings summary::-webkit-details-marker {
            display: none;
        }

        #handwriting-tool-page .advanced-settings[open] .advanced-chevron {
            transform: rotate(180deg);
        }

        #handwriting-tool-page .advanced-chevron {
            transition: transform 0.2s ease;
        }

        #handwriting-tool-page .advanced-settings-panel {
            border-top: 1px solid rgba(231, 229, 228, 0.9);
        }

        #handwriting-tool-page .handwriting-picker summary {
            list-style: none;
        }

        #handwriting-tool-page .handwriting-picker summary::-webkit-details-marker {
            display: none;
        }

        #handwriting-tool-page .handwriting-picker[open] .picker-chevron {
            transform: rotate(180deg);
        }

        #handwriting-tool-page .picker-chevron {
            transition: transform 0.2s ease;
        }

        #handwriting-tool-page .handwriting-picker {
            position: relative;
        }

        #handwriting-tool-page .handwriting-picker[open] {
            z-index: 70;
        }

        #handwriting-tool-page .editor-shell {
            overflow: hidden;
            border-radius: 1.6rem;
            border: 1px solid rgba(231, 229, 228, 1);
            background: #fff;
        }

        #handwriting-tool-page .handwriting-toolbar {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            align-items: center;
            padding: 0.8rem 0.9rem;
            border-bottom: 1px solid rgba(231, 229, 228, 1);
            background: linear-gradient(180deg, rgba(250, 245, 238, 0.9), rgba(255, 255, 255, 0.98));
        }

        #handwriting-tool-page .toolbar-divider {
            width: 1px;
            height: 1.9rem;
            background: rgba(231, 229, 228, 1);
        }

        #handwriting-tool-page .toolbar-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 2.5rem;
            height: 2.5rem;
            padding: 0 0.72rem;
            border-radius: 0.9rem;
            border: 1px solid rgba(231, 229, 228, 1);
            background: #fff;
            color: rgb(68 64 60);
            font-size: 0.86rem;
            font-weight: 600;
            transition: border-color 0.2s ease, background-color 0.2s ease, color 0.2s ease, box-shadow 0.2s ease;
        }

        #handwriting-tool-page .toolbar-btn:hover,
        #handwriting-tool-page .toolbar-btn:focus-visible {
            border-color: rgba(198, 134, 45, 0.5);
            outline: none;
            box-shadow: 0 0 0 3px rgba(198, 134, 45, 0.12);
        }

        #handwriting-tool-page .toolbar-btn.is-active {
            border-color: transparent;
            background: #c6862d;
            color: #fff;
            box-shadow: 0 12px 24px rgba(198, 134, 45, 0.22);
        }

        #handwriting-tool-page .editor-surface {
            height: 32rem;
            padding: 1rem 1.05rem 1.15rem;
            color: rgb(28 25 23);
            font-size: 1rem;
            line-height: 1.75;
            outline: none;
            overflow-y: auto;
            overflow-x: hidden;
            scroll-behavior: smooth;
            scrollbar-gutter: stable;
            white-space: pre-wrap;
            word-break: break-word;
        }

        #handwriting-tool-page .editor-surface > * + * {
            margin-top: 0.75rem;
        }

        #handwriting-tool-page .editor-surface ul,
        #handwriting-tool-page .editor-surface ol {
            margin-left: 1.25rem;
            padding-left: 0.35rem;
        }

        #handwriting-tool-page .editor-surface[data-empty="true"]::before {
            content: attr(data-placeholder);
            color: rgb(168 162 158);
            pointer-events: none;
        }

        #handwriting-tool-page .export-menu[hidden] {
            display: none;
        }

        #handwriting-tool-page .export-menu {
            position: absolute;
            right: 0;
            bottom: calc(100% + 0.75rem);
            width: min(18rem, calc(100vw - 3rem));
            border-radius: 1.25rem;
            border: 1px solid rgba(231, 229, 228, 1);
            background: #fff;
            padding: 0.45rem;
            box-shadow: 0 28px 48px rgba(28, 25, 23, 0.16);
        }

        #handwriting-tool-page .export-option {
            display: flex;
            width: 100%;
            align-items: center;
            gap: 0.75rem;
            border-radius: 1rem;
            padding: 0.8rem 0.9rem;
            color: rgb(28 25 23);
            font-size: 0.92rem;
            font-weight: 600;
            text-align: left;
            cursor: pointer;
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        #handwriting-tool-page .export-option:hover,
        #handwriting-tool-page .export-option:focus-visible {
            background: rgba(198, 134, 45, 0.1);
            color: rgb(161 98 7);
            outline: none;
        }

        #handwriting-tool-page .page-pagination {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        #handwriting-tool-page .page-pagination[hidden] {
            display: none;
        }

        #handwriting-tool-page .page-pagination-btn {
            min-width: 2.4rem;
            height: 2.4rem;
            padding: 0 0.85rem;
            border: 1px solid rgba(231, 229, 228, 1);
            border-radius: 999px;
            background: #fff;
            color: rgb(68 64 60);
            font-size: 0.84rem;
            font-weight: 600;
            cursor: pointer;
            transition: border-color 0.2s ease, background-color 0.2s ease, color 0.2s ease;
        }

        #handwriting-tool-page .page-pagination-btn:hover,
        #handwriting-tool-page .page-pagination-btn:focus-visible {
            border-color: rgba(198, 134, 45, 0.5);
            outline: none;
        }

        #handwriting-tool-page .page-pagination-btn.is-active {
            border-color: transparent;
            background: #c6862d;
            color: #fff;
            box-shadow: 0 12px 24px rgba(198, 134, 45, 0.22);
        }

        @media (max-width: 1023px) {
            #handwriting-tool-page .export-menu {
                right: auto;
                left: 0;
                width: min(100%, 22rem);
            }

            #handwriting-tool-page .editor-surface {
                height: 24rem;
            }
        }
    </style>
@endpush

@section('content')
    <section id="handwriting-tool-page" class="pt-container pt-8 pb-12 sm:pt-10 sm:pb-14 lg:pt-12 lg:pb-16">
        <nav aria-label="Breadcrumb" class="text-xs text-stone-500">
            <ol class="flex flex-wrap items-center gap-2">
                <li><a href="{{ route('home') }}" class="hover:text-primary">Home</a></li>
                <li aria-hidden="true">&gt;</li>
                <li><a href="{{ route('home') }}#pick-potato" class="hover:text-primary">Tools</a></li>
                <li aria-hidden="true">&gt;</li>
                <li aria-current="page" class="font-semibold text-primary">Text to Handwriting Converter</li>
            </ol>
        </nav>

        <div class="mt-5 max-w-4xl">
            <h1 class="text-3xl font-semibold text-stone-900 sm:text-5xl">Text to Handwriting Converter</h1>
            <p class="mt-4 text-sm leading-relaxed text-stone-600 sm:text-base">
                Paste your text, choose a paper look, and download a clean handwriting-style page in seconds.
            </p>
        </div>

        <section class="tool-shell pt-card pt-card-elevated mx-auto mt-6 max-w-[1280px] overflow-visible p-4 sm:p-6 lg:p-7">

            <div class="mt-5 rounded-[1.8rem] border border-stone-200/70 bg-white p-4 sm:p-5">
                <div class="workspace-stack">
                    <div class="space-y-4">
                        <div class="pt-field">
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                <label id="handwriting-editor-label" class="pt-label">Your Text</label>
                                <div class="flex flex-wrap gap-2">
                                    <button type="button" id="clear-text" class="pt-btn-secondary inline-flex min-h-[2.7rem] items-center justify-center gap-2 rounded-2xl px-4 py-0 text-sm font-semibold">
                                        <i class="fa-solid fa-rotate-left" aria-hidden="true"></i>
                                        Reset
                                    </button>
                                </div>
                            </div>

                            <div class="editor-shell mt-2">
                                <div class="handwriting-toolbar" role="toolbar" aria-label="Text formatting">
                                    <button type="button" class="toolbar-btn" data-action="undo" aria-label="Undo">
                                        <i class="fa-solid fa-rotate-left" aria-hidden="true"></i>
                                    </button>
                                    <button type="button" class="toolbar-btn" data-action="redo" aria-label="Redo">
                                        <i class="fa-solid fa-rotate-right" aria-hidden="true"></i>
                                    </button>
                                    <span class="toolbar-divider" aria-hidden="true"></span>
                                    <button type="button" class="toolbar-btn" data-command="bold" aria-label="Bold">
                                        <i class="fa-solid fa-bold" aria-hidden="true"></i>
                                    </button>
                                    <button type="button" class="toolbar-btn" data-command="italic" aria-label="Italic">
                                        <i class="fa-solid fa-italic" aria-hidden="true"></i>
                                    </button>
                                    <button type="button" class="toolbar-btn" data-command="underline" aria-label="Underline">
                                        <i class="fa-solid fa-underline" aria-hidden="true"></i>
                                    </button>
                                    <button type="button" class="toolbar-btn" data-command="strikeThrough" aria-label="Strikethrough">
                                        <i class="fa-solid fa-strikethrough" aria-hidden="true"></i>
                                    </button>
                                    <span class="toolbar-divider" aria-hidden="true"></span>
                                    <button type="button" class="toolbar-btn" data-command="justifyLeft" aria-label="Align left">
                                        <i class="fa-solid fa-align-left" aria-hidden="true"></i>
                                    </button>
                                    <button type="button" class="toolbar-btn" data-command="justifyCenter" aria-label="Align center">
                                        <i class="fa-solid fa-align-center" aria-hidden="true"></i>
                                    </button>
                                    <button type="button" class="toolbar-btn" data-command="justifyRight" aria-label="Align right">
                                        <i class="fa-solid fa-align-right" aria-hidden="true"></i>
                                    </button>
                                    <span class="toolbar-divider" aria-hidden="true"></span>
                                    <button type="button" class="toolbar-btn" data-command="insertUnorderedList" aria-label="Bulleted list">
                                        <i class="fa-solid fa-list-ul" aria-hidden="true"></i>
                                    </button>
                                    <button type="button" class="toolbar-btn" data-command="insertOrderedList" aria-label="Numbered list">
                                        <i class="fa-solid fa-list-ol" aria-hidden="true"></i>
                                    </button>
                                </div>

                                <div
                                    id="handwriting-editor"
                                    class="editor-surface"
                                    contenteditable="true"
                                    spellcheck="false"
                                    aria-labelledby="handwriting-editor-label"
                                    data-empty="true"
                                    data-placeholder="Paste your text here, use the toolbar if you need formatting, then export your handwriting page."></div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="grid gap-4 xl:grid-cols-[minmax(0,1fr)_minmax(0,1fr)_minmax(16rem,0.72fr)]">
                                <div>
                                    <div class="pt-field">
                                        <label class="pt-label">Paper Style</label>
                                        <input id="page-background" type="hidden" value="{{ $paperOptions[0]['id'] }}">
                                        <details class="handwriting-picker group relative">
                                            <summary class="cursor-pointer rounded-2xl border border-stone-200 bg-white px-4 py-3">
                                                <div class="flex items-center gap-3">
                                                    <img id="paper-summary-image" src="{{ $paperOptions[0]['src'] }}" alt="" class="h-12 w-12 rounded-xl border border-stone-200 object-cover">
                                                    <div class="min-w-0 flex-1">
                                                        <p id="paper-summary-label" class="truncate text-sm font-semibold text-stone-900">{{ $paperOptions[0]['label'] }}</p>
                                                        <p id="paper-summary-description" class="truncate text-xs text-stone-500">{{ $paperOptions[0]['description'] }}</p>
                                                    </div>
                                                    <i class="picker-chevron fa-solid fa-chevron-down text-xs text-stone-400" aria-hidden="true"></i>
                                                </div>
                                            </summary>

                                            <div class="absolute left-0 right-0 top-[calc(100%+0.5rem)] z-[90] rounded-3xl border border-stone-200 bg-white p-3 shadow-xl">
                                                <div class="grid max-h-[23rem] gap-1.5 overflow-y-auto">
                                                    @foreach ($paperOptions as $paper)
                                                        <button
                                                            type="button"
                                                            class="paper-option flex items-center gap-3 rounded-2xl border border-stone-200 bg-white px-3 py-3 text-left transition hover:border-primary/50"
                                                            data-paper-id="{{ $paper['id'] }}"
                                                            data-paper-label="{{ $paper['label'] }}"
                                                            data-paper-description="{{ $paper['description'] }}"
                                                            data-paper-src="{{ $paper['src'] }}">
                                                            <img src="{{ $paper['src'] }}" alt="" class="h-14 w-14 rounded-xl border border-stone-200 object-cover">
                                                            <div class="min-w-0">
                                                                <p class="text-sm font-semibold text-stone-900">{{ $paper['label'] }}</p>
                                                                <p class="text-xs text-stone-500">{{ $paper['description'] }}</p>
                                                            </div>
                                                        </button>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </details>
                                    </div>
                                </div>

                                <div>
                                    <div class="pt-field">
                                        <label class="pt-label">Handwriting Font</label>
                                        <input id="handwriting-font" type="hidden" value="kalam">
                                        <details class="handwriting-picker group relative">
                                            <summary class="cursor-pointer rounded-2xl border border-stone-200 bg-white px-4 py-3">
                                                <div class="flex items-center gap-3">
                                                    <div class="flex h-12 w-12 items-center justify-center rounded-xl border border-stone-200 bg-potato-beige/35 text-lg text-primary">
                                                        <i class="fa-solid fa-pen-nib" aria-hidden="true"></i>
                                                    </div>
                                                    <div class="min-w-0 flex-1">
                                                        <p id="font-summary-label" class="truncate text-lg text-stone-900" style="font-family: &quot;Kalam&quot;, cursive;">Kalam</p>
                                                        <p id="font-summary-scripts" class="truncate text-xs text-stone-500">Latin, Devanagari</p>
                                                    </div>
                                                    <i class="picker-chevron fa-solid fa-chevron-down text-xs text-stone-400" aria-hidden="true"></i>
                                                </div>
                                            </summary>

                                            <div class="absolute left-0 right-0 top-[calc(100%+0.5rem)] z-[90] rounded-3xl border border-stone-200 bg-white p-3 shadow-xl">
                                                <div class="grid max-h-[23rem] gap-1.5 overflow-y-auto">
                                                    @foreach ($fontOptions as $font)
                                                        <button
                                                            type="button"
                                                            class="font-option rounded-2xl border border-stone-200 bg-white px-4 py-3 text-left transition hover:border-primary/50"
                                                            data-font-id="{{ $font['id'] }}"
                                                            data-font-label="{{ $font['label'] }}"
                                                            data-font-scripts="{{ $font['scripts'] }}"
                                                            data-font-family="{{ $font['family'] }}">
                                                            <span class="flex flex-wrap items-baseline gap-x-2 gap-y-1">
                                                                <span class="text-xl text-stone-900" style="font-family: {{ $font['family'] }};">{{ $font['label'] }}</span>
                                                                <span class="text-sm text-stone-500">{{ $font['scripts'] }}</span>
                                                            </span>
                                                        </button>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </details>
                                    </div>
                                </div>

                                <div>
                                    <div class="pt-field">
                                        <label for="ink-color" class="pt-label">Ink Color</label>
                                        <div class="rounded-2xl border border-stone-200 bg-white px-3 py-[0.84rem]">
                                            <div class="flex items-center gap-3">
                                                <input
                                                    id="ink-color"
                                                    type="color"
                                                    value="#243247"
                                                    class="h-12 w-14 cursor-pointer rounded-xl border border-stone-200 bg-white p-1">
                                                <div>
                                                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-stone-500">Current</p>
                                                    <p id="ink-hex" class="mt-1 text-sm font-semibold text-stone-900">#243247</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="grid gap-4 sm:max-w-[12rem]">
                                <div class="pt-field">
                                    <label class="pt-label" for="font-size-preset">Font Size</label>
                                    <select id="font-size-preset" class="pt-input pt-input-tall w-full">
                                        @foreach ($fontSizePresets as $preset)
                                            <option value="{{ $preset['id'] }}" @selected((string) $preset['id'] === (string) $paperOptions[0]['template']['fontSize'])>{{ $preset['label'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <input id="alignment-preset" type="hidden" value="standard">
                        <input id="filename-base" type="hidden" value="">
                    </div>

                    <div class="space-y-3">
                        <div class="flex items-center justify-between gap-3">
                            <label class="pt-label" for="handwriting-preview-canvas">Live Preview</label>
                            <p id="template-meta-summary" class="text-xs font-medium text-stone-500">Standard size • Fixed grid</p>
                        </div>
                        <div class="preview-scroll-shell mt-3 rounded-[1.7rem] border border-stone-200/70 p-3 sm:p-4">
                            <div class="preview-canvas-frame">
                                <canvas
                                    id="handwriting-preview-canvas"
                                    class="preview-canvas"
                                    width="{{ $paperOptions[0]['template']['width'] }}"
                                    height="{{ $paperOptions[0]['template']['height'] }}"></canvas>
                            </div>
                        </div>
                        <p class="preview-note mt-3">Preview and export use the same fixed paper grid.</p>
                    </div>
                </div>

                <div class="mt-5 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.12em] text-stone-500">Pages</p>
                        <div id="page-pagination" class="page-pagination mt-2" hidden></div>
                        <p class="mt-3 text-xs text-stone-500"><span id="character-count">0</span> characters</p>
                    </div>

                    <div class="flex flex-col items-start gap-3 lg:items-end">
                        <p id="page-summary" class="text-sm font-semibold text-stone-600">Page 1 of 1</p>
                        <div class="relative w-full lg:w-auto">
                            <button type="button" id="export-writing-button" class="pt-btn-primary inline-flex min-h-[2.95rem] w-full items-center justify-center gap-2 rounded-2xl px-5 py-0 text-sm font-semibold disabled:cursor-not-allowed disabled:opacity-60 lg:w-auto" disabled aria-haspopup="menu" aria-expanded="false">
                                <i class="fa-solid fa-file-export" aria-hidden="true"></i>
                                Export Writing
                                <i class="fa-solid fa-chevron-down text-xs" aria-hidden="true"></i>
                            </button>

                            <div id="export-writing-menu" class="export-menu" role="menu" aria-label="Export writing options" hidden>
                                <button type="button" class="export-option" data-export-action="current-png" data-single-label="Download PNG" data-multi-label="Download Current Page PNG" role="menuitem">
                                    <i class="fa-solid fa-image text-primary" aria-hidden="true"></i>
                                    <span class="export-option-label">Download PNG</span>
                                </button>
                                <button type="button" class="export-option" data-export-action="current-pdf" data-single-label="Download PDF" data-multi-label="Download Current Page PDF" role="menuitem">
                                    <i class="fa-regular fa-file-pdf text-primary" aria-hidden="true"></i>
                                    <span class="export-option-label">Download PDF</span>
                                </button>
                                <button type="button" class="export-option" data-export-action="all-png" role="menuitem">
                                    <i class="fa-regular fa-images text-primary" aria-hidden="true"></i>
                                    <span class="export-option-label">Download All Pages PNG</span>
                                </button>
                                <button type="button" class="export-option" data-export-action="all-pdf" role="menuitem">
                                    <i class="fa-regular fa-copy text-primary" aria-hidden="true"></i>
                                    <span class="export-option-label">Download All Pages PDF</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <p id="handwriting-error" class="mt-4 hidden rounded-xl border border-red-200 bg-red-50 px-3 py-2 text-xs font-semibold text-red-700"></p>
        </section>

        <section class="pt-container px-0 pt-16 pb-6 sm:pt-20">
            <div class="pt-soft-section bg-[#efe5d8] px-5 py-8 sm:px-8 sm:py-10">
                <div class="max-w-4xl">
                    <p class="text-xs font-semibold uppercase tracking-[0.08em] text-stone-500">How It Works</p>
                    <h2 class="mt-2 text-3xl font-semibold text-stone-900 sm:text-4xl">How this text to handwriting converter works</h2>
                    <p class="mt-3 text-sm leading-relaxed text-stone-700 sm:text-base">
                        Choose a paper style, paste your text, and check the live preview. When it looks right, download it as a PNG or PDF.
                    </p>
                </div>

                <div class="mt-6 grid gap-4 md:grid-cols-3">
                    <article class="pt-soft-card p-5">
                        <p class="text-xs font-semibold uppercase tracking-[0.12em] text-stone-500">Step 1</p>
                        <h3 class="mt-3 text-lg font-semibold text-stone-900">Write or paste your text</h3>
                        <p class="mt-2 text-sm leading-relaxed text-stone-600">
                            Use the editor for plain text, lists, alignment, and simple emphasis. The preview updates live.
                        </p>
                    </article>

                    <article class="pt-soft-card p-5">
                        <p class="text-xs font-semibold uppercase tracking-[0.12em] text-stone-500">Step 2</p>
                        <h3 class="mt-3 text-lg font-semibold text-stone-900">Pick the look you want</h3>
                        <p class="mt-2 text-sm leading-relaxed text-stone-600">
                            Switch paper style, handwriting font, font size, and ink color until the page fits your notes or assignment.
                        </p>
                    </article>

                    <article class="pt-soft-card p-5">
                        <p class="text-xs font-semibold uppercase tracking-[0.12em] text-stone-500">Step 3</p>
                        <h3 class="mt-3 text-lg font-semibold text-stone-900">Export the finished page</h3>
                        <p class="mt-2 text-sm leading-relaxed text-stone-600">
                            Use Export Writing to download the current page or every page as PNG or PDF from one menu.
                        </p>
                    </article>
                </div>
            </div>
        </section>

        @include('components.faqs.accordion', [
            'section' => $homePageData['faqs']['text_to_handwriting_converter'] ?? [],
            'sectionClass' => 'pt-container px-0 pt-16 pb-8 sm:pt-20',
            'titleClass' => 'text-center text-3xl font-semibold text-stone-900',
            'descriptionClass' => 'mt-2 text-center text-sm text-stone-600',
            'itemsWrapperClass' => 'mt-6 space-y-3',
            'enableSchema' => true,
        ])

        <section class="pt-container px-0 pt-16 pb-12 sm:pt-20">
            <div class="flex items-center justify-between gap-4">
                <h2 class="text-3xl font-semibold text-stone-900">Related Tools</h2>
                <a
                    href="{{ route('home') }}#pick-potato"
                    aria-label="Browse all tools"
                    class="pt-link-arrow inline-flex items-center gap-1.5 text-sm font-semibold text-primary transition-colors duration-200 focus-visible:rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary/40 focus-visible:ring-offset-2">
                    Browse all
                    <span class="pt-link-arrow-icon" aria-hidden="true">&rarr;</span>
                </a>
            </div>

            <div class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <a
                    href="{{ route('tools.age-calculator') }}"
                    class="pt-soft-card pt-tool-card block p-4"
                    aria-label="Open Age Calculator tool">
                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-primary/10 text-primary">
                        <i class="fa-solid fa-calendar-days" aria-hidden="true"></i>
                    </span>
                    <h3 class="mt-3 text-base font-semibold text-stone-900">Age Calculator</h3>
                    <p class="mt-2 text-xs leading-relaxed text-stone-600">Calculate exact age in years, months, and days with a clear instant result.</p>
                    <span class="pt-link-arrow mt-3 inline-flex items-center gap-1.5 text-sm font-semibold text-primary">
                        Open Tool
                        <span class="pt-link-arrow-icon" aria-hidden="true">&rarr;</span>
                    </span>
                </a>

                <a
                    href="{{ route('tools.height-converter') }}"
                    class="pt-soft-card pt-tool-card block p-4"
                    aria-label="Open Height Converter tool">
                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-primary/10 text-primary">
                        <i class="fa-solid fa-ruler-vertical" aria-hidden="true"></i>
                    </span>
                    <h3 class="mt-3 text-base font-semibold text-stone-900">Height Converter</h3>
                    <p class="mt-2 text-xs leading-relaxed text-stone-600">Convert centimeters, meters, feet, and inches with exact conversion math.</p>
                    <span class="pt-link-arrow mt-3 inline-flex items-center gap-1.5 text-sm font-semibold text-primary">
                        Open Tool
                        <span class="pt-link-arrow-icon" aria-hidden="true">&rarr;</span>
                    </span>
                </a>

                <a
                    href="{{ route('tools.snow-day-calculator') }}"
                    class="pt-soft-card pt-tool-card block p-4"
                    aria-label="Open Snow Day Calculator tool">
                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-primary/10 text-primary">
                        <i class="fa-solid fa-snowflake" aria-hidden="true"></i>
                    </span>
                    <h3 class="mt-3 text-base font-semibold text-stone-900">Snow Day Calculator</h3>
                    <p class="mt-2 text-xs leading-relaxed text-stone-600">Estimate school closure chance from snow, ice, wind, and timing inputs.</p>
                    <span class="pt-link-arrow mt-3 inline-flex items-center gap-1.5 text-sm font-semibold text-primary">
                        Open Tool
                        <span class="pt-link-arrow-icon" aria-hidden="true">&rarr;</span>
                    </span>
                </a>

                <article class="pt-soft-card p-4">
                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-primary/10 text-primary">
                        <i class="fa-solid fa-wand-magic-sparkles" aria-hidden="true"></i>
                    </span>
                    <h3 class="mt-3 text-base font-semibold text-stone-900">More Creative Tools</h3>
                    <p class="mt-2 text-xs leading-relaxed text-stone-600">More creative generators and stylers can be added as new export presets go live.</p>
                    <button type="button" class="pt-btn-secondary mt-3" disabled>Coming soon</button>
                </article>
            </div>
        </section>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const JsPdf = window.PotatoTextToHandwriting?.jsPDF;
            const paperOptions = @json($paperOptions);
            const fontOptions = @json($fontOptions);
            const defaultFontId = 'kalam';
            const alignmentPresetShiftMap = {
                narrow: -10,
                standard: 0,
                wide: 18,
            };
            const paperMap = new Map(paperOptions.map((paper) => [paper.id, paper]));
            const fontMap = new Map(fontOptions.map((font) => [font.id, font]));

            const paperInput = document.getElementById('page-background');
            const fontInput = document.getElementById('handwriting-font');
            const paperSummaryImage = document.getElementById('paper-summary-image');
            const paperSummaryLabel = document.getElementById('paper-summary-label');
            const paperSummaryDescription = document.getElementById('paper-summary-description');
            const fontSummaryLabel = document.getElementById('font-summary-label');
            const fontSummaryScripts = document.getElementById('font-summary-scripts');
            const paperOptionButtons = Array.from(document.querySelectorAll('.paper-option'));
            const fontOptionButtons = Array.from(document.querySelectorAll('.font-option'));
            const pickerDetails = Array.from(document.querySelectorAll('.handwriting-picker'));
            const toolbarButtons = Array.from(document.querySelectorAll('.toolbar-btn'));
            const inkInput = document.getElementById('ink-color');
            const inkHex = document.getElementById('ink-hex');
            const editorInput = document.getElementById('handwriting-editor');
            const handwritingError = document.getElementById('handwriting-error');
            const characterCount = document.getElementById('character-count');
            const canvas = document.getElementById('handwriting-preview-canvas');
            const ctx = canvas.getContext('2d');
            const pagePagination = document.getElementById('page-pagination');
            const pageSummary = document.getElementById('page-summary');
            const templateMetaSummary = document.getElementById('template-meta-summary');
            const alignmentPresetInput = document.getElementById('alignment-preset');
            const fontSizePresetInput = document.getElementById('font-size-preset');
            const filenameBaseInput = document.getElementById('filename-base');
            const exportWritingButton = document.getElementById('export-writing-button');
            const exportWritingMenu = document.getElementById('export-writing-menu');
            const exportOptionButtons = Array.from(document.querySelectorAll('[data-export-action]'));
            const clearTextButton = document.getElementById('clear-text');

            const state = {
                images: new Map(),
                loadedFonts: new Set(),
                fontMetrics: new Map(),
                textMeasureCache: new Map(),
                readyPromise: null,
                renderVersion: 0,
                hasText: false,
                currentPage: 1,
                totalPages: 1,
                renderDocument: null,
            };

            function showError(message) {
                handwritingError.textContent = message;
                handwritingError.classList.remove('hidden');
            }

            function clearError() {
                handwritingError.textContent = '';
                handwritingError.classList.add('hidden');
            }

            function getSelectedPaper() {
                return paperMap.get(paperInput.value) || paperOptions[0];
            }

            function getSelectedFont() {
                return fontMap.get(fontInput.value) || fontMap.get(defaultFontId) || fontOptions[0];
            }

            function getDefaultFontSizeForPaper(paperId = paperInput.value) {
                const paper = paperMap.get(paperId) || paperOptions[0];
                return String(paper?.template?.fontSize || 27);
            }

            function normalizeText(value) {
                return String(value || '')
                    .replace(/\r/g, '')
                    .replace(/\u00a0/g, ' ');
            }

            function getEditorPlainText() {
                const plainText = normalizeText(editorInput.innerText || '');
                return plainText.replace(/\n{3,}/g, '\n\n').trim();
            }

            function isEditorEmpty() {
                return getEditorPlainText().length === 0;
            }

            function updateEditorEmptyState() {
                editorInput.dataset.empty = String(isEditorEmpty());
            }

            function setEditorHtml(value) {
                editorInput.innerHTML = value ? String(value).trim() : '';
                updateEditorEmptyState();
            }

            function setExportReady(isReady) {
                exportWritingButton.disabled = !isReady;

                if (!isReady) {
                    closeExportMenu();
                }
            }

            function updateControlLabels() {
                characterCount.textContent = getEditorPlainText().length.toLocaleString();
                inkHex.textContent = inkInput.value.toUpperCase();
                templateMetaSummary.textContent = `${fontSizePresetInput.selectedOptions[0]?.textContent || '27 px'} • Fixed grid`;
            }

            function updatePageSummary() {
                pageSummary.textContent = `Page ${state.currentPage} of ${state.totalPages}`;
            }

            function updateExportMenuOptions() {
                const hasMultiplePages = state.totalPages > 1;

                exportOptionButtons.forEach((button) => {
                    const labelNode = button.querySelector('.export-option-label');

                    if (!labelNode) {
                        return;
                    }

                    if (button.dataset.exportAction === 'current-png' || button.dataset.exportAction === 'current-pdf') {
                        labelNode.textContent = hasMultiplePages
                            ? button.dataset.multiLabel
                            : button.dataset.singleLabel;
                    }

                    if (button.dataset.exportAction === 'all-png' || button.dataset.exportAction === 'all-pdf') {
                        button.hidden = !hasMultiplePages;
                    }
                });
            }

            function renderPagination() {
                pagePagination.innerHTML = '';

                if (state.totalPages <= 1) {
                    pagePagination.hidden = true;
                    updatePageSummary();
                    return;
                }

                pagePagination.hidden = false;

                for (let pageNumber = 1; pageNumber <= state.totalPages; pageNumber += 1) {
                    const button = document.createElement('button');
                    button.type = 'button';
                    button.className = `page-pagination-btn${pageNumber === state.currentPage ? ' is-active' : ''}`;
                    button.textContent = String(pageNumber);
                    button.setAttribute('aria-label', `Go to page ${pageNumber}`);
                    button.setAttribute('aria-current', pageNumber === state.currentPage ? 'page' : 'false');
                    button.addEventListener('click', () => {
                        setCurrentPage(pageNumber);
                    });
                    pagePagination.appendChild(button);
                }

                updatePageSummary();
            }

            function setCurrentPage(pageNumber) {
                const nextPage = Math.min(Math.max(1, pageNumber), state.totalPages);

                if (state.currentPage === nextPage && pagePagination.childElementCount) {
                    renderCurrentPageCanvas();
                    updatePageSummary();
                    return;
                }

                state.currentPage = nextPage;
                renderPagination();
                renderCurrentPageCanvas();
            }

            function updatePickerSummaries() {
                const paper = getSelectedPaper();
                const font = getSelectedFont();

                paperSummaryImage.src = paper.src;
                paperSummaryLabel.textContent = paper.label;
                paperSummaryDescription.textContent = paper.description;
                fontSummaryLabel.textContent = font.label;
                fontSummaryLabel.style.fontFamily = font.family;
                fontSummaryScripts.textContent = font.scripts || 'Latin';
            }

            function buildFontString(style, template, font) {
                const parts = [];

                if (style?.italic) {
                    parts.push('italic');
                }

                if (style?.bold) {
                    parts.push('700');
                }

                parts.push(`${template.fontSize}px`);
                parts.push(font.family);

                return parts.join(' ');
            }

            function createEmptyStyle() {
                return {
                    bold: false,
                    italic: false,
                    underline: false,
                    strike: false,
                };
            }

            function getStyleKey(style) {
                return `${style.bold ? 'b' : ''}${style.italic ? 'i' : ''}${style.underline ? 'u' : ''}${style.strike ? 's' : ''}` || 'plain';
            }

            function setContextFont(context, style, template, font) {
                context.font = buildFontString(style, template, font);
            }

            function measureStyledText(context, text, style, template, font) {
                if (!text) {
                    return 0;
                }

                const cacheKey = `${template.fontSize}:${font.id}:${getStyleKey(style)}:${text}`;

                if (state.textMeasureCache.has(cacheKey)) {
                    return state.textMeasureCache.get(cacheKey);
                }

                context.save();
                setContextFont(context, style, template, font);
                const width = context.measureText(text).width + (template.letterSpacing * Math.max(0, [...text].length - 1));
                context.restore();

                state.textMeasureCache.set(cacheKey, width);

                return width;
            }

            function loadImage(source) {
                return new Promise((resolve, reject) => {
                    const image = new Image();

                    image.onload = () => resolve(image);
                    image.onerror = () => reject(new Error(`Unable to load image: ${source}`));
                    image.src = source;
                });
            }

            async function ensureAssets() {
                if (state.readyPromise) {
                    return state.readyPromise;
                }

                state.readyPromise = (async () => {
                    const imageEntries = await Promise.all(
                        paperOptions.map(async (paper) => [paper.id, await loadImage(paper.src)])
                    );

                    imageEntries.forEach(([paperId, image]) => {
                        state.images.set(paperId, image);
                    });
                })().catch((error) => {
                    state.readyPromise = null;
                    throw error;
                });

                return state.readyPromise;
            }

            async function ensureSelectedFontLoaded() {
                const font = getSelectedFont();

                if (!document.fonts || !document.fonts.load || state.loadedFonts.has(font.id)) {
                    return;
                }

                await document.fonts.load(`120px ${font.load}`);
                state.loadedFonts.add(font.id);
            }

            function getResolvedTemplate(paper) {
                const baseTemplate = paper.template;
                const rightEdge = baseTemplate.startX + baseTemplate.maxWidth;
                const startX = Math.max(
                    baseTemplate.marginX + 12,
                    baseTemplate.startX + (alignmentPresetShiftMap[alignmentPresetInput.value] ?? 0)
                );
                const maxWidth = Math.max(120, rightEdge - startX);
                const selectedFontSize = Number.parseFloat(fontSizePresetInput.value);
                const fontSize = Number((Number.isFinite(selectedFontSize) ? selectedFontSize : baseTemplate.fontSize).toFixed(2));

                return {
                    ...baseTemplate,
                    startX,
                    maxWidth,
                    fontSize,
                };
            }

            function getFontMetrics(context, paperId, font, template) {
                const cacheKey = `${paperId}:${font.id}:${template.fontSize}`;

                if (state.fontMetrics.has(cacheKey)) {
                    return state.fontMetrics.get(cacheKey);
                }

                context.save();
                setContextFont(context, createEmptyStyle(), template, font);
                const metrics = context.measureText('Agjpqy');
                context.restore();

                const ascent = Math.ceil(metrics.fontBoundingBoxAscent || metrics.actualBoundingBoxAscent || (template.fontSize * 0.78));
                const descent = Math.ceil(metrics.fontBoundingBoxDescent || metrics.actualBoundingBoxDescent || (template.fontSize * 0.22));
                const value = {
                    ascent,
                    descent,
                    drawStartY: Number.isFinite(template.drawStartY) ? template.drawStartY : (template.startY - ascent),
                };

                state.fontMetrics.set(cacheKey, value);
                return value;
            }

            function stylesMatch(first, second) {
                return Boolean(first)
                    && Boolean(second)
                    && first.bold === second.bold
                    && first.italic === second.italic
                    && first.underline === second.underline
                    && first.strike === second.strike;
            }

            function appendTextSegment(segments, text, style) {
                if (!text) {
                    return;
                }

                const normalized = normalizeText(text).replace(/\t/g, '    ');
                const parts = normalized.split('\n');

                parts.forEach((part, index) => {
                    if (part) {
                        const lastSegment = segments[segments.length - 1];

                        if (lastSegment && !lastSegment.break && stylesMatch(lastSegment.style, style)) {
                            lastSegment.text += part;
                        } else {
                            segments.push({
                                text: part,
                                style: { ...style },
                            });
                        }
                    }

                    if (index < parts.length - 1) {
                        segments.push({ break: true });
                    }
                });
            }

            function deriveInlineStyle(element, inheritedStyle) {
                const nextStyle = { ...inheritedStyle };
                const tagName = element.tagName.toLowerCase();
                const textDecoration = `${element.style.textDecorationLine || ''} ${element.style.textDecoration || ''}`.toLowerCase();
                const fontWeight = element.style.fontWeight || '';

                if (['b', 'strong'].includes(tagName) || fontWeight === 'bold' || Number.parseInt(fontWeight, 10) >= 600) {
                    nextStyle.bold = true;
                }

                if (['i', 'em'].includes(tagName) || element.style.fontStyle === 'italic') {
                    nextStyle.italic = true;
                }

                if (tagName === 'u' || textDecoration.includes('underline')) {
                    nextStyle.underline = true;
                }

                if (['s', 'strike', 'del'].includes(tagName) || textDecoration.includes('line-through')) {
                    nextStyle.strike = true;
                }

                return nextStyle;
            }

            function extractInlineSegments(node, inheritedStyle = createEmptyStyle(), segments = []) {
                if (node.nodeType === Node.TEXT_NODE) {
                    appendTextSegment(segments, node.textContent || '', inheritedStyle);
                    return segments;
                }

                if (node.nodeType !== Node.ELEMENT_NODE) {
                    return segments;
                }

                const element = node;
                const tagName = element.tagName.toLowerCase();

                if (tagName === 'br') {
                    segments.push({ break: true });
                    return segments;
                }

                if (['ul', 'ol'].includes(tagName)) {
                    return segments;
                }

                const nextStyle = deriveInlineStyle(element, inheritedStyle);
                Array.from(element.childNodes).forEach((childNode) => {
                    extractInlineSegments(childNode, nextStyle, segments);
                });

                return segments;
            }

            function getBlockAlignment(element) {
                const alignment = (element.style.textAlign || element.getAttribute('align') || '').toLowerCase();

                if (['left', 'center', 'right'].includes(alignment)) {
                    return alignment;
                }

                return 'left';
            }

            function createBlockFromElement(element, listContext = null) {
                const segments = extractInlineSegments(element, createEmptyStyle(), []);
                const prefixText = listContext
                    ? listContext.type === 'ordered'
                        ? `${listContext.index}. `
                        : '• '
                    : '';

                return {
                    align: listContext ? 'left' : getBlockAlignment(element),
                    prefixText,
                    firstLineIndent: listContext ? 16 : 0,
                    segments,
                };
            }

            function getRenderableBlocks() {
                const blocks = [];
                const childNodes = Array.from(editorInput.childNodes);

                if (!childNodes.length) {
                    return blocks;
                }

                childNodes.forEach((childNode) => {
                    if (childNode.nodeType === Node.TEXT_NODE) {
                        const text = normalizeText(childNode.textContent || '');

                        if (text.trim()) {
                            const segments = [];
                            appendTextSegment(segments, text, createEmptyStyle());
                            blocks.push({
                                align: 'left',
                                prefixText: '',
                                firstLineIndent: 0,
                                segments,
                            });
                        }

                        return;
                    }

                    if (childNode.nodeType !== Node.ELEMENT_NODE) {
                        return;
                    }

                    const element = childNode;
                    const tagName = element.tagName.toLowerCase();

                    if (tagName === 'br') {
                        blocks.push({
                            align: 'left',
                            prefixText: '',
                            firstLineIndent: 0,
                            segments: [],
                        });
                        return;
                    }

                    if (tagName === 'ul' || tagName === 'ol') {
                        Array.from(element.children).forEach((listItem, index) => {
                            if (listItem.tagName.toLowerCase() === 'li') {
                                blocks.push(createBlockFromElement(listItem, {
                                    type: tagName === 'ol' ? 'ordered' : 'unordered',
                                    index: index + 1,
                                }));
                            }
                        });
                        return;
                    }

                    blocks.push(createBlockFromElement(element));
                });

                return blocks;
            }

            function tokenizeSegments(segments) {
                const tokens = [];

                segments.forEach((segment) => {
                    if (segment.break) {
                        tokens.push({ break: true });
                        return;
                    }

                    (segment.text.match(/\S+|\s+/g) || []).forEach((part) => {
                        tokens.push({
                            text: part,
                            style: { ...segment.style },
                        });
                    });
                });

                return tokens;
            }

            function getLineLimit(template, line) {
                return Math.max(120, template.maxWidth - line.indent);
            }

            function addFragmentToLine(line, fragment, context, template, font) {
                const lastFragment = line.fragments[line.fragments.length - 1];

                if (lastFragment && stylesMatch(lastFragment.style, fragment.style)) {
                    lastFragment.text += fragment.text;
                } else {
                    line.fragments.push({
                        text: fragment.text,
                        style: { ...fragment.style },
                    });
                }

                line.width += measureStyledText(context, fragment.text, fragment.style, template, font);

                if (fragment.text.trim()) {
                    line.hasContent = true;
                }
            }

            function fitTextToWidth(context, text, style, template, font, maxWidth) {
                const characters = [...text];
                let fittedText = '';

                for (let index = 0; index < characters.length; index += 1) {
                    const candidate = fittedText + characters[index];

                    if (!fittedText || measureStyledText(context, candidate, style, template, font) <= maxWidth) {
                        fittedText = candidate;
                        continue;
                    }

                    break;
                }

                return fittedText;
            }

            function wrapBlock(context, block, template, font) {
                const prefixFragments = block.prefixText
                    ? [{ text: block.prefixText, style: createEmptyStyle() }]
                    : [];
                const prefixWidth = prefixFragments.reduce((totalWidth, fragment) => {
                    return totalWidth + measureStyledText(context, fragment.text, fragment.style, template, font);
                }, 0);
                const continuationIndent = block.prefixText ? block.firstLineIndent + prefixWidth : block.firstLineIndent;
                const lines = [];
                let currentLine = {
                    align: block.align,
                    indent: block.firstLineIndent,
                    fragments: prefixFragments.map((fragment) => ({ ...fragment, style: { ...fragment.style } })),
                    width: prefixWidth,
                    hasContent: false,
                };

                const pushCurrentLine = () => {
                    lines.push({
                        align: currentLine.align,
                        indent: currentLine.indent,
                        fragments: currentLine.fragments.map((fragment) => ({
                            text: fragment.text,
                            style: { ...fragment.style },
                        })),
                        width: currentLine.width,
                        hasContent: currentLine.hasContent,
                    });
                };

                const startNewLine = () => {
                    currentLine = {
                        align: block.align,
                        indent: continuationIndent,
                        fragments: [],
                        width: 0,
                        hasContent: false,
                    };
                };

                const tokens = tokenizeSegments(block.segments);

                if (!tokens.length) {
                    pushCurrentLine();
                    return lines;
                }

                tokens.forEach((token) => {
                    if (token.break) {
                        pushCurrentLine();
                        startNewLine();
                        return;
                    }

                    const tokenWidth = measureStyledText(context, token.text, token.style, template, font);
                    const currentLineLimit = getLineLimit(template, currentLine);

                    if (currentLine.width + tokenWidth <= currentLineLimit) {
                        addFragmentToLine(currentLine, token, context, template, font);
                        return;
                    }

                    if (/^\s+$/.test(token.text)) {
                        pushCurrentLine();
                        startNewLine();
                        return;
                    }

                    let remainingText = token.text;

                    if (currentLine.hasContent) {
                        pushCurrentLine();
                        startNewLine();
                    }

                    while (remainingText) {
                        const availableWidth = getLineLimit(template, currentLine) - currentLine.width;
                        const fittedText = fitTextToWidth(context, remainingText, token.style, template, font, availableWidth);
                        const nextText = fittedText || [...remainingText][0];

                        addFragmentToLine(currentLine, {
                            text: nextText,
                            style: token.style,
                        }, context, template, font);

                        remainingText = remainingText.slice(nextText.length);

                        if (remainingText) {
                            pushCurrentLine();
                            startNewLine();
                        }
                    }
                });

                pushCurrentLine();

                return lines;
            }

            function getEffectiveLinesPerPage(template, metrics) {
                const configuredLineCount = Math.max(1, Number.parseInt(template.linesPerPage, 10) || 1);
                const bottomPadding = Number.isFinite(template.bottomPadding)
                    ? template.bottomPadding
                    : template.lineHeight;
                const drawableHeight = template.height - template.startY - metrics.descent - bottomPadding;
                const heightLimitedLineCount = Math.floor(drawableHeight / template.lineHeight) + 1;

                return Math.max(1, Math.min(configuredLineCount, heightLimitedLineCount));
            }

            function buildRenderablePages(context, template, font, metrics) {
                const wrappedLines = [];

                getRenderableBlocks().forEach((block) => {
                    wrappedLines.push(...wrapBlock(context, block, template, font));
                });

                while (wrappedLines.length && !wrappedLines[wrappedLines.length - 1].hasContent) {
                    wrappedLines.pop();
                }

                const pages = [];
                const linesPerPage = getEffectiveLinesPerPage(template, metrics);

                for (let offset = 0; offset < wrappedLines.length; offset += linesPerPage) {
                    pages.push(wrappedLines.slice(offset, offset + linesPerPage));
                }

                if (!pages.length) {
                    pages.push([]);
                }

                return pages;
            }

            function updateOutputState({ hasText, totalPages = 1 }) {
                state.hasText = hasText;
                state.totalPages = Math.max(1, totalPages);

                if (state.currentPage > state.totalPages) {
                    state.currentPage = state.totalPages;
                }

                setExportReady(hasText);
                updateExportMenuOptions();
                renderPagination();
            }

            function clearPreviewCanvas() {
                const template = getResolvedTemplate(getSelectedPaper());

                canvas.width = template.width;
                canvas.height = template.height;
                ctx.clearRect(0, 0, template.width, template.height);
            }

            function drawPageToCanvas(targetCanvas, pageNumber) {
                if (!state.renderDocument) {
                    return null;
                }

                const {
                    pages,
                    template,
                    backgroundImage,
                    font,
                    ink,
                    metrics,
                } = state.renderDocument;

                const targetContext = targetCanvas.getContext('2d');
                const pageLines = pages[pageNumber - 1] || [];
                const canvasWidth = backgroundImage.naturalWidth || template.width;
                const canvasHeight = backgroundImage.naturalHeight || template.height;

                targetCanvas.width = canvasWidth;
                targetCanvas.height = canvasHeight;

                targetContext.clearRect(0, 0, canvasWidth, canvasHeight);
                targetContext.drawImage(backgroundImage, 0, 0);
                targetContext.textAlign = 'left';
                targetContext.textBaseline = 'top';
                targetContext.fillStyle = ink;
                targetContext.font = `${template.fontSize}px ${font.family}`;

                pageLines.forEach((line, lineIndex) => {
                    if (!line) {
                        return;
                    }

                    const availableWidth = Math.max(0, template.maxWidth - line.indent);
                    let currentX = template.startX + line.indent;
                    const drawY = metrics.drawStartY + (lineIndex * template.lineHeight);
                    const alignment = ['center', 'right'].includes(line.align) ? line.align : 'left';

                    if (alignment === 'center') {
                        currentX += Math.max(0, (availableWidth - line.width) / 2);
                    } else if (alignment === 'right') {
                        currentX += Math.max(0, availableWidth - line.width);
                    }

                    line.fragments.forEach((fragment) => {
                        if (!fragment.text) {
                            return;
                        }

                        targetContext.font = buildFontString(fragment.style, template, font);
                        const fragmentWidth = measureStyledText(targetContext, fragment.text, fragment.style, template, font);

                        if (template.letterSpacing === 0) {
                            targetContext.fillText(fragment.text, currentX, drawY);
                        } else {
                            [...fragment.text].forEach((character, index) => {
                                targetContext.fillText(character, currentX, drawY);
                                currentX += targetContext.measureText(character).width;

                                if (index < fragment.text.length - 1) {
                                    currentX += template.letterSpacing;
                                }
                            });
                            currentX -= fragmentWidth;
                        }

                        if (fragment.style.underline || fragment.style.strike) {
                            targetContext.save();
                            targetContext.strokeStyle = ink;
                            targetContext.lineWidth = Math.max(1, template.fontSize / 18);

                            if (fragment.style.underline) {
                                const underlineY = drawY + metrics.ascent + Math.max(1, template.fontSize * 0.06);
                                targetContext.beginPath();
                                targetContext.moveTo(currentX, underlineY);
                                targetContext.lineTo(currentX + fragmentWidth, underlineY);
                                targetContext.stroke();
                            }

                            if (fragment.style.strike) {
                                const strikeY = drawY + (metrics.ascent * 0.55);
                                targetContext.beginPath();
                                targetContext.moveTo(currentX, strikeY);
                                targetContext.lineTo(currentX + fragmentWidth, strikeY);
                                targetContext.stroke();
                            }

                            targetContext.restore();
                        }

                        currentX += fragmentWidth;
                    });
                });

                return targetCanvas;
            }

            function renderCurrentPageCanvas() {
                if (!state.renderDocument) {
                    clearPreviewCanvas();
                    return;
                }

                drawPageToCanvas(canvas, state.currentPage);
            }

            function createPageCanvas(pageNumber) {
                const offscreenCanvas = document.createElement('canvas');
                return drawPageToCanvas(offscreenCanvas, pageNumber);
            }

            async function renderPreview() {
                const currentRenderVersion = ++state.renderVersion;
                clearError();

                try {
                    await ensureAssets();
                    await ensureSelectedFontLoaded();
                } catch (error) {
                    state.renderDocument = null;
                    clearPreviewCanvas();
                    updateOutputState({ hasText: false, totalPages: 1 });
                    showError('Unable to load page preview. Refresh and try again.');
                    return;
                }

                if (currentRenderVersion !== state.renderVersion) {
                    return;
                }

                const paper = getSelectedPaper();
                const font = getSelectedFont();
                const template = getResolvedTemplate(paper);
                const backgroundImage = state.images.get(paper.id);
                const hasText = !isEditorEmpty();
                state.textMeasureCache.clear();

                if (!backgroundImage) {
                    state.renderDocument = null;
                    clearPreviewCanvas();
                    updateOutputState({ hasText: false, totalPages: 1 });
                    showError('Unable to load this paper style right now.');
                    return;
                }

                const metrics = getFontMetrics(ctx, paper.id, font, template);
                const pages = hasText
                    ? buildRenderablePages(ctx, template, font, metrics)
                    : [[]];

                state.renderDocument = {
                    pages,
                    template,
                    backgroundImage,
                    font,
                    ink: inkInput.value,
                    metrics,
                };

                updateOutputState({
                    hasText,
                    totalPages: pages.length,
                });

                if (!hasText) {
                    state.currentPage = 1;
                }

                setCurrentPage(Math.min(state.totalPages, Math.max(1, state.currentPage)));
            }

            function scheduleRender() {
                window.clearTimeout(scheduleRender.timerId);
                scheduleRender.timerId = window.setTimeout(renderPreview, 220);
            }

            function slugify(value) {
                return value
                    .toLowerCase()
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/^-|-$/g, '');
            }

            function createFilename(extension, suffix = '') {
                const normalizedSuffix = suffix ? `-${slugify(String(suffix))}` : '';
                const paper = getSelectedPaper();
                const customBase = slugify(filenameBaseInput.value || '');
                const baseName = customBase || `text-to-handwriting-${slugify(paper.id)}`;

                return `${baseName}${normalizedSuffix}.${extension}`;
            }

            function downloadDataUrl(dataUrl, filename) {
                const link = document.createElement('a');
                link.href = dataUrl;
                link.download = filename;
                document.body.appendChild(link);
                link.click();
                link.remove();
            }

            function openExportMenu() {
                if (exportWritingButton.disabled) {
                    return;
                }

                exportWritingMenu.hidden = false;
                exportWritingButton.setAttribute('aria-expanded', 'true');
            }

            function closeExportMenu() {
                exportWritingMenu.hidden = true;
                exportWritingButton.setAttribute('aria-expanded', 'false');
            }

            function toggleExportMenu() {
                if (exportWritingMenu.hidden) {
                    openExportMenu();
                    return;
                }

                closeExportMenu();
            }

            function handleCurrentImageDownload() {
                if (!state.hasText) {
                    showError('Enter text to download your handwriting page.');
                    return;
                }

                clearError();
                renderCurrentPageCanvas();
                downloadDataUrl(canvas.toDataURL('image/png'), createFilename('png', `page-${state.currentPage}`));
            }

            async function handleAllImagesDownload() {
                if (!state.hasText || !state.renderDocument) {
                    showError('Enter text to download your handwriting pages.');
                    return;
                }

                clearError();

                for (let pageNumber = 1; pageNumber <= state.totalPages; pageNumber += 1) {
                    const pageCanvas = createPageCanvas(pageNumber);
                    downloadDataUrl(pageCanvas.toDataURL('image/png'), createFilename('png', `page-${pageNumber}`));
                    await new Promise((resolve) => window.setTimeout(resolve, 120));
                }
            }

            function createPdfInstance() {
                const pdfWidth = state.renderDocument?.template?.width || canvas.width;
                const pdfHeight = state.renderDocument?.template?.height || canvas.height;

                return new JsPdf({
                    orientation: pdfWidth >= pdfHeight ? 'landscape' : 'portrait',
                    unit: 'px',
                    format: [pdfWidth, pdfHeight],
                    compress: true,
                });
            }

            function handleCurrentPdfDownload() {
                if (!state.hasText) {
                    showError('Enter text to download your handwriting page.');
                    return;
                }

                if (!JsPdf) {
                    showError('The PDF library is still loading. Please try again in a moment.');
                    return;
                }

                clearError();
                renderCurrentPageCanvas();

                const pdf = createPdfInstance();
                pdf.addImage(canvas.toDataURL('image/png'), 'PNG', 0, 0, canvas.width, canvas.height, undefined, 'FAST');
                pdf.save(createFilename('pdf', `page-${state.currentPage}`));
            }

            function handleAllPdfDownload() {
                if (!state.hasText || !state.renderDocument) {
                    showError('Enter text to download your handwriting pages.');
                    return;
                }

                if (!JsPdf) {
                    showError('The PDF library is still loading. Please try again in a moment.');
                    return;
                }

                clearError();

                const pdf = createPdfInstance();

                for (let pageNumber = 1; pageNumber <= state.totalPages; pageNumber += 1) {
                    const pageCanvas = createPageCanvas(pageNumber);

                    if (pageNumber > 1) {
                        pdf.addPage([pageCanvas.width, pageCanvas.height], pageCanvas.width >= pageCanvas.height ? 'landscape' : 'portrait');
                    }

                    pdf.addImage(pageCanvas.toDataURL('image/png'), 'PNG', 0, 0, pageCanvas.width, pageCanvas.height, undefined, 'FAST');
                }

                pdf.save(createFilename('pdf', 'all-pages'));
            }

            function focusEditorIfNeeded() {
                if (document.activeElement !== editorInput) {
                    editorInput.focus();
                }
            }

            function selectionInsideEditor() {
                const selection = window.getSelection();

                if (!selection || selection.rangeCount === 0) {
                    return false;
                }

                const anchorNode = selection.anchorNode;
                return anchorNode ? editorInput.contains(anchorNode) || anchorNode === editorInput : false;
            }

            function applyEditorCommand(commandName) {
                focusEditorIfNeeded();
                document.execCommand(commandName, false, null);
                updateEditorEmptyState();
                refreshToolbarState();
                updateControlLabels();
                scheduleRender();
            }

            function refreshToolbarState() {
                const selectionActive = selectionInsideEditor();

                toolbarButtons.forEach((button) => {
                    const commandName = button.dataset.command;

                    if (!commandName) {
                        button.classList.remove('is-active');
                        return;
                    }

                    let isActive = false;

                    if (selectionActive) {
                        try {
                            isActive = document.queryCommandState(commandName);
                        } catch (error) {
                            isActive = false;
                        }
                    }

                    button.classList.toggle('is-active', isActive);
                });
            }

            function insertPlainTextAtCursor(text) {
                focusEditorIfNeeded();
                document.execCommand('insertText', false, normalizeText(text));
            }

            paperOptionButtons.forEach((button) => {
                button.addEventListener('click', () => {
                    paperInput.value = button.dataset.paperId;
                    fontSizePresetInput.value = getDefaultFontSizeForPaper(button.dataset.paperId);
                    state.currentPage = 1;
                    updatePickerSummaries();
                    updateControlLabels();
                    button.closest('details').open = false;
                    scheduleRender();
                });
            });

            fontOptionButtons.forEach((button) => {
                button.addEventListener('click', () => {
                    fontInput.value = button.dataset.fontId;
                    updatePickerSummaries();
                    updateControlLabels();
                    button.closest('details').open = false;
                    scheduleRender();
                });
            });

            document.addEventListener('click', (event) => {
                pickerDetails.forEach((details) => {
                    if (!details.contains(event.target)) {
                        details.open = false;
                    }
                });

                if (!event.target.closest('#export-writing-menu') && !event.target.closest('#export-writing-button')) {
                    closeExportMenu();
                }
            });

            toolbarButtons.forEach((button) => {
                button.addEventListener('mousedown', (event) => {
                    event.preventDefault();
                });

                button.addEventListener('click', () => {
                    const actionName = button.dataset.action;
                    const commandName = button.dataset.command;

                    if (actionName) {
                        applyEditorCommand(actionName);
                        return;
                    }

                    if (commandName) {
                        applyEditorCommand(commandName);
                    }
                });
            });

            editorInput.addEventListener('paste', (event) => {
                event.preventDefault();
                const pastedText = event.clipboardData?.getData('text/plain') || '';
                insertPlainTextAtCursor(pastedText);
                updateEditorEmptyState();
                updateControlLabels();
                scheduleRender();
            });

            editorInput.addEventListener('input', () => {
                updateEditorEmptyState();
                updateControlLabels();
                refreshToolbarState();
                scheduleRender();
            });

            editorInput.addEventListener('focus', refreshToolbarState);
            editorInput.addEventListener('keyup', refreshToolbarState);
            editorInput.addEventListener('mouseup', refreshToolbarState);

            document.addEventListener('selectionchange', () => {
                if (selectionInsideEditor() || document.activeElement === editorInput) {
                    refreshToolbarState();
                }
            });

            inkInput.addEventListener('input', () => {
                updateControlLabels();
                scheduleRender();
            });

            [alignmentPresetInput, fontSizePresetInput].forEach((input) => {
                input.addEventListener('change', () => {
                    state.currentPage = 1;
                    updateControlLabels();
                    scheduleRender();
                });
            });

            [filenameBaseInput].forEach((input) => {
                ['input', 'change'].forEach((eventName) => {
                    input.addEventListener(eventName, updateControlLabels);
                });
            });

            clearTextButton.addEventListener('click', () => {
                paperInput.value = paperOptions[0].id;
                fontInput.value = defaultFontId;
                inkInput.value = '#243247';
                fontSizePresetInput.value = getDefaultFontSizeForPaper(paperOptions[0].id);
                alignmentPresetInput.value = 'standard';
                filenameBaseInput.value = '';
                state.currentPage = 1;
                setEditorHtml('');
                updateControlLabels();
                updatePickerSummaries();
                refreshToolbarState();
                scheduleRender();
            });

            exportWritingButton.addEventListener('click', () => {
                toggleExportMenu();
            });

            exportOptionButtons.forEach((button) => {
                button.addEventListener('click', () => {
                    closeExportMenu();

                    switch (button.dataset.exportAction) {
                        case 'current-png':
                            handleCurrentImageDownload();
                            break;
                        case 'current-pdf':
                            handleCurrentPdfDownload();
                            break;
                        case 'all-png':
                            handleAllImagesDownload();
                            break;
                        case 'all-pdf':
                            handleAllPdfDownload();
                            break;
                        default:
                            break;
                    }
                });
            });

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape') {
                    closeExportMenu();
                }
            });

            fontSizePresetInput.value = getDefaultFontSizeForPaper(paperOptions[0].id);
            updatePickerSummaries();
            updateControlLabels();
            updateEditorEmptyState();
            renderPagination();
            refreshToolbarState();
            renderPreview();
        });
    </script>
@endpush
