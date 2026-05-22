<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\AvailableSlot;
use App\Models\Booking;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function show(Request $request)
    {
        $token = $request->query('token');

        if (!$token) {
            abort(404);
        }

        $application = Application::where('booking_token', $token)->firstOrFail();

        if ($application->booking) {
            return Inertia::render('BookingConfirmation', [
                'booking' => $application->booking,
                'application' => $application->only('full_name', 'email'),
            ]);
        }

        return Inertia::render('Booking', [
            'token' => $token,
            'applicantName' => $application->full_name,
        ]);
    }

    public function availableSlots(Request $request)
    {
        $token = $request->query('token');

        if (!$token) {
            return response()->json([], 403);
        }

        Application::where('booking_token', $token)->firstOrFail();

        $month = $request->query('month', now()->format('Y-m'));
        $start = Carbon::parse($month . '-01')->startOfMonth();
        $end = $start->copy()->endOfMonth();

        $slots = AvailableSlot::whereBetween('date', [$start, $end])
            ->where('is_blocked', false)
            ->whereDoesntHave('booking')
            ->where('date', '>=', now()->toDateString())
            ->orderBy('date')
            ->orderBy('start_time')
            ->get(['id', 'date', 'start_time', 'end_time']);

        return response()->json($slots);
    }

    public function book(Request $request)
    {
        $data = $request->validate([
            'token' => 'required|string',
            'slot_id' => 'required|exists:available_slots,id',
        ]);

        $application = Application::where('booking_token', $data['token'])->firstOrFail();

        if ($application->booking) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'You have already booked a call.'], 422);
            }
            return back()->with('error', 'You have already booked a call.');
        }

        $slot = AvailableSlot::where('id', $data['slot_id'])
            ->where('is_blocked', false)
            ->firstOrFail();

        if ($slot->isBooked()) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'This slot has already been taken. Please choose another.'], 422);
            }
            return back()->with('error', 'This slot has already been taken. Please choose another.');
        }

        $booking = Booking::create([
            'application_id' => $application->id,
            'available_slot_id' => $slot->id,
            'date' => $slot->date,
            'start_time' => $slot->start_time,
        ]);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'booking' => $booking]);
        }

        return redirect()->route('booking.show', ['token' => $data['token']]);
    }
}
