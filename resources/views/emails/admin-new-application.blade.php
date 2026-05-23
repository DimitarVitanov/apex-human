@extends('emails.layout', ['subject' => 'New Application — ' . $application->full_name])

@section('content')
    <h2>New Application Received</h2>

    <div class="detail-box">
        <p>
            <span class="detail-label">Name</span>
            <span class="detail-value">{{ $application->full_name }}</span>
        </p>
        <p>
            <span class="detail-label">Email</span>
            <span class="detail-value">{{ $application->email }}</span>
        </p>
        <p>
            <span class="detail-label">Age</span>
            <span class="detail-value">{{ $application->age }}</span>
        </p>
        <p>
            <span class="detail-label">Country</span>
            <span class="detail-value">{{ $application->country }}</span>
        </p>
        <p>
            <span class="detail-label">Commitment</span>
            <span class="detail-value">{{ $application->commitment }}</span>
        </p>
        <p>
            <span class="detail-label">Investment</span>
            <span class="detail-value">{{ $application->investment }}</span>
        </p>
    </div>

    <p><strong class="highlight">Current State:</strong><br>{{ $application->current_state }}</p>
    <p><strong class="highlight">Why Now:</strong><br>{{ $application->why_now }}</p>
    <p><strong class="highlight">Previous Experience:</strong><br>{{ $application->previous_experience }}</p>
    <p><strong class="highlight">12-Month Goal:</strong><br>{{ $application->twelve_month_goal }}</p>

    <a href="https://apexhuman.co/admin/applications/{{ $application->id }}" class="cta-button">View in Admin &rarr;</a>
@endsection
