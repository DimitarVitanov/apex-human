<template>
    <AppLayout :title="page.meta_title">
        <section class="min-h-screen flex items-center justify-center px-6">
            <div class="max-w-5xl mx-auto w-full">

                <!-- Progress bar -->
                <div v-if="step > 0 && step <= 8" class="mb-12">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-warm-grey text-[9px] uppercase tracking-[0.4em] font-sans font-semibold">
                            {{ stepLabel }}
                        </p>
                        <p class="text-warm-grey text-[9px] uppercase tracking-[0.3em]">{{ Math.round((step / 9) * 100) }}%</p>
                    </div>
                    <div class="w-full h-px bg-gold-deep/20">
                        <div class="h-full bg-gold transition-all duration-700 ease-out" :style="{ width: `${(step / 9) * 100}%` }"></div>
                    </div>
                </div>

                    <!-- Step 0: Landing -->
                    <Transition name="step" mode="out-in">
                        <div v-if="step === 0" key="landing" class="text-center">
                            <p class="text-gold text-[9px] uppercase tracking-[0.5em] font-sans font-semibold mb-6">Application</p>
                            <h1 class="font-display text-gold-light text-4xl md:text-6xl tracking-[0.06em] leading-tight mb-6">Think you're a fit?</h1>
                            <p class="font-display text-gold-light/70 text-xl md:text-2xl tracking-[0.04em] italic mb-10">Let's find out.</p>
                            <div class="text-text-body text-sm leading-relaxed max-w-lg mx-auto space-y-3 mb-12">
                                <p>We accept eight men per quarter.</p>
                                <p>We turn down most applicants.</p>
                                <p>If you're ready to commit twelve months, fill out the application below.</p>
                                <p>We review every submission personally within 48 hours.</p>
                            </div>
                            <p class="text-warm-grey text-xs tracking-[0.2em] uppercase mb-10">— six questions · approximately 8 minutes —</p>
                            <button @click="step = 1" class="inline-block px-10 py-3.5 bg-gold text-black text-xs tracking-[0.3em] uppercase font-sans font-semibold hover:bg-gold-light active:bg-gold-deep transition-colors duration-400">
                                Begin Application
                            </button>
                        </div>

                        <!-- Step 1: Where You Are -->
                        <div v-else-if="step === 1" key="q1">
                            <p class="text-gold text-[9px] uppercase tracking-[0.5em] font-sans font-semibold mb-3">Where You Are</p>
                            <h2 class="font-display text-gold-light text-xl md:text-2xl tracking-[0.04em] leading-snug mb-3">
                                What's happening with your body, energy, confidence, and overall health right now — honestly?
                            </h2>
                            <p class="text-warm-grey text-xs mb-8">Be specific. Energy levels, sleep, body composition, mental clarity, confidence. Two to four sentences.</p>
                            <textarea v-model="form.current_state" rows="5" placeholder="Tired by 3 PM. Body doesn't match the work I've put in. Sleep is broken. Confidence isn't what it used to be..." class="w-full bg-transparent border border-gold-deep/20 text-off-white text-sm px-4 py-3 focus:outline-none focus:border-gold/50 transition-colors resize-none mb-2"></textarea>
                            <p v-if="stepError" class="text-red-400 text-xs mb-4">{{ stepError }}</p>
                            <div class="flex justify-between items-center mt-8">
                                <button @click="step = 0" class="text-warm-grey text-xs tracking-[0.2em] uppercase hover:text-gold-light transition-colors">← Back</button>
                                <button @click="nextStep" class="px-8 py-3 bg-gold text-black text-xs tracking-[0.3em] uppercase font-sans font-semibold hover:bg-gold-light transition-colors duration-400">Continue</button>
                            </div>
                        </div>

                        <!-- Step 2: Why You Want to Change -->
                        <div v-else-if="step === 2" key="q2">
                            <p class="text-gold text-[9px] uppercase tracking-[0.5em] font-sans font-semibold mb-3">Why You Want to Change</p>
                            <h2 class="font-display text-gold-light text-xl md:text-2xl tracking-[0.04em] leading-snug mb-3">
                                Why do you want to transform? What would that transformation mean for your life and your loved ones — and what happens if nothing changes?
                            </h2>
                            <p class="text-warm-grey text-xs mb-8">The honest answer. What's at stake — both ways. Be specific about the people who matter.</p>
                            <textarea v-model="form.why_now" rows="5" placeholder="My kids deserve a father who can keep up. My wife deserves a man with energy at the end of the day..." class="w-full bg-transparent border border-gold-deep/20 text-off-white text-sm px-4 py-3 focus:outline-none focus:border-gold/50 transition-colors resize-none mb-2"></textarea>
                            <p v-if="stepError" class="text-red-400 text-xs mb-4">{{ stepError }}</p>
                            <div class="flex justify-between items-center mt-8">
                                <button @click="step = 1" class="text-warm-grey text-xs tracking-[0.2em] uppercase hover:text-gold-light transition-colors">← Back</button>
                                <button @click="nextStep" class="px-8 py-3 bg-gold text-black text-xs tracking-[0.3em] uppercase font-sans font-semibold hover:bg-gold-light transition-colors duration-400">Continue</button>
                            </div>
                        </div>

                        <!-- Step 3: What You've Tried -->
                        <div v-else-if="step === 3" key="q3">
                            <p class="text-gold text-[9px] uppercase tracking-[0.5em] font-sans font-semibold mb-3">What You've Tried</p>
                            <h2 class="font-display text-gold-light text-xl md:text-2xl tracking-[0.04em] leading-snug mb-3">
                                What have you tried over the last few years to improve your health or physique — and why do you think it never fully worked?
                            </h2>
                            <p class="text-warm-grey text-xs mb-8">Diets, programs, coaches, trainers, supplements, apps. What worked for a few weeks? What collapsed when life got busy?</p>
                            <textarea v-model="form.previous_experience" rows="5" placeholder="Tried keto for 3 months — lost weight, gained it back. Worked with a trainer 4x/week — couldn't sustain..." class="w-full bg-transparent border border-gold-deep/20 text-off-white text-sm px-4 py-3 focus:outline-none focus:border-gold/50 transition-colors resize-none mb-2"></textarea>
                            <p v-if="stepError" class="text-red-400 text-xs mb-4">{{ stepError }}</p>
                            <div class="flex justify-between items-center mt-8">
                                <button @click="step = 2" class="text-warm-grey text-xs tracking-[0.2em] uppercase hover:text-gold-light transition-colors">← Back</button>
                                <button @click="nextStep" class="px-8 py-3 bg-gold text-black text-xs tracking-[0.3em] uppercase font-sans font-semibold hover:bg-gold-light transition-colors duration-400">Continue</button>
                            </div>
                        </div>

                        <!-- Step 4: Where You Want to Be -->
                        <div v-else-if="step === 4" key="q4">
                            <p class="text-gold text-[9px] uppercase tracking-[0.5em] font-sans font-semibold mb-3">Where You Want to Be</p>
                            <h2 class="font-display text-gold-light text-xl md:text-2xl tracking-[0.04em] leading-snug mb-3">
                                If we work together successfully for the next 12 months, what would your body, energy, confidence, and lifestyle look like?
                            </h2>
                            <p class="text-warm-grey text-xs mb-8">Paint the picture. Energy at the end of the day, body composition, sleep, capability, confidence, freedom. Be specific.</p>
                            <textarea v-model="form.twelve_month_goal" rows="5" placeholder="Lean in the suit. Energy that lasts the whole day. Sleep that resets the system. Bloodwork in the top 10% for my age..." class="w-full bg-transparent border border-gold-deep/20 text-off-white text-sm px-4 py-3 focus:outline-none focus:border-gold/50 transition-colors resize-none mb-2"></textarea>
                            <p v-if="stepError" class="text-red-400 text-xs mb-4">{{ stepError }}</p>
                            <div class="flex justify-between items-center mt-8">
                                <button @click="step = 3" class="text-warm-grey text-xs tracking-[0.2em] uppercase hover:text-gold-light transition-colors">← Back</button>
                                <button @click="nextStep" class="px-8 py-3 bg-gold text-black text-xs tracking-[0.3em] uppercase font-sans font-semibold hover:bg-gold-light transition-colors duration-400">Continue</button>
                            </div>
                        </div>

                        <!-- Step 5: Commitment -->
                        <div v-else-if="step === 5" key="q5">
                            <p class="text-gold text-[9px] uppercase tracking-[0.5em] font-sans font-semibold mb-3">Commitment</p>
                            <h2 class="font-display text-gold-light text-xl md:text-2xl tracking-[0.04em] leading-snug mb-3">
                                Apex Human is built around long-term transformation, with a 12-month minimum commitment. Are you ready to begin within the next 30 days?
                            </h2>
                            <p class="text-warm-grey text-xs mb-8">Be honest. This is the most important question.</p>
                            <div class="space-y-4">
                                <label v-for="opt in commitmentOptions" :key="opt.value" class="flex items-center gap-4 cursor-pointer group py-1">
                                    <span class="w-5 h-5 rounded-full border-2 flex items-center justify-center shrink-0 transition-colors" :class="form.commitment === opt.value ? 'border-gold bg-gold' : 'border-gold-deep/40 group-hover:border-gold/60'">
                                        <span v-if="form.commitment === opt.value" class="w-2 h-2 rounded-full bg-black"></span>
                                    </span>
                                    <input v-model="form.commitment" type="radio" :value="opt.value" class="sr-only">
                                    <span class="text-off-white text-sm">{{ opt.label }}</span>
                                </label>
                            </div>
                            <p v-if="stepError" class="text-red-400 text-xs mt-4">{{ stepError }}</p>
                            <div class="flex justify-between items-center mt-10">
                                <button @click="step = 4" class="text-warm-grey text-xs tracking-[0.2em] uppercase hover:text-gold-light transition-colors">← Back</button>
                                <button @click="nextStep" class="px-8 py-3 bg-gold text-black text-xs tracking-[0.3em] uppercase font-sans font-semibold hover:bg-gold-light transition-colors duration-400">Continue</button>
                            </div>
                        </div>

                        <!-- Step 6: Investment -->
                        <div v-else-if="step === 6" key="q6">
                            <p class="text-gold text-[9px] uppercase tracking-[0.5em] font-sans font-semibold mb-3">Investment</p>
                            <h2 class="font-display text-gold-light text-xl md:text-2xl tracking-[0.04em] leading-snug mb-3">
                                What level of monthly investment are you prepared to make toward your health, performance, and longevity?
                            </h2>
                            <p class="text-warm-grey text-xs mb-8">Pricing is shared on the discovery call — not before. This question helps us understand your seriousness.</p>
                            <div class="space-y-4">
                                <label v-for="opt in investmentOptions" :key="opt.value" class="flex items-center gap-4 cursor-pointer group py-1">
                                    <span class="w-5 h-5 rounded-full border-2 flex items-center justify-center shrink-0 transition-colors" :class="form.investment === opt.value ? 'border-gold bg-gold' : 'border-gold-deep/40 group-hover:border-gold/60'">
                                        <span v-if="form.investment === opt.value" class="w-2 h-2 rounded-full bg-black"></span>
                                    </span>
                                    <input v-model="form.investment" type="radio" :value="opt.value" class="sr-only">
                                    <span class="text-off-white text-sm">{{ opt.label }}</span>
                                </label>
                            </div>
                            <p v-if="stepError" class="text-red-400 text-xs mt-4">{{ stepError }}</p>
                            <div class="flex justify-between items-center mt-10">
                                <button @click="step = 5" class="text-warm-grey text-xs tracking-[0.2em] uppercase hover:text-gold-light transition-colors">← Back</button>
                                <button @click="nextStep" class="px-8 py-3 bg-gold text-black text-xs tracking-[0.3em] uppercase font-sans font-semibold hover:bg-gold-light transition-colors duration-400">Continue</button>
                            </div>
                        </div>

                        <!-- Step 7: Contact Details -->
                        <div v-else-if="step === 7" key="contact">
                            <p class="text-gold text-[9px] uppercase tracking-[0.5em] font-sans font-semibold mb-8">Contact Details</p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-2">
                                <div>
                                    <label class="block text-warm-grey text-[9px] uppercase tracking-[0.4em] font-sans font-semibold mb-2">Full Name</label>
                                    <input v-model="form.full_name" type="text" placeholder="Your full name" class="w-full bg-transparent border-b border-gold-deep/30 text-off-white text-sm py-2.5 focus:outline-none focus:border-gold/50 transition-colors placeholder:text-warm-grey/40">
                                    <p v-if="form.errors.full_name" class="text-red-400 text-xs mt-2">{{ form.errors.full_name }}</p>
                                </div>
                                <div>
                                    <label class="block text-warm-grey text-[9px] uppercase tracking-[0.4em] font-sans font-semibold mb-2">Email</label>
                                    <input v-model="form.email" type="email" placeholder="you@example.com" class="w-full bg-transparent border-b border-gold-deep/30 text-off-white text-sm py-2.5 focus:outline-none focus:border-gold/50 transition-colors placeholder:text-warm-grey/40">
                                    <p v-if="form.errors.email" class="text-red-400 text-xs mt-2">{{ form.errors.email }}</p>
                                </div>
                                <div>
                                    <label class="block text-warm-grey text-[9px] uppercase tracking-[0.4em] font-sans font-semibold mb-2">Country</label>
                                    <input v-model="form.country" type="text" placeholder="Where you're based" class="w-full bg-transparent border-b border-gold-deep/30 text-off-white text-sm py-2.5 focus:outline-none focus:border-gold/50 transition-colors placeholder:text-warm-grey/40">
                                    <p v-if="form.errors.country" class="text-red-400 text-xs mt-2">{{ form.errors.country }}</p>
                                </div>
                                <div>
                                    <label class="block text-warm-grey text-[9px] uppercase tracking-[0.4em] font-sans font-semibold mb-2">Age</label>
                                    <input v-model="form.age" type="number" min="18" max="100" placeholder="Your age" class="w-full bg-transparent border-b border-gold-deep/30 text-off-white text-sm py-2.5 focus:outline-none focus:border-gold/50 transition-colors placeholder:text-warm-grey/40">
                                    <p v-if="form.errors.age" class="text-red-400 text-xs mt-2">{{ form.errors.age }}</p>
                                </div>
                            </div>
                            <p v-if="stepError" class="text-red-400 text-xs mt-4">{{ stepError }}</p>
                            <div class="flex justify-between items-center mt-10">
                                <button @click="step = 6" class="text-warm-grey text-xs tracking-[0.2em] uppercase hover:text-gold-light transition-colors">← Back</button>
                                <button @click="submitApplication" :disabled="form.processing" class="px-10 py-3.5 bg-gold text-black text-xs tracking-[0.3em] uppercase font-sans font-semibold hover:bg-gold-light active:bg-gold-deep transition-colors duration-400 disabled:opacity-40 disabled:cursor-not-allowed">
                                    {{ form.processing ? 'Submitting...' : 'Submit & Book Call' }}
                                </button>
                            </div>
                        </div>

                        <!-- Step 8: Calendar Booking -->
                        <div v-else-if="step === 8" key="calendar">
                            <p class="text-gold text-[9px] uppercase tracking-[0.5em] font-sans font-semibold mb-4">Select a Date</p>

                            <!-- Month nav -->
                            <div class="flex items-center gap-6 mb-6">
                                <h2 class="font-display text-gold-light text-lg tracking-wide uppercase">{{ monthLabel }}</h2>
                                <div class="flex gap-3">
                                    <button @click="changeMonth(-1)" class="text-gold hover:text-gold-light transition-colors">←</button>
                                    <button @click="changeMonth(1)" class="text-gold hover:text-gold-light transition-colors">→</button>
                                </div>
                            </div>

                            <!-- Day headers -->
                            <div class="grid grid-cols-7 border border-gold-deep/20">
                                <div v-for="d in ['MON','TUE','WED','THU','FRI','SAT','SUN']" :key="d" class="text-center text-gold text-[9px] uppercase tracking-[0.3em] font-semibold py-3 border-b border-gold-deep/20">
                                    {{ d }}
                                </div>
                            </div>

                            <!-- Calendar grid -->
                            <div class="grid grid-cols-7 border-l border-gold-deep/20">
                                <div
                                    v-for="(cell, i) in calendarCells"
                                    :key="i"
                                    class="min-h-[70px] border-r border-b border-gold-deep/20 flex items-center justify-center transition-colors"
                                    :class="cellClass(cell)"
                                    @click="selectDate(cell)"
                                >
                                    <span v-if="cell.day" class="font-display text-sm" :class="cell.hasSlots ? 'text-off-white' : 'text-warm-grey/30'">
                                        {{ String(cell.day).padStart(2, '0') }}
                                    </span>
                                </div>
                            </div>

                            <!-- Time slots -->
                            <div v-if="selectedDate" class="mt-8">
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

                            <!-- Confirm booking -->
                            <div v-if="selectedSlot" class="mt-10 text-center">
                                <button
                                    @click="confirmBooking"
                                    :disabled="bookingLoading"
                                    class="inline-block px-12 py-4 bg-gold text-black text-xs tracking-[0.3em] uppercase font-sans font-semibold hover:bg-gold-light active:bg-gold-deep transition-colors duration-400 disabled:opacity-40"
                                >
                                    {{ bookingLoading ? 'Confirming...' : 'Confirm Booking' }}
                                </button>
                            </div>

                            <p v-if="bookingError" class="text-red-400 text-xs mt-4 text-center">{{ bookingError }}</p>
                        </div>

                        <!-- Step 9: Final Confirmation -->
                        <div v-else-if="step === 9" key="confirmed" class="text-center">
                            <p class="text-gold text-[9px] uppercase tracking-[0.5em] font-sans font-semibold mb-6">Confirmed</p>
                            <h1 class="font-display text-gold-light text-3xl md:text-5xl tracking-[0.06em] leading-tight mb-12">You're booked.</h1>

                            <div class="max-w-md mx-auto space-y-6 text-left mb-12">
                                <div class="flex justify-between border-b border-gold-deep/10 pb-3">
                                    <p class="text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold">Date</p>
                                    <p class="text-off-white text-sm">{{ confirmedDate }}</p>
                                </div>
                                <div class="flex justify-between border-b border-gold-deep/10 pb-3">
                                    <p class="text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold">Time</p>
                                    <p class="text-off-white text-sm">{{ confirmedTime }}</p>
                                </div>
                                <div class="flex justify-between border-b border-gold-deep/10 pb-3">
                                    <p class="text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold">Format</p>
                                    <p class="text-off-white text-sm">Zoom (link sent via email)</p>
                                </div>
                                <div class="flex justify-between border-b border-gold-deep/10 pb-3">
                                    <p class="text-warm-grey text-[9px] uppercase tracking-[0.3em] font-semibold">Duration</p>
                                    <p class="text-off-white text-sm">30 minutes</p>
                                </div>
                            </div>

                            <p class="text-text-body text-sm max-w-md mx-auto mb-8">We review every application personally. You'll hear back within 48 hours.</p>
                            <p class="text-warm-grey text-xs tracking-[0.2em] uppercase">— Apex Human —</p>
                        </div>
                    </Transition>

            </div>
        </section>
    </AppLayout>
</template>

<script setup>
import { ref, computed, watch } from 'vue';
import { useForm, usePage, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({ page: Object, sections: Object });
const $page = usePage();

const step = ref(0);
const stepError = ref('');
const bookingToken = ref(null);

const stepLabel = computed(() => {
    if (step.value <= 6) return `Question ${String(step.value).padStart(2, '0')} of 06`;
    if (step.value === 7) return 'Contact Details';
    if (step.value === 8) return 'Book Your Call';
    return '';
});

const commitmentOptions = [
    { value: 'yes', label: "Yes — I'm ready to commit twelve months, starting in the next 30 days." },
    { value: 'need_to_think', label: 'Need to think about it.' },
    { value: 'no', label: 'No — not the right time.' },
];

const investmentOptions = [
    { value: 'under_500', label: 'Under €500 / month' },
    { value: '500_1000', label: '€500 — €1,000 / month' },
    { value: '1000_2500', label: '€1,000 — €2,500 / month' },
    { value: '2500_plus', label: '€2,500+ / month' },
    { value: 'discuss_on_call', label: "I'd prefer to discuss this on the call" },
];

const form = useForm({
    full_name: '',
    email: '',
    age: '',
    country: '',
    current_state: '',
    why_now: '',
    previous_experience: '',
    twelve_month_goal: '',
    commitment: '',
    investment: '',
});

function nextStep() {
    stepError.value = '';

    if (step.value === 1 && form.current_state.length < 20) {
        stepError.value = 'Please write at least a few sentences (minimum 20 characters).';
        return;
    }
    if (step.value === 2 && form.why_now.length < 20) {
        stepError.value = 'Please write at least a few sentences (minimum 20 characters).';
        return;
    }
    if (step.value === 3 && form.previous_experience.length < 20) {
        stepError.value = 'Please write at least a few sentences (minimum 20 characters).';
        return;
    }
    if (step.value === 4 && form.twelve_month_goal.length < 20) {
        stepError.value = 'Please write at least a few sentences (minimum 20 characters).';
        return;
    }
    if (step.value === 5 && !form.commitment) {
        stepError.value = 'Please select an option.';
        return;
    }
    if (step.value === 6 && !form.investment) {
        stepError.value = 'Please select an option.';
        return;
    }

    step.value++;
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function submitApplication() {
    stepError.value = '';
    if (!form.full_name || !form.email || !form.country || !form.age) {
        stepError.value = 'Please fill in all contact details.';
        return;
    }
    form.post('/apply', {
        preserveScroll: true,
        onSuccess: () => {
            bookingToken.value = $page.props.flash?.booking_token;
            step.value = 8;
            fetchSlots();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        },
    });
}

// ─── Calendar Logic ───
const slots = ref([]);
const currentMonth = ref(new Date());
const selectedDate = ref(null);
const selectedSlot = ref(null);
const bookingLoading = ref(false);
const bookingError = ref('');
const confirmedDate = ref('');
const confirmedTime = ref('');

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
    if (!bookingToken.value) return;
    const m = `${currentMonth.value.getFullYear()}-${String(currentMonth.value.getMonth() + 1).padStart(2, '0')}`;
    try {
        const res = await fetch(`/api/available-slots?token=${bookingToken.value}&month=${m}`);
        slots.value = await res.json();
    } catch (e) {
        slots.value = [];
    }
}

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
    if (cell.dateStr === selectedDate.value) return 'bg-gold/20 border-gold/40 cursor-pointer';
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

async function confirmBooking() {
    bookingLoading.value = true;
    bookingError.value = '';
    try {
        const res = await fetch('/apply/book', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ token: bookingToken.value, slot_id: selectedSlot.value.id }),
        });
        if (!res.ok) {
            const data = await res.json().catch(() => ({}));
            bookingError.value = data.message || 'Something went wrong. Please try again.';
            bookingLoading.value = false;
            return;
        }
        const d = new Date(selectedDate.value + 'T12:00:00');
        confirmedDate.value = d.toLocaleDateString('en-US', { weekday: 'long', month: 'long', day: 'numeric', year: 'numeric' });
        confirmedTime.value = selectedSlot.value.start_time.substring(0, 5);
        step.value = 9;
        window.scrollTo({ top: 0, behavior: 'smooth' });
    } catch (e) {
        bookingError.value = 'Network error. Please try again.';
    }
    bookingLoading.value = false;
}
</script>

<style scoped>
.step-enter-active,
.step-leave-active {
    transition: opacity 0.4s cubic-bezier(0.16, 1, 0.3, 1), transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}
.step-enter-from {
    opacity: 0;
    transform: translateY(20px);
}
.step-leave-to {
    opacity: 0;
    transform: translateY(-10px);
}
</style>
