<template>
    <form @submit.prevent="save" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div v-if="form.eyebrow !== null">
                <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Eyebrow</label>
                <input v-model="form.eyebrow" class="w-full bg-transparent border border-gold-deep/30 text-off-white text-sm px-3 py-2 rounded focus:outline-none focus:border-gold transition-colors">
            </div>
            <div v-if="form.headline !== null">
                <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Headline</label>
                <input v-model="form.headline" class="w-full bg-transparent border border-gold-deep/30 text-off-white text-sm px-3 py-2 rounded focus:outline-none focus:border-gold transition-colors">
            </div>
        </div>

        <div v-if="form.subheadline !== null">
            <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Subheadline</label>
            <textarea v-model="form.subheadline" rows="2" class="w-full bg-transparent border border-gold-deep/30 text-off-white text-sm px-3 py-2 rounded focus:outline-none focus:border-gold transition-colors resize-none"></textarea>
        </div>

        <div v-if="form.body !== null">
            <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Body</label>
            <textarea v-model="form.body" rows="6" class="w-full bg-transparent border border-gold-deep/30 text-off-white text-sm px-3 py-2 rounded focus:outline-none focus:border-gold transition-colors resize-y"></textarea>
        </div>

        <div v-if="form.quote !== null">
            <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Quote</label>
            <textarea v-model="form.quote" rows="2" class="w-full bg-transparent border border-gold-deep/30 text-off-white text-sm px-3 py-2 rounded focus:outline-none focus:border-gold transition-colors resize-none"></textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div v-if="form.cta_text !== null">
                <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">CTA Text</label>
                <input v-model="form.cta_text" class="w-full bg-transparent border border-gold-deep/30 text-off-white text-sm px-3 py-2 rounded focus:outline-none focus:border-gold transition-colors">
            </div>
            <div v-if="form.cta_url !== null">
                <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">CTA URL</label>
                <input v-model="form.cta_url" class="w-full bg-transparent border border-gold-deep/30 text-off-white text-sm px-3 py-2 rounded focus:outline-none focus:border-gold transition-colors">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div v-if="form.image !== null">
                <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Image Path</label>
                <input v-model="form.image" class="w-full bg-transparent border border-gold-deep/30 text-off-white text-sm px-3 py-2 rounded focus:outline-none focus:border-gold transition-colors">
            </div>
            <div v-if="form.image_alt !== null">
                <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Image Alt</label>
                <input v-model="form.image_alt" class="w-full bg-transparent border border-gold-deep/30 text-off-white text-sm px-3 py-2 rounded focus:outline-none focus:border-gold transition-colors">
            </div>
        </div>

        <div v-if="section.metadata !== null">
            <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Metadata (JSON)</label>
            <textarea v-model="form.metadata" rows="6" class="w-full bg-transparent border border-gold-deep/30 text-off-white text-sm font-mono px-3 py-2 rounded focus:outline-none focus:border-gold transition-colors resize-y"></textarea>
        </div>

        <div class="flex items-center gap-4">
            <div class="flex items-center gap-2">
                <input v-model="form.is_visible" type="checkbox" id="visible" class="accent-gold">
                <label for="visible" class="text-warm-grey text-xs">Visible</label>
            </div>
            <button type="submit" :disabled="form.processing" class="px-5 py-2 bg-gold text-black text-xs tracking-[0.2em] uppercase font-semibold hover:bg-gold-light transition-colors disabled:opacity-50">Save Section</button>
        </div>
    </form>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';

const props = defineProps({ section: Object });

const form = useForm({
    eyebrow: props.section.eyebrow,
    headline: props.section.headline,
    subheadline: props.section.subheadline,
    body: props.section.body,
    quote: props.section.quote,
    cta_text: props.section.cta_text,
    cta_url: props.section.cta_url,
    image: props.section.image,
    image_alt: props.section.image_alt,
    metadata: props.section.metadata ? JSON.stringify(props.section.metadata, null, 2) : null,
    is_visible: props.section.is_visible,
});

function save() {
    form.put(`/admin/sections/${props.section.id}`);
}
</script>
