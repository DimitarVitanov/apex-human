<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AvailableSlot;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;

class SlotController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->get('month', now()->format('Y-m'));
        $start = Carbon::parse($month . '-01')->startOfMonth();
        $end = $start->copy()->endOfMonth();

        $slots = AvailableSlot::whereBetween('date', [$start, $end])
            ->orderBy('date')
            ->orderBy('start_time')
            ->get()
            ->map(function ($slot) {
                $slot->is_booked = $slot->isBooked();
                return $slot;
            });

        return Inertia::render('Admin/Slots/Index', [
            'slots' => $slots,
            'month' => $start->format('Y-m'),
        ]);
    }

    public function generate(Request $request)
    {
        $data = $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'days' => 'required|array|min:1',
            'days.*' => 'integer|between:1,7',
            'start_hour' => 'required|integer|between:0,23',
            'end_hour' => 'required|integer|between:1,23|gt:start_hour',
            'slot_duration' => 'required|integer|in:30,60',
            'buffer_minutes' => 'required|integer|in:0,15,30,60',
        ]);

        $start = Carbon::parse($data['start_date']);
        $end = Carbon::parse($data['end_date']);
        $created = 0;

        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            if (!in_array($date->dayOfWeekIso, $data['days'])) continue;

            for ($hour = $data['start_hour']; $hour < $data['end_hour']; $hour++) {
                $slotStart = sprintf('%02d:00', $hour);
                $slotEnd = sprintf('%02d:%02d', $hour, $data['slot_duration']);

                if ($data['slot_duration'] === 60) {
                    $slotEnd = sprintf('%02d:00', $hour + 1);
                }

                $existing = AvailableSlot::where('date', $date->format('Y-m-d'))
                    ->where('start_time', $slotStart)
                    ->exists();

                if (!$existing) {
                    AvailableSlot::create([
                        'date' => $date->format('Y-m-d'),
                        'start_time' => $slotStart,
                        'end_time' => $slotEnd,
                    ]);
                    $created++;
                }

                if ($data['slot_duration'] === 30 && $data['buffer_minutes'] === 0) {
                    $halfSlotStart = sprintf('%02d:30', $hour);
                    $halfSlotEnd = sprintf('%02d:00', $hour + 1);

                    $existing2 = AvailableSlot::where('date', $date->format('Y-m-d'))
                        ->where('start_time', $halfSlotStart)
                        ->exists();

                    if (!$existing2) {
                        AvailableSlot::create([
                            'date' => $date->format('Y-m-d'),
                            'start_time' => $halfSlotStart,
                            'end_time' => $halfSlotEnd,
                        ]);
                        $created++;
                    }
                }
            }
        }

        return back()->with('success', "{$created} slots created.");
    }

    public function toggleBlock(AvailableSlot $slot)
    {
        if ($slot->isBooked()) {
            return back()->with('error', 'Cannot block a slot that has a booking.');
        }

        $slot->update(['is_blocked' => !$slot->is_blocked]);

        return back()->with('success', $slot->is_blocked ? 'Slot blocked.' : 'Slot unblocked.');
    }

    public function destroy(AvailableSlot $slot)
    {
        if ($slot->isBooked()) {
            return back()->with('error', 'Cannot delete a slot that has a booking.');
        }

        $slot->delete();

        return back()->with('success', 'Slot deleted.');
    }
}
