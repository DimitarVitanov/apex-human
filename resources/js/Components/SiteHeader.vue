<template>
    <header
        ref="header"
        class="fixed top-0 left-0 right-0 z-40 transition-transform duration-400"
        :class="{ '-translate-y-full': hidden && !mobileOpen }"
        :style="{ transitionTimingFunction: 'cubic-bezier(0.16, 1, 0.3, 1)' }"
    >
        <div class="absolute inset-0 bg-black/80 backdrop-blur-sm" />
        <nav class="relative mx-auto flex items-center justify-between px-6 lg:px-12 h-16 lg:h-20 max-w-[1440px]">
            <Link href="/" class="font-display text-gold text-sm lg:text-base tracking-[0.18em] cursor-none">
                APEX HUMAN&#8482;
            </Link>

            <div class="hidden lg:flex items-center gap-10">
                <Link
                    v-for="item in navItems"
                    :key="item.url"
                    :href="item.url"
                    class="relative text-text-body text-xs tracking-[0.15em] uppercase font-sans font-medium hover:text-gold-light transition-colors duration-200 cursor-none group"
                >
                    {{ item.label }}
                    <span class="absolute bottom-0 left-0 w-full h-px bg-gold scale-x-0 group-hover:scale-x-100 transition-transform duration-400 origin-center" />
                </Link>
            </div>

            <div v-if="ctaItem" class="hidden lg:block">
                <Link
                    :href="ctaItem.url"
                    class="inline-block px-6 py-2.5 bg-gold text-black text-xs tracking-[0.3em] uppercase font-sans font-semibold hover:bg-gold-light active:bg-gold-deep transition-colors duration-400 cursor-none"
                >
                    {{ ctaItem.label }}
                </Link>
            </div>

            <button
                class="lg:hidden relative w-11 h-11 flex items-center justify-center cursor-none"
                aria-label="Toggle menu"
                @click="mobileOpen = !mobileOpen"
            >
                <div class="flex flex-col gap-1.5">
                    <span
                        class="block w-5 h-px bg-gold transition-all duration-400"
                        :class="mobileOpen ? 'rotate-45 translate-y-[3.5px]' : ''"
                        :style="{ transitionTimingFunction: 'cubic-bezier(0.16, 1, 0.3, 1)' }"
                    />
                    <span
                        class="block w-5 h-px bg-gold transition-all duration-400"
                        :class="mobileOpen ? '-rotate-45 -translate-y-[3.5px]' : ''"
                        :style="{ transitionTimingFunction: 'cubic-bezier(0.16, 1, 0.3, 1)' }"
                    />
                </div>
            </button>
        </nav>

        <Transition
            enter-active-class="transition-opacity duration-400"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition-opacity duration-300"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div
                v-if="mobileOpen"
                class="lg:hidden fixed inset-0 top-16 bg-black/95 backdrop-blur-md z-30 flex flex-col items-center justify-center gap-8"
            >
                <template v-for="item in allItems" :key="item.url">
                    <Link
                        v-if="!item.is_cta"
                        :href="item.url"
                        class="text-text-body text-lg tracking-[0.15em] uppercase font-sans font-medium hover:text-gold-light transition-colors duration-200"
                        @click="mobileOpen = false"
                    >
                        {{ item.label }}
                    </Link>
                    <Link
                        v-else
                        :href="item.url"
                        class="px-8 py-3 bg-gold text-black text-sm tracking-[0.3em] uppercase font-sans font-semibold hover:bg-gold-light active:bg-gold-deep transition-colors duration-400"
                        @click="mobileOpen = false"
                    >
                        {{ item.label }}
                    </Link>
                </template>
            </div>
        </Transition>
    </header>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

const page = usePage();
const allItems = computed(() => page.props.navigation?.header || []);
const navItems = computed(() => allItems.value.filter(i => !i.is_cta));
const ctaItem = computed(() => allItems.value.find(i => i.is_cta));

const hidden = ref(false);
const mobileOpen = ref(false);
let lastScroll = 0;

function onScroll() {
    const y = window.scrollY;
    hidden.value = y > 80 && y > lastScroll;
    lastScroll = y;
}

onMounted(() => window.addEventListener('scroll', onScroll, { passive: true }));
onUnmounted(() => window.removeEventListener('scroll', onScroll));
</script>
