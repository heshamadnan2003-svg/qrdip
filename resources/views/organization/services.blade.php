@extends('layouts.app')

@section('content')
<div class="container">

@if($workingDays->isNotEmpty())
    <div class="alert alert-info text-center mb-4">
        <strong>🕒 أوقات الدوام:</strong><br>

        @foreach($workingDays as $day)
            <div>
                {{ $day->day_name }} :
                {{ \Carbon\Carbon::parse($day->start_time)->format('H:i') }}
                -
                {{ \Carbon\Carbon::parse($day->end_time)->format('H:i') }}
            </div>
        @endforeach
    </div>
@endif



    <h3 class="mb-4 text-center">
        🛎️ اختر الخدمة – {{ $organization->name }}
    </h3>

    @if($organization->services->isEmpty())
        <div class="alert alert-warning text-center">
            لا توجد خدمات متاحة حاليًا
        </div>
    @else
        <div class="row">
            @foreach($organization->services as $service)
                <div class="col-md-4 mb-3">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body text-center">
                            <h5>{{ $service->name }}</h5>
                            <p class="text-muted">
                                ⏱ {{ $service->duration }} دقيقة
                            </p>
                            <p class="fw-bold">
                                💰 {{ $service->price }}
                            </p>

                           <a href="{{ route('org.times', [$organization->slug, $service->id]) }}"
   class="btn btn-primary w-100">
   اختيار الخدمة
</a>


                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection
