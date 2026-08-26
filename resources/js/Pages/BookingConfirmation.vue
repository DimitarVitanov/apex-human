<template>
    <AppLayout :title="t('booking_confirm.page_title', 'Booking Confirmed')">
        <section class="min-h-screen flex items-center justify-center px-6">
            <div class="max-w-5xl mx-auto text-center">

                <p class="text-gold text-[9px] uppercase tracking-[0.5em] font-sans font-semibold mb-6">{{ t('booking_confirm.eyebrow', 'Confirmed') }}</p>
                <h1 class="font-display text-gold-light text-3xl md:text-5xl tracking-[0.06em] leading-tight mb-2">{{ t('booking_confirm.headline_1', "We'll see you") }}</h1>
                <h1 class="font-display text-gold-light text-3xl md:text-5xl tracking-[0.06em] leading-tight mb-12">{{ t('booking_confirm.headline_2_on', 'on') }} {{ dayName }}.</h1>

                <div class="max-w-md mx-auto space-y-6 text-left">
                    <div class="flex justify-between border-b border-gold-deep/10 pb-3">
                        <p class="text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold">{{ t('booking_confirm.detail_date', 'Date') }}</p>
                        <p class="text-off-white text-sm">{{ formattedDate }}</p>
                    </div>
                    <div class="flex justify-between border-b border-gold-deep/10 pb-3">
                        <p class="text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold">{{ t('booking_confirm.detail_time', 'Time') }}</p>
                        <p class="text-off-white text-sm">{{ booking.start_time?.substring(0, 5) }} {{ t('booking_confirm.your_local_time', '(your local time)') }}</p>
                    </div>
                    <div class="flex justify-between border-b border-gold-deep/10 pb-3">
                        <p class="text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold">{{ t('booking_confirm.detail_format', 'Format') }}</p>
                        <p class="text-off-white text-sm">{{ t('booking_confirm.detail_format_value', 'Google Meet (link sent via email)') }}</p>
                    </div>
                    <div class="flex justify-between border-b border-gold-deep/10 pb-3">
                        <p class="text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold">{{ t('booking_confirm.detail_duration', 'Duration') }}</p>
                        <p class="text-off-white text-sm">{{ booking.duration_minutes }} {{ t('booking_confirm.minutes', 'minutes') }}</p>
                    </div>
                </div>

                <p class="text-text-body text-sm mt-12 max-w-md mx-auto">
                    {{ t('booking_confirm.note', 'A calendar invite has been sent to your email. You can add it to your calendar with one tap.') }}
                </p>
                <p class="text-warm-grey text-xs tracking-[0.2em] uppercase mt-8">— Apex Human —</p>

            </div>
        </section>
    </AppLayout>
</template>

<script setup>
import { computed } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { useI18n } from '@/Composables/useI18n';

const props = defineProps({ booking: Object, application: Object });
const { t } = useI18n();

const formattedDate = computed(() => {
    if (!props.booking.date) return '';
    const d = new Date(props.booking.date + 'T12:00:00');
    return d.toLocaleDateString('en-US', { weekday: 'long', month: 'long', day: 'numeric', year: 'numeric' });
});

const dayName = computed(() => {
    if (!props.booking.date) return '';
    const d = new Date(props.booking.date + 'T12:00:00');
    return d.toLocaleDateString('en-US', { weekday: 'long' });
});
</script>
