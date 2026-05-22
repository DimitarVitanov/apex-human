<template>
    <AdminLayout>
        <template #title>{{ post ? 'Edit Daily Apex' : 'New Daily Apex' }}</template>
        <form @submit.prevent="save" class="bg-black-warm border border-gold-deep/20 rounded p-6 space-y-5 max-w-2xl">
            <div>
                <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Headline</label>
                <input v-model="form.headline" class="w-full bg-transparent border border-gold-deep/30 text-off-white text-sm px-3 py-2 rounded focus:outline-none focus:border-gold transition-colors">
            </div>
            <div>
                <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Body</label>
                <textarea v-model="form.body" rows="6" class="w-full bg-transparent border border-gold-deep/30 text-off-white text-sm px-3 py-2 rounded focus:outline-none focus:border-gold transition-colors resize-y"></textarea>
            </div>
            <div>
                <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Category</label>
                <input v-model="form.category" class="w-full bg-transparent border border-gold-deep/30 text-off-white text-sm px-3 py-2 rounded focus:outline-none focus:border-gold transition-colors">
            </div>
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2">
                    <input v-model="form.is_published" type="checkbox" class="accent-gold">
                    <label class="text-warm-grey text-xs">Published</label>
                </div>
                <input v-model="form.published_at" type="datetime-local" class="bg-transparent border border-gold-deep/30 text-off-white text-sm px-3 py-1 rounded focus:outline-none focus:border-gold transition-colors">
            </div>
            <div class="flex gap-3">
                <button type="submit" :disabled="form.processing" class="px-5 py-2 bg-gold text-black text-xs tracking-[0.2em] uppercase font-semibold hover:bg-gold-light transition-colors disabled:opacity-50">{{ post ? 'Update' : 'Create' }}</button>
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
    headline: props.post?.headline || '',
    body: props.post?.body || '',
    category: props.post?.category || '',
    is_published: props.post?.is_published || false,
    published_at: props.post?.published_at ? props.post.published_at.slice(0, 16) : '',
});
function save() {
    if (props.post) form.put(`/admin/daily-apex/${props.post.id}`);
    else form.post('/admin/daily-apex');
}
function destroy() {
    if (confirm('Delete?')) router.delete(`/admin/daily-apex/${props.post.id}`);
}
</script>
