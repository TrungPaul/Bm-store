@extends('layouts.admin')
@section('page_title', "Admin")
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>
                <div class="card-body">
                    View screen login <a href="{{ url('login') }}">here</a>
                    <form action="{{ route('create-payment') }}" method="post">
                        @csrf
                        <input type="number" class="form-control" name="money">
                        <button type="submit" class="btn btn-primary">Paynow</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection()
