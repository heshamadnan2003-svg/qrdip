@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 900px">

    {{-- Step Indicator --}}
    @include('manager.onboarding._steps', ['currentStep' => 'working-hours'])

    <h4 class="mb-3">🕒 أوقات الدوام</h4>
    <p class="text-muted mb-4">
        حدّد أيام وساعات العمل
    </p>

    <form method="POST" action="{{ route('manager.onboarding.complete') }}">
        @csrf

        @php
            $days = [
                0 => 'الأحد',
                1 => 'الاثنين',
                2 => 'الثلاثاء',
                3 => 'الأربعاء',
                4 => 'الخميس',
                5 => 'الجمعة',
                6 => 'السبت',
            ];

            $oldHours = old('working_hours', session('onboarding.working_hours', []));
        @endphp

        @foreach($days as $dayIndex => $dayName)
            @php
                $dayData = collect($oldHours)->firstWhere('day_of_week', $dayIndex) ?? [];
            @endphp

            <div class="card mb-3">
                <div class="card-body">

                    <div class="form-check mb-2">
                        <input
                            class="form-check-input toggle-day"
                            type="checkbox"
                            data-day="{{ $dayIndex }}"
                            {{ isset($dayData['start_time']) ? 'checked' : '' }}
                        >
                        <label class="form-check-label fw-bold">
                            {{ $dayName }}
                        </label>
                    </div>

                    <div class="row g-3 day-fields {{ isset($dayData['start_time']) ? '' : 'd-none' }}"
                         id="day-{{ $dayIndex }}">

                        <input type="hidden"
                               name="working_hours[{{ $dayIndex }}][day_of_week]"
                               value="{{ $dayIndex }}">

                        <div class="col-md-6">
                            <label class="form-label">من</label>
                            <input type="time"
                                   name="working_hours[{{ $dayIndex }}][start_time]"
                                   class="form-control"
                                   value="{{ $dayData['start_time'] ?? '' }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">إلى</label>
                            <input type="time"
                                   name="working_hours[{{ $dayIndex }}][end_time]"
                                   class="form-control"
                                   value="{{ $dayData['end_time'] ?? '' }}">
                        </div>

                    </div>

                </div>
            </div>
        @endforeach

        <div class="d-flex justify-content-between mt-4">
            {{-- رجوع ذكي --}}
            <a href="{{ route('manager.onboarding.services') }}" class="btn btn-outline-dark">
                ⬅️ رجوع
            </a>

            <button class="btn btn-success">
                ✅ إكمال الإعداد
            </button>
        </div>

    </form>
</div>

<script>
document.querySelectorAll('.toggle-day').forEach(function (checkbox) {
    checkbox.addEventListener('change', function () {
        const day = this.dataset.day;
        const fields = document.getElementById('day-' + day);
        fields.classList.toggle('d-none', !this.checked);
    });
});
</script>
@endsection
