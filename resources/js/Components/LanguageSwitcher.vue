<template>
    <div v-if="options.length > 1" class="flex items-center gap-1.5" :class="compact ? 'text-[10px]' : 'text-xs'">
        <template v-for="(opt, i) in options" :key="opt.code">
            <button
                type="button"
                class="uppercase tracking-[0.2em] font-sans font-semibold transition-colors duration-200 cursor-none"
                :class="opt.code === locale ? 'text-gold' : 'text-warm-grey hover:text-gold-light'"
                :aria-current="opt.code === locale ? 'true' : 'false'"
                @click="setLocale(opt.code)"
            >
                {{ opt.short }}
            </button>
            <span v-if="i < options.length - 1" class="text-gold-deep/40">/</span>
        </template>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import { useI18n } from '@/Composables/useI18n';

defineProps({
    compact: { type: Boolean, default: false },
});

const { locale, locales, setLocale } = useI18n();

// Short codes for the toggle: EN / MK.
const shortLabels = { en: 'EN', mk: 'MK' };

const options = computed(() =>
    Object.keys(locales.value).map((code) => ({
        code,
        short: shortLabels[code] || code.toUpperCase(),
        label: locales.value[code],
    }))
);
</script>
