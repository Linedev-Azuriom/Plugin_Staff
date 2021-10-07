@extends('admin.layouts.admin')

@section('title', trans('staff::admin.title'))


@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <h3>Création d'un staff</h3>
            <form action="{{ route('staff.admin.tags.update',$tag)}}" method="POST" id="staffForm">
                @include('staff::admin.tags._form')
                @method('PUT')

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> {{ trans('messages.actions.save') }}
                </button>

                <a href="{{ route('staff.admin.tags.destroy', $tag) }}" class="btn btn-danger" data-confirm="delete">
                    <i class="fas fa-trash"></i> {{ trans('messages.actions.delete') }}
                </a>
            </form>
        </div>
    </div>
@endsection
