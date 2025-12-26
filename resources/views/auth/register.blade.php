@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center">
    <div class="auth-card w-100" style="max-width: 460px">

        <h3 class="auth-title text-center">
            📝 {{ __('messages.register_title') }}
        </h3>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">
                    {{ __('messages.customer_name') }}
                </label>
                <input type="text"
                       name="name"
                       class="form-control"
                       placeholder="{{ __('messages.placeholder_customer_name') }}"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">
                    {{ __('messages.customer_email') }}
                </label>
                <input type="email"
                       name="email"
                       class="form-control"
                       placeholder="{{ __('messages.placeholder_customer_email') }}"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">
                    {{ __('messages.password') }}
                </label>
                <input type="password"
                       name="password"
                       class="form-control"
                       placeholder="{{ __('messages.placeholder_password') }}"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">
                    {{ __('messages.password_confirmation') }}
                </label>
                <input type="password"
                       name="password_confirmation"
                       class="form-control"
                       placeholder="{{ __('messages.placeholder_password_confirmation') }}"
                       required>
            </div>

            <button class="btn btn-primary w-100 mb-3">
                {{ __('messages.register') }}
            </button>

            <div class="text-center">
                <a href="{{ route('login') }}" class="auth-link">
                    {{ __('messages.have_account_login') }}
                </a>
            </div>
        </form>

    </div>
</div>
@endsection
