@extends('layouts.app')

@section('content')
<div class="container">

    {{-- معلومات الجهة --}}
    <div class="ui-card mb-4">
        <h2 class="fw-bold mb-2">{{ $organization->name }}</h2>

        <p class="text-muted mb-3">
            {{ $organization->description }}
        </p>

        <div class="row">

            <div class="col-md-4 mb-2">
                <strong>📂 التصنيف:</strong>
                <span class="text-muted">{{ $organization->category }}</span>
            </div>

            <div class="col-md-4 mb-2">
                <strong>📞 الهاتف:</strong>
                <span class="text-muted">{{ $organization->contact_phone }}</span>
            </div>

            <div class="col-md-4 mb-2">
                <strong>📍 العنوان:</strong>
                <span class="text-muted">{{ $organization->address }}</span>
            </div>

        </div>
    </div>

    {{-- الخدمات --}}
    <div class="ui-card mb-4">
        <h4 class="section-title mb-3">✂️ الخدمات المقدمة</h4>

        @if($organization->services->count())
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>الخدمة</th>
                            <th>السعر</th>
                            <th>المدة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($organization->services as $service)
                            <tr>
                                <td>{{ $service->name }}</td>
                                <td>{{ $service->price }} </td>
                                <td>{{ $service->duration }} دقيقة</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-muted mb-0">
                لا توجد خدمات مضافة حاليًا.
            </p>
        @endif
    </div>

    {{-- زر الحجز (مستقبليًا) --}}
    <div class="text-center">
        <button class="btn btn-primary btn-lg" disabled>
            📅 حجز موعد (قريبًا)
        </button>

        <p class="text-muted mt-2">
            سيتم تفعيل الحجز الإلكتروني قريبًا
        </p>
    </div>

</div>
@endsection
