<template>
    <AdminLayout>
        <template #title>Message from {{ contact.name }}</template>
        <div class="max-w-2xl bg-black-warm border border-gold-deep/20 rounded p-6 space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <div><p class="text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Name</p><p class="text-off-white text-sm">{{ contact.name }}</p></div>
                <div><p class="text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Email</p><p class="text-off-white text-sm">{{ contact.email }}</p></div>
            </div>
            <div><p class="text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Message</p><p class="text-off-white text-sm whitespace-pre-line">{{ contact.message }}</p></div>
            <div class="flex gap-3 pt-2">
                <a :href="`mailto:${contact.email}`" class="px-5 py-2 bg-gold text-black text-xs tracking-[0.2em] uppercase font-semibold hover:bg-gold-light transition-colors">Reply via Email</a>
                <button @click="deleteContact" class="px-5 py-2 border border-red-500/30 text-red-400 text-xs tracking-[0.2em] uppercase font-semibold hover:bg-red-500/10 transition-colors">Delete</button>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
const props = defineProps({ contact: Object });
function deleteContact() {
    if (confirm('Delete this message?')) router.delete(`/admin/contacts/${props.contact.id}`);
}
</script>
