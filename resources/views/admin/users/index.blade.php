@extends('layouts.admin')
@section('page_title' , @trans('common.page.user'))

@section('content')
    <!--begin::Portlet-->
    <div class="kt-portlet">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label d-flex align-items-center justify-content-between w-100">
                <h3 class="kt-portlet__head-title">
                    @lang('common.page.user'): {{ $users->total() }}
                </h3>
            </div>
        </div>
        {{--                        @include('components.add_button', ['route' => route('category.create') ])--}}
        @include('admin.users.search')

        <div class="kt-portlet__body">
            <div class="kt-section">
                <div class="kt-section__content">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>@lang('common.ref_no')</th>
                                <th>@lang('common.name')</th>
                                <th>@lang('common.email')</th>
                                <th>@lang('common.phone')</th>
                                <th>@lang('common.balance')</th>
                                <th>@lang('common.status')</th>
                                <th>@lang('common.created_at')</th>
                                <th>@lang('common.action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>{{ $user->balance }}</td>
{{--                                    <td>@lang('config.tab.' .$user->type)</td>--}}
                                    <td>
                                        <span class="btn btn-block btn-bold btn-sm btn-font-sm  btn-label-{{ $user->status == 1 ? 'success' : 'dark'}}">
                                            @lang('config.status.' .$user->status)
                                        </span>
                                    </td>
                                    <td>{{ $user->created_at }}</td>
                                    <td class="text-center">
                                        {!! Form::open(['route' => ['password.reset.default', $user->id] , 'method' => 'post', 'id' => 'form-reset-pass' ]) !!}
                                        <a href="javascript:;" onclick="resetPass()" title="Reset pass default:123456" class="btn btn-sm btn-clean btn-icon btn-icon-md">
                                            <i class="la la-unlock-alt"></i>
                                        </a>
                                        {!! Form::close() !!}
                                        <a href="javascript:void(0)" id="edit-user" data-toggle="modal" data-target="#exampleModal" data-id="{{ $user->id }}"
                                           class="btn btn-sm btn-clean btn-icon btn-icon-md">
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
                        {!! $users->appends(Request::except('page'))->links('components.pagination') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end::Portlet-->
    <div class="modal fade" id="exampleModal" data-user-id="" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('common.change_password')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <input type="hidden" name="id" id="user_id">
                            <label for="recipient-name" class="col-form-label required-flag">Password:</label>
                            <input type="text" name="password" class="form-control" id="new_pass" required>
                            <span id="pass-error"></span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="save-pass" onclick="handleSave()" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("a#edit-user").on('click', function (e) {
            var id = $(this).data('id');
            $('#user_id').val(id);
        });

        function handleSave() {
            let id = $('#user_id').val();
            let new_pass = $('#new_pass').val();
            if ($.trim(new_pass) == '')
            {
                var error = $('#pass-error')
                    error.text('Không được để trống mật khẩu');
                    error.addClass('help-block has-error');
                return false;
            }

            $.ajax({
                type: 'PUT',
                url: '/admin/user/' + id,
                data: {
                    id: id,
                    password: new_pass,
                    type: 'CHANGE_PASS'
                },
                success: function (data)
                {
                    $('#new_pass').val('');
                    $('#exampleModal').modal('toggle');
                    toastr.success(data.message);
                },
                error: function (res)
                {
                    toastr.error(res.message);
                }
            })
        }

        function resetPass()
        {
            $('#form-reset-pass').submit();
        }
    </script>
@endsection
