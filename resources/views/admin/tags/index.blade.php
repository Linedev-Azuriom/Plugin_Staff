@extends('admin.layouts.admin')

@section('title', trans('staff::admin.title'))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <form action="{{ route('staff.admin.tags.store') }}" method="POST">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Création d'un tag
                                </h3>
                                @include('staff::admin.tags._form')
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> {{ trans('messages.actions.save') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-8">
                    <h3>Liste des tags</h3>

                </div>
            </div>
        </div>
@endsection
