@extends('emails.layout', ['subject' => 'We Got Your Message — Apex Human'])

@section('content')
    <h2>Thank you for reaching out.</h2>

    <p>{{ $contact->name }},</p>

    <p>We've received your message and will get back to you as soon as possible.</p>

    <div class="detail-box">
        <p>
            <span class="detail-label">Your Message</span>
            <span class="detail-value">{{ Str::limit($contact->message, 200) }}</span>
        </p>
    </div>

    <p>In the meantime, if you're ready to start your transformation, you can apply directly:</p>

    <a href="https://apexhuman.co/apply" class="cta-button">Apply for Coaching &rarr;</a>

    <p style="font-size: 13px; color: #8A8478; margin-top: 32px;">This is an automated confirmation. A real human will follow up shortly.</p>
@endsection
