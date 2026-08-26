import { computed } from 'vue';
import { router, usePage } from '@inertiajs/vue3';

/**
 * Lightweight UI-string translation for the public site.
 *
 * The active locale, the available locales and the string dictionary for the
 * current locale are shared from the server (see HandleInertiaRequests). Use
 * `t('key', 'English default')` for hardcoded chrome text; CMS content
 * (sections, posts, nav, settings) is already localized server-side.
 */
export function useI18n() {
    const page = usePage();

    const locale = computed(() => page.props.locale || 'en');
    const locales = computed(() => page.props.locales || { en: 'English' });
    const dictionary = computed(() => page.props.translations || {});

    /**
     * Translate a key. Falls back to the provided English default (or the key
     * itself) when the active locale has no entry — so English always renders
     * even before the dictionary is filled in.
     */
    function t(key, fallback = null) {
        const value = dictionary.value[key];
        if (value !== undefined && value !== null && value !== '') return value;
        return fallback !== null ? fallback : key;
    }

    /** Persist a language choice and reload the current page in that language. */
    function setLocale(next) {
        if (next === locale.value) return;
        window.location.href = `/lang/${next}`;
    }

    return { t, locale, locales, setLocale };
}
