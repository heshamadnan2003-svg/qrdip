@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 500px">

    <h4 class="mb-4 text-center">
        ⭐ {{ __('messages.leave_review') }}
    </h4>

    <form method="POST" action="{{ route('reviews.store', $booking) }}">
        @csrf

        {{-- Rating --}}
        <div class="mb-3 text-center">
            <label class="form-label">
                {{ __('messages.rating') }}
            </label>

            <select name="rating" class="form-select text-center" required>
                <option value="">{{ __('messages.choose_rating') }}</option>
                @for($i = 5; $i >= 1; $i--)
                    <option value="{{ $i }}">
                        {{ $i }} ⭐
                    </option>
                @endfor
            </select>
        </div>

        {{-- Comment --}}
        <div class="mb-3">
            <label class="form-label">
                {{ __('messages.comment_optional') }}
            </label>
            <textarea
                name="comment"
                class="form-control"
                rows="3"
                placeholder="{{ __('messages.comment_placeholder') }}"
            ></textarea>
        </div>

        <button class="btn btn-primary w-100">
            ✅ {{ __('messages.submit_review') }}
        </button>

    </form>
</div>
@endsection
