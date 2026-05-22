<template>
    <Head :title="title" />
    <div class="min-h-screen bg-black">
        <CustomCursor />
        <SiteHeader />
        <main>
            <slot />
        </main>
        <SiteFooter />
    </div>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import CustomCursor from '@/Components/CustomCursor.vue';
import SiteHeader from '@/Components/SiteHeader.vue';
import SiteFooter from '@/Components/SiteFooter.vue';

defineProps({
    title: { type: String, default: 'Apex Human' },
});
</script>
