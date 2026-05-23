<template>
    <AppLayout :title="page.meta_title" :description="page.meta_description">
        <!-- Hero -->
        <section v-if="s('hero')" class="relative min-h-[70vh] flex items-center justify-center px-6 overflow-hidden">
            <GoldLightning />
            <div class="relative text-center max-w-5xl mx-auto">
                <h1 class="font-display text-gold-light text-4xl md:text-6xl tracking-[0.06em] leading-tight">{{ s('hero').headline }}</h1>
                <p v-if="s('hero').subheadline" class="text-text-body text-base md:text-lg mt-6 max-w-2xl mx-auto leading-relaxed">{{ s('hero').subheadline }}</p>
            </div>
        </section>

        <!-- Outcomes -->
        <section v-if="s('outcomes')" class="scroll-section py-14 md:py-24 lg:py-32 px-6">
            <div class="max-w-5xl mx-auto">
                <p v-if="s('outcomes').eyebrow" class="text-gold text-[9px] uppercase tracking-[0.5em] font-sans font-semibold mb-4">{{ s('outcomes').eyebrow }}</p>
                <h2 class="font-display text-gold-light text-3xl md:text-4xl tracking-[0.06em] mb-10">{{ s('outcomes').headline }}</h2>
                <ul class="space-y-4">
                    <li v-for="(outcome, i) in parseMeta(s('outcomes'), 'outcomes')" :key="i" class="flex gap-4 text-text-body text-base leading-relaxed">
                        <span class="text-gold shrink-0 mt-1">&#8226;</span>
                        <span>{{ outcome }}</span>
                    </li>
                </ul>
            </div>
        </section>

        <!-- Pillars -->
        <section v-if="s('pillars')" class="scroll-section py-14 md:py-24 lg:py-32 px-6 bg-black-warm/30">
            <div class="max-w-5xl mx-auto">
                <p v-if="s('pillars').eyebrow" class="text-gold text-[9px] uppercase tracking-[0.5em] font-sans font-semibold mb-4">{{ s('pillars').eyebrow }}</p>
                <h2 class="font-display text-gold-light text-3xl md:text-4xl tracking-[0.06em] mb-12">{{ s('pillars').headline }}</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div v-for="pillar in parseMeta(s('pillars'), 'pillars')" :key="pillar.numeral" class="border border-gold-deep/20 p-6 hover:border-gold/30 transition-colors duration-400">
                        <span class="text-gold text-xs font-display tracking-widest">{{ pillar.numeral }}</span>
                        <h3 class="text-off-white font-display text-lg tracking-wide mt-3">{{ pillar.title }}</h3>
                        <p class="text-warm-grey text-[10px] uppercase tracking-[0.3em] mt-1">{{ pillar.subtitle }}</p>
                        <p class="text-text-body text-sm leading-relaxed mt-4">{{ pillar.body }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Timeline -->
        <section v-if="s('timeline')" class="scroll-section py-14 md:py-24 lg:py-32 px-6">
            <div class="max-w-5xl mx-auto">
                <p v-if="s('timeline').eyebrow" class="text-gold text-[9px] uppercase tracking-[0.5em] font-sans font-semibold mb-4">{{ s('timeline').eyebrow }}</p>
                <h2 class="font-display text-gold-light text-3xl md:text-4xl tracking-[0.06em] mb-12">{{ s('timeline').headline }}</h2>
                <div class="space-y-8 relative">
                    <div class="absolute left-3 top-2 bottom-2 w-px bg-gold-deep/30"></div>
                    <div v-for="ms in parseMeta(s('timeline'), 'milestones')" :key="ms.month" class="relative pl-10">
                        <span class="absolute left-0 top-1 w-6 h-6 rounded-full border border-gold bg-black flex items-center justify-center">
                            <span class="w-2 h-2 rounded-full bg-gold"></span>
                        </span>
                        <p class="text-gold text-xs uppercase tracking-[0.3em] font-semibold">{{ ms.month }}</p>
                        <p class="text-off-white font-semibold mt-1">{{ ms.title }}</p>
                        <p class="text-text-body text-sm mt-1">{{ ms.body }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- How it works -->
        <section v-if="s('how_it_works')" class="scroll-section py-14 md:py-24 lg:py-32 px-6 bg-black-warm/30">
            <div class="max-w-5xl mx-auto">
                <p v-if="s('how_it_works').eyebrow" class="text-gold text-[9px] uppercase tracking-[0.5em] font-sans font-semibold mb-4">{{ s('how_it_works').eyebrow }}</p>
                <h2 class="font-display text-gold-light text-3xl md:text-4xl tracking-[0.06em] mb-8">{{ s('how_it_works').headline }}</h2>
                <ul class="space-y-4">
                    <li v-for="(item, i) in parseMeta(s('how_it_works'), 'items')" :key="i" class="flex gap-4 text-text-body text-base">
                        <span class="text-gold shrink-0">&#8226;</span>
                        <span>{{ item }}</span>
                    </li>
                </ul>
            </div>
        </section>

        <!-- Standards -->
        <section v-if="s('standards')" class="scroll-section py-14 md:py-24 lg:py-32 px-6">
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

        <!-- CTA -->
        <section v-if="s('cta')" class="scroll-section py-14 md:py-24 lg:py-32 px-6 text-center">
            <Link v-if="s('cta').cta_text" :href="s('cta').cta_url || '/apply'" class="inline-block px-8 py-3.5 bg-gold text-black text-xs tracking-[0.3em] uppercase font-sans font-semibold hover:bg-gold-light active:bg-gold-deep transition-colors duration-400">
                {{ s('cta').cta_text }}
            </Link>
        </section>
    </AppLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import GoldLightning from '@/Components/GoldLightning.vue';
import { usePageAnimations } from '@/Composables/useScrollReveal.js';

const props = defineProps({ page: Object, sections: Object });

usePageAnimations();

function s(key) { return props.sections?.[key] || null; }
function parseMeta(section, key) {
    if (!section?.metadata) return [];
    const meta = typeof section.metadata === 'string' ? JSON.parse(section.metadata) : section.metadata;
    return meta[key] || [];
}
</script>
