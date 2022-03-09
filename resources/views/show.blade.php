<?php
/**
 * @var \App\Models\User $user
 * @var array $roles
 */
?>

@extends('layouts.admin')

@section('content')

    <div class="container-xl">

        <div class="card">

            <div class="card-body p-4">

                <h3>@if($user->id) Update @else Create @endif User</h3>

                <x-admin.errors />

                <form class="mt-4" style="max-width:400px;" action="{{ $user->id ? route('admin.user.update', $user) : route('admin.user.store') }}" method="post">
                    @csrf
                    @if($user->id)
                        @method('put')
                    @endif

                    <x-admin.form.input
                        :model="$user"
                        attr="name"
                        label="Name"
                        help="name can contain also spaces"
                    />

                    <x-admin.form.input
                        :model="$user"
                        attr="email"
                        label="E-mail"
                        help="used to login"
                    />

                    @if(!$user->id)
                        <x-admin.form.input
                            :model="$user"
                            attr="password"
                            label="Password"
                            type="password"
                        />
                    @endif

                    {{-- roles checkboxes --}}
                    <div class="row mb-3">
                        <label>Роли</label>
                        @foreach($roles as $role)
                            <div class="col-auto">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input" name="roles[]" value="{{ $role }}" @if(in_array($role, old('roles', $user->roles ?? []))) checked @endif>
                                        {{ $role }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                        @error($role)
                            <div class="alert invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <label>Уведомления</label>
                        <div class="col-auto">
                            <x-admin.form.checkbox :model="$user" attr="notify" label="notify" />
                        </div>
                        <div class="col-auto">
                            <x-admin.form.checkbox :model="$user" attr="notify_spam" label="notify_spam" />
                        </div>
                    </div>

                    <div class="mt-4">

                        <button type="submit" class="btn btn-primary">Сохранить</button>

                    </div>

                </form>

            </div>

        </div>

    </div>
@endsection
