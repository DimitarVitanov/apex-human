<template>
    <AdminLayout>
        <template #title>{{ post ? 'Edit Post' : 'New Post' }}</template>

        <form @submit.prevent="save" class="bg-black-warm border border-gold-deep/20 rounded p-6 space-y-5 max-w-4xl">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Title</label>
                    <input v-model="form.title" class="w-full bg-transparent border border-gold-deep/30 text-off-white text-sm px-3 py-2 rounded focus:outline-none focus:border-gold transition-colors">
                </div>
                <div>
                    <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Slug</label>
                    <input v-model="form.slug" class="w-full bg-transparent border border-gold-deep/30 text-off-white text-sm px-3 py-2 rounded focus:outline-none focus:border-gold transition-colors">
                </div>
                <div>
                    <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Category</label>
                    <input v-model="form.category" class="w-full bg-transparent border border-gold-deep/30 text-off-white text-sm px-3 py-2 rounded focus:outline-none focus:border-gold transition-colors">
                </div>
                <div>
                    <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Reading Time</label>
                    <input v-model="form.reading_time" class="w-full bg-transparent border border-gold-deep/30 text-off-white text-sm px-3 py-2 rounded focus:outline-none focus:border-gold transition-colors">
                </div>
            </div>

            <div>
                <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Excerpt</label>
                <textarea v-model="form.excerpt" rows="2" class="w-full bg-transparent border border-gold-deep/30 text-off-white text-sm px-3 py-2 rounded focus:outline-none focus:border-gold transition-colors resize-none"></textarea>
            </div>

            <div>
                <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Body (HTML)</label>
                <textarea v-model="form.body" rows="16" class="w-full bg-transparent border border-gold-deep/30 text-off-white text-sm font-mono px-3 py-2 rounded focus:outline-none focus:border-gold transition-colors resize-y"></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Featured Image</label>
                    <input v-model="form.featured_image" class="w-full bg-transparent border border-gold-deep/30 text-off-white text-sm px-3 py-2 rounded focus:outline-none focus:border-gold transition-colors">
                </div>
                <div>
                    <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Image Alt</label>
                    <input v-model="form.featured_image_alt" class="w-full bg-transparent border border-gold-deep/30 text-off-white text-sm px-3 py-2 rounded focus:outline-none focus:border-gold transition-colors">
                </div>
                <div>
                    <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Meta Title</label>
                    <input v-model="form.meta_title" class="w-full bg-transparent border border-gold-deep/30 text-off-white text-sm px-3 py-2 rounded focus:outline-none focus:border-gold transition-colors">
                </div>
                <div>
                    <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Meta Description</label>
                    <input v-model="form.meta_description" class="w-full bg-transparent border border-gold-deep/30 text-off-white text-sm px-3 py-2 rounded focus:outline-none focus:border-gold transition-colors">
                </div>
            </div>

            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2">
                    <input v-model="form.is_published" type="checkbox" class="accent-gold">
                    <label class="text-warm-grey text-xs">Published</label>
                </div>
                <div>
                    <label class="text-warm-grey text-[9px] uppercase tracking-[0.2em] font-semibold mr-2">Published At</label>
                    <input v-model="form.published_at" type="datetime-local" class="bg-transparent border border-gold-deep/30 text-off-white text-sm px-3 py-1 rounded focus:outline-none focus:border-gold transition-colors">
                </div>
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" :disabled="form.processing" class="px-5 py-2 bg-gold text-black text-xs tracking-[0.2em] uppercase font-semibold hover:bg-gold-light transition-colors disabled:opacity-50">
                    {{ post ? 'Update' : 'Create' }}
                </button>
                <button v-if="post" type="button" @click="destroy" class="px-5 py-2 border border-red-500/30 text-red-400 text-xs tracking-[0.2em] uppercase font-semibold hover:bg-red-500/10 transition-colors">Delete</button>
            </div>
        </form>
    </AdminLayout>
</template>

<script setup>
import { useForm, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({ post: Object });

const form = useForm({
    title: props.post?.title || '',
    slug: props.post?.slug || '',
    category: props.post?.category || '',
    excerpt: props.post?.excerpt || '',
    body: props.post?.body || '',
    featured_image: props.post?.featured_image || '',
    featured_image_alt: props.post?.featured_image_alt || '',
    meta_title: props.post?.meta_title || '',
    meta_description: props.post?.meta_description || '',
    reading_time: props.post?.reading_time || '',
    is_published: props.post?.is_published || false,
    published_at: props.post?.published_at ? props.post.published_at.slice(0, 16) : '',
});

function save() {
    if (props.post) {
        form.put(`/admin/posts/${props.post.id}`);
    } else {
        form.post('/admin/posts');
    }
}

function destroy() {
    if (confirm('Delete this post?')) {
        router.delete(`/admin/posts/${props.post.id}`);
    }
}
</script>
