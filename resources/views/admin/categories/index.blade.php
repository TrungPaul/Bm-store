@extends('layouts.admin')
@section('page_title' , 'Category ')

@section('content')
                <!--begin::Portlet-->
                <div class="kt-portlet">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label d-flex align-items-center justify-content-between w-100">
                            <h3 class="kt-portlet__head-title">
                                @lang('common.page.category'): {{ $categories->total() }}
                            </h3>
                        </div>
                    </div>
{{--                        @include('components.add_button', ['route' => route('category.create') ])--}}
                    @include('admin.categories.seach')

                    <div class="kt-portlet__body">
                        <div class="kt-section">
                            <div class="kt-section__content">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>@lang('common.ref_no')</th>
                                            <th>@lang('common.name')</th>
                                            <th>@lang('common.price')</th>
                                            <th>@lang('common.description')</th>
                                            <th>@lang('common.type')</th>
                                            <th>@lang('common.status')</th>
                                            <th>@lang('common.created_at')</th>
                                            <th>@lang('common.action')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($categories as $category)
                                            <tr>
                                                <td>{{ $category->id }}</td>
                                                <td>{{ $category->name }}</td>
                                                <td>{{ $category->price }}</td>
                                                <td>{{ $category->description }}</td>
                                                <td>@lang('config.tab.' .$category->type)</td>
                                                <td>
                                                    <span class="btn btn-block btn-bold btn-sm btn-font-sm  btn-label-{{ $category->status == 1 ? 'success' : 'dark'}}">
                                                        @lang('config.status.' .$category->status)
                                                    </span>
                                                </td>
                                                <td>{{ $category->created_at }}</td>
                                                <td class="text-center">
                                                        <a href="{{ route('category.edit', $category) }}" class="btn btn-sm btn-clean btn-icon btn-icon-md">
                                                            <i class="la la-edit"></i>
                                                        </a>

                                                </td>
                                            </tr>
                                        @empty
                                            @include('partials.table_empty_row')
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <div class="pull-right">
                                    {!! $categories->appends(Request::except('page'))->render() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Portlet-->


@endsection
