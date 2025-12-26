@php
    $current = $currentStep ?? 'company';
    $completed = session('onboarding.last_completed_step');
@endphp

<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center text-center">

        {{-- Company --}}
        <div class="flex-fill">
            <div class="fw-bold
                {{ in_array($completed, ['company','services','working-hours'])
                    ? 'text-success'
                    : ($current === 'company'
                        ? 'text-primary'
                        : 'text-muted') }}">
                1️⃣ {{ __('messages.company_info') }}
            </div>
        </div>

        <div class="mx-2">➜</div>

        {{-- Services --}}
        <div class="flex-fill">
            <div class="fw-bold
                {{ in_array($completed, ['services','working-hours'])
                    ? 'text-success'
                    : ($current === 'services'
                        ? 'text-primary'
                        : 'text-muted') }}">
                2️⃣ {{ __('messages.services') }}
            </div>
        </div>

        <div class="mx-2">➜</div>

        {{-- Working Hours --}}
        <div class="flex-fill">
            <div class="fw-bold
                {{ $completed === 'working-hours'
                    ? 'text-success'
                    : ($current === 'working-hours'
                        ? 'text-primary'
                        : 'text-muted') }}">
                3️⃣ {{ __('messages.working_hours') }}
            </div>
        </div>

    </div>
</div>
