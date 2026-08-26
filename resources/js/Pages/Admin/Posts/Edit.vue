<template>
    <AdminLayout>
        <template #title>{{ post ? 'Edit Post' : 'New Post' }}</template>

        <form @submit.prevent="save" class="bg-black-warm border border-gold-deep/20 rounded p-6 space-y-5 max-w-4xl">
            <!-- Validation summary -->
            <div v-if="Object.keys(form.errors).length" class="px-4 py-3 bg-red-900/20 border border-red-500/30 text-red-400 text-sm rounded">
                Please fix the highlighted fields below before saving.
            </div>

            <!-- Language tabs -->
            <div class="flex items-center gap-1 border-b border-gold-deep/20">
                <button
                    v-for="l in langTabs"
                    :key="l.code"
                    type="button"
                    @click="activeLang = l.code"
                    class="px-4 py-2 text-xs uppercase tracking-[0.2em] font-semibold border-b-2 -mb-px transition-colors"
                    :class="activeLang === l.code ? 'border-gold text-gold' : 'border-transparent text-warm-grey hover:text-off-white'"
                >
                    {{ l.label }}
                </button>
            </div>

            <!-- ============ ENGLISH (base) ============ -->
            <div v-show="activeLang === 'en'" class="space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Title <span class="text-gold">*</span></label>
                        <input v-model="form.title" @input="onTitleInput" :class="inputClass('title')">
                        <p v-if="form.errors.title" class="text-red-400 text-xs mt-1">{{ form.errors.title }}</p>
                    </div>
                    <div>
                        <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Slug <span class="text-gold">*</span></label>
                        <input v-model="form.slug" @input="slugTouched = true" :class="inputClass('slug')">
                        <p v-if="form.errors.slug" class="text-red-400 text-xs mt-1">{{ form.errors.slug }}</p>
                        <p v-else class="text-warm-grey/60 text-[10px] mt-1">URL: /journal/{{ form.slug || '…' }} (shared across languages)</p>
                    </div>
                    <div>
                        <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Category <span class="text-gold">*</span></label>
                        <input v-model="form.category" :class="inputClass('category')">
                        <p v-if="form.errors.category" class="text-red-400 text-xs mt-1">{{ form.errors.category }}</p>
                    </div>
                    <div>
                        <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Reading Time</label>
                        <input v-model="form.reading_time" placeholder="e.g. 5 min read" :class="inputClass('reading_time')">
                        <p v-if="form.errors.reading_time" class="text-red-400 text-xs mt-1">{{ form.errors.reading_time }}</p>
                    </div>
                </div>

                <div>
                    <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Excerpt</label>
                    <textarea v-model="form.excerpt" rows="2" :class="inputClass('excerpt')" class="resize-none"></textarea>
                    <p v-if="form.errors.excerpt" class="text-red-400 text-xs mt-1">{{ form.errors.excerpt }}</p>
                </div>

                <div>
                    <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Body <span class="text-gold">*</span></label>
                    <RichTextEditor v-model="form.body" />
                    <p v-if="form.errors.body" class="text-red-400 text-xs mt-1">{{ form.errors.body }}</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Meta Title</label>
                        <input v-model="form.meta_title" :class="inputClass('meta_title')">
                        <p v-if="form.errors.meta_title" class="text-red-400 text-xs mt-1">{{ form.errors.meta_title }}</p>
                    </div>
                    <div>
                        <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Meta Description</label>
                        <input v-model="form.meta_description" :class="inputClass('meta_description')">
                        <p v-if="form.errors.meta_description" class="text-red-400 text-xs mt-1">{{ form.errors.meta_description }}</p>
                    </div>
                </div>
            </div>

            <!-- ============ МАКЕДОНСКИ (overrides) ============ -->
            <div v-show="activeLang === 'mk'" class="space-y-5">
                <p class="text-warm-grey/70 text-[11px] leading-relaxed bg-black/30 border border-gold-deep/20 rounded px-3 py-2">
                    Macedonian translation. Any field left blank falls back to the English version.
                    Shown automatically to visitors in Macedonia.
                </p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Наслов (Title)</label>
                        <input v-model="form.translations.mk.title" :class="inputClass('translations.mk.title')" :placeholder="form.title">
                    </div>
                    <div>
                        <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Категорија (Category)</label>
                        <input v-model="form.translations.mk.category" :class="inputClass('translations.mk.category')" :placeholder="form.category">
                    </div>
                    <div>
                        <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Време на читање (Reading Time)</label>
                        <input v-model="form.translations.mk.reading_time" :class="inputClass('translations.mk.reading_time')" :placeholder="form.reading_time">
                    </div>
                </div>

                <div>
                    <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Извадок (Excerpt)</label>
                    <textarea v-model="form.translations.mk.excerpt" rows="2" :class="inputClass('translations.mk.excerpt')" class="resize-none" :placeholder="form.excerpt"></textarea>
                </div>

                <div>
                    <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Содржина (Body)</label>
                    <RichTextEditor v-model="form.translations.mk.body" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Мета наслов (Meta Title)</label>
                        <input v-model="form.translations.mk.meta_title" :class="inputClass('translations.mk.meta_title')" :placeholder="form.meta_title">
                    </div>
                    <div>
                        <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Мета опис (Meta Description)</label>
                        <input v-model="form.translations.mk.meta_description" :class="inputClass('translations.mk.meta_description')" :placeholder="form.meta_description">
                    </div>
                </div>

                <div>
                    <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Опис на слика (Image Alt)</label>
                    <input v-model="form.translations.mk.featured_image_alt" :class="inputClass('translations.mk.featured_image_alt')" :placeholder="form.featured_image_alt">
                </div>
            </div>

            <!-- ============ Shared (language-independent) ============ -->
            <div class="pt-2 border-t border-gold-deep/20 space-y-5">
                <!-- Featured image -->
                <div>
                    <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Featured Image <span class="text-warm-grey/50 normal-case tracking-normal">(shared)</span></label>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <div class="w-full sm:w-48 shrink-0">
                            <div class="aspect-[16/9] border border-gold-deep/30 rounded overflow-hidden bg-black/40 flex items-center justify-center">
                                <img v-if="form.featured_image" :src="form.featured_image" alt="" class="w-full h-full object-cover">
                                <span v-else class="text-warm-grey/50 text-[10px] uppercase tracking-[0.2em]">No image</span>
                            </div>
                            <label class="mt-2 block text-center cursor-pointer px-3 py-2 border border-gold-deep/30 text-gold text-[10px] uppercase tracking-[0.2em] font-semibold hover:bg-gold/10 transition-colors rounded" :class="{ 'opacity-50 pointer-events-none': uploading }">
                                {{ uploading ? 'Uploading…' : 'Upload image' }}
                                <input type="file" accept="image/*" class="hidden" @change="uploadImage">
                            </label>
                        </div>
                        <div class="flex-1 space-y-3">
                            <div>
                                <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Image URL</label>
                                <input v-model="form.featured_image" placeholder="Upload above, or paste a URL" :class="inputClass('featured_image')">
                                <p v-if="uploadError" class="text-red-400 text-xs mt-1">{{ uploadError }}</p>
                                <p v-else-if="form.errors.featured_image" class="text-red-400 text-xs mt-1">{{ form.errors.featured_image }}</p>
                            </div>
                            <div>
                                <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Image Alt (English)</label>
                                <input v-model="form.featured_image_alt" :class="inputClass('featured_image_alt')">
                                <p v-if="form.errors.featured_image_alt" class="text-red-400 text-xs mt-1">{{ form.errors.featured_image_alt }}</p>
                            </div>
                        </div>
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
                <p v-if="form.is_published && !form.published_at" class="text-warm-grey/70 text-[11px] -mt-2">
                    Leave “Published At” empty and it will be set to now when you save.
                </p>
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" :disabled="form.processing || uploading" class="px-5 py-2 bg-gold text-black text-xs tracking-[0.2em] uppercase font-semibold hover:bg-gold-light transition-colors disabled:opacity-50">
                    {{ post ? 'Update' : 'Create' }}
                </button>
                <button v-if="post" type="button" @click="destroy" class="px-5 py-2 border border-red-500/30 text-red-400 text-xs tracking-[0.2em] uppercase font-semibold hover:bg-red-500/10 transition-colors">Delete</button>
            </div>
        </form>
    </AdminLayout>
</template>

<script setup>
import { ref } from 'vue';
import { useForm, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import RichTextEditor from '@/Components/Admin/RichTextEditor.vue';

const props = defineProps({
    post: Object,
    translations: { type: Object, default: () => ({}) },
    locales: { type: Object, default: () => ({ en: 'English', mk: 'Македонски' }) },
});

const langTabs = [
    { code: 'en', label: 'English' },
    { code: 'mk', label: 'Македонски' },
];
const activeLang = ref('en');

const mk = props.translations?.mk || {};

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
    translations: {
        mk: {
            title: mk.title || '',
            category: mk.category || '',
            excerpt: mk.excerpt || '',
            body: mk.body || '',
            featured_image_alt: mk.featured_image_alt || '',
            meta_title: mk.meta_title || '',
            meta_description: mk.meta_description || '',
            reading_time: mk.reading_time || '',
        },
    },
});

// Don't auto-rewrite the slug of an existing post (would break its live URL).
const slugTouched = ref(!!props.post);
const uploading = ref(false);
const uploadError = ref('');

function slugify(value) {
    return value
        .toLowerCase()
        .trim()
        .replace(/[^\w\s-]/g, '')
        .replace(/[\s_]+/g, '-')
        .replace(/-+/g, '-')
        .replace(/^-+|-+$/g, '');
}

function onTitleInput() {
    if (!slugTouched.value) form.slug = slugify(form.title);
}

function inputClass(field) {
    return [
        'w-full bg-transparent border text-off-white text-sm px-3 py-2 rounded focus:outline-none transition-colors',
        form.errors[field] ? 'border-red-500/60 focus:border-red-500' : 'border-gold-deep/30 focus:border-gold',
    ];
}

function csrfToken() {
    const match = document.cookie.match(/(?:^|;\s*)XSRF-TOKEN=([^;]+)/);
    return match ? decodeURIComponent(match[1]) : '';
}

async function uploadImage(event) {
    const file = event.target.files?.[0];
    event.target.value = ''; // allow re-selecting the same file later
    if (!file) return;

    uploadError.value = '';
    uploading.value = true;
    const data = new FormData();
    data.append('file', file);
    data.append('collection', 'posts');

    try {
        const res = await fetch('/admin/media', {
            method: 'POST',
            headers: { 'X-XSRF-TOKEN': csrfToken(), Accept: 'application/json' },
            body: data,
        });
        if (!res.ok) {
            const body = await res.json().catch(() => ({}));
            throw new Error(body?.errors?.file?.[0] || body?.message || 'Upload failed.');
        }
        const json = await res.json();
        form.featured_image = json.url;
        if (!form.featured_image_alt) form.featured_image_alt = form.title;
    } catch (err) {
        uploadError.value = err.message || 'Upload failed. Please try again.';
    } finally {
        uploading.value = false;
    }
}

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
