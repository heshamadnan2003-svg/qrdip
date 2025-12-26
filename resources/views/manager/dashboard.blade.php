@extends('layouts.app')

@section('content')
<div class="container position-relative">

    {{-- زر المينيو --}}
    <button
        class="btn btn-light border position-absolute"
        style="top: 20px; {{ app()->getLocale() === 'ar' ? 'left:20px' : 'right:20px' }}"
        data-bs-toggle="offcanvas"
        data-bs-target="#managerMenu">
        ☰
    </button>

    <div class="mt-5 pt-5">

        <h3 class="fw-bold text-center mb-4">
            {{ __('messages.manager_dashboard') }}
        </h3>

        {{-- الإحصائيات --}}
        @if(isset($stats))
            <div class="row mb-4 text-center">

                <div class="col-md-3 mb-3">
                    <div class="dashboard-card today">
                        <div class="icon">📅</div>
                        <div class="label">{{ __('messages.today') }}</div>
                        <div class="value">{{ $stats['today'] }}</div>
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <div class="dashboard-card week">
                        <div class="icon">📆</div>
                        <div class="label">{{ __('messages.this_week') }}</div>
                        <div class="value">{{ $stats['week'] }}</div>
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <div class="dashboard-card month">
                        <div class="icon">📈</div>
                        <div class="label">{{ __('messages.this_month') }}</div>
                        <div class="value">{{ $stats['month'] }}</div>
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <div class="dashboard-card cancelled">
                        <div class="icon">❌</div>
                        <div class="label">{{ __('messages.cancelled') }}</div>
                        <div class="value">{{ $stats['cancelled'] }}</div>
                    </div>
                </div>

            </div>
        @endif

        @if($organization)

            {{-- QR Code --}}
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">

                    <h5 class="mb-3">
                        📷 {{ __('messages.your_qr_code') }}
                    </h5>

                    {!! QrCode::format('svg')
                        ->size(220)
                        ->generate(route('org.show', $organization->slug)) !!}

                    <a href="{{ route('org.show', $organization->slug) }}"
                       target="_blank"
                       class="btn btn-primary w-100 mt-3">
                        🌍 {{ __('messages.open_public_page') }}
                    </a>

                </div>
            </div>

            {{-- معلومات الشركة --}}
            <div class="card shadow-sm mx-auto mb-4" style="max-width: 600px">
                <div class="card-body {{ app()->getLocale() === 'ar' ? 'text-end' : 'text-start' }}">

                    <h5 class="fw-bold mb-2">
                        🏢 {{ $organization->name }}
                    </h5>

                    @if($organization->description)
                        <p class="text-muted mb-3">
                            {{ $organization->description }}
                        </p>
                    @endif

                    <hr>

                    <div class="row g-2 small">

                        @if($organization->category)
                            <div class="col-12">
                                🏷 <strong>{{ __('messages.category') }}:</strong>
                                {{ $organization->category }}
                            </div>
                        @endif

                        @if($organization->contact_phone)
                            <div class="col-12">
                                📞 <strong>{{ __('messages.phone') }}:</strong>
                                {{ $organization->contact_phone }}
                            </div>
                        @endif

                        @if($organization->contact_email)
                            <div class="col-12">
                                ✉️ <strong>{{ __('messages.email') }}:</strong>
                                {{ $organization->contact_email }}
                            </div>
                        @endif

                        @if($organization->address)
                            <div class="col-12">
                                📍 <strong>{{ __('messages.address') }}:</strong>
                                {{ $organization->address }}
                            </div>
                        @endif

                    </div>

                </div>
            </div>

        @else
            <div class="alert alert-warning text-center">
                {{ __('messages.no_company_attached') }}
            </div>
        @endif

    </div>
</div>

{{-- Offcanvas Menu --}}
<div class="offcanvas offcanvas-end" tabindex="-1" id="managerMenu">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">
            ☰ {{ __('messages.management_menu') }}
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body">

        {{-- الشركة --}}
        @if($organization)
            <a href="{{ route('manager.onboarding.company') }}"
               class="btn btn-outline-primary w-100 mb-3">
                ✏️ {{ __('messages.edit_company_info') }}
            </a>
        @endif

        <hr>

        {{-- التنقل --}}
        <a href="{{ route('manager.services') }}"
           class="btn btn-outline-secondary w-100 mb-2">
            ✂️ {{ __('messages.services') }}
        </a>

        <a href="{{ route('manager.working-hours') }}"
           class="btn btn-outline-secondary w-100 mb-2">
            🕒 {{ __('messages.working_hours') }}
        </a>

        <a href="{{ route('manager.bookings') }}"
           class="btn btn-outline-secondary w-100 mb-3">
            📅 {{ __('messages.bookings') }}
        </a>

        <hr>

        {{-- اللغة --}}
        <a href="{{ route('lang.switch', 'ar') }}"
           class="btn btn-outline-secondary w-100 mb-2">
            🇸🇦 {{ __('messages.language_ar') }}
        </a>

        <a href="{{ route('lang.switch', 'en') }}"
           class="btn btn-outline-secondary w-100 mb-3">
            🇺🇸 {{ __('messages.language_en') }}
        </a>

        <hr>

        {{-- تسجيل الخروج --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-danger w-100">
                🚪 {{ __('messages.logout') }}
            </button>
        </form>

    </div>
</div>
@endsection
