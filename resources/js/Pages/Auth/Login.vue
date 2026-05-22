<template>
    <div class="min-h-screen bg-black flex items-center justify-center px-6">
        <div class="w-full max-w-sm">
            <p class="font-display text-gold text-center text-lg tracking-[0.18em] mb-8">APEX HUMAN&#8482;</p>

            <form @submit.prevent="submit" class="space-y-5">
                <div>
                    <label class="block text-warm-grey text-[9px] uppercase tracking-[0.4em] font-sans font-semibold mb-2">Email</label>
                    <input
                        v-model="form.email"
                        type="email"
                        required
                        class="w-full bg-transparent border-b border-gold-deep text-off-white text-sm font-sans py-2.5 focus:outline-none focus:border-gold transition-colors duration-200"
                    >
                    <p v-if="form.errors.email" class="text-red-400 text-xs mt-1">{{ form.errors.email }}</p>
                </div>

                <div>
                    <label class="block text-warm-grey text-[9px] uppercase tracking-[0.4em] font-sans font-semibold mb-2">Password</label>
                    <input
                        v-model="form.password"
                        type="password"
                        required
                        class="w-full bg-transparent border-b border-gold-deep text-off-white text-sm font-sans py-2.5 focus:outline-none focus:border-gold transition-colors duration-200"
                    >
                </div>

                <div class="flex items-center gap-2">
                    <input v-model="form.remember" type="checkbox" id="remember" class="accent-gold">
                    <label for="remember" class="text-warm-grey text-xs">Remember me</label>
                </div>

                <button
                    type="submit"
                    :disabled="form.processing"
                    class="w-full py-3 bg-gold text-black text-xs tracking-[0.3em] uppercase font-sans font-semibold hover:bg-gold-light active:bg-gold-deep transition-colors duration-400 disabled:opacity-50"
                >
                    {{ form.processing ? 'Signing in...' : 'Sign In' }}
                </button>
            </form>
        </div>
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

function submit() {
    form.post('/login');
}
</script>
