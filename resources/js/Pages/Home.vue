<template>
    <AppLayout :title="page.meta_title" :description="page.meta_description">
        <!-- Hero with Parallax -->
        <section v-if="s('hero')" class="relative min-h-screen flex items-center justify-center px-6 overflow-hidden">
            <div class="absolute inset-0">
                <img
                    v-if="s('hero').image"
                    ref="heroImg"
                    :src="s('hero').image"
                    :alt="s('hero').image_alt || ''"
                    fetchpriority="high"
                    class="parallax-hero w-full h-[120%] object-cover opacity-20"
                >
                <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-transparent to-black"></div>
            </div>
            <GoldLightning />
            <div class="relative text-center max-w-4xl mx-auto">
                <p v-if="s('hero').eyebrow" class="text-gold text-[9px] uppercase tracking-[0.5em] font-sans font-semibold mb-6">{{ s('hero').eyebrow }}</p>
                <h1 class="font-display text-gold-light text-4xl md:text-6xl lg:text-7xl tracking-[0.06em] leading-tight">{{ s('hero').headline }}</h1>
                <p v-if="s('hero').subheadline" class="text-text-body text-base md:text-lg mt-6 max-w-2xl mx-auto leading-relaxed">{{ s('hero').subheadline }}</p>
                <Link v-if="s('hero').cta_text" :href="s('hero').cta_url || '/apply'" class="inline-block mt-10 px-8 py-3.5 bg-gold text-black text-xs tracking-[0.3em] uppercase font-sans font-semibold hover:bg-gold-light active:bg-gold-deep transition-colors duration-400">
                    {{ s('hero').cta_text }}
                </Link>
            </div>
            <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce">
                <div class="w-5 h-8 border border-gold/40 rounded-full flex justify-center pt-1.5">
                    <div class="w-0.5 h-2 bg-gold/60 rounded-full"></div>
                </div>
            </div>
        </section>

        <!-- Manifesto -->
        <section v-if="s('manifesto')" class="scroll-section py-14 md:py-24 lg:py-32 px-6">
            <div class="max-w-5xl mx-auto">
                <p v-if="s('manifesto').eyebrow" class="text-gold text-[9px] uppercase tracking-[0.5em] font-sans font-semibold mb-4">{{ s('manifesto').eyebrow }}</p>
                <h2 v-if="s('manifesto').headline" class="font-display text-gold-light text-3xl md:text-4xl tracking-[0.06em] leading-tight mb-8">{{ s('manifesto').headline }}</h2>
                <div v-if="s('manifesto').body" class="text-text-body text-base leading-[1.85] whitespace-pre-line max-w-3xl">{{ s('manifesto').body }}</div>
            </div>
        </section>

        <!-- Stats -->
        <section v-if="s('stats')" class="scroll-section py-10 md:py-16 bg-black-warm/50 border-y border-gold-deep/10">
            <div class="max-w-5xl mx-auto px-6 grid grid-cols-2 md:grid-cols-4 gap-8">
                <div v-for="stat in parseMeta(s('stats'), 'stats')" :key="stat.value" class="text-center">
                    <p class="font-display text-gold text-4xl lg:text-5xl">{{ stat.value }}</p>
                    <p class="text-warm-grey text-xs uppercase tracking-[0.2em] mt-2">{{ stat.label }}</p>
                </div>
            </div>
        </section>

        <!-- Image Divider: Marble -->
        <div class="parallax-divider img-divider h-[15vh] md:h-[30vh] lg:h-[40vh]">
            <img src="/images/transition-marble.webp" alt="" class="w-full h-full object-cover" loading="lazy">
        </div>

        <!-- The Method Preview (6 Pillars) -->
        <section v-if="s('pillars')" class="scroll-section py-14 md:py-24 lg:py-32 px-6">
            <div class="max-w-5xl mx-auto">
                <div class="flex items-end justify-between mb-12">
                    <div>
                        <p v-if="s('pillars').eyebrow" class="text-gold text-[9px] uppercase tracking-[0.5em] font-sans font-semibold mb-4">{{ s('pillars').eyebrow }}</p>
                        <h2 class="font-display text-gold-light text-3xl md:text-4xl tracking-[0.06em]">{{ s('pillars').headline }}</h2>
                    </div>
                    <Link href="/method" class="hidden md:inline-block text-gold text-xs tracking-[0.2em] uppercase font-semibold hover:text-gold-light transition-colors border-b border-gold/30 pb-0.5">
                        Explore the Method
                    </Link>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <Link
                        v-for="pillar in parseMeta(s('pillars'), 'pillars')"
                        :key="pillar.numeral"
                        href="/method"
                        class="group border border-gold-deep/20 p-6 hover:border-gold/40 hover:bg-black-warm/40 transition-all duration-400"
                    >
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-gold text-xs font-display tracking-widest">{{ pillar.numeral }}</span>
                            <span class="text-gold-deep group-hover:text-gold transition-colors duration-300 text-xs">&rarr;</span>
                        </div>
                        <h3 class="text-off-white font-display text-lg tracking-wide group-hover:text-gold-light transition-colors duration-300">{{ pillar.title }}</h3>
                        <p class="text-warm-grey text-[10px] uppercase tracking-[0.3em] mt-1">{{ pillar.subtitle }}</p>
                        <p class="text-text-body text-sm leading-relaxed mt-4">{{ pillar.body }}</p>
                    </Link>
                </div>
                <div class="mt-8 text-center md:hidden">
                    <Link href="/method" class="text-gold text-xs tracking-[0.2em] uppercase font-semibold hover:text-gold-light transition-colors border-b border-gold/30 pb-0.5">
                        Explore the Method
                    </Link>
                </div>
            </div>
        </section>

        <!-- Quote / Promise -->
        <section v-if="s('promise')" class="scroll-section py-12 md:py-20 px-6 bg-black-warm/50 border-y border-gold-deep/10">
            <div class="max-w-3xl mx-auto text-center">
                <blockquote class="font-serif text-gold-light text-2xl md:text-3xl tracking-[0.02em] leading-snug italic">
                    &ldquo;{{ s('promise').quote }}&rdquo;
                </blockquote>
            </div>
        </section>

        <!-- Social Proof / Client Results -->
        <section v-if="s('social_proof')" class="scroll-section py-14 md:py-24 lg:py-32 px-6">
            <div class="max-w-5xl mx-auto">
                <div class="mb-16">
                    <p v-if="s('social_proof').eyebrow" class="text-gold text-[9px] uppercase tracking-[0.5em] font-sans font-semibold mb-4">{{ s('social_proof').eyebrow }}</p>
                    <h2 class="font-display text-gold-light text-3xl md:text-4xl tracking-[0.06em] mb-6">{{ s('social_proof').headline }}</h2>
                    <p v-if="s('social_proof').body" class="text-text-body text-base max-w-2xl leading-relaxed">{{ s('social_proof').body }}</p>
                </div>
                <div v-if="parseMeta(s('social_proof'), 'testimonials').length" class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div v-for="(t, i) in parseMeta(s('social_proof'), 'testimonials')" :key="i" class="border border-gold-deep/20 p-6 relative">
                        <span class="font-serif text-gold/20 text-6xl absolute top-3 left-4 leading-none">&ldquo;</span>
                        <p class="text-text-body text-sm leading-relaxed relative z-10 mt-6">{{ t.quote }}</p>
                        <div class="mt-6 pt-4 border-t border-gold-deep/10">
                            <p class="text-off-white text-sm font-semibold">{{ t.name }}</p>
                            <p v-if="t.result" class="text-gold text-xs mt-1">{{ t.result }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Image Divider: Metal -->
        <div class="parallax-divider img-divider h-[15vh] md:h-[30vh] lg:h-[40vh]">
            <img src="/images/transition-metal.webp" alt="" class="w-full h-full object-cover" loading="lazy">
        </div>

        <!-- For Whom — with image -->
        <section v-if="s('for_whom')" class="scroll-section py-14 md:py-24 lg:py-32 px-6">
            <div class="max-w-5xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">
                <div>
                    <p v-if="s('for_whom').eyebrow" class="text-gold text-[9px] uppercase tracking-[0.5em] font-sans font-semibold mb-4">{{ s('for_whom').eyebrow }}</p>
                    <h2 class="font-display text-gold-light text-3xl md:text-4xl tracking-[0.06em] mb-8 leading-tight">{{ s('for_whom').headline }}</h2>
                    <div class="text-text-body text-base leading-[1.85] whitespace-pre-line">{{ s('for_whom').body }}</div>
                    <Link href="/apply" class="inline-block mt-8 px-8 py-3.5 bg-gold text-black text-xs tracking-[0.3em] uppercase font-sans font-semibold hover:bg-gold-light active:bg-gold-deep transition-colors duration-400">
                        Start Your Application
                    </Link>
                </div>
                <div class="relative">
                    <img src="/images/morning-scene.webp" alt="Morning routine" class="w-full aspect-[4/3] object-cover">
                    <div class="absolute inset-0 border border-gold/10"></div>
                </div>
            </div>
        </section>

        <!-- Standards -->
        <section v-if="s('standards')" class="scroll-section py-14 md:py-24 lg:py-32 px-6 bg-black-warm/30">
            <div class="max-w-6xl mx-auto">
                <p v-if="s('standards').eyebrow" class="text-gold text-[9px] uppercase tracking-[0.5em] font-sans font-semibold mb-4">{{ s('standards').eyebrow }}</p>
                <h2 class="font-display text-gold-light text-3xl md:text-4xl tracking-[0.06em] leading-tight mb-12">{{ s('standards').headline }}</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    <div
                        v-for="std in parseMeta(s('standards'), 'standards').slice(0, 4)"
                        :key="std.number"
                        class="border border-gold-deep/20 p-6 hover:border-gold/30 transition-colors duration-400"
                    >
                        <span class="text-gold font-display text-lg tracking-widest">{{ std.number }}</span>
                        <h3 class="text-off-white font-sans font-semibold text-sm mt-3">{{ std.title }}</h3>
                        <p class="text-text-body text-sm leading-relaxed mt-2">{{ std.body }}</p>
                    </div>
                </div>
                <div v-if="parseMeta(s('standards'), 'standards').length > 4" class="flex flex-wrap justify-center gap-5 mt-5">
                    <div
                        v-for="std in parseMeta(s('standards'), 'standards').slice(4)"
                        :key="std.number"
                        class="border border-gold-deep/20 p-6 hover:border-gold/30 transition-colors duration-400 w-full sm:w-[calc(50%-10px)] lg:w-[calc(25%-15px)]"
                    >
                        <span class="text-gold font-display text-lg tracking-widest">{{ std.number }}</span>
                        <h3 class="text-off-white font-sans font-semibold text-sm mt-3">{{ std.title }}</h3>
                        <p class="text-text-body text-sm leading-relaxed mt-2">{{ std.body }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Latest from The Journal -->
        <section v-if="latestPosts.length" class="scroll-section py-14 md:py-24 lg:py-32 px-6">
            <div class="max-w-5xl mx-auto">
                <div class="flex items-end justify-between mb-12">
                    <div>
                        <p class="text-gold text-[9px] uppercase tracking-[0.5em] font-sans font-semibold mb-4">Insights &amp; Knowledge</p>
                        <h2 class="font-display text-gold-light text-3xl md:text-4xl tracking-[0.06em]">The Journal</h2>
                    </div>
                    <Link href="/journal" class="hidden md:inline-block text-gold text-xs tracking-[0.2em] uppercase font-semibold hover:text-gold-light transition-colors border-b border-gold/30 pb-0.5">
                        View All Articles
                    </Link>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <Link
                        v-for="post in latestPosts"
                        :key="post.id"
                        :href="`/journal/${post.slug}`"
                        class="group block border border-gold-deep/20 hover:border-gold/30 transition-all duration-400 overflow-hidden"
                    >
                        <div v-if="post.featured_image" class="aspect-[16/9] overflow-hidden bg-dark-grey">
                            <img :src="post.featured_image" :alt="post.featured_image_alt || post.title" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" loading="lazy">
                        </div>
                        <div v-else class="aspect-[16/9] bg-dark-grey flex items-center justify-center">
                            <span class="text-gold-deep/40 font-display text-2xl tracking-widest">AH</span>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center gap-3 mb-3">
                                <p class="text-gold text-[9px] uppercase tracking-[0.4em] font-semibold">{{ post.category }}</p>
                                <span class="text-gold-deep/40">&middot;</span>
                                <p class="text-warm-grey text-[9px] uppercase tracking-[0.2em]">{{ post.reading_time }}</p>
                            </div>
                            <h3 class="font-display text-off-white text-lg tracking-wide group-hover:text-gold-light transition-colors duration-200">{{ post.title }}</h3>
                            <p v-if="post.excerpt" class="text-text-body text-sm mt-3 line-clamp-2">{{ post.excerpt }}</p>
                        </div>
                    </Link>
                </div>
                <div class="mt-8 text-center md:hidden">
                    <Link href="/journal" class="text-gold text-xs tracking-[0.2em] uppercase font-semibold hover:text-gold-light transition-colors border-b border-gold/30 pb-0.5">
                        View All Articles
                    </Link>
                </div>
            </div>
        </section>

        <!-- Image Divider: Stakes Thread -->
        <div class="parallax-divider img-divider h-[12vh] md:h-[25vh] lg:h-[35vh]">
            <img src="/images/stakes-thread.webp" alt="" class="w-full h-full object-cover" loading="lazy">
        </div>

        <!-- Daily Apex Feed -->
        <section v-if="latestDailyApex.length" class="scroll-section py-14 md:py-24 lg:py-32 px-6">
            <div class="max-w-5xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-12 items-start">
                <div class="lg:col-span-1">
                    <p class="text-gold text-[9px] uppercase tracking-[0.5em] font-sans font-semibold mb-4">Daily Practice</p>
                    <h2 class="font-display text-gold-light text-3xl md:text-4xl tracking-[0.06em] mb-4">Daily Apex</h2>
                    <p class="text-text-body text-sm leading-relaxed">Short, potent insights delivered daily. Each one a catalyst for the day ahead.</p>
                    <Link href="/daily-apex" class="inline-block mt-6 text-gold text-xs tracking-[0.2em] uppercase font-semibold hover:text-gold-light transition-colors border-b border-gold/30 pb-0.5">
                        View Full Archive
                    </Link>
                </div>
                <div class="lg:col-span-2 space-y-0">
                    <div
                        v-for="(apex, i) in latestDailyApex"
                        :key="apex.id"
                        class="border-l-2 border-gold/30 pl-6 py-5 hover:border-gold transition-colors duration-300"
                        :class="i < latestDailyApex.length - 1 ? 'border-b border-b-gold-deep/10' : ''"
                    >
                        <div class="flex items-center gap-3 mb-2">
                            <p class="text-gold text-[9px] uppercase tracking-[0.4em] font-semibold">{{ apex.category || 'Daily Apex' }}</p>
                            <span class="text-gold-deep/40">&middot;</span>
                            <p class="text-warm-grey text-[9px] uppercase tracking-[0.2em]">{{ formatDate(apex.published_at) }}</p>
                        </div>
                        <h3 class="text-off-white font-display text-base tracking-wide">{{ apex.headline }}</h3>
                        <p class="text-text-body text-sm leading-relaxed mt-2 line-clamp-2">{{ apex.body }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- The Anti-Testimonial -->
        <section class="scroll-section py-16 md:py-32 lg:py-44 px-6">
            <div class="max-w-3xl mx-auto text-center">
                <p class="font-serif italic text-gold text-2xl md:text-3xl lg:text-4xl leading-relaxed tracking-wide">"We do not publish names, photos, or testimonials. The work is private. The work is the proof."</p>
                <p class="font-serif italic text-gold text-base md:text-lg tracking-wide mt-8">— Apex Human</p>
            </div>
        </section>

        <!-- Final CTA with background image -->
        <section v-if="s('cta')" class="scroll-section relative py-16 md:py-32 lg:py-40 px-6 overflow-hidden">
            <div class="absolute inset-0">
                <img src="/images/final-horizon.webp" alt="" class="w-full h-full object-cover opacity-15" loading="lazy">
                <div class="absolute inset-0 bg-gradient-to-t from-black via-black/70 to-black/40"></div>
            </div>
            <div class="relative max-w-3xl mx-auto text-center">
                <h2 v-if="s('cta').headline" class="font-display text-gold-light text-3xl md:text-5xl tracking-[0.06em] mb-4">{{ s('cta').headline }}</h2>
                <p v-if="s('cta').subheadline" class="text-text-body text-base mb-10 max-w-xl mx-auto">{{ s('cta').subheadline }}</p>
                <Link v-if="s('cta').cta_text" :href="s('cta').cta_url || '/apply'" class="inline-block px-10 py-4 bg-gold text-black text-xs tracking-[0.3em] uppercase font-sans font-semibold hover:bg-gold-light active:bg-gold-deep transition-colors duration-400">
                    {{ s('cta').cta_text }}
                </Link>
            </div>
        </section>
    </AppLayout>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import GoldLightning from '@/Components/GoldLightning.vue';
import { usePageAnimations } from '@/Composables/useScrollReveal.js';

const props = defineProps({
    page: Object,
    sections: Object,
    latestPosts: { type: Array, default: () => [] },
    latestDailyApex: { type: Array, default: () => [] },
});

usePageAnimations();

const heroImg = ref(null);
let ticking = false;

function onScroll() {
    if (!ticking) {
        window.requestAnimationFrame(() => {
            if (heroImg.value) {
                heroImg.value.style.transform = `translateY(${window.scrollY * 0.35}px)`;
            }
            ticking = false;
        });
        ticking = true;
    }
}

onMounted(() => {
    window.addEventListener('scroll', onScroll, { passive: true });
});

onUnmounted(() => {
    window.removeEventListener('scroll', onScroll);
});

function s(key) {
    return props.sections?.[key] || null;
}

function parseMeta(section, key) {
    if (!section?.metadata) return [];
    const meta = typeof section.metadata === 'string' ? JSON.parse(section.metadata) : section.metadata;
    return meta[key] || [];
}

function formatDate(date) {
    if (!date) return '';
    return new Date(date).toLocaleDateString('en-GB', { day: 'numeric', month: 'short' });
}
</script>
