<template>
    <div class="absolute inset-0 overflow-hidden pointer-events-none z-10">
        <canvas ref="canvas" class="absolute inset-0 w-full h-full" />
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';

const canvas = ref(null);
let ctx = null;
let raf = null;
let bolts = [];
let lastTime = 0;
let nextBolt = 0;

class LightningBolt {
    constructor(w, h) {
        this.x = Math.random() * w;
        this.y = 0;
        this.w = w;
        this.h = h;
        this.segments = this.generateSegments();
        this.life = 0;
        this.drawPhase = 0; // 0 to 1 — how much of the bolt is revealed
        this.drawSpeed = 2.5 + Math.random() * 1.5; // segments revealed per second (as fraction)
        this.maxLife = 1.2 + Math.random() * 0.6;
        this.fadeStart = 0.6 + Math.random() * 0.3; // when fade begins
        this.opacity = 1;
        this.branches = [];
        this.color = ['#C9973A', '#F5D17A', '#FFE9A0'][Math.floor(Math.random() * 3)];
        this.glowColor = '#C9973A';
        this.thickness = 1.5 + Math.random() * 1.5;

        // Generate branches
        for (let i = 0; i < this.segments.length; i++) {
            if (Math.random() < 0.3 && i > 2) {
                this.branches.push({
                    startIdx: i,
                    segments: this.generateBranch(this.segments[i], 3 + Math.floor(Math.random() * 4)),
                });
            }
        }
    }

    generateSegments() {
        const segs = [];
        let x = this.x;
        let y = 0;
        const numSegs = 12 + Math.floor(Math.random() * 8);
        const stepY = this.h / numSegs;

        for (let i = 0; i <= numSegs; i++) {
            segs.push({ x, y });
            x += (Math.random() - 0.5) * 60;
            y += stepY * (0.7 + Math.random() * 0.6);
        }
        return segs;
    }

    generateBranch(start, count) {
        const segs = [{ x: start.x, y: start.y }];
        let x = start.x;
        let y = start.y;
        const dir = Math.random() > 0.5 ? 1 : -1;

        for (let i = 0; i < count; i++) {
            x += dir * (15 + Math.random() * 25);
            y += 10 + Math.random() * 20;
            segs.push({ x, y });
        }
        return segs;
    }

    update(dt) {
        this.life += dt;

        // Smoothly reveal the bolt from top to bottom
        if (this.drawPhase < 1) {
            this.drawPhase = Math.min(1, this.drawPhase + dt * this.drawSpeed);
        }

        // Fade in fast, hold, then fade out smoothly
        if (this.life < 0.15) {
            this.opacity = this.life / 0.15;
        } else if (this.life > this.fadeStart) {
            this.opacity = Math.max(0, 1 - (this.life - this.fadeStart) / (this.maxLife - this.fadeStart));
        } else {
            this.opacity = 0.8 + Math.random() * 0.2;
        }

        return this.life < this.maxLife;
    }

    draw(ctx) {
        const visibleCount = Math.floor(this.drawPhase * this.segments.length);
        if (visibleCount < 2) return;

        ctx.save();
        ctx.globalAlpha = this.opacity;
        ctx.lineCap = 'round';
        ctx.lineJoin = 'round';

        // Outer glow
        ctx.shadowColor = this.glowColor;
        ctx.shadowBlur = 25;
        ctx.strokeStyle = this.color;
        ctx.lineWidth = this.thickness;

        ctx.beginPath();
        ctx.moveTo(this.segments[0].x, this.segments[0].y);
        for (let i = 1; i < visibleCount; i++) {
            ctx.lineTo(this.segments[i].x, this.segments[i].y);
        }
        ctx.stroke();

        // Inner bright core
        ctx.shadowBlur = 8;
        ctx.shadowColor = '#FFE9A0';
        ctx.strokeStyle = '#FFE9A0';
        ctx.lineWidth = this.thickness * 0.35;
        ctx.beginPath();
        ctx.moveTo(this.segments[0].x, this.segments[0].y);
        for (let i = 1; i < visibleCount; i++) {
            ctx.lineTo(this.segments[i].x, this.segments[i].y);
        }
        ctx.stroke();

        // Branches — only draw if the bolt has reached their start point
        ctx.lineWidth = this.thickness * 0.5;
        ctx.strokeStyle = this.color;
        ctx.shadowBlur = 12;
        ctx.shadowColor = this.glowColor;
        for (const branch of this.branches) {
            if (branch.startIdx >= visibleCount) continue;
            const branchProgress = Math.min(1, (this.drawPhase - branch.startIdx / this.segments.length) * 3);
            const branchVisible = Math.floor(branchProgress * branch.segments.length);
            if (branchVisible < 2) continue;

            ctx.beginPath();
            ctx.moveTo(branch.segments[0].x, branch.segments[0].y);
            for (let i = 1; i < branchVisible; i++) {
                ctx.lineTo(branch.segments[i].x, branch.segments[i].y);
            }
            ctx.stroke();
        }

        ctx.restore();
    }
}

function resize() {
    if (!canvas.value) return;
    const rect = canvas.value.parentElement.getBoundingClientRect();
    canvas.value.width = rect.width;
    canvas.value.height = rect.height;
}

function animate(time) {
    if (!ctx || !canvas.value) return;
    const dt = lastTime ? (time - lastTime) / 1000 : 0.016;
    lastTime = time;

    ctx.clearRect(0, 0, canvas.value.width, canvas.value.height);

    // Spawn new bolts
    nextBolt -= dt;
    if (nextBolt <= 0) {
        bolts.push(new LightningBolt(canvas.value.width, canvas.value.height));
        // Occasionally spawn double strike
        if (Math.random() < 0.4) {
            bolts.push(new LightningBolt(canvas.value.width, canvas.value.height));
        }
        nextBolt = 0.4 + Math.random() * 1.2;
    }

    // Update and draw
    bolts = bolts.filter(bolt => {
        const alive = bolt.update(dt);
        if (alive) bolt.draw(ctx);
        return alive;
    });

    raf = requestAnimationFrame(animate);
}

onMounted(() => {
    if (!canvas.value) return;
    ctx = canvas.value.getContext('2d');
    resize();
    window.addEventListener('resize', resize);
    nextBolt = 0.5;
    raf = requestAnimationFrame(animate);
});

onUnmounted(() => {
    if (raf) cancelAnimationFrame(raf);
    window.removeEventListener('resize', resize);
});
</script>
