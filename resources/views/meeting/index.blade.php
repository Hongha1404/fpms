@extends('layouts.app')

@section('content')
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <!-- BEGIN: Subheader -->
    <div class="m-subheader">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title ">
                    {{ __('Quantity meeting') }} ({{ $meetings->count() }})
                </h3>
                <a href="{{ route('user.meeting.create') }}">
                    <button class="btn m-btn--pill btn-primary">
                        <i class="fa fa-plus"></i>
                        {{ __('Create new meeting') }}
                    </button>
                </a>
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
        <div class="row">
            @foreach($meetings as $meeting)
            <div class="col-lg-6">
                <!--begin::Portlet-->
                <div class="m-portlet">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <a href="{{ route('user.meeting.show', $meeting->id) }}" class="m-portlet__head-text">
                                    <span>
                                        {{ $meeting->name }} - {{$meeting->sprint->sprint }}<br>
                                        ({{ $meeting->sprint->release->project->name }}/{{ $meeting->sprint->release->release_date }})
                                    </span>
                                </a>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">
                            <ul class="m-portlet__nav">
                                <li class="m-portlet__nav-item">
                                    <a href="{{ route('user.meeting.edit', $meeting->id) }}" class="btn m-btn--pill btn-warning" data-toggle="tooltip" data-placement="bottom" title="Edit">
                                        <span>
                                            <i class="fa fa-edit"></i>
                                        </span>
                                    </a>
                                </li>
                                {{ Form::open([ 'method' => 'DELETE', 'route' => [ 'user.meeting.destroy', $meeting->id], 'class' => 'm-portlet__nav-item']) }}
                                    {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn m-btn--pill btn-danger']) }}
                                {{ Form::close() }}
                            </ul>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <!--begin::Section-->
                        <div class="m-section m-section--last">
                            <div class="m-section__content">
                                <!--begin::Preview-->
                                <div class="m-demo" data-code-preview="true" data-code-html="true" data-code-js="false">
                                    <div class="m-demo__preview">
                                        <ul class="m-nav">
                                            <li class="m-nav__item">
                                                <a class="m-nav__link">
                                                    <i class="m-nav__link-icon flaticon-info"></i>
                                                    <span class="m-nav__link-text">
                                                        {{ __('Meeting type') }}: {!! $meeting->meetingType->name !!}
                                                    </span>
                                                </a>
                                            </li>
                                            <li class="m-nav__item">
                                                <a class="m-nav__link">
                                                    <i class="m-nav__link-icon flaticon-info"></i>
                                                    <span class="m-nav__link-text">
                                                        {{ __('Location') }}: <p>{!! $meeting->location !!}</p>
                                                    </span>
                                                </a>
                                            </li>
                                            <li class="m-nav__item">
                                                <a class="m-nav__link">
                                                    <i class="m-nav__link-icon flaticon-info"></i>
                                                    <span class="m-nav__link-text">
                                                        {{ __('Hosting by') }}: {{ $meeting->hostingBy($meeting->hosting_by)->name }}
                                                    </span>
                                                </a>
                                            </li>
                                            @foreach($meeting->meetingMetas as $meetingMeta)
                                                @if($meetingMeta->meeting_key == 'meeting_time')
                                                    @foreach(json_decode($meetingMeta->meeting_value, true) as $meeting_value)
                                                        <li class="m-nav__item">
                                                            <a class="m-nav__link">
                                                                <i class="m-nav__link-icon flaticon-info"></i>
                                                                <span class="m-nav__link-text">
                                                                    {{ __('Date') }}:
                                                                    {{ $meeting_value['date'] }}
                                                                </span>
                                                            </a>
                                                        </li>
                                                        <li class="m-nav__item">
                                                            <a class="m-nav__link">
                                                                <i class="m-nav__link-icon flaticon-info"></i>
                                                                <span class="m-nav__link-text">
                                                                    {{ __('Time') }}:
                                                                    {{ $meeting_value['time_start']}} - {{ $meeting_value['time_end'] }}
                                                                </span>
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                @endif
                                                @if($meetingMeta->meeting_key == 'meeting_attendees')
                                                    @foreach(json_decode($meetingMeta->meeting_value, true) as $meeting_value)
                                                        <li class="m-nav__item">
                                                            <a class="m-nav__link">
                                                                <i class="m-nav__link-icon flaticon-info"></i>
                                                                <span class="m-nav__link-text">
                                                                {{ __('Attendees') }}: 
                                                                <?php 
                                                                    foreach($meeting_value as $key => $value) {
                                                                        echo $key . ' - ';
                                                                        foreach( json_decode($value, true) as $position) echo $position . ', ';
                                                                    }
                                                                ?>
                                                                </span>
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <!--end::Preview-->
                                <!--begin::Dropdown-->
                                <div class="m-dropdown m-dropdown--inline  m-dropdown--arrow" data-dropdown-toggle="click">
                                    <a href="{{ route('user.meeting.show', $meeting->id) }}" class="btn btn-success">
                                        {{ __('Detail') }}
                                    </a>
                                </div>
                                <!--end::Dropdown-->
                            </div>
                        </div>
                        <!--end::Section-->
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
