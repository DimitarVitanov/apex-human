<template>
    <AppLayout :title="page.meta_title">
        <!-- Hero -->
        <section v-if="s('hero')" class="relative min-h-[70vh] flex items-center justify-center px-6">
            <div class="relative text-center max-w-5xl mx-auto">
                <h1 class="font-display text-gold-light text-4xl md:text-6xl tracking-[0.06em] leading-tight">{{ s('hero').headline }}</h1>
                <p v-if="s('hero').subheadline" class="text-text-body text-base md:text-lg mt-6 max-w-2xl mx-auto leading-relaxed">{{ s('hero').subheadline }}</p>
            </div>
        </section>

        <!-- Manifesto -->
        <section v-if="s('manifesto')" class="scroll-section py-24 lg:py-32 px-6">
            <div class="max-w-5xl mx-auto">
                <h2 v-if="s('manifesto').headline" class="font-display text-gold-light text-3xl md:text-4xl tracking-[0.06em] mb-8">{{ s('manifesto').headline }}</h2>
                <div class="text-text-body text-base leading-[1.8] whitespace-pre-line">{{ s('manifesto').body }}</div>
            </div>
        </section>

        <!-- Standards -->
        <section v-if="s('standards')" class="scroll-section py-24 lg:py-32 px-6 bg-black-warm/30">
            <div class="max-w-5xl mx-auto">
                <p v-if="s('standards').eyebrow" class="text-gold text-[9px] uppercase tracking-[0.5em] font-sans font-semibold mb-4">{{ s('standards').eyebrow }}</p>
                <h2 class="font-display text-gold-light text-3xl md:text-4xl tracking-[0.06em] mb-12">{{ s('standards').headline }}</h2>
                <div class="space-y-6">
                    <div v-for="std in parseMeta(s('standards'), 'standards')" :key="std.number" class="flex gap-6 border-b border-gold-deep/10 pb-6">
                        <span class="text-gold font-display text-lg shrink-0 w-8">{{ std.number }}</span>
                        <div>
                            <p class="text-off-white font-sans font-semibold text-sm">{{ std.title }}</p>
                            <p class="text-text-body text-sm mt-1">{{ std.body }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Promise / CTA -->
        <section v-if="s('promise')" class="scroll-section py-24 lg:py-32 px-6 text-center">
            <div class="max-w-5xl mx-auto">
                <blockquote v-if="s('promise').quote" class="font-display text-gold-light text-xl md:text-2xl tracking-[0.04em] leading-snug italic mb-10">
                    "{{ s('promise').quote }}"
                </blockquote>
                <Link v-if="s('promise').cta_text" :href="s('promise').cta_url || '/apply'" class="inline-block px-8 py-3.5 bg-gold text-black text-xs tracking-[0.3em] uppercase font-sans font-semibold hover:bg-gold-light active:bg-gold-deep transition-colors duration-400">
                    {{ s('promise').cta_text }}
                </Link>
            </div>
        </section>
    </AppLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
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
