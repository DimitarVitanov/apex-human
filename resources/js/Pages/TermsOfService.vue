<template>
    <AppLayout title="Terms of Service — Apex Human">
        <article class="pt-24 pb-14 md:pt-32 md:pb-24 px-6">
            <header class="max-w-3xl mx-auto text-center mb-12 md:mb-16">
                <p class="text-gold text-[9px] uppercase tracking-[0.5em] font-sans font-semibold mb-6">{{ t('terms.eyebrow', 'Legal') }}</p>
                <h1 class="font-display text-gold-light text-3xl md:text-5xl tracking-[0.06em] leading-tight">{{ t('terms.title', 'Terms of Service') }}</h1>
                <p class="text-warm-grey text-xs uppercase tracking-[0.2em] mt-4">{{ t('terms.effective_date', 'Effective May 23, 2026') }}</p>
            </header>

            <div class="max-w-3xl mx-auto space-y-10 text-text-body text-sm leading-[1.85]">
                <p class="text-warm-grey italic">{{ t('terms.intro', 'This document is intended to provide comprehensive legal protection, operational clarity, and user transparency for the APEX HUMAN™ brand, digital infrastructure, coaching systems, educational content, and related services.') }}</p>

                <section>
                    <h2 class="font-display text-gold-light text-lg tracking-wide mb-3">{{ t('terms.acceptance_heading', '1. Acceptance of Terms') }}</h2>
                    <p>{{ t('terms.acceptance_body', 'By accessing or using apexhuman.co, APEX HUMAN™ coaching systems, digital products, programs, consultations, or related services, you agree to be legally bound by these Terms of Service.') }}</p>
                </section>

                <section>
                    <h2 class="font-display text-gold-light text-lg tracking-wide mb-3">{{ t('terms.eligibility_heading', '2. Eligibility') }}</h2>
                    <p>{{ t('terms.eligibility_body', 'You must be at least 18 years old to access, purchase, or use APEX HUMAN™ services.') }}</p>
                </section>

                <section>
                    <h2 class="font-display text-gold-light text-lg tracking-wide mb-3">{{ t('terms.educational_heading', '3. Educational Purposes') }}</h2>
                    <p>{{ t('terms.educational_body', 'All content, systems, protocols, frameworks, recommendations, and materials provided by APEX HUMAN™ are intended solely for educational and informational purposes.') }}</p>
                </section>

                <section>
                    <h2 class="font-display text-gold-light text-lg tracking-wide mb-3">{{ t('terms.medical_heading', '4. Medical Disclaimer') }}</h2>
                    <p>{{ t('terms.medical_body', 'Nothing provided through APEX HUMAN™ constitutes medical advice, diagnosis, treatment, or healthcare services. Users should consult qualified healthcare professionals before beginning any training, nutrition, recovery, supplementation, or hormone-related protocol.') }}</p>
                </section>

                <section>
                    <h2 class="font-display text-gold-light text-lg tracking-wide mb-3">{{ t('terms.results_heading', '5. Results Disclaimer') }}</h2>
                    <p>{{ t('terms.results_body', 'Individual outcomes vary based on genetics, consistency, adherence, health status, effort, recovery, lifestyle, and numerous external variables. No guarantees are made regarding specific results.') }}</p>
                </section>

                <section>
                    <h2 class="font-display text-gold-light text-lg tracking-wide mb-3">{{ t('terms.payments_heading', '6. Payments & Refunds') }}</h2>
                    <p>{{ t('terms.payments_body', 'Pricing, subscriptions, retainers, digital purchases, deposits, and coaching fees are governed by the terms presented during checkout or onboarding. Unless otherwise stated in writing, payments are non-refundable.') }}</p>
                </section>

                <section>
                    <h2 class="font-display text-gold-light text-lg tracking-wide mb-3">{{ t('terms.ip_heading', '7. Intellectual Property') }}</h2>
                    <p>{{ t('terms.ip_body', 'All APEX HUMAN™ branding, systems, frameworks, strategies, educational materials, videos, graphics, PDFs, website assets, logos, methodologies, and proprietary content remain the exclusive intellectual property of APEX HUMAN™.') }}</p>
                </section>

                <section>
                    <h2 class="font-display text-gold-light text-lg tracking-wide mb-3">{{ t('terms.restrictions_heading', '8. Restrictions') }}</h2>
                    <p>{{ t('terms.restrictions_body', 'Users may not reproduce, distribute, republish, modify, reverse engineer, exploit, copy, resell, or commercially use any APEX HUMAN™ material without prior written authorization.') }}</p>
                </section>

                <section>
                    <h2 class="font-display text-gold-light text-lg tracking-wide mb-3">{{ t('terms.conduct_heading', '9. User Conduct') }}</h2>
                    <p>{{ t('terms.conduct_body', 'Users agree not to engage in unlawful behavior, interfere with platform operations, transmit malicious code, violate intellectual property rights, abuse services, or misuse website access.') }}</p>
                </section>

                <section>
                    <h2 class="font-display text-gold-light text-lg tracking-wide mb-3">{{ t('terms.termination_heading', '10. Account Termination') }}</h2>
                    <p>{{ t('terms.termination_body', 'APEX HUMAN™ reserves the right to suspend, restrict, or terminate user access, memberships, or services at its sole discretion without prior notice.') }}</p>
                </section>

                <section>
                    <h2 class="font-display text-gold-light text-lg tracking-wide mb-3">{{ t('terms.liability_heading', '11. Limitation of Liability') }}</h2>
                    <p>{{ t('terms.liability_body', 'To the fullest extent permitted by law, APEX HUMAN™ shall not be liable for indirect, incidental, consequential, punitive, exemplary, or special damages arising from website or service use.') }}</p>
                </section>

                <section>
                    <h2 class="font-display text-gold-light text-lg tracking-wide mb-3">{{ t('terms.risk_heading', '12. Assumption of Risk') }}</h2>
                    <p>{{ t('terms.risk_body', 'Users voluntarily assume all risks associated with physical training, nutrition, supplementation, recovery practices, lifestyle optimization, and performance-related activities.') }}</p>
                </section>

                <section>
                    <h2 class="font-display text-gold-light text-lg tracking-wide mb-3">{{ t('terms.third_party_heading', '13. Third-Party Services') }}</h2>
                    <p>{{ t('terms.third_party_body', 'APEX HUMAN™ may integrate with or link to third-party platforms, tools, or services. We are not responsible for the content, policies, or practices of any third-party provider.') }}</p>
                </section>
            </div>
        </article>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useI18n } from '@/Composables/useI18n';

const { t } = useI18n();
</script>
