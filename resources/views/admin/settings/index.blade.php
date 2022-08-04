
<div class="card shadow mb-4">
    <div class="card-header">
        <h3 class="mb-0">{{ trans('staff::admin.setting.title') }}</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('staff.admin.settings.update', $setting) }}" method="POST">
            @method('PUT')

            @include('staff::admin.settings._form')
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
            </button>
        </form>
    </div>
</div>
