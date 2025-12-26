@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 800px">

    <h2 class="mb-4 text-center">
        {{ __('messages.contact_title') }}
    </h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <p class="fs-5 text-muted text-center">
                {{ __('messages.contact_description') }}
            </p>
        </div>
    </div>

</div>
@endsection
