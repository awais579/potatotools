<header class="relative z-10 border-b border-stone-200/50 bg-potato-beige/95 backdrop-blur">
    <div class="pt-container flex items-center gap-3 py-3">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2">
            <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-primary/20 text-xs font-bold text-primary">PT</span>
            <span class="font-display text-lg font-semibold text-stone-900">PotatoTools</span>
        </a>

        <nav class="ml-2 hidden items-center gap-4 text-sm font-semibold text-stone-700 md:flex">
            <a href="{{ route('tools.height-calculator') }}" class="inline-flex items-center gap-1.5 hover:text-primary">
                <span class="h-1.5 w-1.5 rounded-full bg-primary"></span>
                Tools
            </a>
            <a href="{{ route('home') }}#pick-potato" class="inline-flex items-center gap-1.5 hover:text-primary">
                <span class="h-1.5 w-1.5 rounded-full bg-accent"></span>
                Categories
            </a>
        </nav>

        <div class="ml-auto hidden w-full max-w-sm lg:block">
            <label for="site-search" class="sr-only">Find tools</label>
            <input id="site-search" type="text" placeholder="Find a tool..." class="w-full rounded-full border border-stone-200 bg-white/70 px-4 py-2 text-sm text-stone-700 outline-none ring-primary/20 placeholder:text-stone-400 focus:ring-2">
        </div>

        <a href="{{ route('tools.height-calculator') }}" class="pt-btn-primary px-4 py-2 text-xs sm:text-sm">
            Try a Tool
        </a>
    </div>
</header>
