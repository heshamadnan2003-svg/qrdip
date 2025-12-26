@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">
                    ✂️ {{ __('messages.apply_provider_title') }}
                </div>

                <div class="card-body">

                    <form method="POST" action="{{ route('provider.apply.store') }}">
                        @csrf

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- اسم الخدمة --}}
                        <div class="mb-3">
                            <label class="form-label">
                                {{ __('messages.service_name') }}
                            </label>
                            <input type="text"
                                   name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- التصنيف --}}
                        <div class="mb-3">
                            <label class="form-label">
                                {{ __('messages.category') }}
                            </label>
                            <input type="text"
                                   name="category"
                                   class="form-control @error('category') is-invalid @enderror"
                                   placeholder="{{ __('messages.category_example') }}"
                                   value="{{ old('category') }}"
                                   required>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- الوصف --}}
                        <div class="mb-3">
                            <label class="form-label">
                                {{ __('messages.short_description') }}
                            </label>
                            <textarea name="description"
                                      class="form-control @error('description') is-invalid @enderror"
                                      rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- بريد التواصل --}}
                        <div class="mb-3">
                            <label class="form-label">
                                {{ __('messages.contact_email') }}
                            </label>
                            <input type="email"
                                   name="contact_email"
                                   class="form-control @error('contact_email') is-invalid @enderror"
                                   value="{{ old('contact_email') }}"
                                   required>
                            @error('contact_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- هاتف التواصل --}}
                        <div class="mb-3">
                            <label class="form-label">
                                {{ __('messages.contact_phone') }}
                            </label>
                            <input type="text"
                                   name="contact_phone"
                                   class="form-control @error('contact_phone') is-invalid @enderror"
                                   value="{{ old('contact_phone') }}">
                            @error('contact_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- العنوان --}}
                        <div class="mb-3">
                            <label class="form-label">
                                {{ __('messages.address') }}
                            </label>
                            <textarea name="address"
                                      class="form-control @error('address') is-invalid @enderror"
                                      rows="2">{{ old('address') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- زر الإرسال --}}
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success">
                                🚀 {{ __('messages.submit_application') }}
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
