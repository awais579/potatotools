<footer class="mt-20 border-t border-stone-200/60 bg-[#efe5d8]">
    <div class="pt-container py-12 sm:py-14">
        <div class="grid gap-8 lg:grid-cols-[1.05fr_0.95fr] lg:items-start">
            <div>
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2">
                    <img
                        src="{{ asset('images/logo2.png') }}"
                        alt="PotatoTools logo"
                        class="h-11 w-11 rounded-xl object-contain">
                    <span class="font-display text-xl font-semibold text-stone-900">PotatoTools</span>
                </a>
                <p class="mt-4 max-w-md text-sm leading-relaxed text-stone-600">
                    Clean online tools for everyday tasks. Fast, simple, and easy to understand for both technical and non-technical users.
                </p>
                <div class="mt-5 flex flex-wrap gap-2">
                    <span class="inline-flex items-center gap-2 rounded-full border border-stone-200/80 bg-white/70 px-3 py-1.5 text-xs font-semibold text-stone-700">
                        <span class="h-2 w-2 rounded-full bg-accent"></span>
                        Fast results
                    </span>
                    <span class="inline-flex items-center gap-2 rounded-full border border-stone-200/80 bg-white/70 px-3 py-1.5 text-xs font-semibold text-stone-700">
                        <span class="h-2 w-2 rounded-full bg-primary"></span>
                        No signup
                    </span>
                    <span class="inline-flex items-center gap-2 rounded-full border border-stone-200/80 bg-white/70 px-3 py-1.5 text-xs font-semibold text-stone-700">
                        <span class="h-2 w-2 rounded-full bg-accent"></span>
                        Privacy first
                    </span>
                </div>
            </div>

            <div class="pt-soft-card border-stone-200/80 bg-white/75 p-5 sm:p-6">
                <p class="text-xs font-bold uppercase tracking-[0.14em] text-stone-500">Get Product Updates</p>
                <h2 class="mt-2 text-2xl font-semibold text-stone-900">Get new tools in your inbox</h2>
                <p class="mt-2 text-sm leading-relaxed text-stone-600">
                    Add your email to get notified when useful new tools and updates go live. No spam. No clutter.
                </p>

                <form id="footer-updates-form" class="mt-5">
                    <label for="footer-email" class="sr-only">Email address</label>
                    <div class="flex flex-col gap-3 sm:flex-row">
                        <input
                            id="footer-email"
                            name="email"
                            type="email"
                            class="pt-input pt-input-tall"
                            placeholder="Enter your email address"
                            autocomplete="email"
                            required>
                        <button type="submit" class="pt-btn-primary shrink-0 px-6">
                            Get Updates
                        </button>
                    </div>
                    <p id="footer-updates-status" class="mt-3 text-xs text-stone-500">Your email app will open with a prefilled request.</p>
                </form>
            </div>
        </div>

        <div class="mt-10 grid gap-8 border-t border-stone-200/60 pt-8 sm:grid-cols-2 lg:grid-cols-4">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.14em] text-stone-500">Garden</p>
                <ul class="mt-3 space-y-2.5 text-sm text-stone-700">
                    <li><a class="pt-link-underline hover:text-primary focus-visible:outline-none" href="{{ route('tools.height-converter') }}">Height Converter</a></li>
                    <li><a class="pt-link-underline hover:text-primary focus-visible:outline-none" href="{{ route('tools.age-calculator') }}">Age Calculator</a></li>
                    <li><a class="pt-link-underline hover:text-primary focus-visible:outline-none" href="{{ route('tools.snow-day-calculator') }}">Snow Day Calculator</a></li>
                </ul>
            </div>

            <div>
                <p class="text-xs font-bold uppercase tracking-[0.14em] text-stone-500">Explore</p>
                <ul class="mt-3 space-y-2.5 text-sm text-stone-700">
                    <li><a class="pt-link-underline hover:text-primary focus-visible:outline-none" href="{{ route('home') }}">Home</a></li>
                    <li><a class="pt-link-underline hover:text-primary focus-visible:outline-none" href="{{ route('home') }}#pick-potato">Browse Tools</a></li>
                    <li><a class="pt-link-underline hover:text-primary focus-visible:outline-none" href="{{ route('home') }}#pick-potato">Tool Categories</a></li>
                </ul>
            </div>

            <div>
                <p class="text-xs font-bold uppercase tracking-[0.14em] text-stone-500">Support</p>
                <ul class="mt-3 space-y-2.5 text-sm text-stone-700">
                    <li><a class="pt-link-underline hover:text-primary focus-visible:outline-none" href="mailto:hello@potatotools.com?subject=PotatoTools%20Tool%20Request">Request a Tool</a></li>
                    <li><a class="pt-link-underline hover:text-primary focus-visible:outline-none" href="mailto:hello@potatotools.com?subject=PotatoTools%20Partnership">Partnerships</a></li>
                    <li><a class="pt-link-underline hover:text-primary focus-visible:outline-none" href="mailto:support@potatotools.com?subject=PotatoTools%20Support">Help & Support</a></li>
                </ul>
            </div>

            <div>
                <p class="text-xs font-bold uppercase tracking-[0.14em] text-stone-500">Contact</p>
                <ul class="mt-3 space-y-2.5 text-sm text-stone-700">
                    <li><a class="pt-link-underline hover:text-primary focus-visible:outline-none" href="mailto:hello@potatotools.com">hello@potatotools.com</a></li>
                    <li><a class="pt-link-underline hover:text-primary focus-visible:outline-none" href="mailto:support@potatotools.com">support@potatotools.com</a></li>
                    <li><span class="text-stone-500">Built for fast everyday tools</span></li>
                </ul>
            </div>
        </div>

        <div class="mt-10 flex flex-col gap-3 border-t border-stone-200/60 pt-5 text-xs text-stone-500 sm:flex-row sm:items-center sm:justify-between">
            <p>&copy; {{ date('Y') }} PotatoTools. Grown with organic love.</p>
            <span class="inline-flex w-fit items-center gap-2 rounded-full border border-stone-200/80 bg-[#e6eadf] px-3 py-1.5 text-[11px] font-semibold uppercase tracking-wide text-accent">
                <span class="h-1.5 w-1.5 rounded-full bg-accent"></span>
                Private by design
            </span>
        </div>
    </div>
</footer>

@once
    @push('scripts')
        <script>
            (() => {
                const form = document.getElementById('footer-updates-form');
                const emailInput = document.getElementById('footer-email');
                const status = document.getElementById('footer-updates-status');

                if (!form || !emailInput || !status) {
                    return;
                }

                form.addEventListener('submit', (event) => {
                    event.preventDefault();

                    const email = emailInput.value.trim();

                    if (!email) {
                        status.textContent = 'Enter your email address first.';
                        return;
                    }

                    status.textContent = 'Opening your email app...';

                    const subject = encodeURIComponent('PotatoTools Updates');
                    const body = encodeURIComponent(`Please add this email to PotatoTools update requests:\n\n${email}`);
                    window.location.href = `mailto:hello@potatotools.com?subject=${subject}&body=${body}`;
                });
            })();
        </script>
    @endpush
@endonce
