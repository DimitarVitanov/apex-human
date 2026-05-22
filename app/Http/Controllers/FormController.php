<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Contact;
use Illuminate\Http\Request;

class FormController extends Controller
{
    public function submitApplication(Request $request)
    {
        $data = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'age' => 'required|integer|min:18|max:100',
            'country' => 'required|string|max:100',
            'current_state' => 'required|string|min:20|max:5000',
            'why_now' => 'required|string|min:20|max:5000',
            'previous_experience' => 'required|string|min:20|max:5000',
            'twelve_month_goal' => 'required|string|min:20|max:5000',
            'commitment' => 'required|string|in:yes,need_to_think,no',
            'investment' => 'required|string|in:under_500,500_1000,1000_2500,2500_plus,discuss_on_call',
        ]);

        $data['booking_token'] = bin2hex(random_bytes(32));
        $data['status'] = 'pending';

        $application = Application::create($data);

        return back()->with('success', true)->with('booking_token', $application->booking_token);
    }

    public function submitContact(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:5000',
        ]);

        Contact::create($data);

        return back()->with('success', "Message sent. We'll respond within 48 hours.");
    }
}
