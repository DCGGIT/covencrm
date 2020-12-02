@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <main-app :user="{{ auth()->user() }}"/>

        </div>
    </div>
</div>
@endsection
