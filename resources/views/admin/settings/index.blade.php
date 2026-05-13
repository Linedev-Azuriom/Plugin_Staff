
<div class="card shadow mb-4">
    <div class="card-header d-flex align-items-center gap-2">
        <i class="bi bi-sliders"></i>
        <span class="fw-semibold">{{ trans('staff::admin.setting.title') }}</span>
    </div>
    <div class="card-body">
        <form action="{{ route('staff.admin.settings.update') }}" method="POST">
            @method('PUT')
            @include('staff::admin.settings._form')
            <button type="submit" class="btn btn-primary mt-3">
                <i class="bi bi-save me-1"></i> {{ trans('messages.actions.save') }}
            </button>
        </form>
    </div>
</div>
