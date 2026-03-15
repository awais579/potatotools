@php
    $isToolsPage = request()->routeIs('tools.*');
    $isCategoriesPage = request()->is('categories*');

    $toolLinks = [
        ['label' => 'Height Converter', 'url' => route('tools.height-converter'), 'description' => 'Convert cm, m, ft, and inches'],
        ['label' => 'Age Calculator', 'url' => route('tools.age-calculator'), 'description' => 'Calculate exact age instantly'],
        ['label' => 'Snow Day Calculator', 'url' => route('tools.snow-day-calculator'), 'description' => 'Quick snow day estimate'],
        ['label' => 'BMI Calculator', 'url' => '/tools/bmi-calculator', 'description' => 'Coming next for body metrics'],
    ];

    $categoryLinks = [
        ['label' => 'Life & Utility', 'url' => '/categories/calculators', 'description' => 'Everyday calculators and converters'],
        ['label' => 'Fun & Creative', 'url' => '/categories/creative', 'description' => 'Creative and playful tools'],
        ['label' => 'Developer & Data', 'url' => '/categories/developer-data', 'description' => 'Clean and convert technical data'],
        ['label' => 'Parenting & Family', 'url' => '/categories/parenting-family', 'description' => 'Useful tools for home and family'],
    ];
@endphp

<header class="relative z-30 border-b border-stone-200/50 bg-potato-beige/95 backdrop-blur">
    <div class="pt-container py-3">
        <div class="flex items-center gap-3">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2">
                <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-primary/20 text-xs font-bold text-primary">PT</span>
                <span class="font-display text-lg font-semibold text-stone-900">PotatoTools</span>
            </a>

            <nav class="ml-4 hidden items-center gap-2 md:flex">
                <a
                    href="{{ route('home') }}#pick-potato"
                    class="inline-flex items-center gap-2 rounded-full px-3 py-2 text-sm font-semibold {{ $isToolsPage ? 'bg-white/75 text-primary shadow-sm ring-1 ring-stone-200/70' : 'text-stone-700 hover:bg-white/60 hover:text-primary' }}"
                    @if ($isToolsPage) aria-current="page" @endif>
                    <span class="h-1.5 w-1.5 rounded-full bg-primary"></span>
                    Tools
                </a>

                <div class="relative">
                    <button
                        type="button"
                        id="desktop-tools-button"
                        data-dropdown-target="desktop-tools-menu"
                        class="inline-flex cursor-pointer items-center gap-2 rounded-full px-3 py-2 text-sm font-semibold text-stone-700 transition hover:bg-white/60 hover:text-primary"
                        aria-expanded="false"
                        aria-controls="desktop-tools-menu">
                        <span class="h-1.5 w-1.5 rounded-full bg-primary"></span>
                        Popular
                        <i class="fa-solid fa-chevron-down text-[10px]" aria-hidden="true"></i>
                    </button>

                    <div
                        id="desktop-tools-menu"
                        class="pointer-events-none invisible absolute left-0 top-full z-30 mt-3 w-[20rem] rounded-3xl border border-stone-200/80 bg-white/95 p-3 opacity-0 shadow-[0_18px_45px_rgba(32,24,16,0.12)] transition duration-200">
                        <p class="px-3 pb-2 text-[11px] font-bold uppercase tracking-[0.14em] text-stone-500">Popular Tools</p>
                        <div class="space-y-1">
                            @foreach ($toolLinks as $toolLink)
                                <a
                                    href="{{ $toolLink['url'] }}"
                                    class="block rounded-2xl px-3 py-3 transition hover:bg-potato-beige/80">
                                    <span class="block text-sm font-semibold text-stone-900">{{ $toolLink['label'] }}</span>
                                    <span class="mt-1 block text-xs text-stone-500">{{ $toolLink['description'] }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <button
                        type="button"
                        id="desktop-categories-button"
                        data-dropdown-target="desktop-categories-menu"
                        class="inline-flex cursor-pointer items-center gap-2 rounded-full px-3 py-2 text-sm font-semibold {{ $isCategoriesPage ? 'bg-white/75 text-primary shadow-sm ring-1 ring-stone-200/70' : 'text-stone-700 hover:bg-white/60 hover:text-primary' }}"
                        aria-expanded="false"
                        aria-controls="desktop-categories-menu">
                        <span class="h-1.5 w-1.5 rounded-full bg-accent"></span>
                        Categories
                        <i class="fa-solid fa-chevron-down text-[10px]" aria-hidden="true"></i>
                    </button>

                    <div
                        id="desktop-categories-menu"
                        class="pointer-events-none invisible absolute left-0 top-full z-30 mt-3 w-[21rem] rounded-3xl border border-stone-200/80 bg-white/95 p-3 opacity-0 shadow-[0_18px_45px_rgba(32,24,16,0.12)] transition duration-200">
                        <p class="px-3 pb-2 text-[11px] font-bold uppercase tracking-[0.14em] text-stone-500">Browse Categories</p>
                        <div class="space-y-1">
                            @foreach ($categoryLinks as $categoryLink)
                                <a
                                    href="{{ $categoryLink['url'] }}"
                                    class="block rounded-2xl px-3 py-3 transition hover:bg-potato-beige/80">
                                    <span class="block text-sm font-semibold text-stone-900">{{ $categoryLink['label'] }}</span>
                                    <span class="mt-1 block text-xs text-stone-500">{{ $categoryLink['description'] }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </nav>

            <div class="ml-auto hidden w-full max-w-[19rem] lg:block">
                <label for="site-search" class="sr-only">Find tools</label>
                <div class="relative">
                    <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-sm text-stone-400">
                        <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                    </span>
                    <input
                        id="site-search"
                        type="text"
                        placeholder="Find a tool..."
                        class="w-full rounded-full border border-stone-200 bg-white/75 py-2.5 pl-10 pr-4 text-sm text-stone-700 outline-none ring-primary/20 placeholder:text-stone-400 focus:ring-2">
                </div>
            </div>

            <div class="relative mr-1 hidden md:block lg:mr-2">
                <button
                    type="button"
                    id="desktop-account-button"
                    data-dropdown-target="desktop-account-menu"
                    class="inline-flex h-11 w-11 cursor-pointer items-center justify-center rounded-2xl border border-stone-200/80 bg-white/80 text-stone-700 transition hover:border-primary/40 hover:text-primary"
                    aria-expanded="false"
                    aria-controls="desktop-account-menu"
                    aria-label="Open account menu">
                    <i class="fa-solid fa-gear text-sm" aria-hidden="true"></i>
                </button>

                <div
                    id="desktop-account-menu"
                    class="pointer-events-none invisible absolute right-0 top-full z-30 mt-3 w-56 rounded-3xl border border-stone-200/80 bg-white/95 p-3 opacity-0 shadow-[0_18px_45px_rgba(32,24,16,0.12)] transition duration-200">
                    <p class="px-3 pb-2 text-[11px] font-bold uppercase tracking-[0.14em] text-stone-500">Account</p>
                    <div class="space-y-2">
                        <a href="{{ route('login') }}" class="flex items-center gap-2 rounded-2xl border border-stone-200/80 px-4 py-3 text-sm font-semibold text-stone-800 transition hover:border-primary/40 hover:bg-potato-beige/80 hover:text-primary">
                            <i class="fa-regular fa-user" aria-hidden="true"></i>
                            Login
                        </a>
                        <a href="{{ route('signup') }}" class="pt-btn-primary flex w-full justify-start py-3 text-sm">
                            <i class="fa-solid fa-user-plus" aria-hidden="true"></i>
                            Signup
                        </a>
                    </div>
                </div>
            </div>

            <button
                type="button"
                id="mobile-nav-button"
                class="ml-auto inline-flex h-11 w-11 cursor-pointer items-center justify-center rounded-2xl border border-stone-200/80 bg-white/80 text-stone-700 md:hidden"
                aria-expanded="false"
                aria-controls="mobile-nav-panel"
                aria-label="Open navigation">
                <i class="fa-solid fa-bars text-sm" aria-hidden="true"></i>
            </button>
        </div>

        <div id="mobile-nav-panel" class="hidden border-t border-stone-200/60 pt-4 md:hidden">
            <div class="space-y-3">
                <div>
                    <label for="mobile-site-search" class="sr-only">Find tools</label>
                    <div class="relative">
                        <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-sm text-stone-400">
                            <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                        </span>
                        <input
                            id="mobile-site-search"
                            type="text"
                            placeholder="Find a tool..."
                            class="w-full rounded-2xl border border-stone-200 bg-white/80 py-3 pl-10 pr-4 text-sm text-stone-700 outline-none ring-primary/20 placeholder:text-stone-400 focus:ring-2">
                    </div>
                </div>

                <a
                    href="{{ route('home') }}#pick-potato"
                    class="flex items-center justify-between rounded-2xl border border-stone-200/80 bg-white/75 px-4 py-3 text-sm font-semibold text-stone-800">
                    <span class="inline-flex items-center gap-2">
                        <span class="h-1.5 w-1.5 rounded-full bg-primary"></span>
                        Browse Tools
                    </span>
                    <i class="fa-solid fa-arrow-right text-xs text-stone-400" aria-hidden="true"></i>
                </a>

                <div class="rounded-3xl border border-stone-200/80 bg-white/75 p-2">
                    <button
                        type="button"
                        data-mobile-section-toggle="mobile-tools-list"
                        class="flex w-full cursor-pointer items-center justify-between rounded-2xl px-3 py-3 text-left text-sm font-semibold text-stone-800"
                        aria-expanded="false"
                        aria-controls="mobile-tools-list">
                        <span>Popular Tools</span>
                        <i class="fa-solid fa-chevron-down text-[10px] text-stone-400" aria-hidden="true"></i>
                    </button>
                    <div id="mobile-tools-list" class="hidden px-3 pb-2">
                        <div class="space-y-1">
                            @foreach ($toolLinks as $toolLink)
                                <a href="{{ $toolLink['url'] }}" class="block rounded-2xl px-3 py-3 text-sm font-medium text-stone-700 transition hover:bg-potato-beige/80 hover:text-stone-900">
                                    {{ $toolLink['label'] }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="rounded-3xl border border-stone-200/80 bg-white/75 p-2">
                    <button
                        type="button"
                        data-mobile-section-toggle="mobile-categories-list"
                        class="flex w-full cursor-pointer items-center justify-between rounded-2xl px-3 py-3 text-left text-sm font-semibold text-stone-800"
                        aria-expanded="false"
                        aria-controls="mobile-categories-list">
                        <span>Categories</span>
                        <i class="fa-solid fa-chevron-down text-[10px] text-stone-400" aria-hidden="true"></i>
                    </button>
                    <div id="mobile-categories-list" class="hidden px-3 pb-2">
                        <div class="space-y-1">
                            @foreach ($categoryLinks as $categoryLink)
                                <a href="{{ $categoryLink['url'] }}" class="block rounded-2xl px-3 py-3 text-sm font-medium text-stone-700 transition hover:bg-potato-beige/80 hover:text-stone-900">
                                    {{ $categoryLink['label'] }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="grid gap-3 sm:grid-cols-2">
                    <a href="{{ route('login') }}" class="pt-btn-secondary w-full justify-center py-3">
                        Login
                    </a>
                    <a href="{{ route('signup') }}" class="pt-btn-primary w-full justify-center py-3">
                        Signup
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>

@once
    @push('scripts')
        <script>
            (() => {
                const desktopButtons = Array.from(document.querySelectorAll('[data-dropdown-target]'));
                const mobileButton = document.getElementById('mobile-nav-button');
                const mobilePanel = document.getElementById('mobile-nav-panel');
                const mobileSectionButtons = Array.from(document.querySelectorAll('[data-mobile-section-toggle]'));

                const closeDesktopMenus = (exceptId = null) => {
                    desktopButtons.forEach((button) => {
                        const menuId = button.getAttribute('data-dropdown-target');
                        const menu = document.getElementById(menuId);
                        const shouldStayOpen = exceptId && exceptId === menuId;

                        button.setAttribute('aria-expanded', shouldStayOpen ? 'true' : 'false');

                        if (!menu) {
                            return;
                        }

                        menu.classList.toggle('opacity-0', !shouldStayOpen);
                        menu.classList.toggle('invisible', !shouldStayOpen);
                        menu.classList.toggle('pointer-events-none', !shouldStayOpen);
                    });
                };

                desktopButtons.forEach((button) => {
                    button.addEventListener('click', (event) => {
                        event.stopPropagation();

                        const menuId = button.getAttribute('data-dropdown-target');
                        const isOpen = button.getAttribute('aria-expanded') === 'true';
                        closeDesktopMenus(isOpen ? null : menuId);
                    });
                });

                document.addEventListener('click', () => {
                    closeDesktopMenus();
                });

                document.addEventListener('keydown', (event) => {
                    if (event.key === 'Escape') {
                        closeDesktopMenus();

                        if (mobilePanel && !mobilePanel.classList.contains('hidden')) {
                            mobilePanel.classList.add('hidden');
                            mobileButton?.setAttribute('aria-expanded', 'false');
                        }
                    }
                });

                if (mobileButton && mobilePanel) {
                    mobileButton.addEventListener('click', () => {
                        const isExpanded = mobileButton.getAttribute('aria-expanded') === 'true';
                        mobileButton.setAttribute('aria-expanded', isExpanded ? 'false' : 'true');
                        mobilePanel.classList.toggle('hidden', isExpanded);
                    });
                }

                mobileSectionButtons.forEach((button) => {
                    button.addEventListener('click', () => {
                        const targetId = button.getAttribute('data-mobile-section-toggle');
                        const target = document.getElementById(targetId);
                        const isExpanded = button.getAttribute('aria-expanded') === 'true';

                        button.setAttribute('aria-expanded', isExpanded ? 'false' : 'true');
                        target?.classList.toggle('hidden', isExpanded);
                    });
                });
            })();
        </script>
    @endpush
@endonce
