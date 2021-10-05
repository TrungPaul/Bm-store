<div class="kt-portlet__body">
    <div class="kt-section margin-none">
        <div class="kt-section__content">
            <div class="kt-form kt-form--label-right">
                {!! Form::open(['url' => route('user.index'), 'method' => 'GET']) !!}
                <div class="row align-items-center">
                    <div class="col-md-4 col-sm-12">
                        @component('components.text_input',
                            [
                                'name' => 'key',
                                'label' => 'Search',
                                'value' => Request::get('key') ?? '',
                                'attributes' => [
                                    'class' => 'form-control',
                                ]
                            ]
                        ) @endcomponent
                    </div>

                    <div class="col-md-2 col-sm-6 pt-5">
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-search"></i>{{ __('common.search') }}
                        </button>
                    </div>
                    <div class="col-md-6 col-sm-6 pt-5 d-flex justify-content-end">
                        <div class="kt-subheader__wrapper">
                            <a href="{{ route('user.create') }}"
                               class="btn btn btn-success text-white kt-subheader__btn-success">
                                <i class="fa fa-plus-circle"></i> @lang('common.add_new')
                            </a>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
