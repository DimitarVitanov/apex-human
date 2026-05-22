<template>
    <AppLayout title="Book Your Discovery Call">
        <section class="min-h-screen flex items-center justify-center px-6 py-32">
            <div class="max-w-5xl mx-auto w-full">

                <!-- Header -->
                <div class="text-center mb-16">
                    <p class="text-gold text-[9px] uppercase tracking-[0.5em] font-sans font-semibold mb-4">You Have Been Selected</p>
                    <h1 class="font-display text-gold-light text-3xl md:text-5xl tracking-[0.06em] leading-tight mb-4">The Discovery Call.</h1>
                    <p class="text-text-body text-sm leading-relaxed max-w-lg mx-auto">
                        Thirty minutes. Zoom or Google Meet — your choice. We'll talk through your context, your goals, and whether the system is the right fit.
                    </p>
                </div>

                <!-- Calendar -->
                <div class="mb-8">
                    <p class="text-gold text-[9px] uppercase tracking-[0.5em] font-sans font-semibold mb-6">Select a Date</p>

                    <!-- Month Navigation -->
                    <div class="flex items-center gap-6 mb-6">
                        <h2 class="font-display text-gold-light text-lg tracking-wide uppercase">{{ monthLabel }}</h2>
                        <div class="flex gap-2">
                            <button @click="changeMonth(-1)" class="text-gold hover:text-gold-light transition-colors text-sm">←</button>
                            <button @click="changeMonth(1)" class="text-gold hover:text-gold-light transition-colors text-sm">→</button>
                        </div>
                    </div>

                    <!-- Day Headers -->
                    <div class="grid grid-cols-7 border border-gold-deep/20">
                        <div v-for="day in ['MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT', 'SUN']" :key="day" class="text-center text-gold text-[9px] uppercase tracking-[0.3em] font-semibold py-3 border-b border-gold-deep/20">
                            {{ day }}
                        </div>
                    </div>

                    <!-- Calendar Grid -->
                    <div class="grid grid-cols-7 border-l border-gold-deep/20">
                        <div
                            v-for="(cell, i) in calendarCells"
                            :key="i"
                            class="min-h-[70px] border-r border-b border-gold-deep/20 flex items-center justify-center cursor-pointer transition-colors"
                            :class="cellClass(cell)"
                            @click="selectDate(cell)"
                        >
                            <span v-if="cell.day" class="font-display text-sm" :class="cell.day && cell.hasSlots ? 'text-off-white' : 'text-warm-grey/30'">
                                {{ String(cell.day).padStart(2, '0') }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Time Slots -->
                <Transition name="fade">
                    <div v-if="selectedDate" class="mb-12">
                        <p class="text-gold text-[9px] uppercase tracking-[0.5em] font-sans font-semibold mb-6">
                            Selected: {{ formatSelectedDate }} · Available Times
                        </p>
                        <div v-if="selectedDateSlots.length" class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-0">
                            <button
                                v-for="slot in selectedDateSlots"
                                :key="slot.id"
                                @click="selectedSlot = slot"
                                class="py-3 text-center text-sm font-semibold border border-gold-deep/20 transition-all duration-200"
                                :class="selectedSlot?.id === slot.id
                                    ? 'bg-gold text-black border-gold'
                                    : 'text-off-white hover:border-gold/50 hover:bg-gold/5'"
                            >
                                {{ slot.start_time.substring(0, 5) }}
                            </button>
                        </div>
                        <p v-else class="text-warm-grey text-sm">No available times on this date.</p>
                    </div>
                </Transition>

                <!-- Confirm Button -->
                <Transition name="fade">
                    <div v-if="selectedSlot" class="text-center">
                        <button
                            @click="confirmBooking"
                            :disabled="bookingForm.processing"
                            class="inline-block px-12 py-4 bg-gold text-black text-xs tracking-[0.3em] uppercase font-sans font-semibold hover:bg-gold-light active:bg-gold-deep transition-colors duration-400 disabled:opacity-40"
                        >
                            {{ bookingForm.processing ? 'Confirming...' : 'Confirm Booking' }}
                        </button>
                        <p class="text-warm-grey text-xs mt-4">You'll receive a calendar invite within 60 seconds.</p>
                    </div>
                </Transition>

                <!-- Error -->
                <div v-if="$page.props.flash?.error" class="mt-6 bg-red-500/10 border border-red-500/30 text-red-400 text-sm p-4 rounded text-center">
                    {{ $page.props.flash.error }}
                </div>

            </div>
        </section>
    </AppLayout>
</template>

<script setup>
import { ref, computed, onMounted, watch } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({ token: String, applicantName: String });
const $page = usePage();

const slots = ref([]);
const loading = ref(false);
const currentMonth = ref(new Date());
const selectedDate = ref(null);
const selectedSlot = ref(null);

const bookingForm = useForm({
    token: props.token,
    slot_id: null,
});

const monthLabel = computed(() => {
    return currentMonth.value.toLocaleDateString('en-US', { month: 'long', year: 'numeric' }).toUpperCase();
});

function changeMonth(delta) {
    const d = new Date(currentMonth.value);
    d.setMonth(d.getMonth() + delta);
    currentMonth.value = d;
    selectedDate.value = null;
    selectedSlot.value = null;
    fetchSlots();
}

async function fetchSlots() {
    loading.value = true;
    const m = `${currentMonth.value.getFullYear()}-${String(currentMonth.value.getMonth() + 1).padStart(2, '0')}`;
    try {
        const res = await fetch(`/api/available-slots?token=${props.token}&month=${m}`);
        slots.value = await res.json();
    } catch (e) {
        slots.value = [];
    }
    loading.value = false;
}

onMounted(fetchSlots);

const slotsByDate = computed(() => {
    const map = {};
    slots.value.forEach(s => {
        const dateKey = typeof s.date === 'string' ? s.date.substring(0, 10) : '';
        if (!map[dateKey]) map[dateKey] = [];
        map[dateKey].push(s);
    });
    return map;
});

const calendarCells = computed(() => {
    const d = currentMonth.value;
    const year = d.getFullYear();
    const month = d.getMonth();
    const firstDay = new Date(year, month, 1);
    const lastDay = new Date(year, month + 1, 0);

    let startOffset = firstDay.getDay() - 1;
    if (startOffset < 0) startOffset = 6;

    const cells = [];
    for (let i = 0; i < startOffset; i++) cells.push({ day: null, dateStr: null, hasSlots: false });

    for (let day = 1; day <= lastDay.getDate(); day++) {
        const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
        cells.push({ day, dateStr, hasSlots: !!slotsByDate.value[dateStr]?.length });
    }

    while (cells.length % 7 !== 0) cells.push({ day: null, dateStr: null, hasSlots: false });

    return cells;
});

function cellClass(cell) {
    if (!cell.day) return '';
    if (cell.dateStr === selectedDate.value) return 'bg-gold/20 border-gold/40';
    if (cell.hasSlots) return 'hover:bg-gold/5 cursor-pointer';
    return 'cursor-default';
}

function selectDate(cell) {
    if (!cell.day || !cell.hasSlots) return;
    selectedDate.value = cell.dateStr;
    selectedSlot.value = null;
}

const selectedDateSlots = computed(() => {
    if (!selectedDate.value) return [];
    return (slotsByDate.value[selectedDate.value] || []).sort((a, b) => a.start_time.localeCompare(b.start_time));
});

const formatSelectedDate = computed(() => {
    if (!selectedDate.value) return '';
    const d = new Date(selectedDate.value + 'T12:00:00');
    return d.toLocaleDateString('en-US', { weekday: 'long', month: 'long', day: 'numeric' }).toUpperCase();
});

function confirmBooking() {
    bookingForm.slot_id = selectedSlot.value.id;
    bookingForm.post('/apply/book');
}
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
