<template>
    <AdminLayout>
        <template #title>Blog Posts</template>

        <div class="flex justify-end mb-5">
            <Link href="/admin/posts/create" class="px-5 py-2 bg-gold text-black text-xs tracking-[0.2em] uppercase font-semibold hover:bg-gold-light transition-colors">New Post</Link>
        </div>

        <div class="space-y-3">
            <div v-for="post in posts" :key="post.id" class="bg-black-warm border border-gold-deep/20 rounded p-5 flex items-center justify-between">
                <div>
                    <p class="text-off-white text-sm font-semibold">{{ post.title }}</p>
                    <p class="text-warm-grey text-xs mt-1">{{ post.category }} &middot; {{ post.reading_time }}</p>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-[9px] uppercase tracking-[0.2em] font-semibold px-2 py-1 rounded"
                        :class="post.is_published ? 'bg-green-500/10 text-green-400' : 'bg-warm-grey/10 text-warm-grey'"
                    >
                        {{ post.is_published ? 'Published' : 'Draft' }}
                    </span>
                    <Link :href="`/admin/posts/${post.id}/edit`" class="text-gold text-xs hover:text-gold-light transition-colors">Edit</Link>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Link } from '@inertiajs/vue3';

defineProps({ posts: Array });
</script>
