@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <h2 class="mb-4"><i class="fa-solid fa-user me-2"></i>Profile Settings</h2>
        
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="card shadow-sm border-danger">
            <div class="card-body text-danger">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</div>
@endsection
