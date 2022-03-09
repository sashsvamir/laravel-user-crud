<?php
/**
 * @var \App\Models\User[] $users
 */
?>

@extends('layouts.admin')

@push('scripts')
    {{--<script src="{{ mix('js/admin/user.js') }}" defer></script>--}}
@endpush

@section('content')

    <div class="container-xl admin-user-index">

        <div class="card">

            <div class="card-body p-4">

                <h3>Users</h3>

                <a href="{{ route('admin.user.create') }}" class="btn btn-primary btn-sm mt-3 mb-3">
                    <i class="fas fa-plus"></i>
                    Добавить
                </a>

                <div class="table-responsive-md">
                    <table class="table models-list rooms-list">
                        <thead>
                            <tr>
                                <th scope="col">id</th>
                                <th scope="col">name</th>
                                <th scope="col">email</th>
                                <th scope="col">notify</th>
                                <th scope="col">notify_spam</th>
                                <th scope="col">roles</th>
                                <th scope="col">created_at</th>
                                <th scope="col">updated_at</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr class="user">
                                    <td class="id">
                                        {{ $user->id }}
                                    </td>
                                    <td class="name">
                                        {{ $user->name }}
                                    </td>
                                    <td class="email">
                                        {{ $user->email }}
                                    </td>
                                    <td class="notify">
                                        <x-admin.status-bool :status="$user->notify" />
                                    </td>
                                    <td class="notify_spam">
                                        <x-admin.status-bool :status="$user->notify_spam" />
                                    </td>
                                    <td class="roles">
                                        {{ $user->roles ? implode(', ', $user->roles) : '' }}
                                    </td>
                                    <td class="created_at ">
                                        <small>{{ $user->created_at }}</small>
                                    </td>
                                    <td class="created_at ">
                                        <small>{{ $user->updated_at }}</small>
                                    </td>
                                    <td class="text-end">

                                        <x-admin.table-btn-edit :url="route('admin.user.edit', $user)" />

                                        <x-admin.table-btn-delete :action-url="route('admin.user.destroy', $user)" />

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>

        </div>

    </div>
@endsection
