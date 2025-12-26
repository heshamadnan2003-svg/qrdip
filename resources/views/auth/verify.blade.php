@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-header">
                    {{ __('messages.verify_email_title') }}
                </div>

                <div class="card-body">

                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('messages.verify_email_link_sent') }}
                        </div>
                    @endif

                    <p class="mb-2">
                        {{ __('messages.verify_email_instruction') }}
                    </p>

                    <p class="mb-0">
                        {{ __('messages.verify_email_not_received') }}
                    </p>

                    <form class="d-inline"
                          method="POST"
                          action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit"
                                class="btn btn-link p-0 m-0 align-baseline">
                            {{ __('messages.verify_email_resend') }}
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
