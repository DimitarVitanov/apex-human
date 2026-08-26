<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AdminNewApplication;
use App\Mail\AdminNewContact;
use App\Mail\ApplicationConfirmation;
use App\Mail\BookingConfirmation;
use App\Mail\ContactAutoReply;
use App\Models\Application;
use App\Models\Booking;
use App\Models\Contact;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class SettingController extends Controller
{
    /** Settings that are user-facing copy and worth translating to Macedonian. */
    private array $translatableKeys = [
        'tagline',
        'default_meta_title',
        'default_meta_description',
        'footer_newsletter_headline',
        'footer_newsletter_sub',
    ];

    public function index()
    {
        $settings = SiteSetting::all()->map(function (SiteSetting $setting) {
            $data = $setting->getRawOriginal();
            $data['translatable'] = in_array($setting->key, $this->translatableKeys, true);
            $data['value_mk'] = data_get($setting->translations, 'mk.value');

            return (object) $data;
        })->groupBy('group');

        return Inertia::render('Admin/Settings/Index', [
            'settings' => $settings,
            'locales' => config('app.available_locales'),
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'settings' => 'required|array',
            'settings.*.key' => 'required|string',
            'settings.*.value' => 'nullable|string',
            'settings.*.value_mk' => 'nullable|string',
        ]);

        foreach ($request->settings as $setting) {
            $model = SiteSetting::firstOrNew(['key' => $setting['key']]);
            $model->value = $setting['value'];

            if (in_array($setting['key'], $this->translatableKeys, true)) {
                $model->setTranslations('mk', ['value' => $setting['value_mk'] ?? null]);
            }

            $model->save();
        }

        foreach (array_keys(config('app.available_locales', ['en' => 'English'])) as $locale) {
            Cache::forget("site_settings_{$locale}");
        }
        Cache::forget('site_settings'); // legacy key, safe to clear

        return back()->with('success', 'Settings updated.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->update(['password' => Hash::make($request->password)]);

        return back()->with('success', 'Password updated successfully.');
    }

    public function testEmail(Request $request, string $type)
    {
        $to = config('mail.from.address');

        try {
            switch ($type) {
                case 'application-confirmation':
                    $app = Application::latest()->first() ?? new Application([
                        'full_name' => 'Test User',
                        'email' => $to,
                        'age' => 30,
                        'country' => 'Bulgaria',
                        'current_state' => 'This is a test application.',
                        'why_now' => 'Testing the email system.',
                        'previous_experience' => 'Test experience.',
                        'twelve_month_goal' => 'Test goal.',
                        'commitment' => 'yes',
                        'investment' => '1000_2500',
                        'booking_token' => 'test-token-123',
                    ]);
                    Mail::to($to)->send(new ApplicationConfirmation($app));
                    break;

                case 'contact-auto-reply':
                    $contact = Contact::latest()->first() ?? new Contact([
                        'name' => 'Test User',
                        'email' => $to,
                        'message' => 'This is a test contact message to verify the email template.',
                    ]);
                    Mail::to($to)->send(new ContactAutoReply($contact));
                    break;

                case 'admin-new-application':
                    $app = Application::latest()->first() ?? new Application([
                        'full_name' => 'Test User',
                        'email' => $to,
                        'age' => 30,
                        'country' => 'Bulgaria',
                        'current_state' => 'This is a test application.',
                        'why_now' => 'Testing the email system.',
                        'previous_experience' => 'Test experience.',
                        'twelve_month_goal' => 'Test goal.',
                        'commitment' => 'yes',
                        'investment' => '1000_2500',
                        'booking_token' => 'test-token-123',
                    ]);
                    Mail::to($to)->send(new AdminNewApplication($app));
                    break;

                case 'admin-new-contact':
                    $contact = Contact::latest()->first() ?? new Contact([
                        'name' => 'Test User',
                        'email' => $to,
                        'message' => 'This is a test contact message to verify the email template.',
                    ]);
                    Mail::to($to)->send(new AdminNewContact($contact));
                    break;

                case 'booking-confirmation':
                    $app = Application::latest()->first() ?? new Application([
                        'full_name' => 'Test User',
                        'email' => $to,
                        'booking_token' => 'test-token-123',
                    ]);
                    $booking = Booking::latest()->first() ?? new Booking([
                        'date' => now()->addDays(3)->toDateString(),
                        'start_time' => '10:00:00',
                    ]);
                    $meetLink = config('services.google.meet_link', 'https://meet.google.com');
                    Mail::to($to)->send(new BookingConfirmation($booking, $app, $meetLink));
                    break;

                default:
                    return back()->with('error', 'Unknown email type.');
            }

            return back()->with('success', "Test email ({$type}) sent to {$to}.");
        } catch (\Exception $e) {
            return back()->with('error', 'Email failed: ' . $e->getMessage());
        }
    }
}
