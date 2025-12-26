@extends('layouts.app')

@section('content')
<div class="container">

    <h2 class="mb-4">
        👋 {{ __('messages.home_welcome') }}
        {{ auth()->user()->name }}
    </h2>

    {{-- إذا لم يكن لديه مؤسسة --}}
    @if(!auth()->user()->organization)
        <div class="card">
            <div class="card-body text-center">
                <p class="mb-3">
                    {{ __('messages.home_regular_user') }}
                </p>

                <a href="{{ route('provider.apply') }}"
                   class="btn btn-primary btn-lg">
                    ✂️ {{ __('messages.become_provider') }}
                </a>
            </div>
        </div>
    @endif

    {{-- إذا كان مقدم خدمة --}}
    @if(auth()->user()->organization)
        <div class="card">
            <div class="card-body text-center">
                <h4 class="mb-3">
                    🧑‍💼 {{ __('messages.provider_dashboard_title') }}
                </h4>

                <a href="{{ route('manager.dashboard') }}"
                   class="btn btn-success mb-2">
                    📊 {{ __('messages.dashboard') }}
                </a>

                <br>

                <a href="{{ route('organization.show', auth()->user()->organization->slug) }}"
                   target="_blank"
                   class="btn btn-outline-primary">
                    🌍 {{ __('messages.open_public_page') }}
                </a>
            </div>
        </div>
    @endif

</div>
@endsection
