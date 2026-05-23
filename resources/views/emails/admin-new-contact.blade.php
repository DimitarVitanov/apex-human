@extends('emails.layout', ['subject' => 'New Contact — ' . $contact->name])

@section('content')
    <h2>New Contact Message</h2>

    <div class="detail-box">
        <p>
            <span class="detail-label">Name</span>
            <span class="detail-value">{{ $contact->name }}</span>
        </p>
        <p>
            <span class="detail-label">Email</span>
            <span class="detail-value">{{ $contact->email }}</span>
        </p>
    </div>

    <p><strong class="highlight">Message:</strong></p>
    <p>{{ $contact->message }}</p>

    <a href="https://apexhuman.co/admin/contacts/{{ $contact->id }}" class="cta-button">View in Admin &rarr;</a>
@endsection
