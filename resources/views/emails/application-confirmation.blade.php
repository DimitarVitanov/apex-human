@extends('emails.layout', ['subject' => __('email.application.subject')])

@section('content')
    <h2>{{ __('email.application.heading') }}</h2>

    <p>{{ $application->full_name }},</p>

    <p>{{ __('email.application.thanks') }}</p>

    <div class="detail-box">
        <p>
            <span class="detail-label">{{ __('email.application.next_step_label') }}</span>
            <span class="detail-value">{{ __('email.application.next_step_value') }}</span>
        </p>
    </div>

    <p>{{ __('email.application.call_purpose') }}</p>

    <a href="{{ $bookingUrl }}" class="cta-button">{{ __('email.application.cta') }} &rarr;</a>

    <p style="font-size: 13px; color: #8A8478; margin-top: 32px;">{{ __('email.application.questions') }}</p>
@endsection
