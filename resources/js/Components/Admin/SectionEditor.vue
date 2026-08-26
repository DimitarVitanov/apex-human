<template>
    <form @submit.prevent="save" class="space-y-4">
        <!-- Language tabs -->
        <div class="flex items-center gap-1 border-b border-gold-deep/20">
            <button
                v-for="l in langTabs"
                :key="l.code"
                type="button"
                @click="activeLang = l.code"
                class="px-3 py-1.5 text-[10px] uppercase tracking-[0.2em] font-semibold border-b-2 -mb-px transition-colors"
                :class="activeLang === l.code ? 'border-gold text-gold' : 'border-transparent text-warm-grey hover:text-off-white'"
            >
                {{ l.label }}
            </button>
        </div>

        <p v-if="activeLang === 'mk'" class="text-warm-grey/70 text-[11px] bg-black/30 border border-gold-deep/20 rounded px-3 py-2">
            Македонски превод. Празните полиња автоматски ја користат англиската верзија.
        </p>

        <!-- Field set (rendered for whichever language is active) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div v-if="active.eyebrow !== undefined">
                <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Eyebrow</label>
                <input v-model="active.eyebrow" :placeholder="ph('eyebrow')" class="w-full bg-transparent border border-gold-deep/30 text-off-white text-sm px-3 py-2 rounded focus:outline-none focus:border-gold transition-colors">
            </div>
            <div v-if="active.headline !== undefined">
                <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Headline</label>
                <input v-model="active.headline" :placeholder="ph('headline')" class="w-full bg-transparent border border-gold-deep/30 text-off-white text-sm px-3 py-2 rounded focus:outline-none focus:border-gold transition-colors">
            </div>
        </div>

        <div v-if="active.subheadline !== undefined">
            <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Subheadline</label>
            <textarea v-model="active.subheadline" rows="2" :placeholder="ph('subheadline')" class="w-full bg-transparent border border-gold-deep/30 text-off-white text-sm px-3 py-2 rounded focus:outline-none focus:border-gold transition-colors resize-none"></textarea>
        </div>

        <div v-if="active.body !== undefined">
            <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Body</label>
            <textarea v-model="active.body" rows="6" :placeholder="ph('body')" class="w-full bg-transparent border border-gold-deep/30 text-off-white text-sm px-3 py-2 rounded focus:outline-none focus:border-gold transition-colors resize-y"></textarea>
        </div>

        <div v-if="active.quote !== undefined">
            <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Quote</label>
            <textarea v-model="active.quote" rows="2" :placeholder="ph('quote')" class="w-full bg-transparent border border-gold-deep/30 text-off-white text-sm px-3 py-2 rounded focus:outline-none focus:border-gold transition-colors resize-none"></textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div v-if="active.cta_text !== undefined">
                <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">CTA Text</label>
                <input v-model="active.cta_text" :placeholder="ph('cta_text')" class="w-full bg-transparent border border-gold-deep/30 text-off-white text-sm px-3 py-2 rounded focus:outline-none focus:border-gold transition-colors">
            </div>
            <div v-if="activeLang === 'en' && form.cta_url !== null">
                <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">CTA URL <span class="text-warm-grey/50 normal-case tracking-normal">(shared)</span></label>
                <input v-model="form.cta_url" class="w-full bg-transparent border border-gold-deep/30 text-off-white text-sm px-3 py-2 rounded focus:outline-none focus:border-gold transition-colors">
            </div>
        </div>

        <!-- Image path is language-independent; alt text is translatable -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div v-if="activeLang === 'en' && form.image !== null">
                <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Image Path <span class="text-warm-grey/50 normal-case tracking-normal">(shared)</span></label>
                <input v-model="form.image" class="w-full bg-transparent border border-gold-deep/30 text-off-white text-sm px-3 py-2 rounded focus:outline-none focus:border-gold transition-colors">
            </div>
            <div v-if="active.image_alt !== undefined">
                <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Image Alt</label>
                <input v-model="active.image_alt" :placeholder="ph('image_alt')" class="w-full bg-transparent border border-gold-deep/30 text-off-white text-sm px-3 py-2 rounded focus:outline-none focus:border-gold transition-colors">
            </div>
        </div>

        <div v-if="section.metadata !== null && active.metadata !== undefined">
            <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Metadata (JSON)</label>
            <textarea v-model="active.metadata" rows="6" class="w-full bg-transparent border border-gold-deep/30 text-off-white text-sm font-mono px-3 py-2 rounded focus:outline-none focus:border-gold transition-colors resize-y"></textarea>
            <p class="text-warm-grey/60 text-[10px] mt-1">Keep the same keys/structure as English; translate only the text values.</p>
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
import { computed, ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({ section: Object });

const langTabs = [
    { code: 'en', label: 'English' },
    { code: 'mk', label: 'Македонски' },
];
const activeLang = ref('en');

// Only fields present on the section (non-null) are translatable/editable.
const TRANSLATABLE = ['eyebrow', 'headline', 'subheadline', 'body', 'quote', 'cta_text', 'image_alt'];
const mk = props.section.translations?.mk || {};

function mkField(field, value) {
    // Preserve which fields the section uses: mirror non-null EN fields as ''.
    if (props.section[field] === null || props.section[field] === undefined) return undefined;
    return value ?? '';
}

const form = useForm({
    // English (base columns)
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
    // Macedonian overrides
    translations: {
        mk: {
            eyebrow: mkField('eyebrow', mk.eyebrow),
            headline: mkField('headline', mk.headline),
            subheadline: mkField('subheadline', mk.subheadline),
            body: mkField('body', mk.body),
            quote: mkField('quote', mk.quote),
            cta_text: mkField('cta_text', mk.cta_text),
            image_alt: mkField('image_alt', mk.image_alt),
            metadata: props.section.metadata
                ? JSON.stringify(mk.metadata ?? props.section.metadata, null, 2)
                : undefined,
        },
    },
});

// The object bound to the visible inputs for the active language.
const active = computed(() => (activeLang.value === 'mk' ? form.translations.mk : form));

// Placeholder = the English value, shown on the MK tab as a hint.
function ph(field) {
    return activeLang.value === 'mk' ? (form[field] || '') : '';
}

function save() {
    form.put(`/admin/sections/${props.section.id}`);
}
</script>
