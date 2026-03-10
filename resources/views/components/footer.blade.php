<footer class="mt-20 border-t border-stone-200/60 bg-[#efe5d8]">
    <div class="pt-container py-12">
        <div class="grid gap-8 md:grid-cols-[1.4fr_1fr_1fr_1fr]">
            <div>
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2">
                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-primary/20 text-xs font-bold text-primary">PT</span>
                    <span class="font-display text-xl font-semibold text-stone-900">PotatoTools</span>
                </a>
                <p class="mt-4 max-w-xs text-sm text-stone-600">
                    Making the internet easier to digest, one simple tool at a time.
                </p>
            </div>
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.14em] text-stone-500">Garden</p>
                <ul class="mt-3 space-y-2 text-sm text-stone-700">
                    <li><a class="hover:text-primary" href="{{ route('tools.height-calculator') }}">Height Calculator</a></li>
                    <li><span class="text-stone-500">GitHub</span></li>
                    <li><span class="text-stone-500">Updates</span></li>
                </ul>
            </div>
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.14em] text-stone-500">Policy</p>
                <ul class="mt-3 space-y-2 text-sm text-stone-700">
                    <li><span class="text-stone-500">Privacy</span></li>
                    <li><span class="text-stone-500">Terms</span></li>
                </ul>
            </div>
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.14em] text-stone-500">Say Hi</p>
                <ul class="mt-3 space-y-2 text-sm text-stone-700">
                    <li><span class="text-stone-500">Contact</span></li>
                    <li><span class="text-stone-500">Support</span></li>
                </ul>
            </div>
        </div>

        <div class="mt-12 flex flex-col gap-3 border-t border-stone-200/60 pt-5 text-xs text-stone-500 sm:flex-row sm:items-center sm:justify-between">
            <p>&copy; {{ date('Y') }} PotatoTools. Grown with organic love.</p>
            <span class="inline-flex w-fit items-center gap-2 rounded-full border border-stone-200/80 bg-[#e6eadf] px-3 py-1.5 text-[11px] font-semibold uppercase tracking-wide text-accent">
                <span class="h-1.5 w-1.5 rounded-full bg-accent"></span>
                Private by design
            </span>
        </div>
    </div>
</footer>
