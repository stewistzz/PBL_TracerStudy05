@extends('layouts.template')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-md-12">
                <h3 class="font-weight-bold">Welcome to Tracer Study!</h3> <br>
                <h4>Good to see you again, {{ Auth::user()->alumni->nama }}.</h4>
            </div>
        </div>



        <div class="row mb-4">
            <div class="col-md-12">
                <div class="alert alert-primary text-center" style="font-style: italic; font-size: 1.2rem;">
                    “Keberhasilan bukan milik mereka yang pintar. Keberhasilan ialah milik mereka yang senantiasa berusaha.” — Bj. Habibie
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    
@endsection
