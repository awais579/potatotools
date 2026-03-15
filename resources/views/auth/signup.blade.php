@extends('layouts.auth')

@section('title', 'Signup - PotatoTools')
@section('description', 'Create your PotatoTools account from a clean and simple signup page.')
@section('canonical', route('signup'))

@section('content')
    <section class="h-screen overflow-y-auto px-4 py-4 sm:px-5 sm:py-5">
        <div class="mx-auto grid min-h-full w-full max-w-[1140px] overflow-hidden rounded-[2rem] border border-stone-200/70 bg-white/80 shadow-[0_24px_70px_rgba(32,24,16,0.09)] backdrop-blur lg:grid-cols-[minmax(0,0.92fr)_minmax(360px,1.08fr)]">
            <section class="flex items-stretch bg-white p-5 shadow-[18px_0_40px_rgba(32,24,16,0.12)] sm:p-6 lg:p-8">
                <div class="mx-auto flex h-full w-full max-w-md flex-col pt-2 sm:pt-3">
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2">
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-primary/15 text-sm font-bold text-primary">PT</span>
                        <span class="text-lg font-semibold text-stone-900">PotatoTools</span>
                    </a>

                    <div class="flex flex-1 items-start py-4">
                        <div class="w-full">
                            <div class="mb-4">
                                <p class="text-xs font-semibold uppercase tracking-[0.14em] text-stone-500">Create Account</p>
                                <h1 class="mt-2 text-3xl font-semibold text-stone-900 sm:text-4xl">Signup for PotatoTools</h1>
                                <p class="mt-2 text-sm leading-relaxed text-stone-600">Create your account to get started.</p>
                            </div>

                            @if (session('status'))
                                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                                    {{ session('status') }}
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700 {{ session('status') ? 'mt-4' : '' }}">
                                    {{ $errors->first() }}
                                </div>
                            @endif

                            <form method="post" action="{{ route('signup.submit') }}" class="{{ session('status') || $errors->any() ? 'mt-5' : '' }} space-y-3">
                                @csrf

                                <div class="pt-field">
                                    <label for="name" class="pt-label">Full Name</label>
                                    <input
                                        id="name"
                                        name="name"
                                        type="text"
                                        value="{{ old('name') }}"
                                        autocomplete="name"
                                        class="pt-input"
                                        placeholder="Enter your full name"
                                        required>
                                </div>

                                <div class="pt-field">
                                    <label for="email" class="pt-label">Email Address</label>
                                    <input
                                        id="email"
                                        name="email"
                                        type="email"
                                        value="{{ old('email') }}"
                                        autocomplete="email"
                                        class="pt-input"
                                        placeholder="Enter your email"
                                        required>
                                </div>

                                <div class="pt-field">
                                    <label for="password" class="pt-label">Password</label>
                                    <input
                                        id="password"
                                        name="password"
                                        type="password"
                                        autocomplete="new-password"
                                        class="pt-input"
                                        placeholder="Create a password"
                                        required>
                                </div>

                                <div class="pt-field">
                                    <label for="password_confirmation" class="pt-label">Confirm Password</label>
                                    <input
                                        id="password_confirmation"
                                        name="password_confirmation"
                                        type="password"
                                        autocomplete="new-password"
                                        class="pt-input"
                                        placeholder="Confirm your password"
                                        required>
                                </div>

                                <div class="flex flex-col gap-2 text-sm text-stone-600 sm:flex-row sm:items-center sm:justify-between">
                                    <label class="inline-flex cursor-pointer items-center gap-2">
                                        <input type="checkbox" name="agree_terms" class="h-4 w-4 cursor-pointer rounded border-stone-300 text-primary focus:ring-primary/30" required>
                                        <span>I agree to the terms</span>
                                    </label>
                                    <span class="font-medium text-stone-500">No payment required</span>
                                </div>

                                <button type="submit" class="pt-btn-primary mt-3 w-full py-3.5 text-base">
                                    Create Account
                                </button>
                            </form>

                            <a href="{{ route('login') }}" class="pt-btn-secondary mt-3 flex w-full justify-center py-3 text-sm">
                                Already have an account
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <section class="border-t border-stone-200/70 bg-[linear-gradient(180deg,#f4e6d2_0%,#ead7bf_100%)] p-5 sm:p-6 lg:border-l lg:border-t-0 lg:p-8">
                <div class="flex h-full items-end justify-center rounded-[1.75rem] border border-white/70 bg-white/28 p-4 shadow-[inset_0_1px_0_rgba(255,255,255,0.7)] sm:p-5 lg:justify-end">
                    <div class="flex h-full w-full items-end justify-center lg:justify-end">
                        <img
                            src="{{ asset('images/signup.png') }}"
                            alt="PotatoTools mascot illustration"
                            class="h-full w-full max-h-full max-w-[40rem] object-contain object-bottom"
                            loading="eager"
                            decoding="async">
                    </div>
                </div>
            </section>
        </div>
    </section>
@endsection
