@extends('layouts.app')

@section('content')
<div class="container">

    <h3 class="mb-4">
        ✂️ {{ __('messages.services') }} {{ $organization->name }}
    </h3>

    <div class="row">
        @forelse($organization->services as $service)
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-body">

                        <h5>{{ $service->name }}</h5>

                        <p class="text-muted">
                            {{ __('messages.service_duration') }}:
                            {{ $service->duration }}
                            {{ __('messages.minutes') }}
                        </p>

                        <p class="fw-bold">
                            {{ __('messages.price') }}:
                            {{ $service->price }}
                            {{ __('messages.currency') }}
                        </p>

                        <a href="#"
                           class="btn btn-primary w-100">
                            {{ __('messages.select_service') }}
                        </a>

                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">
                {{ __('messages.no_services') }}
            </p>
        @endforelse
    </div>

</div>
@endsection
