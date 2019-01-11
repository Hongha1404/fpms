@extends('layouts.app')

@section('content')
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <!-- BEGIN: Subheader -->
    <div class="m-subheader">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title ">
                    {{ __('Create New Meeting') }}
                </h3>
            </div>
            <div>
                <span class="m-subheader__daterange" id="m_dashboard_daterangepicker">
                    <span class="m-subheader__daterange-label">
                        <span class="m-subheader__daterange-title"></span>
                        <span class="m-subheader__daterange-date m--font-brand"></span>
                    </span>
                    <a href="#" class="btn btn-sm btn-brand m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill">
                        <i class="la la-angle-down"></i>
                    </a>
                </span>
            </div>
        </div>
    </div>
    <!-- END: Subheader -->
    <div class="m-content">
        {{ Form::open([ 'method' => 'POST', 'files' => true, 'route' => [ 'user.meeting.store' ] ]) }}
            <div class="row">
                <div class="col-lg-8">
                    <div class="form-group m-form__group">
                        <label>
                            <h5>
                                {{ __('Name') }}
                            </h5>
                        </label>
                        <div class="m-input-icon m-input-icon--left m-input-icon--right">
                            {{ Form::text('name', null, ['class' => 'form-control m-input m-input--pill', 'placeholder' => __('Name meeting')]) }}
                            <span class="m-input-icon__icon m-input-icon__icon--left">
                                <span>
                                    <i class="la la-edit"></i>
                                </span>
                            </span>
                        </div>
                    </div>
                    <div class="m-select2 m-select2--pill">
                        <label>
                            <h5>
                                {{ __('Sprint') }}
                            </h5>
                        </label>
                        {!! Form::select('sprint', $sprints->pluck('sprint', 'id'), null, ['class' => 'form-control m-select2', 'id' => 'm_select2_12_1']) !!}
                    </div>
                    <div class="m--space-10"></div>
                    <div class="m-select2 m-select2--pill">
                        <label>
                            <h5>
                                {{ __('Meeting Type') }}
                            </h5>
                        </label>
                        {!! Form::select('meeting_type', $meetingTypes->pluck('name', 'id'), null, ['class' => 'form-control m-select2', 'id' => 'm_select2_12_2']) !!}
                    </div>
                    <div class="m--space-10"></div>
                    <div class="form-group m-form__group">
                        <label>
                            <h5>{{ __('Date Meeting') }}</h5>
                        </label>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="input-group date" id="m_datepicker_1">
                                {{ Form::text('date', null, ['class' => 'form-control m-input', 'readonly' => '', 'placeholder' => __('Select date')]) }}
                                <span class="input-group-addon">
                                    <i class="la la-calendar-check-o"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group m-form__group">
                        <label>
                            <h5>{{ __('Time Start') }}</h5>
                        </label>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="input-group timepicker">
                                {{ Form::text('time_start', null, ['class' => 'form-control m-input', 'readonly' => '', 'placeholder' => __('Select time'), 'id' => 'm_timepicker_1']) }}
                                <span class="input-group-addon">
                                    <i class="la la-clock-o"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group m-form__group">
                        <label>
                            <h5>{{ __('Time End') }}</h5>
                        </label>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="input-group timepicker">
                                {{ Form::text('time_end', null, ['class' => 'form-control m-input', 'readonly' => '', 'placeholder' => __('Select time'), 'id' => 'm_timepicker_1']) }}
                                <span class="input-group-addon">
                                    <i class="la la-clock-o"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group m-form__group">
                        <label>
                            <h5>
                                {{ __('Location') }}
                            </h5>
                        </label>
                        <div class="m-input-icon m-input-icon--left m-input-icon--right">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                {{ Form::textarea('location', null, ['class' => 'summernote']) }}
                            </div>
                        </div>
                    </div>
                    <div class="m-select2 m-select2--pill">
                        <label>
                            <h5>
                                {{ __('Attendees') }}
                            </h5>
                        </label>
                        {!! Form::select('attendees[]', $users->pluck('name', 'id'), null, ['class' => 'form-control m-select2', 'id' => 'm_select2_12_3', 'multiple' => 'multiple']) !!}
                    </div>
                    <div class="m--space-10"></div>
                    <div class="m-select2 m-select2--pill">
                        <label>
                            <h5>
                                {{ __('Hosting by') }}
                            </h5>
                        </label>
                        {!! Form::select('hosting', $users->pluck('name', 'id'), null, ['class' => 'form-control m-select2', 'id' => 'm_select2_12_4']) !!}
                    </div>
                    <div class="m--space-10"></div>
                    <div class="form-group m-form__group">
                        <label>
                            <h5>
                                {{ __('Time Keeper') }}
                            </h5>
                        </label>
                        <div class="m-input-icon m-input-icon--left m-input-icon--right">
                            {{ Form::text('time_keeper', null, ['class' => 'form-control m-input m-input--pill', 'placeholder' => __('Time Keeper')]) }}
                            <span class="m-input-icon__icon m-input-icon__icon--left">
                                <span>
                                    <i class="la la-edit"></i>
                                </span>
                            </span>
                        </div>
                    </div>
                    {!! Form::submit( __('CREATE'), ['class' => 'btn m-btn--pill btn-accent']) !!}
                    <a class="btn m-btn--pill btn-metal" href="{{ route('user.release.index') }}">{{ __('CANCEL') }}</a>
                </div>
            </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection
@push('js')
<script src="{{ asset('assets/js/summernote.js') }}"></script>
<script src="{{ asset('assets/js/select2.js') }}"></script>
<script src="{{ asset('assets/js/datepicker.js') }}"></script>
<script src="{{ asset('assets/js/timepicker.init.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#m_select2_12_1').change(function() {
            var id = $(this).val();
            var users = [] ;
            $.ajax({
                url : 'getUser/' + id,
                type : 'get',
                dataType : 'json',
                success : function (result){
                    $.each (result, function (key, value)
                    {
                        users[key] = "<option value='" + value.id + "'>" + value.name + "</option>";
                    });
                    $('#m_select2_12_3').html(users);
                    $('#m_select2_12_4').html(users);
                }
            });
        });
    });
</script>
@endpush
