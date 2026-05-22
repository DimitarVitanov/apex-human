<template>
    <AdminLayout>
        <template #title>Edit: {{ page.title }}</template>

        <form @submit.prevent="savePage" class="bg-black-warm border border-gold-deep/20 rounded p-6 mb-8">
            <p class="text-warm-grey text-[9px] uppercase tracking-[0.4em] font-sans font-semibold mb-4">Page Settings</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1.5">Title</label>
                    <input v-model="pageForm.title" class="w-full bg-transparent border border-gold-deep/30 text-off-white text-sm px-3 py-2 rounded focus:outline-none focus:border-gold transition-colors">
                </div>
                <div>
                    <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1.5">Meta Title</label>
                    <input v-model="pageForm.meta_title" class="w-full bg-transparent border border-gold-deep/30 text-off-white text-sm px-3 py-2 rounded focus:outline-none focus:border-gold transition-colors">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1.5">Meta Description</label>
                    <textarea v-model="pageForm.meta_description" rows="2" class="w-full bg-transparent border border-gold-deep/30 text-off-white text-sm px-3 py-2 rounded focus:outline-none focus:border-gold transition-colors resize-none"></textarea>
                </div>
                <div class="flex items-center gap-2">
                    <input v-model="pageForm.is_published" type="checkbox" id="published" class="accent-gold">
                    <label for="published" class="text-warm-grey text-xs">Published</label>
                </div>
            </div>
            <button type="submit" :disabled="pageForm.processing" class="mt-4 px-5 py-2 bg-gold text-black text-xs tracking-[0.2em] uppercase font-semibold hover:bg-gold-light transition-colors">Save Page</button>
        </form>

        <p class="text-warm-grey text-[9px] uppercase tracking-[0.4em] font-sans font-semibold mb-4">Sections</p>
        <div class="space-y-4">
            <div v-for="section in page.sections" :key="section.id" class="bg-black-warm border border-gold-deep/20 rounded">
                <button
                    @click="toggleSection(section.id)"
                    class="w-full flex items-center justify-between px-5 py-4 text-left"
                >
                    <div>
                        <span class="text-gold text-[9px] uppercase tracking-[0.3em] font-semibold">{{ section.key }}</span>
                        <span class="text-warm-grey text-[9px] uppercase tracking-[0.2em] ml-3">{{ section.type }}</span>
                    </div>
                    <span class="text-warm-grey text-xs">{{ openSections.includes(section.id) ? '−' : '+' }}</span>
                </button>

                <div v-if="openSections.includes(section.id)" class="px-5 pb-5 border-t border-gold-deep/10 pt-4">
                    <SectionEditor :section="section" />
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import SectionEditor from '@/Components/Admin/SectionEditor.vue';

const props = defineProps({ page: Object });

const pageForm = useForm({
    title: props.page.title,
    meta_title: props.page.meta_title,
    meta_description: props.page.meta_description,
    is_published: props.page.is_published,
});

const openSections = ref([]);

function toggleSection(id) {
    const idx = openSections.value.indexOf(id);
    if (idx > -1) openSections.value.splice(idx, 1);
    else openSections.value.push(id);
}

function savePage() {
    pageForm.put(`/admin/pages/${props.page.id}`);
}
</script>
