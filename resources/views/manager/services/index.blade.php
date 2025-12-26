@extends('layouts.app')

@section('content')

<h3 class="mb-4">
    {{ __('messages.my_services') }}
</h3>

@if(session()->has('success'))
    <div class="alert alert-success">
        {{ __('messages.success_saved') }}
    </div>
@endif

<div class="card mb-4">
    <div class="card-header">
        {{ __('messages.add_new_service') }}
    </div>
    <div class="card-body">

        <form method="POST" action="{{ route('manager.services.store') }}">
            @csrf

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label>{{ __('messages.service_name') }}</label>
                    <input type="text"
                           name="name"
                           class="form-control"
                           placeholder="{{ __('messages.placeholder_service_name') }}"
                           required>
                </div>

                <div class="col-md-4 mb-3">
                    <label>{{ __('messages.service_price') }}</label>
                    <input type="number"
                           name="price"
                           class="form-control"
                           placeholder="{{ __('messages.placeholder_service_price') }}"
                           required>
                </div>

                <div class="col-md-4 mb-3">
                    <label>{{ __('messages.service_duration_minutes') }}</label>
                    <input type="number"
                           name="duration"
                           class="form-control"
                           placeholder="{{ __('messages.placeholder_service_duration') }}"
                           required>
                </div>
            </div>

            <button class="btn btn-primary">
                {{ __('messages.add') }}
            </button>
        </form>

    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ __('messages.current_services') }}
    </div>
    <div class="card-body">

        @if($services->count())
            <table class="table table-bordered align-middle
                {{ app()->getLocale() === 'ar' ? 'text-center' : 'text-start' }}">
                <thead>
                    <tr>
                        <th>{{ __('messages.service') }}</th>
                        <th>{{ __('messages.service_price') }}</th>
                        <th>{{ __('messages.service_duration') }}</th>
                        <th>{{ __('messages.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($services as $service)
                        <tr>
                            <td>
                                <form method="POST" action="{{ route('manager.services.update', $service) }}">
                                    @csrf
                                    @method('PUT')

                                    <input type="text"
                                           name="name"
                                           value="{{ $service->name }}"
                                           class="form-control mb-1">

                            </td>

                            <td>
                                    <input type="number"
                                           name="price"
                                           step="0.01"
                                           value="{{ $service->price }}"
                                           class="form-control mb-1">
                            </td>

                            <td>
                                    <input type="number"
                                           name="duration"
                                           value="{{ $service->duration }}"
                                           class="form-control mb-1">
                            </td>

                            <td class="d-flex gap-2 justify-content-center">
                                    <button class="btn btn-success btn-sm">
                                        💾 {{ __('messages.save') }}
                                    </button>
                                </form>

                                <form method="POST"
                                      action="{{ route('manager.services.destroy', $service) }}"
                                      onsubmit="return confirm('{{ __('messages.confirm_delete_service') }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">
                                        🗑️ {{ __('messages.delete') }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-muted">
                {{ __('messages.no_services') }}
            </p>
        @endif

    </div>
</div>

@endsection
