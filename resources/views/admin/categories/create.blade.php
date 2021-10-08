@extends('layouts.admin')
@section('page_title' , 'Thêm category')
@section('breadcrumb')
{{--    {{ Breadcrumbs::render('managers.create') }}--}}
@endsection

@section('content')
    @include('admin.categories.form_base', [
         'route' => route('category.store'),
         'method' => 'post',
         'type' => 'create'
     ])
@endsection
