@extends('layouts.admin')
@section('page_title' , 'Category ')

@section('content')
    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid form-intervale-top">
        <div class="row">
            <div class="col-lg-12">
                <!--begin::Portlet-->
                @if (strtolower($type) == 'create')
                    {!! Form::open(['url' => $route, 'method' => $method]) !!}
                @else
                    {!! Form::model($category, ['url' => $route, 'method' => $method]) !!}
                @endif
                <div class="kt-portlet">
                    <!--begin::Portlet-->
                    <div class="kt-portlet kt-portlet--last kt-portlet--head-lg kt-portlet--responsive-mobile"
                         id="kt_page_portlet">
                        <div class="kt-portlet__head kt-portlet__head--lg">
                            <div class="kt-portlet__head-label"></div>
                            <div class="kt-portlet__head-toolbar">
                                <a href="{{ route('category.index') }}" class="btn btn-clean kt-margin-r-10">
                                    <i class="la la-arrow-left"></i>
                                    <span class="kt-hidden-mobile">Back</span>
                                </a>
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-brand">
                                        <i class="la la-check"></i>
                                        <span class="kt-hidden-mobile">Save</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <!--begin::Form-->
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    @component('components.text_input',
                                        [
                                            'name' => 'name',
                                            'label' => 'Tên danh mục',
                                            'attributes' => [
                                                'required' => true,
                                            ]
                                    ]) @endcomponent
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    @component('components.number_input',[
                                            'name' => 'price',
                                            'label' => @trans('common.price'),
                                            'attributes' => [
                                                'required' => true,
                                            ]
                                    ]) @endcomponent
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    @component('components.select_input',
                                        [
                                            'name' => 'type',
                                            'label' => 'Loại danh mục',
                                            'options' => @trans('config.tab'),
                                            'attributes' => [
                                                'required' => true,
                                            ]
                                    ]) @endcomponent
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    @component('components.text_input',
                                        [
                                            'name' => 'description',
                                            'label' => 'Mo ta',
                                            'attributes' => [
                                                'required' => true,
                                            ]
                                    ]) @endcomponent
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    @component('components.radio_input',
                                        [
                                            'name' => 'status',
                                            'label' => 'Status',
                                            'options' => ['1' => 'Active', '2' => 'Inactive'],
                                            'attributes' => [
                                                'required' => true,
                                                'default' => 1
                                            ]
                                        ])
                                    @endcomponent
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
                <!--end::Portlet-->
            </div>
        </div>
    </div>

@endsection
