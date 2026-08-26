<template>
    <AppLayout title="Privacy Policy — Apex Human">
        <article class="pt-24 pb-14 md:pt-32 md:pb-24 px-6">
            <header class="max-w-3xl mx-auto text-center mb-12 md:mb-16">
                <p class="text-gold text-[9px] uppercase tracking-[0.5em] font-sans font-semibold mb-6">{{ t('privacy.eyebrow', 'Legal') }}</p>
                <h1 class="font-display text-gold-light text-3xl md:text-5xl tracking-[0.06em] leading-tight">{{ t('privacy.title', 'Privacy Policy') }}</h1>
                <p class="text-warm-grey text-xs uppercase tracking-[0.2em] mt-4">{{ t('privacy.effective_date', 'Effective May 23, 2026') }}</p>
            </header>

            <div class="max-w-3xl mx-auto space-y-10 text-text-body text-sm leading-[1.85]">
                <p class="text-warm-grey italic">{{ t('privacy.intro', 'This document is intended to provide comprehensive legal protection, operational clarity, and user transparency for the APEX HUMAN™ brand, digital infrastructure, coaching systems, educational content, and related services.') }}</p>

                <section>
                    <h2 class="font-display text-gold-light text-lg tracking-wide mb-3">{{ t('privacy.introduction_heading', '1. Introduction') }}</h2>
                    <p>{{ t('privacy.introduction_body', 'This Privacy Policy governs the collection, use, disclosure, storage, protection, and processing of information by APEX HUMAN™ through the website apexhuman.co, coaching systems, consultations, digital products, applications, questionnaires, payment systems, communications, and related services.') }}</p>
                </section>

                <section>
                    <h2 class="font-display text-gold-light text-lg tracking-wide mb-3">{{ t('privacy.information_collect_heading', '2. Information We Collect') }}</h2>
                    <p>{{ t('privacy.information_collect_body', 'We may collect personal information including your full name, email address, phone number, payment details, IP address, browser information, operating system data, device identifiers, account activity, application forms, health and performance questionnaires, communication history, and analytics data.') }}</p>
                </section>

                <section>
                    <h2 class="font-display text-gold-light text-lg tracking-wide mb-3">{{ t('privacy.health_data_heading', '3. Health & Performance Data') }}</h2>
                    <p>{{ t('privacy.health_data_body', 'Users may voluntarily provide information related to training, recovery, nutrition, sleep, supplementation, hormones, stress management, lifestyle habits, and physical performance. This information is used solely for service personalization and coaching optimization.') }}</p>
                </section>

                <section>
                    <h2 class="font-display text-gold-light text-lg tracking-wide mb-3">{{ t('privacy.how_use_heading', '4. How We Use Information') }}</h2>
                    <p>{{ t('privacy.how_use_body', 'Collected information may be used to deliver coaching services, improve customer experience, personalize recommendations, process transactions, analyze website performance, provide customer support, maintain platform security, communicate updates, and fulfill legal obligations.') }}</p>
                </section>

                <section>
                    <h2 class="font-display text-gold-light text-lg tracking-wide mb-3">{{ t('privacy.legal_basis_heading', '5. Legal Basis for Processing') }}</h2>
                    <p>{{ t('privacy.legal_basis_body', 'Where applicable under GDPR and other privacy regulations, information is processed based on consent, contractual necessity, legitimate business interests, legal compliance, and user-initiated requests.') }}</p>
                </section>

                <section>
                    <h2 class="font-display text-gold-light text-lg tracking-wide mb-3">{{ t('privacy.cookies_heading', '6. Cookies & Tracking') }}</h2>
                    <p>{{ t('privacy.cookies_body', 'APEX HUMAN™ may use cookies, analytics platforms, advertising pixels, behavioral tracking tools, session identifiers, and related technologies to improve website performance, optimize advertising campaigns, and enhance user experience.') }}</p>
                </section>

                <section>
                    <h2 class="font-display text-gold-light text-lg tracking-wide mb-3">{{ t('privacy.payment_heading', '7. Payment Processing') }}</h2>
                    <p>{{ t('privacy.payment_body', 'Payments may be processed through third-party providers. APEX HUMAN™ does not directly store complete credit card or banking information on its servers.') }}</p>
                </section>

                <section>
                    <h2 class="font-display text-gold-light text-lg tracking-wide mb-3">{{ t('privacy.third_party_heading', '8. Third-Party Services') }}</h2>
                    <p>{{ t('privacy.third_party_body', 'Our services may integrate with external platforms including payment processors, scheduling software, CRM systems, analytics providers, communication tools, email platforms, social media services, and cloud-based systems. We are not responsible for the privacy practices of third-party providers.') }}</p>
                </section>

                <section>
                    <h2 class="font-display text-gold-light text-lg tracking-wide mb-3">{{ t('privacy.security_heading', '9. Data Security') }}</h2>
                    <p>{{ t('privacy.security_body', 'We implement commercially reasonable safeguards designed to protect information from unauthorized access, misuse, disclosure, alteration, or destruction. Despite these measures, no online system can guarantee absolute security.') }}</p>
                </section>

                <section>
                    <h2 class="font-display text-gold-light text-lg tracking-wide mb-3">{{ t('privacy.international_heading', '10. International Data Transfers') }}</h2>
                    <p>{{ t('privacy.international_body', 'Information may be processed and stored in jurisdictions outside your country of residence where privacy protections may differ.') }}</p>
                </section>

                <section>
                    <h2 class="font-display text-gold-light text-lg tracking-wide mb-3">{{ t('privacy.retention_heading', '11. Data Retention') }}</h2>
                    <p>{{ t('privacy.retention_body', 'Information is retained only for as long as necessary to fulfill operational, legal, compliance, accounting, contractual, and legitimate business purposes.') }}</p>
                </section>

                <section>
                    <h2 class="font-display text-gold-light text-lg tracking-wide mb-3">{{ t('privacy.user_rights_heading', '12. User Rights') }}</h2>
                    <p>{{ t('privacy.user_rights_body', 'Depending on your jurisdiction, you may have the right to access, correct, delete, restrict, or port your personal data. To exercise these rights, contact us at coach@apexhuman.co.') }}</p>
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
