<template>
    <AppLayout :title="page.meta_title" :description="page.meta_description">
        <!-- Hero -->
        <section v-if="s('hero')" class="pt-24 pb-10 md:pt-32 md:pb-16 px-6">
            <div class="max-w-5xl mx-auto text-center">
                <h1 class="font-display text-gold-light text-4xl md:text-5xl tracking-[0.06em] leading-tight">{{ s('hero').headline }}</h1>
                <p v-if="s('hero').subheadline" class="text-text-body text-base mt-4">{{ s('hero').subheadline }}</p>
            </div>
        </section>

        <!-- Posts -->
        <section class="scroll-section py-10 md:py-16 px-6">
            <div class="max-w-5xl mx-auto space-y-8">
                <article v-for="post in posts.data" :key="post.id" class="border-l-2 border-gold pl-6 py-2">
                    <p class="text-gold text-[9px] uppercase tracking-[0.4em] font-semibold">{{ post.category || 'Daily Apex' }}</p>
                    <h2 class="font-display text-off-white text-lg tracking-wide mt-2">{{ post.headline }}</h2>
                    <p class="text-text-body text-sm leading-relaxed mt-3">{{ post.body }}</p>
                    <p class="text-warm-grey text-xs mt-3">{{ formatDate(post.published_at) }}</p>
                </article>
            </div>
        </section>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { usePageAnimations } from '@/Composables/useScrollReveal.js';

const props = defineProps({ page: Object, sections: Object, posts: Object });

usePageAnimations();

function s(key) { return props.sections?.[key] || null; }

function formatDate(date) {
    if (!date) return '';
    return new Date(date).toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' });
}
</script>
