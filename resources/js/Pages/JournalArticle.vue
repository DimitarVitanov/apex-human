<template>
    <AppLayout :title="post.meta_title || post.title" :description="post.meta_description || post.excerpt">
        <article class="pt-24 pb-14 md:pt-32 md:pb-24 px-6">
            <header class="max-w-5xl mx-auto text-center mb-16">
                <p class="text-gold text-[9px] uppercase tracking-[0.4em] font-semibold">{{ post.category }}</p>
                <h1 class="font-display text-gold-light text-3xl md:text-5xl tracking-[0.06em] leading-tight mt-4">{{ post.title }}</h1>
                <p v-if="post.excerpt" class="text-text-body text-base mt-6 max-w-2xl mx-auto">{{ post.excerpt }}</p>
                <p class="text-warm-grey text-xs mt-4">{{ post.reading_time }}</p>
            </header>

            <div v-if="post.featured_image" class="max-w-5xl mx-auto mb-16">
                <img :src="post.featured_image" :alt="post.featured_image_alt || post.title" class="w-full aspect-[21/9] object-cover">
            </div>

            <div class="max-w-5xl mx-auto prose-apex" v-html="post.body"></div>
        </article>

        <!-- Related Posts -->
        <section v-if="related.length" class="scroll-section py-10 md:py-16 px-6 border-t border-gold-deep/10">
            <div class="max-w-5xl mx-auto">
                <p class="text-gold text-[9px] uppercase tracking-[0.4em] font-semibold mb-8 text-center">More from The Journal</p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <Link v-for="r in related" :key="r.id" :href="`/journal/${r.slug}`" class="group block border border-gold-deep/20 hover:border-gold/30 transition-colors duration-400 p-6">
                        <p class="text-gold text-[9px] uppercase tracking-[0.4em] font-semibold">{{ r.category }}</p>
                        <h3 class="font-display text-off-white text-base tracking-wide mt-2 group-hover:text-gold-light transition-colors">{{ r.title }}</h3>
                        <p class="text-warm-grey text-xs mt-3">{{ r.reading_time }}</p>
                    </Link>
                </div>
            </div>
        </section>
    </AppLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import { usePageAnimations } from '@/Composables/useScrollReveal.js';

defineProps({ post: Object, related: Array });

usePageAnimations();
</script>
