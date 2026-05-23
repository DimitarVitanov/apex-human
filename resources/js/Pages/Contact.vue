<template>
    <AppLayout :title="page.meta_title" :description="page.meta_description">
        <!-- Hero -->
        <section v-if="s('hero')" class="pt-24 pb-10 md:pt-32 md:pb-16 px-6">
            <div class="max-w-5xl mx-auto text-center">
                <h1 class="font-display text-gold-light text-4xl md:text-5xl tracking-[0.06em] leading-tight">{{ s('hero').headline }}</h1>
            </div>
        </section>

        <!-- Success -->
        <section v-if="$page.props.flash?.success" class="px-6 pb-16">
            <div class="max-w-5xl mx-auto bg-gold/10 border border-gold/30 text-gold-light text-sm p-6 rounded text-center">
                {{ $page.props.flash.success }}
            </div>
        </section>

        <!-- Contact Form -->
        <section v-else class="scroll-section py-10 md:py-16 px-6">
            <form @submit.prevent="submit" class="max-w-5xl mx-auto space-y-6">
                <div>
                    <label class="block text-warm-grey text-[9px] uppercase tracking-[0.4em] font-sans font-semibold mb-2">Name *</label>
                    <input v-model="form.name" type="text" required class="w-full bg-transparent border-b border-gold-deep text-off-white text-sm py-2.5 focus:outline-none focus:border-gold transition-colors">
                    <p v-if="form.errors.name" class="text-red-400 text-xs mt-1">{{ form.errors.name }}</p>
                </div>
                <div>
                    <label class="block text-warm-grey text-[9px] uppercase tracking-[0.4em] font-sans font-semibold mb-2">Email *</label>
                    <input v-model="form.email" type="email" required class="w-full bg-transparent border-b border-gold-deep text-off-white text-sm py-2.5 focus:outline-none focus:border-gold transition-colors">
                    <p v-if="form.errors.email" class="text-red-400 text-xs mt-1">{{ form.errors.email }}</p>
                </div>
                <div>
                    <label class="block text-warm-grey text-[9px] uppercase tracking-[0.4em] font-sans font-semibold mb-2">Message *</label>
                    <textarea v-model="form.message" rows="6" required class="w-full bg-transparent border border-gold-deep/30 text-off-white text-sm px-3 py-2.5 rounded focus:outline-none focus:border-gold transition-colors resize-none"></textarea>
                    <p v-if="form.errors.message" class="text-red-400 text-xs mt-1">{{ form.errors.message }}</p>
                </div>
                <button
                    type="submit"
                    :disabled="form.processing"
                    class="w-full py-3.5 bg-gold text-black text-xs tracking-[0.3em] uppercase font-sans font-semibold hover:bg-gold-light active:bg-gold-deep transition-colors duration-400 disabled:opacity-50"
                >
                    {{ form.processing ? 'Sending...' : 'Send Message' }}
                </button>
            </form>
        </section>

        <!-- Contact Info -->
        <section class="scroll-section py-10 md:py-16 px-6 border-t border-gold-deep/10">
            <div class="max-w-5xl mx-auto text-center space-y-4">
                <p class="text-warm-grey text-[9px] uppercase tracking-[0.4em] font-semibold">Or reach us directly</p>
                <p class="text-off-white text-sm">coach@apexhuman.co</p>
                <p class="text-off-white text-sm">@apexhumansystem</p>
            </div>
        </section>
    </AppLayout>
</template>

<script setup>
import { useForm, usePage } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import { usePageAnimations } from '@/Composables/useScrollReveal.js';

const props = defineProps({ page: Object, sections: Object });

usePageAnimations();
const $page = usePage();

function s(key) { return props.sections?.[key] || null; }

const form = useForm({
    name: '',
    email: '',
    message: '',
});

function submit() {
    form.post('/contact');
}
</script>
