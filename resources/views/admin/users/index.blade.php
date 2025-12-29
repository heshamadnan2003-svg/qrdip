@extends('layouts.app')

@section('content')
<div class="container">

    <h3 class="mb-4 text-center">
        👥 {{ __('messages.users_management') }}
    </h3>

    {{-- زر إضافة أدمن (للأدمن فقط) --}}
    @if(auth()->user()->role === 'admin')
        <div class="text-end mb-3">
            <a href="{{ route('admin.admins.create') }}"
               class="btn btn-danger">
                ➕ {{ __('messages.add_admin') }}
            </a>
        </div>
    @endif

    {{-- رسالة نجاح --}}
    @if(session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif

    @if($users->isEmpty())
        <div class="alert alert-info text-center">
            {{ __('messages.no_users') }}
        </div>
    @else
        <table class="table table-bordered align-middle
            {{ app()->getLocale() === 'ar' ? 'text-center' : 'text-start' }}">

            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>{{ __('messages.name') }}</th>
                    <th>{{ __('messages.email') }}</th>
                    <th>{{ __('messages.role') }}</th>
                    <th>{{ __('messages.status') }}</th>
                    <th>{{ __('messages.rating') }}</th>
                    <th>{{ __('messages.actions') }}</th>
                </tr>
            </thead>

            <tbody>
                @foreach($users as $index => $user)
                    <tr>
                        <td>{{ $index + 1 }}</td>

                        <td>{{ $user->name }}</td>

                        <td>{{ $user->email }}</td>

                        {{-- الدور --}}
                        <td>
                            @if($user->role === 'admin')
                                <span class="badge bg-dark">Admin</span>
                            @elseif($user->role === 'manager')
                                <span class="badge bg-primary">Manager</span>
                            @else
                                <span class="badge bg-secondary">User</span>
                            @endif
                        </td>

                        {{-- الحالة --}}
                        <td>
                            @if($user->is_active)
                                <span class="badge bg-success">
                                    {{ __('messages.active') }}
                                </span>
                            @else
                                <span class="badge bg-danger">
                                    {{ __('messages.inactive') }}
                                </span>
                            @endif
                        </td>

                        {{-- التقييم --}}
                        <td>
                            @if($user->organization && $user->organization->reviews->count())
                                ⭐ {{ number_format($user->organization->reviews->avg('rating'), 1) }}
                                <small class="text-muted">
                                    ({{ $user->organization->reviews->count() }})
                                </small>
                            @else
                                —
                            @endif
                        </td>

                        {{-- الإجراءات --}}
                        <td>
                            @if($user->role !== 'admin')
                                <div class="d-flex flex-column gap-1">

                                    {{-- عرض --}}
                                    <a href="{{ route('admin.users.show', $user) }}"
                                       class="btn btn-info btn-sm">
                                        👁 {{ __('messages.view') }}
                                    </a>

                                    {{-- تفعيل / تعطيل --}}
                                    <form method="POST"
                                          action="{{ route('admin.users.toggle', $user) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn btn-warning btn-sm w-100">
                                            🔄 {{ __('messages.toggle_status') }}
                                        </button>
                                    </form>

                                    {{-- حذف --}}
                                    <form method="POST"
                                          action="{{ route('admin.users.destroy', $user) }}"
                                          onsubmit="return confirm('{{ __('messages.confirm_delete') }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm w-100">
                                            🗑 {{ __('messages.delete') }}
                                        </button>
                                    </form>

                                </div>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    @endif

</div>
@endsection
