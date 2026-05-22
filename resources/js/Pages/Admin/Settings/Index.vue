<template>
    <AdminLayout>
        <template #title>Site Settings</template>
        <form @submit.prevent="save" class="space-y-8 max-w-3xl">
            <div v-for="(items, group) in settings" :key="group" class="bg-black-warm border border-gold-deep/20 rounded p-6">
                <p class="text-gold text-[9px] uppercase tracking-[0.4em] font-semibold mb-4">{{ group }}</p>
                <div class="space-y-4">
                    <div v-for="setting in items" :key="setting.key">
                        <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">{{ setting.label || setting.key }}</label>
                        <textarea v-if="setting.type === 'textarea'" v-model="formData[setting.key]" rows="3" class="w-full bg-transparent border border-gold-deep/30 text-off-white text-sm px-3 py-2 rounded focus:outline-none focus:border-gold transition-colors resize-none"></textarea>
                        <input v-else v-model="formData[setting.key]" class="w-full bg-transparent border border-gold-deep/30 text-off-white text-sm px-3 py-2 rounded focus:outline-none focus:border-gold transition-colors">
                    </div>
                </div>
            </div>
            <button type="submit" :disabled="form.processing" class="px-5 py-2 bg-gold text-black text-xs tracking-[0.2em] uppercase font-semibold hover:bg-gold-light transition-colors disabled:opacity-50">Save Settings</button>
        </form>
    </AdminLayout>
</template>

<script setup>
import { reactive } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({ settings: Object });

const formData = reactive({});
Object.values(props.settings).flat().forEach(s => { formData[s.key] = s.value; });

const form = useForm({});

function save() {
    const settingsArray = Object.entries(formData).map(([key, value]) => ({ key, value }));
    form.transform(() => ({ settings: settingsArray })).put('/admin/settings');
}
</script>
