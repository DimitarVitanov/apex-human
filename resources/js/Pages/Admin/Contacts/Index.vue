<template>
    <AdminLayout>
        <template #title>Contact Messages</template>
        <div class="space-y-3">
            <Link v-for="contact in contacts.data" :key="contact.id" :href="`/admin/contacts/${contact.id}`"
                class="block bg-black-warm border border-gold-deep/20 rounded p-5 hover:border-gold/30 transition-colors"
            >
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-off-white text-sm font-semibold" :class="!contact.is_read ? 'text-gold-light' : ''">{{ contact.name }}</p>
                        <p class="text-warm-grey text-xs mt-1">{{ contact.email }}</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <span v-if="!contact.is_read" class="w-2 h-2 rounded-full bg-gold"></span>
                        <p class="text-warm-grey text-xs">{{ new Date(contact.created_at).toLocaleDateString() }}</p>
                    </div>
                </div>
                <p class="text-warm-grey text-xs mt-2 truncate">{{ contact.message }}</p>
            </Link>
        </div>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Link } from '@inertiajs/vue3';
defineProps({ contacts: Object });
</script>
