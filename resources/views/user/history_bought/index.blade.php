@extends('layouts.admin')
@section('page_title' , 'Order')

@section('content')
    <!--begin::Portlet-->
    <div class="kt-portlet">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label d-flex align-items-center justify-content-between w-100">
                <h3 class="kt-portlet__head-title">
                    Lịch sử mua
                </h3>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="kt-section">
                <div class="kt-section__content">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>@lang('common.created_at')</th>
                                <th>@lang('common.category')</th>
                                <th>@lang('common.quantity')</th>
                                <th>@lang('common.balance')</th>
                                <th>@lang('common.status')</th>
                                <th>@lang('common.download')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($products as $product)
                                <tr>
                                    <td>{{ $product->first()->updated_at }}</td>
                                    <td>{{ $product->first()->category->name }}</td>
                                    <td>{{ $product->count() }}</td>
                                    <td>{{ number_format($product->first()->category->price*$product->count(), 0,'.', '.').' d' }}</td>
                                    <td>
                                        <span class="btn btn-block btn-bold btn-sm btn-font-sm  btn-label-success">
                                            Completed
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        {!! Form::open(['route' => ['buyer.download_bough', $product->first()->category_id] , 'method' => 'get', 'id' => 'form-download' ]) !!}
                                        <a href="javascript:;" onclick="$('#form-download').submit();" class="btn btn-sm btn-clean btn-icon btn-icon-md">
                                            <i class="la la-download"></i>
                                        </a>
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @empty
                                @include('partials.table_empty_row')
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="pull-right">
                        {!! $products->appends(Request::except('page'))->links('components.pagination') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end::Portlet-->
@endsection
