@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <h2 class="mb-3">Verify Your Email Address</h2>
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-primary">Click Here to Verify New Email</button>
        </form>
        <p class="mt-3"></a></p>
    </div>
</div>
@endsection