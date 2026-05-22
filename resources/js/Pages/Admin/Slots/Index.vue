<template>
    <AdminLayout>
        <template #title>Manage Available Slots</template>

        <div class="max-w-5xl space-y-8 relative z-0">

            <!-- Generate Slots Form -->
            <div class="bg-black-warm border border-gold-deep/20 rounded p-6 overflow-hidden">
                <p class="text-warm-grey text-[9px] uppercase tracking-[0.4em] font-semibold mb-4">Generate Slots</p>
                <form @submit.prevent="generate" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Start Date</label>
                        <input v-model="genForm.start_date" type="date" class="w-full bg-dark-grey border border-gold-deep/30 text-off-white text-sm px-3 py-2 rounded focus:outline-none focus:border-gold">
                    </div>
                    <div>
                        <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">End Date</label>
                        <input v-model="genForm.end_date" type="date" class="w-full bg-dark-grey border border-gold-deep/30 text-off-white text-sm px-3 py-2 rounded focus:outline-none focus:border-gold">
                    </div>
                    <div>
                        <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Days</label>
                        <div class="flex flex-wrap gap-2 mt-1">
                            <label v-for="d in dayOptions" :key="d.value" class="flex items-center gap-1.5 cursor-pointer">
                                <input type="checkbox" :value="d.value" v-model="genForm.days" class="accent-gold">
                                <span class="text-off-white text-xs">{{ d.label }}</span>
                            </label>
                        </div>
                    </div>
                    <div>
                        <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Start Hour</label>
                        <select v-model="genForm.start_hour" class="w-full bg-dark-grey border border-gold-deep/30 text-off-white text-sm px-3 py-2 rounded focus:outline-none focus:border-gold">
                            <option v-for="h in 24" :key="h-1" :value="h-1">{{ String(h-1).padStart(2, '0') }}:00</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">End Hour</label>
                        <select v-model="genForm.end_hour" class="w-full bg-dark-grey border border-gold-deep/30 text-off-white text-sm px-3 py-2 rounded focus:outline-none focus:border-gold">
                            <option v-for="h in 24" :key="h" :value="h">{{ String(h).padStart(2, '0') }}:00</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Duration</label>
                        <select v-model="genForm.slot_duration" class="w-full bg-dark-grey border border-gold-deep/30 text-off-white text-sm px-3 py-2 rounded focus:outline-none focus:border-gold">
                            <option :value="30">30 min</option>
                            <option :value="60">60 min</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold mb-1">Buffer</label>
                        <select v-model="genForm.buffer_minutes" class="w-full bg-dark-grey border border-gold-deep/30 text-off-white text-sm px-3 py-2 rounded focus:outline-none focus:border-gold">
                            <option :value="0">None</option>
                            <option :value="15">15 min</option>
                            <option :value="30">30 min</option>
                            <option :value="60">60 min</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" :disabled="genForm.processing" class="px-5 py-2 bg-gold text-black text-xs tracking-[0.2em] uppercase font-semibold hover:bg-gold-light transition-colors rounded">
                            Generate
                        </button>
                    </div>
                </form>
            </div>

            <!-- Month Navigation -->
            <div class="flex items-center justify-between">
                <button @click="changeMonth(-1)" class="text-gold text-xs tracking-[0.2em] uppercase hover:text-gold-light transition-colors">← Previous</button>
                <p class="text-gold-light font-display text-lg tracking-wide">{{ monthLabel }}</p>
                <button @click="changeMonth(1)" class="text-gold text-xs tracking-[0.2em] uppercase hover:text-gold-light transition-colors">Next →</button>
            </div>

            <!-- Calendar Grid -->
            <div class="bg-black-warm border border-gold-deep/20 rounded p-6">
                <!-- Day headers -->
                <div class="grid grid-cols-7 gap-1 mb-2">
                    <div v-for="day in ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']" :key="day" class="text-center text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold py-2">
                        {{ day }}
                    </div>
                </div>
                <!-- Calendar days -->
                <div class="grid grid-cols-7 gap-1">
                    <div v-for="(cell, i) in calendarCells" :key="i"
                        class="min-h-[80px] border border-gold-deep/10 p-2 relative"
                        :class="cell.day ? 'bg-dark-grey/30' : 'bg-transparent'"
                    >
                        <template v-if="cell.day">
                            <p class="text-off-white text-xs font-semibold mb-1">{{ cell.day }}</p>
                            <div class="space-y-0.5">
                                <div v-for="slot in cell.slots" :key="slot.id" class="flex items-center justify-between gap-1">
                                    <span class="text-[10px]" :class="{
                                        'text-red-400 line-through': slot.is_blocked,
                                        'text-green-400': slot.is_booked,
                                        'text-warm-grey': !slot.is_blocked && !slot.is_booked,
                                    }">
                                        {{ slot.start_time.substring(0, 5) }}
                                        <span v-if="slot.is_booked" class="text-[8px]">●</span>
                                    </span>
                                    <div class="flex gap-0.5" v-if="!slot.is_booked">
                                        <button @click.stop="toggleSlot(slot)" class="text-xs px-1.5 py-0.5 rounded cursor-pointer hover:bg-white/10" :class="slot.is_blocked ? 'text-green-400 hover:text-green-300' : 'text-yellow-400 hover:text-yellow-300'">
                                            {{ slot.is_blocked ? '✓' : '✕' }}
                                        </button>
                                        <button @click.stop="deleteSlot(slot)" class="text-xs text-red-400 hover:text-red-300 px-1.5 py-0.5 rounded cursor-pointer hover:bg-white/10">✕✕</button>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Legend -->
            <div class="flex items-center gap-6 text-xs">
                <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-warm-grey"></span> Available</span>
                <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-green-400"></span> Booked</span>
                <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-red-400"></span> Blocked</span>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { computed } from 'vue';
import { useForm, usePage, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({ slots: Array, month: String });
const $page = usePage();

const dayOptions = [
    { value: 1, label: 'Mon' },
    { value: 2, label: 'Tue' },
    { value: 3, label: 'Wed' },
    { value: 4, label: 'Thu' },
    { value: 5, label: 'Fri' },
];

const genForm = useForm({
    start_date: '',
    end_date: '',
    days: [1, 2, 3, 4, 5],
    start_hour: 9,
    end_hour: 17,
    slot_duration: 30,
    buffer_minutes: 60,
});

function generate() {
    genForm.post('/admin/slots/generate');
}

const currentMonth = computed(() => {
    const [y, m] = props.month.split('-');
    return new Date(parseInt(y), parseInt(m) - 1, 1);
});

const monthLabel = computed(() => {
    return currentMonth.value.toLocaleDateString('en-US', { month: 'long', year: 'numeric' });
});

function changeMonth(delta) {
    const d = new Date(currentMonth.value);
    d.setMonth(d.getMonth() + delta);
    const m = `${d.getFullYear()}-${String(d.getMonth() + 1).padStart(2, '0')}`;
    router.get('/admin/slots', { month: m }, { preserveState: true });
}

const calendarCells = computed(() => {
    const d = currentMonth.value;
    const year = d.getFullYear();
    const month = d.getMonth();
    const firstDay = new Date(year, month, 1);
    const lastDay = new Date(year, month + 1, 0);

    let startOffset = firstDay.getDay() - 1;
    if (startOffset < 0) startOffset = 6;

    const cells = [];
    for (let i = 0; i < startOffset; i++) cells.push({ day: null, slots: [] });

    for (let day = 1; day <= lastDay.getDate(); day++) {
        const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
        const daySlots = props.slots.filter(s => s.date === dateStr || s.date?.startsWith(dateStr));
        cells.push({ day, slots: daySlots });
    }

    while (cells.length % 7 !== 0) cells.push({ day: null, slots: [] });

    return cells;
});

function toggleSlot(slot) {
    router.put(`/admin/slots/${slot.id}/toggle`, {}, { preserveState: true });
}

function deleteSlot(slot) {
    if (confirm('Delete this slot?')) {
        router.delete(`/admin/slots/${slot.id}`, { preserveState: true });
    }
}
</script>
