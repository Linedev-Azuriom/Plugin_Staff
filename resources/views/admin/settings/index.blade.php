@extends('admin.layouts.admin')

@section('title', trans('staff::admin.setting.title'))

@section('content')
    <div class="row">
        <div class="col-xl-8 my-3 mx-auto">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h3>{{ trans('staff::admin.setting.title') }}</h3>
                    <form action="{{ route('staff.admin.settings.update', $setting) }}" method="POST">
                        @method('PUT')

                        @include('staff::admin.settings._form')
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> {{ trans('messages.actions.save') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
