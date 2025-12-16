@extends('layouts.app')

@section('content')

<h3 class="mb-4">خدماتي</h3>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card mb-4">
    <div class="card-header">إضافة خدمة جديدة</div>
    <div class="card-body">

        <form method="POST" action="{{ route('manager.services.store') }}">
            @csrf

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label>اسم الخدمة</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label>السعر</label>
                    <input type="number" name="price" class="form-control" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label>المدة (دقائق)</label>
                    <input type="number" name="duration" class="form-control" required>
                </div>
            </div>

            <button class="btn btn-primary">إضافة</button>
        </form>

    </div>
</div>

<div class="card">
    <div class="card-header">الخدمات الحالية</div>
    <div class="card-body">

        @if($services->count())
            <table class="table">
                <thead>
                    <tr>
                        <th>الخدمة</th>
                        <th>السعر</th>
                        <th>المدة</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($services as $service)
                        <tr>
                            <td>{{ $service->name }}</td>
                            <td>{{ $service->price }}</td>
                            <td>{{ $service->duration }} دقيقة</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-muted">لا توجد خدمات بعد.</p>
        @endif

    </div>
</div>

@endsection
