@extends('layouts.app')

@section('content')
<div class="container py-5" style="max-width:600px">

    <div class="card shadow-sm">
        <div class="card-body text-center">

            <h2 class="fw-bold mb-2">
                {{ $organization->name }}
            </h2>

            @if($organization->category)
                <span class="badge bg-secondary mb-3">
                    {{ $organization->category }}
                </span>
            @endif

            @if($organization->description)
                <p class="text-muted mt-3">
                    {{ $organization->description }}
                </p>
            @endif

            <hr>

            <div class="{{ app()->getLocale() === 'ar' ? 'text-end' : 'text-start' }}">
                @if($organization->address)
                    <p>
                        📍 <strong>{{ __('messages.address') }}:</strong>
                        {{ $organization->address }}
                    </p>
                @endif

                @if($organization->contact_phone)
                    <p>
                        📞 <strong>{{ __('messages.phone') }}:</strong>
                        {{ $organization->contact_phone }}
                    </p>
                @endif

                @if($organization->contact_email)
                    <p>
                        ✉️ <strong>{{ __('messages.email') }}:</strong>
                        {{ $organization->contact_email }}
                    </p>
                @endif
            </div>

            <div class="d-grid mt-4">
                <a href="{{ route('org.services', $organization->slug) }}"
                   class="btn btn-primary btn-lg">
                    🔔 {{ __('messages.book_now') }}
                </a>
            </div>

        </div>
    </div>

</div>
@endsection
