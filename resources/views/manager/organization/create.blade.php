@extends('layouts.app')

@section('content')
<div class="container" style="max-width:700px">

    <div class="ui-card">
        <h3 class="mb-4 fw-bold text-center">🏢 إنشاء جهة جديدة</h3>

<form method="POST" action="{{ route('manager.onboarding.company.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">اسم الجهة</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">الوصف</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">التصنيف</label>
                <input type="text" name="category" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">رقم الهاتف</label>
                <input type="text" name="contact_phone" class="form-control" required>
            </div>

            <div class="mb-3">
    <label class="form-label">البريد الإلكتروني</label>
    <input 
        type="email" 
        name="contact_email" 
        class="form-control"
        placeholder="example@email.com"
        required
    >
</div>


            <div class="mb-4">
                <label class="form-label">العنوان</label>
                <input type="text" name="address" class="form-control" required>
            </div>

            <div class="d-grid">
                <button class="btn btn-primary btn-lg">
                    ✅ إنشاء الجهة
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
