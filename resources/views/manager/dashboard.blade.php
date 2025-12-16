@extends('layouts.app')

@section('content')

<h3 class="mb-4">لوحة تحكم المدير</h3>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="row g-4">

    {{-- بطاقة QR --}}
    <div class="col-md-6">
        <div class="card p-4 text-center">
            <h5 class="mb-3">QR Code الخاص بصفحتك</h5>

            @if(auth()->user()->organization)
                <img 
                    src="{{ asset(auth()->user()->organization->qr_code) }}" 
                    class="img-fluid mb-3" 
                    style="max-width:200px"
                >

                <a 
                    href="{{ route('organization.show', auth()->user()->organization->slug) }}"
                    class="btn btn-success"
                    target="_blank"
                >
                    فتح الصفحة العامة
                </a>
            @else
                <p class="text-muted">لم يتم إنشاء جهة بعد</p>
            @endif
        </div>
    </div>

    {{-- أزرار الإدارة --}}
    <div class="col-md-6">
        <div class="card p-4">
            <h5 class="mb-3">الإدارة</h5>

            <div class="d-grid gap-3">
                <a href="{{ route('manager.services') }}" class="btn btn-outline-primary">
                    ✂️ إدارة الخدمات
                </a>

                {{-- مؤقتًا بدون time-slots لتفادي الخطأ --}}
                {{-- <a href="#" class="btn btn-outline-secondary">إدارة المواعيد</a> --}}
            </div>
        </div>
    </div>

</div>

@endsection
