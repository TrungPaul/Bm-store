@extends('layouts.admin')
@section('page_title', "Deposit")
@section('content')
    <div class="tab-content kt-portlet">
        <!--begin::Tab pane-->
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label d-flex align-items-center justify-content-between w-100">
                <h3 class="kt-portlet__head-title">
                    Nạp tiền bằng paypal
                </h3>
            </div>
        </div>
        <div id="kt_project_users_card_pane" class="tab-pane fade show active">
            <!--begin::Row-->
            {!! Form::open(['url' => route('paypal.create'), 'method' => 'post']) !!}
            <div class="row">
                <div class="col-lg-12">
                    <div class="col-md-6 col-sm-12 pt-5">
                        <div class="form-group">
                            <div class="input-group" style="width:200px">
                                <input type="number" class="form-control" name="money" id="amount_paypal" placeholder="USD"
                                       value="10">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-primary">$</button>
                                </div>

                            </div>
                            @error('money')
                            <span class="help-block has-error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Nap</button>

                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection()

