@extends('layouts.admin')
@section('page_title', "Admin")
@section('content')
    <div class="tab-content kt-portlet">
        <!--begin::Tab pane-->
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label d-flex align-items-center justify-content-between w-100">
                <h3 class="kt-portlet__head-title">
                    BM
                </h3>
            </div>
        </div>
        <div id="kt_project_users_card_pane" class="tab-pane fade show active">
            <!--begin::Row-->
            <div class="row g-6 g-xl-9">
                <!--begin::Col-->
                @foreach($categories->where('type', \App\Models\Category::TAB_BM) as $category)
                    <div class="col-md-3 col-xxl-4">
                    <!--begin::Card-->
                    <div class="card">
                        <!--begin::Card body-->
                        <div class="card-body d-flex flex-center flex-column pt-12 p-9">
                            <!--begin::Avatar-->
                            <div class="symbol symbol-65px symbol-circle mb-5">
                                <img src="assets/media/flags/226-united-states.svg" alt="image" width="50">
                                <div class="bg-success position-absolute border border-4 border-white h-15px w-15px rounded-circle translate-middle start-100 top-100 ms-n3 mt-n3"></div>
                            </div>
                            <!--end::Avatar-->
                            <!--begin::Name-->
                            <a href="#" class="fs-4 text-gray-800 text-hover-primary fw-bolder mb-0">Karina Clark</a>
                            <!--end::Name-->
                            <!--begin::Position-->
                            <div class="fw-bold text-gray-400 mb-6">{{ $category->name }}</div>
                            <!--end::Position-->
                            <!--begin::Info-->
                            <div class="d-flex flex-center flex-wrap">
                                <!--begin::Stats-->
                                <div class="border border-gray-300 border-dashed rounded min-w-80px py-3 px-4 mb-3">
                                    <div class="fs-6 fw-bolder text-gray-700">{{ $category->price }}</div>
                                    <div class="fw-bold text-gray-400">USDT</div>
                                </div>
                                <!--end::Stats-->
                                <!--begin::Stats-->
                                <div class="border border-gray-300 border-dashed rounded min-w-80px py-3 px-4 mx-2 mb-3">
                                    <div class="fs-6 fw-bolder text-gray-700">{{ $category->products->count() }}</div>
                                    <div class="fw-bold text-gray-400">Total</div>
                                </div>
                                <!--end::Stats-->
                                <!--begin::Stats-->
                                <button class="btn {{ $category->products->count() == 0 ? "btn-dark" : "btn-primary" }}">{{ $category->products->count() == 0 ? "Het hang" : "Mua hang" }}</button>
                                <!--end::Stats-->
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                </div>
                @endforeach
            </div>
            <!--end::Row-->
        </div>
    </div>
    <div class="tab-content kt-portlet">
        <!--begin::Tab pane-->
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label d-flex align-items-center justify-content-between w-100">
                <h3 class="kt-portlet__head-title">
                    VIA
                </h3>
            </div>
        </div>
        <div id="kt_project_users_card_pane" class="tab-pane fade show active">
            <!--begin::Row-->
            <div class="row g-6 g-xl-9">
                <!--begin::Col-->
                @foreach($categories->where('type', \App\Models\Category::TAB_VIA) as $category)
                    <div class="col-md-3 col-xxl-4">
                    <!--begin::Card-->
                    <div class="card">
                        <!--begin::Card body-->
                        <div class="card-body d-flex flex-center flex-column pt-12 p-9">
                            <!--begin::Avatar-->
                            <div class="symbol symbol-65px symbol-circle mb-5">
                                <img src="assets/media/flags/226-united-states.svg" alt="image" width="50">
                                <div class="bg-success position-absolute border border-4 border-white h-15px w-15px rounded-circle translate-middle start-100 top-100 ms-n3 mt-n3"></div>
                            </div>
                            <!--end::Avatar-->
                            <!--begin::Name-->
{{--                            <a href="#" class="fs-4 text-gray-800 text-hover-primary fw-bolder mb-0">Karina Clark</a>--}}
                            <!--end::Name-->
                            <!--begin::Position-->
                            <div class="fw-bold text-gray-400 mb-6">{{ $category->name }}</div>
                            <!--end::Position-->
                            <!--begin::Info-->
                            <div class="d-flex flex-center flex-wrap">
                                <!--begin::Stats-->
                                <div class="border border-gray-300 border-dashed rounded min-w-80px py-3 px-4 mx-2 mb-3">
                                    <div class="fs-6 fw-bolder text-gray-700">{{ $category->price }}</div>
                                    <div class="fw-bold text-gray-400">USDT</div>
                                </div>
                                <!--end::Stats-->
                                <!--begin::Stats-->
                                <div class="border border-gray-300 border-dashed rounded min-w-80px py-3 px-4 mx-2 mb-3">
                                    <div class="fs-6 fw-bolder text-gray-700">{{ $category->products->count() }}</div>
                                    <div class="fw-bold text-gray-400">Total</div>
                                </div>
                                <!--end::Stats-->
                                <!--begin::Stats-->
                                <button class="btn {{ $category->products->count() == 0 ? "btn-dark" : "btn-primary" }}">{{ $category->products->count() == 0 ? "Het hang" : "Mua hang" }}</button>
                                <!--end::Stats-->
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                </div>
                @endforeach
            </div>
            <!--end::Row-->
        </div>
    </div>
    <div class="tab-content kt-portlet">
        <!--begin::Tab pane-->
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label d-flex align-items-center justify-content-between w-100">
                <h3 class="kt-portlet__head-title">
                    CLONE
                </h3>
            </div>
        </div>
        <div id="kt_project_users_card_pane" class="tab-pane fade show active">
            <!--begin::Row-->
            <div class="row g-6 g-xl-9">
                <!--begin::Col-->
                @foreach($categories->where('type', \App\Models\Category::TAB_CLONE) as $category)
                    <div class="col-md-3 col-xxl-4">
                    <!--begin::Card-->
                    <div class="card">
                        <!--begin::Card body-->
                        <div class="card-body d-flex flex-center flex-column pt-12 p-9">
                            <!--begin::Avatar-->
                            <div class="symbol symbol-65px symbol-circle mb-5">
                                <img src="assets/media/flags/226-united-states.svg" alt="image" width="50">
                                <div class="bg-success position-absolute border border-4 border-white h-15px w-15px rounded-circle translate-middle start-100 top-100 ms-n3 mt-n3"></div>
                            </div>
                            <!--end::Avatar-->
                            <!--begin::Name-->
{{--                            <a href="#" class="fs-4 text-gray-800 text-hover-primary fw-bolder mb-0">Karina Clark</a>--}}
                            <!--end::Name-->
                            <!--begin::Position-->
                            <div class="fw-bold text-gray-400 mb-6">{{ $category->name }}</div>
                            <!--end::Position-->
                            <!--begin::Info-->
                            <div class="d-flex flex-center flex-wrap">
                                <!--begin::Stats-->
                                <div class="border border-gray-300 border-dashed rounded min-w-80px py-3 px-4 mx-2 mb-3">
                                    <div class="fs-6 fw-bolder text-gray-700">{{ $category->price }}</div>
                                    <div class="fw-bold text-gray-400">USDT</div>
                                </div>
                                <!--end::Stats-->
                                <!--begin::Stats-->
                                <div class="border border-gray-300 border-dashed rounded min-w-80px py-3 px-4 mx-2 mb-3">
                                    <div class="fs-6 fw-bolder text-gray-700">{{ $category->products->count() }}</div>
                                    <div class="fw-bold text-gray-400">Total</div>
                                </div>
                                <!--end::Stats-->
                                <!--begin::Stats-->
                                <button class="btn {{ $category->products->count() == 0 ? "btn-dark" : "btn-primary" }}">{{ $category->products->count() == 0 ? "Het hang" : "Mua hang" }}</button>
                                <!--end::Stats-->
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                </div>
                @endforeach
            </div>
            <!--end::Row-->
        </div>
    </div>
@endsection()
