@extends('layouts.admin')
@section('page_title' , @trans('common.page.product'))

@section('content')
    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid form-intervale-top">
        <div class="row">
            <div class="col-lg-12">
                <!--begin::Portlet-->
                {!! Form::open(['url' => route('product.store'), 'method' => 'POST']) !!}
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
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    @component('components.select_input',
                                        [
                                            'name' => 'category_id',
                                            'label' => @trans('common.categories'),
                                            'options' => $categories->pluck('name', 'id')->toArray(),
                                            'attributes' => [
                                                'required' => true,
                                            ]
                                    ]) @endcomponent
                                </div>
                            </div>
                        <!-- title
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    @component('components.text_input',
                                        [
                                            'name' => 'name_user',
                                            'label' => @trans('common.title'),
                                            'attributes' => [
                                                'required' => true,
                                            ]
                                    ]) @endcomponent
                                </div>
                            </div>
                            -->
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group">
                                    @component('components.textarea_input',
                                        [
                                            'name' => 'data',
                                            'label' => @trans('common.data'),
                                            'attributes' => [
                                                'required' => true,
                                                'class' => 'form-control',
                                                'placeholder' => 'fb_id/password/email/email_pass'
                                            ]
                                    ]) @endcomponent
                                    <span>Tài khoản cách nhau 1 dòng</span>
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
@endsection
