@extends('layouts.admin')
@section('page_title' , 'Order')

@section('content')
    <!--begin::Portlet-->
    <div class="kt-portlet">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label d-flex align-items-center justify-content-between w-100">
                <h3 class="kt-portlet__head-title">
                    Lịch sử giao dịch
                </h3>
            </div>
        </div>
{{--        @include('admin.categories.seach')--}}

        <div class="kt-portlet__body">
            <div class="kt-section">
                <div class="kt-section__content">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>@lang('common.created_at')</th>
                                <th>@lang('common.paypal_id')</th>
                                <th>@lang('common.balance')</th>
                                <th>@lang('common.status')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($orders as $order)
                                <tr>
                                    <td>{{ $order->created_at }}</td>
                                    <td>{{ $order->paypal_id }}</td>
                                    <td>{{ $order->amount }}</td>
                                    <td>
                                        <span
                                            @switch($order->status)
                                                @case(\App\Models\Order::STATUS_VERIFIED)
                                                    class="btn btn-block btn-bold btn-sm btn-font-sm  btn-label-primary">
                                                    @break
                                                @case(\App\Models\Order::STATUS_WEBHOOK)
                                                    class="btn btn-block btn-bold btn-sm btn-font-sm  btn-label-success">
                                                    @break
                                                @case(\App\Models\Order::STATUS_CANCEL)
                                                    class="btn btn-block btn-bold btn-sm btn-font-sm  btn-label-danger">
                                                    @break
                                                @default
                                                    class="btn btn-block btn-bold btn-sm btn-font-sm  btn-label-dark">
                                            @endswitch

                                            @lang('config.order.status.' .$order->status)
                                        </span>
                                    </td>

                                </tr>
                            @empty
                                @include('partials.table_empty_row')
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="pull-right">
                        {!! $orders->appends(Request::except('page'))->links('components.pagination') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end::Portlet-->
@endsection
