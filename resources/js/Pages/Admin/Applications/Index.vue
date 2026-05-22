<template>
    <AdminLayout>
        <template #title>Applications</template>
        <div class="space-y-3">
            <div v-for="app in applications.data" :key="app.id" class="bg-black-warm border border-gold-deep/20 rounded p-5">
                <Link :href="`/admin/applications/${app.id}`" class="flex items-center justify-between">
                    <div>
                        <p class="text-off-white text-sm font-semibold">{{ app.full_name }}</p>
                        <p class="text-warm-grey text-xs mt-1">{{ app.email }} &middot; {{ app.country }} &middot; Age {{ app.age }}</p>
                    </div>
                    <span class="text-[9px] uppercase tracking-[0.2em] font-semibold px-2 py-1 rounded"
                        :class="{ 'bg-gold/10 text-gold': app.status === 'pending', 'bg-blue-500/10 text-blue-400': app.status === 'reviewed', 'bg-green-500/10 text-green-400': app.status === 'accepted', 'bg-red-500/10 text-red-400': app.status === 'rejected' }"
                    >{{ app.status }}</span>
                </Link>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Link } from '@inertiajs/vue3';
defineProps({ applications: Object, filters: Object });
</script>
