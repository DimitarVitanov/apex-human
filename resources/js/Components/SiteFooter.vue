<template>
    <footer class="border-t border-gold-deep/30 bg-black">
        <div class="mx-auto max-w-[1440px] px-6 lg:px-12 py-10 md:py-16 lg:py-24">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-8">
                <div>
                    <p class="font-display text-gold text-[22px] tracking-[0.18em]">APEX HUMAN&#8482;</p>
                    <p class="mt-3 font-serif italic text-off-white text-base leading-relaxed">
                        The Apex isn't a body. It's a life.
                    </p>
                    <p class="text-warm-grey text-[9px] uppercase tracking-[0.4em] font-sans font-semibold mt-8 mb-4">Follow Us</p>
                    <div class="flex items-center gap-4">
                        <a
                            href="mailto:coach@apexhuman.co"
                            class="group flex items-center justify-center w-9 h-9 border border-gold-deep/30 hover:border-gold transition-colors duration-300 cursor-none"
                            title="Email us"
                        >
                            <svg class="w-4 h-4 text-text-body group-hover:text-gold-light transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                            </svg>
                        </a>
                        <a
                            href="https://www.instagram.com/apexhumansystem"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="group flex items-center justify-center w-9 h-9 border border-gold-deep/30 hover:border-gold transition-colors duration-300 cursor-none"
                            title="Instagram"
                        >
                            <svg class="w-4 h-4 text-text-body group-hover:text-gold-light transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <rect x="2" y="2" width="20" height="20" rx="5" />
                                <circle cx="12" cy="12" r="5" />
                                <circle cx="17.5" cy="6.5" r="1.5" fill="currentColor" stroke="none" />
                            </svg>
                        </a>
                    </div>
                </div>

                <div>
                    <p class="text-warm-grey text-[9px] uppercase tracking-[0.4em] font-sans font-semibold mb-5">Navigate</p>
                    <div class="flex flex-col gap-3">
                        <Link
                            v-for="item in footerNav"
                            :key="item.url"
                            :href="item.url"
                            class="text-text-body text-sm tracking-wide hover:text-gold-light transition-colors duration-200 cursor-none"
                        >
                            {{ item.label }}
                        </Link>
                    </div>
                </div>

                <div>
                    <p class="text-warm-grey text-[9px] uppercase tracking-[0.4em] font-sans font-semibold mb-5">Connect</p>
                    <div class="flex flex-col gap-3">
                        <a
                            href="mailto:coach@apexhuman.co"
                            class="text-text-body text-sm tracking-wide hover:text-gold-light transition-colors duration-200 cursor-none"
                        >
                            coach@apexhuman.co
                        </a>
                      
                        <Link
                            href="/apply"
                            class="text-gold text-sm tracking-wide hover:text-gold-light transition-colors duration-200 cursor-none"
                        >
                            Apply for Coaching &rarr;
                        </Link>
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-8 border-t border-gold-deep/20">
                <p class="text-warm-grey text-[9px] uppercase tracking-[0.4em] font-sans font-semibold mb-4">Not ready to apply?</p>
                <p class="text-warm-grey text-sm mb-4">Get the Apex Letter. One email when it matters. No noise.</p>
                <form @submit.prevent="subscribeNewsletter" class="flex gap-0 max-w-md border-b border-gold-deep focus-within:border-gold transition-colors duration-400">
                    <input
                        v-model="email"
                        type="email"
                        placeholder="you@example.com"
                        required
                        class="flex-1 bg-transparent text-off-white text-sm font-sans py-3 focus:outline-none placeholder:text-warm-grey placeholder:italic cursor-none"
                    >
                    <button
                        type="submit"
                        class="text-gold text-xs uppercase tracking-[0.3em] font-sans font-semibold px-4 py-3 hover:text-gold-light transition-colors duration-200 cursor-none"
                    >
                        Subscribe
                    </button>
                </form>
                <p v-if="subscribed" class="text-gold-light text-sm mt-3">You're in. Watch your inbox.</p>
            </div>
        </div>

        <div class="border-t border-gold-deep/20 py-6 px-6 lg:px-12">
            <div class="mx-auto max-w-[1440px] text-center space-y-2">
                <div class="flex items-center justify-center gap-2 text-warm-grey text-[10px] uppercase tracking-[0.2em]">
                    <Link href="/privacy-policy" class="hover:text-gold-light transition-colors duration-200">Privacy Policy</Link>
                    <span>&middot;</span>
                    <Link href="/terms-of-service" class="hover:text-gold-light transition-colors duration-200">Terms of Service</Link>
                </div>
                <p class="text-warm-grey text-[10px] uppercase tracking-[0.2em]">
                    &copy; {{ currentYear }} APEX HUMAN&#8482; &middot; ALL RIGHTS RESERVED &middot; apexhuman.co
                </p>
            </div>
        </div>
    </footer>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

const page = usePage();
const footerNav = computed(() => page.props.navigation?.footer || []);
const settings = computed(() => page.props.settings || {});

const currentYear = new Date().getFullYear();
const email = ref('');
const subscribed = ref(false);

function subscribeNewsletter() {
    subscribed.value = true;
    email.value = '';
}
</script>
