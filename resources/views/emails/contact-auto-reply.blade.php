@extends('emails.layout', ['subject' => __('email.contact.subject')])

@section('content')
    <h2>{{ __('email.contact.heading') }}</h2>

    <p>{{ $contact->name }},</p>

    <p>{{ __('email.contact.received') }}</p>

    <div class="detail-box">
        <p>
            <span class="detail-label">{{ __('email.contact.your_message_label') }}</span>
            <span class="detail-value">{{ Str::limit($contact->message, 200) }}</span>
        </p>
    </div>

    <p>{{ __('email.contact.meantime') }}</p>

    <a href="https://apexhuman.co/apply" class="cta-button">{{ __('email.contact.cta') }} &rarr;</a>

    <p style="font-size: 13px; color: #8A8478; margin-top: 32px;">{{ __('email.contact.automated') }}</p>
@endsection
