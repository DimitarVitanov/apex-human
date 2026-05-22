<template>
    <AdminLayout>
        <template #title>Dashboard</template>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">
            <div v-for="stat in statCards" :key="stat.label" class="bg-black-warm border border-gold-deep/20 rounded p-5">
                <p class="text-warm-grey text-[9px] uppercase tracking-[0.4em] font-sans font-semibold">{{ stat.label }}</p>
                <p class="font-display text-gold-light text-3xl mt-2">{{ stat.value }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-black-warm border border-gold-deep/20 rounded p-5">
                <p class="text-warm-grey text-[9px] uppercase tracking-[0.4em] font-sans font-semibold mb-4">Recent Applications</p>
                <div v-if="applications.length === 0" class="text-warm-grey text-sm italic">No applications yet.</div>
                <div v-for="app in applications" :key="app.id" class="flex items-center justify-between py-3 border-b border-gold-deep/10 last:border-0">
                    <div>
                        <p class="text-off-white text-sm">{{ app.full_name }}</p>
                        <p class="text-warm-grey text-xs">{{ app.email }}</p>
                    </div>
                    <span class="text-[9px] uppercase tracking-[0.2em] font-semibold px-2 py-1 rounded"
                        :class="{
                            'bg-gold/10 text-gold': app.status === 'pending',
                            'bg-green-500/10 text-green-400': app.status === 'accepted',
                            'bg-red-500/10 text-red-400': app.status === 'rejected',
                        }"
                    >
                        {{ app.status }}
                    </span>
                </div>
            </div>

            <div class="bg-black-warm border border-gold-deep/20 rounded p-5">
                <p class="text-warm-grey text-[9px] uppercase tracking-[0.4em] font-sans font-semibold mb-4">Unread Messages</p>
                <div v-if="contacts.length === 0" class="text-warm-grey text-sm italic">No unread messages.</div>
                <div v-for="contact in contacts" :key="contact.id" class="py-3 border-b border-gold-deep/10 last:border-0">
                    <div class="flex items-center justify-between">
                        <p class="text-off-white text-sm">{{ contact.name }}</p>
                        <p class="text-warm-grey text-xs">{{ new Date(contact.created_at).toLocaleDateString() }}</p>
                    </div>
                    <p class="text-warm-grey text-xs mt-1 truncate">{{ contact.message }}</p>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { computed } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    stats: Object,
    recent_applications: Array,
    recent_contacts: Array,
});

const statCards = computed(() => [
    { label: 'Total Applications', value: props.stats.applications },
    { label: 'Pending Review', value: props.stats.pending_applications },
    { label: 'Unread Messages', value: props.stats.contacts },
    { label: 'Blog Posts', value: props.stats.posts },
]);

const applications = computed(() => props.recent_applications || []);
const contacts = computed(() => props.recent_contacts || []);
</script>
