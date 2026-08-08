<template>
    <div class="border border-gold-deep/30 rounded overflow-hidden focus-within:border-gold transition-colors">
        <!-- Toolbar -->
        <div class="flex flex-wrap items-center gap-0.5 bg-black/40 border-b border-gold-deep/30 px-2 py-1.5">
            <button
                v-for="btn in toolbar"
                :key="btn.title"
                type="button"
                :title="btn.title"
                @mousedown.prevent="btn.action"
                class="min-w-[2rem] px-2 py-1 text-xs text-warm-grey hover:text-gold hover:bg-gold/10 rounded transition-colors font-semibold"
            >
                <span v-html="btn.label"></span>
            </button>
            <div class="flex-1"></div>
            <button
                type="button"
                title="Edit raw HTML"
                @mousedown.prevent="toggleSource"
                class="px-2 py-1 text-[10px] uppercase tracking-[0.15em] rounded transition-colors font-semibold"
                :class="showSource ? 'text-gold bg-gold/10' : 'text-warm-grey hover:text-gold'"
            >
                HTML
            </button>
        </div>

        <!-- WYSIWYG -->
        <div
            v-show="!showSource"
            ref="editor"
            contenteditable="true"
            data-placeholder="Write your post…"
            @input="onInput"
            @blur="onInput"
            class="prose-apex editor-surface min-h-[24rem] max-h-[40rem] overflow-y-auto px-4 py-3 text-sm focus:outline-none"
        ></div>

        <!-- Raw HTML source -->
        <textarea
            v-show="showSource"
            :value="modelValue"
            @input="onSource"
            rows="18"
            class="w-full bg-transparent text-off-white text-sm font-mono px-4 py-3 focus:outline-none resize-y"
        ></textarea>
    </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';

const props = defineProps({ modelValue: { type: String, default: '' } });
const emit = defineEmits(['update:modelValue']);

const editor = ref(null);
const showSource = ref(false);

function exec(command, value = null) {
    document.execCommand(command, false, value);
    editor.value?.focus();
    onInput();
}

function format(tag) {
    document.execCommand('formatBlock', false, tag);
    editor.value?.focus();
    onInput();
}

function createLink() {
    const url = window.prompt('Link URL', 'https://');
    if (url) exec('createLink', url);
}

const toolbar = [
    { label: 'P', title: 'Paragraph', action: () => format('p') },
    { label: 'H2', title: 'Heading', action: () => format('h2') },
    { label: 'H3', title: 'Subheading', action: () => format('h3') },
    { label: '<strong>B</strong>', title: 'Bold', action: () => exec('bold') },
    { label: '<em>I</em>', title: 'Italic', action: () => exec('italic') },
    { label: '&ldquo; &rdquo;', title: 'Quote', action: () => format('blockquote') },
    { label: '&bull;&nbsp;List', title: 'Bulleted list', action: () => exec('insertUnorderedList') },
    { label: '1.&nbsp;List', title: 'Numbered list', action: () => exec('insertOrderedList') },
    { label: 'Link', title: 'Insert link', action: createLink },
    { label: 'Clear', title: 'Clear formatting', action: () => { exec('removeFormat'); format('p'); } },
];

function onInput() {
    if (!editor.value) return;
    let html = editor.value.innerHTML;
    // An empty contenteditable leaves a stray <br>; treat it as truly empty.
    if (html === '<br>' || html === '<div><br></div>') html = '';
    emit('update:modelValue', html);
}

function onSource(e) {
    emit('update:modelValue', e.target.value);
}

function toggleSource() {
    // Leaving source view: push the (possibly hand-edited) HTML back into the WYSIWYG.
    if (showSource.value && editor.value) {
        editor.value.innerHTML = props.modelValue || '';
    }
    showSource.value = !showSource.value;
}

onMounted(() => {
    if (editor.value) editor.value.innerHTML = props.modelValue || '';
});

// Sync external changes (e.g. form reset) into the WYSIWYG, but never while the
// user is typing in it — reassigning innerHTML would reset the caret.
watch(() => props.modelValue, (val) => {
    if (showSource.value || !editor.value) return;
    if (document.activeElement !== editor.value && editor.value.innerHTML !== (val || '')) {
        editor.value.innerHTML = val || '';
    }
});
</script>

<style scoped>
.editor-surface:empty::before {
    content: attr(data-placeholder);
    color: var(--color-warm-grey);
    pointer-events: none;
}
</style>
