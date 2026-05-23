@extends('emails.layout', ['subject' => 'Application Received — Apex Human'])

@section('content')
    <h2>Your application has been received.</h2>

    <p>{{ $application->full_name }},</p>

    <p>Thank you for taking the first step. We've received your application and our team is reviewing it now.</p>

    <div class="detail-box">
        <p>
            <span class="detail-label">Next Step</span>
            <span class="detail-value">Book your free strategy call</span>
        </p>
    </div>

    <p>This call is where we learn about your goals, assess your current state, and determine if the Apex system is the right fit for you.</p>

    <a href="{{ $bookingUrl }}" class="cta-button">Book Your Call &rarr;</a>

    <p style="font-size: 13px; color: #8A8478; margin-top: 32px;">If you have any questions before your call, reply directly to this email.</p>
@endsection
