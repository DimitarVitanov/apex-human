@extends('emails.layout', ['subject' => __('email.booking.subject')])

@section('content')
    <h2>{{ __('email.booking.heading') }}</h2>

    <p>{{ $application->full_name }},</p>

    <p>{{ __('email.booking.intro') }}</p>

    <div class="detail-box">
        <p>
            <span class="detail-label">{{ __('email.booking.date_label') }}</span>
            <span class="detail-value">{{ \Carbon\Carbon::parse($booking->date)->locale(app()->getLocale())->translatedFormat(__('email.booking.date_format')) }}</span>
        </p>
        <p>
            <span class="detail-label">{{ __('email.booking.time_label') }}</span>
            <span class="detail-value">{{ \Carbon\Carbon::parse($booking->start_time)->format(__('email.booking.time_format')) }} UTC</span>
        </p>
    </div>

    <p>{{ __('email.booking.join_instruction') }}</p>

    <a href="{{ $meetLink }}" class="cta-button">{{ __('email.booking.cta') }} &rarr;</a>

    <p style="font-size: 13px; color: #8A8478; margin-top: 32px;">{{ __('email.booking.reschedule') }}</p>
@endsection
