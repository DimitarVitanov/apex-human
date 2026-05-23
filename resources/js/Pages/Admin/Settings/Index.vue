<template>
    <AdminLayout>
        <template #title>Site Settings</template>
        <div class="space-y-12 max-w-3xl">
            <form @submit.prevent="save" class="space-y-8">
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

            <div class="bg-black-warm border border-gold-deep/20 rounded p-6 space-y-4">
                <p class="text-gold text-[9px] uppercase tracking-[0.4em] font-semibold mb-2">Test Emails</p>
                <p class="text-warm-grey text-xs mb-4">Send test emails to <span class="text-off-white">{{ fromAddress }}</span></p>
                <div class="flex flex-wrap gap-3">
                    <button
                        v-for="emailType in emailTypes"
                        :key="emailType.type"
                        @click="sendTestEmail(emailType.type)"
                        :disabled="testingEmail === emailType.type"
                        class="px-4 py-2 border border-gold-deep/30 text-off-white text-xs tracking-[0.1em] uppercase font-semibold hover:border-gold hover:text-gold transition-colors disabled:opacity-50"
                    >
                        <span v-if="testingEmail === emailType.type">Sending...</span>
                        <span v-else>{{ emailType.label }}</span>
                    </button>
                </div>
            </div>

            <form @submit.prevent="changePassword" class="bg-black-warm border border-gold-deep/20 rounded p-6 space-y-4">
                <p class="text-gold text-[9px] uppercase tracking-[0.4em] font-semibold mb-2">Change Password</p>
                <div>
                    <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Current Password</label>
                    <input v-model="passwordForm.current_password" type="password" class="w-full bg-transparent border border-gold-deep/30 text-off-white text-sm px-3 py-2 rounded focus:outline-none focus:border-gold transition-colors">
                    <p v-if="passwordForm.errors.current_password" class="text-red-400 text-xs mt-1">{{ passwordForm.errors.current_password }}</p>
                </div>
                <div>
                    <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">New Password</label>
                    <input v-model="passwordForm.password" type="password" class="w-full bg-transparent border border-gold-deep/30 text-off-white text-sm px-3 py-2 rounded focus:outline-none focus:border-gold transition-colors">
                    <p v-if="passwordForm.errors.password" class="text-red-400 text-xs mt-1">{{ passwordForm.errors.password }}</p>
                </div>
                <div>
                    <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Confirm New Password</label>
                    <input v-model="passwordForm.password_confirmation" type="password" class="w-full bg-transparent border border-gold-deep/30 text-off-white text-sm px-3 py-2 rounded focus:outline-none focus:border-gold transition-colors">
                </div>
                <button type="submit" :disabled="passwordForm.processing" class="px-5 py-2 bg-gold text-black text-xs tracking-[0.2em] uppercase font-semibold hover:bg-gold-light transition-colors disabled:opacity-50">Update Password</button>
            </form>
        </div>
    </AdminLayout>
</template>

<script setup>
import { reactive, ref } from 'vue';
import { useForm, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({ settings: Object });

const formData = reactive({});
Object.values(props.settings).flat().forEach(s => { formData[s.key] = s.value; });

const form = useForm({});

function save() {
    const settingsArray = Object.entries(formData).map(([key, value]) => ({ key, value }));
    form.transform(() => ({ settings: settingsArray })).put('/admin/settings');
}

const fromAddress = 'coach@apexhuman.co';
const testingEmail = ref(null);

const emailTypes = [
    { type: 'application-confirmation', label: 'Application Confirmation' },
    { type: 'contact-auto-reply', label: 'Contact Auto-Reply' },
    { type: 'admin-new-application', label: 'Admin: New Application' },
    { type: 'admin-new-contact', label: 'Admin: New Contact' },
    { type: 'booking-confirmation', label: 'Booking Confirmation' },
];

function sendTestEmail(type) {
    testingEmail.value = type;
    router.post(`/admin/settings/test-email/${type}`, {}, {
        preserveScroll: true,
        onFinish: () => { testingEmail.value = null; },
    });
}

const passwordForm = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

function changePassword() {
    passwordForm.put('/admin/settings/password', {
        onSuccess: () => passwordForm.reset(),
    });
}
</script>
