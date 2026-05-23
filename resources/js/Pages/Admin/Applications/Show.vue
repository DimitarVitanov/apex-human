<template>
    <AdminLayout>
        <template #title>Application: {{ application.full_name }}</template>
        <div class="max-w-3xl space-y-6">
            <div class="bg-black-warm border border-gold-deep/20 rounded p-6 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div><p class="text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Name</p><p class="text-off-white text-sm">{{ application.full_name }}</p></div>
                    <div><p class="text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Email</p><p class="text-off-white text-sm">{{ application.email }}</p></div>
                    <div><p class="text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Age</p><p class="text-off-white text-sm">{{ application.age }}</p></div>
                    <div><p class="text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Country</p><p class="text-off-white text-sm">{{ application.country }}</p></div>
                </div>
                <div><p class="text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Q1 · Where You Are</p><p class="text-off-white text-sm whitespace-pre-line">{{ application.current_state }}</p></div>
                <div><p class="text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Q2 · Why You Want to Change</p><p class="text-off-white text-sm whitespace-pre-line">{{ application.why_now }}</p></div>
                <div><p class="text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Q3 · What You've Tried</p><p class="text-off-white text-sm whitespace-pre-line">{{ application.previous_experience }}</p></div>
                <div><p class="text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Q4 · 12-Month Vision</p><p class="text-off-white text-sm whitespace-pre-line">{{ application.twelve_month_goal }}</p></div>
                <div class="grid grid-cols-2 gap-4">
                    <div><p class="text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Q5 · Commitment</p><p class="text-off-white text-sm">{{ commitmentLabel }}</p></div>
                    <div><p class="text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Q6 · Investment</p><p class="text-off-white text-sm">{{ investmentLabel }}</p></div>
                </div>
            </div>

            <!-- Booking Link (shown when accepted) -->
            <div v-if="application.booking_token" class="bg-gold/5 border border-gold/20 rounded p-4 md:p-6 space-y-4">
                <div>
                    <p class="text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-2">Booking Link</p>
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-3">
                        <input :value="bookingUrl" readonly class="w-full sm:flex-1 bg-transparent border border-gold-deep/30 text-off-white text-xs px-3 py-2 rounded font-mono truncate">
                        <button @click="copyLink" class="px-4 py-2 bg-gold text-black text-[9px] tracking-[0.2em] uppercase font-semibold hover:bg-gold-light transition-colors rounded whitespace-nowrap">
                            {{ copied ? 'Copied!' : 'Copy' }}
                        </button>
                    </div>
                    <p class="text-warm-grey text-xs mt-2">Send this link to the applicant so they can book a discovery call via Google Meet.</p>
                </div>
                <div>
                    <p class="text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-2">Google Meet Link</p>
                    <a :href="meetLink" target="_blank" class="text-gold text-xs hover:text-gold-light transition-colors underline break-all">{{ meetLink }}</a>
                    <p class="text-warm-grey text-xs mt-2">This link will be sent to the applicant when they book their call.</p>
                </div>
            </div>

            <form @submit.prevent="save" class="bg-black-warm border border-gold-deep/20 rounded p-6 space-y-4">
                <p class="text-warm-grey text-[9px] uppercase tracking-[0.4em] font-semibold">Update Status</p>
                <select v-model="form.status" class="bg-dark-grey border border-gold-deep/30 text-off-white text-sm px-3 py-2 rounded focus:outline-none focus:border-gold">
                    <option value="pending">Pending</option>
                    <option value="reviewed">Reviewed</option>
                    <option value="accepted">Accepted</option>
                    <option value="rejected">Rejected</option>
                </select>
                <div>
                    <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Admin Notes</label>
                    <textarea v-model="form.admin_notes" rows="3" class="w-full bg-transparent border border-gold-deep/30 text-off-white text-sm px-3 py-2 rounded focus:outline-none focus:border-gold transition-colors resize-none"></textarea>
                </div>
                <button type="submit" :disabled="form.processing" class="px-5 py-2 bg-gold text-black text-xs tracking-[0.2em] uppercase font-semibold hover:bg-gold-light transition-colors">Save</button>
            </form>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
const props = defineProps({ application: Object, meetLink: String });
const form = useForm({ status: props.application.status, admin_notes: props.application.admin_notes || '' });
function save() { form.put(`/admin/applications/${props.application.id}`); }

const commitmentMap = { yes: 'Yes — ready to commit', need_to_think: 'Needs to think about it', no: 'No — not the right time' };
const investmentMap = { under_500: 'Under €500/mo', '500_1000': '€500–€1,000/mo', '1000_2500': '€1,000–€2,500/mo', '2500_plus': '€2,500+/mo', discuss_on_call: 'Prefers to discuss on call' };
const commitmentLabel = computed(() => commitmentMap[props.application.commitment] || props.application.commitment || '—');
const investmentLabel = computed(() => investmentMap[props.application.investment] || props.application.investment || '—');

const bookingUrl = computed(() => props.application.booking_token ? `${window.location.origin}/apply/book?token=${props.application.booking_token}` : '');
const copied = ref(false);
function copyLink() {
    navigator.clipboard.writeText(bookingUrl.value);
    copied.value = true;
    setTimeout(() => copied.value = false, 2000);
}
</script>
