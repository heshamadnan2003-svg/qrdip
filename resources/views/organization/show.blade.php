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
                    <p>📍 <strong>{{ __('messages.address') }}:</strong> {{ $organization->address }}</p>
                @endif

                @if($organization->contact_phone)
                    <p>📞 <strong>{{ __('messages.phone') }}:</strong> {{ $organization->contact_phone }}</p>
                @endif

                @if($organization->contact_email)
                    <p>✉️ <strong>{{ __('messages.email') }}:</strong> {{ $organization->contact_email }}</p>
                @endif

                @if($organization->reviews->count())
                    <p>
                        ⭐ {{ number_format($organization->reviews->avg('rating'), 1) }}
                        ({{ $organization->reviews->count() }} {{ __('messages.reviews') }})
                    </p>
                @else
                    <p class="text-muted">
                        {{ __('messages.no_reviews') }}
                    </p>
                @endif
            </div>

            <div class="d-grid mt-4 gap-2">
                <a href="{{ route('org.services', $organization->slug) }}"
                   class="btn btn-primary btn-lg">
                    🔔 {{ __('messages.book_now') }}
                </a>

                <button type="button"
                        class="btn btn-outline-secondary"
                        data-bs-toggle="modal"
                        data-bs-target="#myBookingsModal">
                    📅 عرض حجوزاتي السابقة
                </button>
            </div>

        </div>
    </div>

</div>

{{-- Modal عرض الحجوزات السابقة --}}
<div class="modal fade" id="myBookingsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <form method="POST"
                  action="{{ route('public.bookings.lookup') }}">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">🔍 عرض حجوزاتي السابقة</h5>
                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>

                <div class="modal-body text-start">

                    <input type="hidden"
                           name="organization_id"
                           value="{{ $organization->id }}">

                    <div class="mb-3">
                        <label class="form-label">الاسم</label>
                        <input type="text"
                               name="customer_name"
                               class="form-control"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">البريد الإلكتروني</label>
                        <input type="email"
                               name="customer_email"
                               class="form-control"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">كلمة المرور</label>
                        <input type="password"
                               name="password"
                               class="form-control"
                               required>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit"
                            class="btn btn-primary w-100">
                        عرض الحجوزات
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection
