@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center">
    <div class="auth-card w-100" style="max-width: 420px">

        <h3 class="auth-title text-center">
            🔐 {{ __('messages.login_title') }}
        </h3>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">
                    {{ __('messages.customer_email') }}
                </label>
                <input type="email"
                       name="email"
                       class="form-control"
                       placeholder="{{ __('messages.placeholder_customer_email') }}"
                       required
                       autofocus>
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

            <button class="btn btn-primary w-100 mb-3">
                {{ __('messages.login') }}
            </button>

            <div class="text-center">
                <a href="{{ route('register') }}" class="auth-link">
                    {{ __('messages.no_account_register') }}
                </a>
            </div>
        </form>

    </div>
</div>
@endsection
