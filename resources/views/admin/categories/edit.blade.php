@extends('layouts.admin')
@section('page_title' , 'Sửa category')
@section('breadcrumb')
    {{--    {{ Breadcrumbs::render('managers.create') }}--}}
@endsection

@section('content')
    @include('admin.categories.form_base', [
         'route' => route('category.update', $category),
         'method' => 'put',
         'type' => 'edit'
     ])
@endsection
