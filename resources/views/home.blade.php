
@extends('layouts.app')

@section('content')
<div class="container">

    <h2 class="mb-4">👋 مرحبًا {{ auth()->user()->name }}</h2>

    {{-- إذا لم يكن لديه مؤسسة --}}
    @if(!auth()->user()->organization)
        <div class="card">
            <div class="card-body text-center">
                <p class="mb-3">أنت مسجّل كمستخدم عادي</p>

                <a href="{{ route('provider.apply') }}" class="btn btn-primary btn-lg">
                    ✂️ اشترك كمقدم خدمة
                </a>
            </div>
        </div>
    @endif

    {{-- إذا كان مقدم خدمة --}}
    @if(auth()->user()->organization)
        <div class="card">
            <div class="card-body text-center">
                <h4 class="mb-3">🧑‍💼 لوحة مقدم الخدمة</h4>

                <a href="{{ route('manager.dashboard') }}" class="btn btn-success mb-2">
                    📊 لوحة التحكم
                </a>

                <br>

                <a href="{{ route('organization.show', auth()->user()->organization->slug) }}"
                   target="_blank"
                   class="btn btn-outline-primary">
                    🌍 فتح الصفحة العامة
                </a>
            </div>
        </div>
    @endif

</div>
@endsection
