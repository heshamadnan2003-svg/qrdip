@extends('layouts.app')

@section('content')
<div class="container">

    <h3 class="mb-4 text-center">
        👤 {{ __('messages.manager_details') }}
    </h3>

    {{-- بيانات المدير --}}
    <div class="card mb-4">
        <div class="card-header fw-bold">
            {{ __('messages.account_info') }}
        </div>

        <div class="card-body">
            <p><strong>{{ __('messages.name') }}:</strong> {{ $user->name }}</p>
            <p><strong>{{ __('messages.email') }}:</strong> {{ $user->email }}</p>
            <p><strong>{{ __('messages.role') }}:</strong> {{ ucfirst($user->role) }}</p>
            <p><strong>{{ __('messages.registered_at') }}:</strong>
                {{ $user->created_at->format('Y-m-d') }}
            </p>
            <p>
                <strong>{{ __('messages.status') }}:</strong>
                @if($user->is_active)
                    <span class="badge bg-success">
                        {{ __('messages.active') }}
                    </span>
                @else
                    <span class="badge bg-danger">
                        {{ __('messages.inactive') }}
                    </span>
                @endif
            </p>
        </div>
    </div>

    {{-- بيانات الشركة --}}
    @if($user->organization)

        <div class="card mb-4">
            <div class="card-header fw-bold">
                🏢 {{ __('messages.company_info') }}
            </div>
            <div class="card-body">
                <p>
                    <strong>{{ __('messages.company_name') }}:</strong>
                    {{ $user->organization->name }}
                </p>
                <p>
                    <strong>{{ __('messages.description') }}:</strong>
                    {{ $user->organization->description ?? '-' }}
                </p>
            </div>
        </div>

        {{-- الخدمات --}}
        <div class="card mb-4">
            <div class="card-header fw-bold">
                🛠 {{ __('messages.services') }}
            </div>
            <div class="card-body">
                @forelse($user->organization->services as $service)
                    <p>
                        {{ $service->name }} —
                        {{ $service->price }} {{ __('messages.currency') }}
                        ({{ $service->duration }} {{ __('messages.minutes') }})
                    </p>
                @empty
                    <p class="text-muted">
                        {{ __('messages.no_services') }}
                    </p>
                @endforelse
            </div>
        </div>

        {{-- الحجوزات --}}
        <div class="card mb-4">
            <div class="card-header fw-bold">
                📅 {{ __('messages.bookings') }}
            </div>

            @if($user->organization->bookings->isEmpty())
                <div class="card-body text-muted">
                    {{ __('messages.no_bookings') }}
                </div>
            @else
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>{{ __('messages.customer') }}</th>
                            <th>{{ __('messages.phone') }}</th>
                            <th>{{ __('messages.service') }}</th>
                            <th>{{ __('messages.date') }}</th>
                            <th>{{ __('messages.time') }}</th>
                            <th>{{ __('messages.status') }}</th>
                            <th>{{ __('messages.actions') }}</th>
                        </tr>
                    </thead>

                    <tbody>
                    @foreach($user->organization->bookings as $booking)
                        <tr>
                            <td>{{ $booking->customer_name }}</td>
                            <td>{{ $booking->customer_phone }}</td>
                            <td>{{ $booking->service->name ?? '-' }}</td>
                            <td>{{ $booking->booking_date }}</td>
                            <td>{{ substr($booking->start_time, 0, 5) }}</td>

                            <td>
                                <span class="badge bg-secondary">
                                    {{ $booking->status }}
                                </span>
                            </td>

                            {{-- إجراءات الأدمن على الزبون --}}
                            <td>
                                <div class="d-flex flex-column gap-1">

                                    {{-- حظر الزبون --}}
                                    <form method="POST"
                                          action="{{ route('admin.customers.block', ['booking' => $booking->id]) }}">
                                        @csrf
                                        @method('PATCH')

                                        <button class="btn btn-warning btn-sm w-100">
                                            🚫 {{ __('messages.block_customer') }}
                                        </button>
                                    </form>

                                    {{-- حذف الحجز --}}
                                    <form method="POST"
                                          action="{{ route('admin.customers.delete', ['booking' => $booking->id]) }}"
                                          onsubmit="return confirm('{{ __('messages.confirm_delete') }}')">
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-danger btn-sm w-100">
                                            🗑 {{ __('messages.delete_customer') }}
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    @endif

    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
        ⬅ {{ __('messages.back') }}
    </a>

</div>
@endsection
