@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row align-items-center mb-5">

        {{-- النص الرئيسي --}}
        <div class="col-md-6 mb-4">
            <h1 class="fw-bold mb-3">
                {{ __('messages.welcome_title') }}
                <span class="text-primary">{{ __('messages.app_name') }}</span>
            </h1>

            <p class="text-muted fs-5 mb-4">
                {{ __('messages.welcome_description') }}
            </p>

            <div class="d-flex gap-3 flex-wrap">
                @auth
                    <a href="{{ route('home') }}" class="btn btn-success btn-lg">
                        {{ __('messages.go_to_dashboard') }}
                    </a>
                @endauth
            </div>
        </div>

        {{-- صورة --}}
        <div class="text-center my-5">
    <img src="{{ asset('images/qrdip-logo.png') }}"
         alt="QRDIP Logo"
         class="mb-4"
         style="max-width:520px; width:100%;">

    <h1 class="fw-bold">
        {{ __('messages.app_name') }}
    </h1>

    <p class="text-muted mt-2">
        {{ __('messages.app_tagline') }}
    </p>
</div>


    </div>

    {{-- شرح طريقة العمل --}}
    <div class="row text-center">

        <h3 class="section-title mb-4">
            {{ __('messages.how_it_works_title') }}
        </h3>

        <div class="col-md-3 mb-4">
            <div class="ui-card h-100">
                <h5 class="mb-2">
                    📝 {{ __('messages.how_step_register_title') }}
                </h5>
                <p class="text-muted mb-0">
                    {{ __('messages.how_step_register_desc') }}
                </p>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="ui-card h-100">
                <h5 class="mb-2">
                    ⚙️ {{ __('messages.how_step_page_title') }}
                </h5>
                <p class="text-muted mb-0">
                    {{ __('messages.how_step_page_desc') }}
                </p>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="ui-card h-100">
                <h5 class="mb-2">
                    📱 {{ __('messages.how_step_scan_title') }}
                </h5>
                <p class="text-muted mb-0">
                    {{ __('messages.how_step_scan_desc') }}
                </p>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="ui-card h-100">
                <h5 class="mb-2">
                    ✅ {{ __('messages.how_step_booking_title') }}
                </h5>
                <p class="text-muted mb-0">
                    {{ __('messages.how_step_booking_desc') }}
                </p>
            </div>
        </div>

    </div>

</div>
@endsection
