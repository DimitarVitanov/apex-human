<template>
    <AppLayout :title="page.meta_title">
        <!-- Hero -->
        <section v-if="s('hero')" class="pt-32 pb-16 px-6">
            <div class="max-w-5xl mx-auto text-center">
                <h1 class="font-display text-gold-light text-4xl md:text-5xl tracking-[0.06em] leading-tight">{{ s('hero').headline }}</h1>
                <p v-if="s('hero').subheadline" class="text-text-body text-base mt-4">{{ s('hero').subheadline }}</p>
            </div>
        </section>

        <!-- Posts Grid -->
        <section class="scroll-section py-16 px-6">
            <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <Link
                    v-for="post in posts.data"
                    :key="post.id"
                    :href="`/journal/${post.slug}`"
                    class="group block border border-gold-deep/20 hover:border-gold/30 transition-colors duration-400 overflow-hidden"
                >
                    <div v-if="post.featured_image" class="aspect-[16/9] overflow-hidden">
                        <img :src="post.featured_image" :alt="post.featured_image_alt || post.title" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                    </div>
                    <div class="p-6">
                        <p class="text-gold text-[9px] uppercase tracking-[0.4em] font-semibold">{{ post.category }}</p>
                        <h2 class="font-display text-off-white text-lg tracking-wide mt-2 group-hover:text-gold-light transition-colors duration-200">{{ post.title }}</h2>
                        <p v-if="post.excerpt" class="text-text-body text-sm mt-3 line-clamp-2">{{ post.excerpt }}</p>
                        <p class="text-warm-grey text-xs mt-4">{{ post.reading_time }}</p>
                    </div>
                </Link>
            </div>
        </section>
    </AppLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import { usePageAnimations } from '@/Composables/useScrollReveal.js';

const props = defineProps({ page: Object, sections: Object, posts: Object });

usePageAnimations();

function s(key) { return props.sections?.[key] || null; }
</script>
