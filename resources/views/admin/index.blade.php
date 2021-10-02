@extends('admin.layouts.admin')

@section('title', trans('staff::admin.title'))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
{{--            <form action="{{ route('staff.admin.store') }}" method="POST">--}}
{{--                @include('shop::admin.categories._form')--}}

{{--                <button type="submit" class="btn btn-primary">--}}
{{--                    <i class="fas fa-save"></i> {{ trans('messages.actions.save') }}--}}
{{--                </button>--}}
{{--            </form>--}}
        </div>
    </div>
@endsection
