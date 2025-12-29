@extends('layouts.app')

@section('content')
<div class="container position-relative">

    {{-- زر المينيو --}}
    <button
        class="btn btn-light border position-absolute"
        style="top: 20px; left: 20px"
        data-bs-toggle="offcanvas"
        data-bs-target="#userMenu"
        aria-controls="userMenu"
    >
        ☰
    </button>

    {{-- محتوى الصفحة --}}
    <div class="text-center mt-5 pt-5">

        <h2 class="mb-3">
            👋 {{ __('messages.home_welcome') }}
            {{ auth()->user()->name }}
        </h2>

        @if(auth()->user()->organization)
            <p class="text-muted mb-4">
                {{ __('messages.company_info') }}
            </p>

            <div class="card mx-auto shadow-sm" style="max-width: 500px">
                <div class="card-body text-end">
                    <h5 class="mb-2">
                        🏢 {{ auth()->user()->organization->name }}
                    </h5>

                    <p class="text-muted mb-0">
                        {{ auth()->user()->organization->description
                            ?? __('messages.no_company_description') }}
                    </p>
                </div>
            </div>
        @else
            <p class="text-muted">
                {{ __('messages.no_company_attached') }}
            </p>
        @endif

    </div>

</div>

{{-- Offcanvas Menu --}}
<div class="offcanvas offcanvas-end" tabindex="-1" id="userMenu">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">
            ☰ {{ __('messages.menu') }}
        </h5>
        <button type="button"
                class="btn-close"
                data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body">

        {{-- معلومات الشركة --}}
        <div class="mb-3">
            <h6 class="text-muted mb-2">
                🏢 {{ __('messages.company_info') }}
            </h6>

            @if(auth()->user()->organization)
    <a href="{{ route('manager.organization.edit') }}"
       class="btn btn-outline-primary w-100 mb-2">
        ✏️ {{ __('messages.edit_company_info') }}
    </a>


                <form method="POST" action="#">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-outline-danger w-100">
                        🗑️ {{ __('messages.delete_company') }}
                    </button>
                </form>
            @else
                <a href="{{ route('provider.apply') }}"
                   class="btn btn-success w-100">
                    ➕ {{ __('messages.add_company') }}
                </a>
            @endif
        </div>

        <hr>

        {{-- لوحة التحكم --}}
        <div>
            <h6 class="text-muted mb-2">
                ⚙️ {{ __('messages.control_panel') }}
            </h6>

            <a href="{{ route('manager.dashboard') }}"
               class="btn btn-dark w-100">
                {{ __('messages.go_to_dashboard') }}
            </a>
        </div>

    </div>
</div>
@endsection
