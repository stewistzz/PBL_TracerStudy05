@extends('layouts.template')

@section('content')

    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                    <h3 class="font-weight-bold">Welcome to Tracer Study Alumni!</h3>
                    <br>
                    <h6 class="font-weight-normal mb-0">
                        You are logged in as {{ Auth::user()->username }}
                        {{-- <span class="text-primary">Website Tracer Study</span> --}}
                    </h6>
                </div>
            </div>
        </div>
    </div>
@endsection
