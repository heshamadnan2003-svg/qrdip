@extends('layouts.app')

@section('content')
<div class="container" style="max-width:500px">

    <h3 class="mb-4 text-center">
        🛡 {{ __('messages.add_new_admin') }}
    </h3>

    <form method="POST" action="{{ route('admin.admins.store') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">{{ __('messages.name') }}</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">{{ __('messages.email') }}</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">{{ __('messages.password') }}</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">{{ __('messages.confirm_password') }}</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <button class="btn btn-danger w-100">
            ➕ {{ __('messages.add_admin') }}
        </button>
    </form>

</div>
@endsection
