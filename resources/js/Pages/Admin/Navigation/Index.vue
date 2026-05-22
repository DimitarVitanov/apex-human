<template>
    <AdminLayout>
        <template #title>Navigation</template>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div v-for="(items, location) in { Header: headerItems, Footer: footerItems }" :key="location">
                <p class="text-gold text-[9px] uppercase tracking-[0.4em] font-semibold mb-4">{{ location }}</p>
                <div class="space-y-2 mb-4">
                    <div v-for="item in items" :key="item.id" class="bg-black-warm border border-gold-deep/20 rounded p-4 flex items-center justify-between">
                        <div>
                            <p class="text-off-white text-sm">{{ item.label }}</p>
                            <p class="text-warm-grey text-xs">{{ item.url }}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <span v-if="item.is_cta" class="text-[8px] uppercase tracking-[0.2em] bg-gold/10 text-gold px-1.5 py-0.5 rounded">CTA</span>
                            <button @click="deleteItem(item.id)" class="text-red-400 text-xs hover:text-red-300 transition-colors">Del</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8 bg-black-warm border border-gold-deep/20 rounded p-6 max-w-lg">
            <p class="text-warm-grey text-[9px] uppercase tracking-[0.4em] font-semibold mb-4">Add Navigation Item</p>
            <form @submit.prevent="addItem" class="space-y-3">
                <select v-model="newItem.location" class="w-full bg-dark-grey border border-gold-deep/30 text-off-white text-sm px-3 py-2 rounded focus:outline-none focus:border-gold">
                    <option value="header">Header</option>
                    <option value="footer">Footer</option>
                </select>
                <input v-model="newItem.label" placeholder="Label" class="w-full bg-transparent border border-gold-deep/30 text-off-white text-sm px-3 py-2 rounded focus:outline-none focus:border-gold transition-colors">
                <input v-model="newItem.url" placeholder="URL" class="w-full bg-transparent border border-gold-deep/30 text-off-white text-sm px-3 py-2 rounded focus:outline-none focus:border-gold transition-colors">
                <div class="flex items-center gap-4">
                    <label class="flex items-center gap-2"><input v-model="newItem.is_cta" type="checkbox" class="accent-gold"><span class="text-warm-grey text-xs">CTA</span></label>
                    <label class="flex items-center gap-2"><input v-model="newItem.is_external" type="checkbox" class="accent-gold"><span class="text-warm-grey text-xs">External</span></label>
                </div>
                <button type="submit" class="px-5 py-2 bg-gold text-black text-xs tracking-[0.2em] uppercase font-semibold hover:bg-gold-light transition-colors">Add</button>
            </form>
        </div>
    </AdminLayout>
</template>

<script setup>
import { reactive } from 'vue';
import { router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

defineProps({ headerItems: Array, footerItems: Array });

const newItem = reactive({ location: 'header', label: '', url: '', is_cta: false, is_external: false, sort_order: 99 });

function addItem() {
    router.post('/admin/navigation', { ...newItem }, { preserveScroll: true });
    newItem.label = '';
    newItem.url = '';
    newItem.is_cta = false;
    newItem.is_external = false;
}

function deleteItem(id) {
    if (confirm('Remove this item?')) router.delete(`/admin/navigation/${id}`, { preserveScroll: true });
}
</script>
