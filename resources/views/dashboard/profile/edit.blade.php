@extends('layouts.dashboard')

@section('title', 'Edit Profile')

@section('breadcrumb')
@parent
<li class="breadcrumb-item">Profile</li>
@endsection

@section('content')
<x-alert type="success" />

<form action="{{ route('dashboard.profile.update') }}" method="post">
    @csrf
    @method('patch')

    <div class="form-row">
        <div class="form-group col-md-6">
            <x-form.input name="first_name" label="First Name" :value="$user->profile->first_name" />
        </div>
        <div class="form-group col-md-6">
            <x-form.input name="last_name" label="Last Name" :value="$user->profile->last_name" />
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <x-form.input name="birth_date" label="Birth Date" type="date" :value="$user->profile->birth_date" />
        </div>
        <div class="form-group col-md-6">
            <label for="">Gender</label>
            <x-form.radio name="gender" :options="['male' => 'Male', 'female' => 'Female']" :checked="$user->profile->gender" />
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-5">
            <x-form.input name="street_address" label="Street Address" :value="$user->profile->street_address" />
        </div>
        <div class="form-group col-md-5">
            <x-form.input name="city" label="City" :value="$user->profile->city" />
        </div>
        <div class="form-group col-md-2">
            <x-form.input name="postal_code" label="Postal Code" :value="$user->profile->postal_code" />
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <x-form.select name="country" label="Country" :options="$countries" :selected="$user->profile->country" />
        </div>
        <div class="form-group col-md-6">
            <x-form.select name="locale" label="Language" :options="$locales" :selected="$user->profile->locale" />
        </div>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>

</form>
@endsection