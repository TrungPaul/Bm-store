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
                    <span>So USD can nap</span>
                </div>
                <div class="card-body">
                    <span>So USD can nap</span>
                </div>
                <form action="{{ route('paypal.create') }}" method="post">
                    @csrf
                    <input type="number" name="money" class="form-control">
                    <button type="submit" class="btn btn-primary" class="">Nap</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection()
