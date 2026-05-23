@extends('emails.layout', ['subject' => 'Call Booked — Apex Human'])

@section('content')
    <h2>Your call is booked.</h2>

    <p>{{ $application->full_name }},</p>

    <p>You're one step closer. Here are your call details:</p>

    <div class="detail-box">
        <p>
            <span class="detail-label">Date</span>
            <span class="detail-value">{{ \Carbon\Carbon::parse($booking->date)->format('l, F j, Y') }}</span>
        </p>
        <p>
            <span class="detail-label">Time</span>
            <span class="detail-value">{{ \Carbon\Carbon::parse($booking->start_time)->format('g:i A') }} UTC</span>
        </p>
    </div>

    <p>Join the call using the link below at your scheduled time:</p>

    <a href="{{ $meetLink }}" class="cta-button">Join Google Meet &rarr;</a>

    <p style="font-size: 13px; color: #8A8478; margin-top: 32px;">If you need to reschedule, reply to this email at least 24 hours before your call.</p>
@endsection
