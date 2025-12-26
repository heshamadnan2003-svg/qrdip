@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 700px">

    {{-- Step Indicator --}}
    @include('manager.onboarding._steps', ['currentStep' => 'company'])

    <h4 class="mb-3">
        🏢 {{ __('messages.company_info') }}
    </h4>

    <p class="text-muted mb-4">
        {{ __('messages.company_info_hint') }}
    </p>

    <form method="POST" action="{{ route('manager.onboarding.company.store') }}">
    @csrf

    {{-- اسم الشركة --}}
    <div class="mb-3">
        <label class="form-label">{{ __('messages.company_name') }}</label>
        <input type="text" name="name" class="form-control"
               value="{{ old('name', $organization->name ?? '') }}" required>
    </div>

    {{-- الوصف --}}
    <div class="mb-3">
        <label class="form-label">{{ __('messages.company_description_optional') }}</label>
        <textarea name="description" class="form-control" rows="3">{{ old('description', $organization->description ?? '') }}</textarea>
    </div>

    {{-- التصنيف --}}
<div class="mb-3">
    <label class="form-label required">
        {{ __('messages.category') }}
    </label>

    <select name="category_select"
            id="categorySelect"
            class="form-control"
            onchange="toggleCustomCategory()"
            required>
        <option value="">— اختر التصنيف —</option>

        <option value="barber">✂️ حلاق</option>
        <option value="clinic">🏥 عيادة</option>
        <option value="beauty">💄 مركز تجميل</option>
        <option value="gym">🏋️ نادي رياضي</option>
        <option value="education">📚 مركز تعليمي</option>
        <option value="other">➕ أخرى</option>
    </select>
</div>

<div class="mb-3 d-none" id="customCategoryWrapper">
    <label class="form-label required">
        {{ __('messages.custom_category') }}
    </label>

    <input type="text"
           name="category_custom"
           class="form-control"
           placeholder="{{ __('messages.custom_category_placeholder') }}">
</div>


    {{-- الهاتف --}}
    <div class="mb-3">
        <label class="form-label">{{ __('messages.contact_phone') }}</label>
        <input type="text" name="contact_phone" class="form-control"
               value="{{ old('contact_phone', $organization->contact_phone ?? '') }}" required>
    </div>

    {{-- البريد --}}
    <div class="mb-3">
        <label class="form-label">{{ __('messages.contact_email') }}</label>
        <input type="email" name="contact_email" class="form-control"
               value="{{ old('contact_email', $organization->contact_email ?? '') }}" required>
    </div>

   {{-- البلد --}}
<div class="mb-3">
    <label class="form-label">{{ __('messages.country') }}</label>
    <input type="text" class="form-control" value="سوريا" disabled>
</div>

{{-- المحافظة --}}
<div class="mb-3">
    <label class="form-label required">{{ __('messages.governorate') }}</label>
    <select id="governorate" name="governorate"
            class="form-control"
            onchange="loadCities()" required>
        <option value="">— اختر المحافظة —</option>
        <option value="damascus">دمشق</option>
        <option value="aleppo">حلب</option>
        <option value="homs">حمص</option>
        <option value="latakia">اللاذقية</option>
    </select>
</div>

{{-- المدينة --}}
<div class="mb-3">
    <label class="form-label required">{{ __('messages.city') }}</label>
    <select id="city" name="city" class="form-control" required>
        <option value="">— اختر المدينة —</option>
    </select>
</div>


    <div class="d-flex justify-content-end">
        <button class="btn btn-primary">
            💾 {{ __('messages.save') }}
        </button>
    </div>
</form>


</div>

<script>
function toggleCustomCategory() {
    const select = document.getElementById('categorySelect');
    const wrapper = document.getElementById('customCategoryWrapper');

    if (select.value === 'other') {
        wrapper.classList.remove('d-none');
    } else {
        wrapper.classList.add('d-none');
    }
}
</script>

<script>
const citiesByGovernorate = {
    damascus: ['دمشق', 'جرمانا', 'دوما'],
    aleppo: ['حلب', 'اعزاز', 'الباب'],
    homs: ['حمص', 'تدمر'],
    latakia: ['اللاذقية', 'جبلة']
};

function loadCities() {
    const g = document.getElementById('governorate').value;
    const city = document.getElementById('city');

    city.innerHTML = '<option value="">— اختر المدينة —</option>';

    if (!citiesByGovernorate[g]) return;

    citiesByGovernorate[g].forEach(c => {
        const opt = document.createElement('option');
        opt.value = c;
        opt.textContent = c;
        city.appendChild(opt);
    });
}
</script>

@endsection
