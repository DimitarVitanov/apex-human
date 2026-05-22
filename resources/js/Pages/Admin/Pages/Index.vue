<template>
    <AdminLayout>
        <template #title>Pages &amp; Sections</template>

        <div class="space-y-3">
            <Link
                v-for="page in pages"
                :key="page.id"
                :href="`/admin/pages/${page.id}/edit`"
                class="block bg-black-warm border border-gold-deep/20 rounded p-5 hover:border-gold/30 transition-colors duration-200"
            >
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-off-white text-sm font-semibold">{{ page.title }}</p>
                        <p class="text-warm-grey text-xs mt-1">/{{ page.slug }} &middot; {{ page.sections?.length || 0 }} sections</p>
                    </div>
                    <span class="text-[9px] uppercase tracking-[0.2em] font-semibold px-2 py-1 rounded"
                        :class="page.is_published ? 'bg-green-500/10 text-green-400' : 'bg-warm-grey/10 text-warm-grey'"
                    >
                        {{ page.is_published ? 'Published' : 'Draft' }}
                    </span>
                </div>
            </Link>
        </div>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Link } from '@inertiajs/vue3';

defineProps({ pages: Array });
</script>
