@extends('layouts.app')

@section('content')
<div class="container" style="max-width:540px">

    <h3 class="mb-4 fw-bold
        {{ app()->getLocale() === 'ar' ? 'text-center' : 'text-start' }}">
        🕒 {{ __('messages.working_hours') }}
    </h3>

    <form method="POST" action="{{ route('manager.working-hours.store') }}">
        @csrf

        @php
            $days = [
                0 => __('messages.sunday'),
                1 => __('messages.monday'),
                2 => __('messages.tuesday'),
                3 => __('messages.wednesday'),
                4 => __('messages.thursday'),
                5 => __('messages.friday'),
                6 => __('messages.saturday'),
            ];
        @endphp

        @foreach($days as $dayNumber => $dayName)

            @php
                $dayData = $workingHours[$dayNumber] ?? null;

                $isHoliday = $dayData
                    ? (!$dayData->start_time && !$dayData->end_time)
                    : true;
            @endphp

            <div class="card mb-2 shadow-sm">
                <div class="card-body py-3">

                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <strong>{{ $dayName }}</strong>

                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="days[{{ $dayNumber }}][is_holiday]"
                                id="holiday_{{ $dayNumber }}"
                                value="1"
                                {{ $isHoliday ? 'checked' : '' }}
                                onchange="toggleTimes({{ $dayNumber }})"
                            >
                            <label class="form-check-label" for="holiday_{{ $dayNumber }}">
                                {{ __('messages.day_off') }}
                            </label>
                        </div>
                    </div>

                    <div id="times_{{ $dayNumber }}"
                         style="{{ $isHoliday ? 'display:none' : '' }}">
                        <div class="row">
                            <div class="col-6 mb-2">
                                <label class="form-label">
                                    {{ __('messages.start_time') }}
                                </label>
                                <input
                                    type="time"
                                    name="days[{{ $dayNumber }}][start_time]"
                                    class="form-control"
                                    value="{{ $dayData->start_time ?? '' }}"
                                >
                            </div>

                            <div class="col-6 mb-2">
                                <label class="form-label">
                                    {{ __('messages.end_time') }}
                                </label>
                                <input
                                    type="time"
                                    name="days[{{ $dayNumber }}][end_time]"
                                    class="form-control"
                                    value="{{ $dayData->end_time ?? '' }}"
                                >
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        @endforeach

        <div class="d-grid mt-4">
            <button class="btn btn-primary btn-lg">
                💾 {{ __('messages.save_working_hours') }}
            </button>
        </div>
    </form>

    {{-- ================= BUSY TIMES ================= --}}
    <hr class="my-5">

    <h4 class="fw-bold mb-3
        {{ app()->getLocale() === 'ar' ? 'text-center' : 'text-start' }}">
        ⛔ {{ __('messages.busy_times') }}
    </h4>

    <form method="POST"
          action="{{ route('manager.busy-times.store') }}"
          class="card shadow-sm mb-4">
        @csrf
        <div class="card-body">

            <input type="date"
                   name="date"
                   class="form-control mb-2"
                   placeholder="{{ __('messages.placeholder_busy_date') }}"
                   required>

            <div class="row">
                <div class="col-6">
                    <input type="time"
                           name="start_time"
                           class="form-control"
                           placeholder="{{ __('messages.placeholder_busy_start') }}"
                           required>
                </div>
                <div class="col-6">
                    <input type="time"
                           name="end_time"
                           class="form-control"
                           placeholder="{{ __('messages.placeholder_busy_end') }}"
                           required>
                </div>
            </div>

            <input type="text"
                   name="reason"
                   class="form-control mt-2"
                   placeholder="{{ __('messages.busy_reason_optional') }}">

            <button class="btn btn-danger w-100 mt-3">
                ➕ {{ __('messages.add_busy_time') }}
            </button>
        </div>
    </form>

    @if($busyTimes->count())
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold mb-3">
                    📋 {{ __('messages.busy_times_list') }}
                </h6>

                @foreach($busyTimes as $busy)
                    <div class="border rounded p-2 mb-2 small">
                        📅 {{ $busy->date }} <br>
                        ⏰ {{ $busy->start_time }}
                        {{ app()->getLocale() === 'ar' ? '←' : '→' }}
                        {{ $busy->end_time }}

                        @if($busy->reason)
                            <br>📝 {{ $busy->reason }}
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <p class="text-muted text-center">
            {{ __('messages.no_busy_times') }}
        </p>
    @endif

</div>

<script>
function toggleTimes(day) {
    const checkbox = document.getElementById('holiday_' + day);
    const times = document.getElementById('times_' + day);
    times.style.display = checkbox.checked ? 'none' : 'block';
}
</script>
@endsection
