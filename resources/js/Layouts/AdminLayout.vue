<template>
    <div class="min-h-screen bg-dark-grey" style="cursor: auto;">
        <nav class="fixed top-0 left-0 bottom-0 w-56 bg-black-warm border-r border-gold-deep/20 z-40 flex flex-col">
            <div class="px-5 py-5 border-b border-gold-deep/20">
                <Link href="/admin" class="font-display text-gold text-sm tracking-[0.18em]">
                    APEX HUMAN&#8482;
                </Link>
                <p class="text-warm-grey text-[9px] uppercase tracking-[0.3em] mt-1">Admin Panel</p>
            </div>

            <div class="flex-1 overflow-y-auto py-4">
                <div class="px-3 space-y-0.5">
                    <Link
                        v-for="item in sidebarItems"
                        :key="item.url"
                        :href="item.url"
                        class="flex items-center gap-3 px-3 py-2.5 rounded text-sm font-sans transition-colors duration-200"
                        :class="isActive(item.url) ? 'bg-gold/10 text-gold' : 'text-text-body hover:text-off-white hover:bg-white/5'"
                    >
                        <span class="text-[10px] uppercase tracking-[0.2em]">{{ item.label }}</span>
                        <span v-if="item.badge" class="ml-auto bg-gold text-black text-[9px] font-semibold px-1.5 py-0.5 rounded-full">
                            {{ item.badge }}
                        </span>
                    </Link>
                </div>
            </div>

            <div class="px-5 py-4 border-t border-gold-deep/20">
                <p class="text-warm-grey text-xs truncate">{{ $page.props.auth?.user?.email }}</p>
                <div class="flex gap-3 mt-2">
                    <Link href="/" class="text-warm-grey text-[10px] uppercase tracking-[0.2em] hover:text-gold-light transition-colors">View Site</Link>
                    <Link href="/logout" method="post" as="button" class="text-warm-grey text-[10px] uppercase tracking-[0.2em] hover:text-gold-light transition-colors">Logout</Link>
                </div>
            </div>
        </nav>

        <main class="ml-56 min-h-screen">
            <div class="px-8 py-6 border-b border-gold-deep/20 bg-black-warm/50 relative">
                <h1 class="font-display text-gold-light text-2xl tracking-[0.1em]">
                    <slot name="title">Dashboard</slot>
                </h1>
            </div>

            <div v-if="$page.props.flash?.success" class="mx-8 mt-6 px-4 py-3 bg-gold/10 border border-gold/30 text-gold-light text-sm rounded">
                {{ $page.props.flash.success }}
            </div>

            <div class="p-8">
                <slot />
            </div>
        </main>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

const $page = usePage();

const sidebarItems = computed(() => {
    const stats = $page.props.stats || {};
    return [
        { label: 'Dashboard', url: '/admin' },
        { label: 'Pages & Sections', url: '/admin/pages' },
        { label: 'Blog Posts', url: '/admin/posts' },
        { label: 'Daily Apex', url: '/admin/daily-apex' },
        { label: 'Applications', url: '/admin/applications', badge: stats.pending_applications || null },
        { label: 'Booking Slots', url: '/admin/slots' },
        { label: 'Contacts', url: '/admin/contacts', badge: stats.contacts || null },
        { label: 'Navigation', url: '/admin/navigation' },
        { label: 'Settings', url: '/admin/settings' },
    ];
});

function isActive(url) {
    const current = $page.url;
    if (url === '/admin') return current === '/admin';
    return current.startsWith(url);
}
</script>
