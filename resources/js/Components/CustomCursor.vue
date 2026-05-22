<template>
    <div
        ref="cursor"
        class="fixed top-0 left-0 pointer-events-none z-[9999] rounded-full transition-[width,height,background-color,border] duration-200 hidden lg:block"
        :class="expanded ? 'w-10 h-10 bg-gold/20 border border-gold/50' : 'w-1.5 h-1.5 bg-gold border-0'"
        :style="{ transform: `translate(${pos.x}px, ${pos.y}px) translate(-50%, -50%)` }"
    />
</template>

<script setup>
import { ref, reactive, onMounted, onUnmounted } from 'vue';

const cursor = ref(null);
const expanded = ref(false);
const pos = reactive({ x: -100, y: -100 });
const target = reactive({ x: -100, y: -100 });
let raf = null;

function onMouseMove(e) {
    target.x = e.clientX;
    target.y = e.clientY;
}

function onMouseOver(e) {
    const el = e.target.closest('a, button, input, textarea, select, [role="button"]');
    expanded.value = !!el;
}

function lerp() {
    pos.x += (target.x - pos.x) * 0.18;
    pos.y += (target.y - pos.y) * 0.18;
    raf = requestAnimationFrame(lerp);
}

onMounted(() => {
    const isTouch = window.matchMedia('(hover: none)').matches;
    if (isTouch) return;

    document.addEventListener('mousemove', onMouseMove);
    document.addEventListener('mouseover', onMouseOver);
    raf = requestAnimationFrame(lerp);
});

onUnmounted(() => {
    document.removeEventListener('mousemove', onMouseMove);
    document.removeEventListener('mouseover', onMouseOver);
    if (raf) cancelAnimationFrame(raf);
});
</script>
