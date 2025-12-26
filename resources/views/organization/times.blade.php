@extends('layouts.app')

@section('content')
<div class="container text-center">

    <h3 class="mb-3">
        🕒 {{ __('messages.select_service_time') }}
    </h3>

    <p class="mb-4">
        {{ $organization->name }} <br>
        {{ __('messages.service') }}:
        <strong>{{ $service->name }}</strong>
    </p>

    {{-- اختيار التاريخ (GET فقط) --}}
    <form method="GET" class="mb-4">
        <input
            type="date"
            name="date"
            value="{{ $date }}"
            onchange="this.form.submit()"
            class="form-control text-center"
        >
    </form>

    @if(empty($times) || count($times) === 0)
        <div class="alert alert-warning">
            ⛔ {{ __('messages.no_available_times') }}
        </div>
    @else

        {{-- فورم تأكيد الوقت --}}
        <form method="POST" action="{{ url('/booking/confirm') }}">
            @csrf

            <input type="hidden" name="organization_id" value="{{ $organization->id }}">
            <input type="hidden" name="service_id" value="{{ $service->id }}">
            <input type="hidden" name="booking_date" value="{{ $date }}">
            <input type="hidden" name="start_time" id="start_time">

            {{-- عرض الأوقات --}}
            <div class="row justify-content-center">
                @foreach($times as $time)
                    <div class="col-4 col-md-2 mb-3">
                        <button
                            type="button"
                            class="btn btn-outline-primary w-100 time-slot"
                            onclick="selectTime('{{ $time }}', this)"
                        >
                            {{ $time }}
                        </button>
                    </div>
                @endforeach
            </div>

            <button type="submit" class="btn btn-success w-100 mt-4">
                ✅ {{ __('messages.confirm_time') }}
            </button>
        </form>

    @endif
</div>

{{-- JavaScript --}}
<script>
function selectTime(time, el) {
    document.getElementById('start_time').value = time;

    document.querySelectorAll('.time-slot').forEach(btn => {
        btn.classList.remove('active');
    });

    el.classList.add('active');
}
</script>
@endsection
