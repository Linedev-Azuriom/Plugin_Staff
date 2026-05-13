@extends('admin.layouts.admin')

@section('title', trans('staff::admin.staff.title-edit') . ' : ' . $staff->name)

@push('footer-scripts')
    <script src="{{ asset('vendor/sortablejs/Sortable.min.js') }}"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {

        // ---- Sortable des liens ----
        const linksEl = document.getElementById('links');
        if (linksEl) {
            Sortable.create(linksEl, {
                animation: 150,
                handle: '.sortable-handle',
                onEnd: function () {
                    const items = Array.from(linksEl.children)
                        .filter(function(c) { return c.dataset.linkId; })
                        .map(function(c) { return { id: c.dataset.linkId }; });
                    axios.post('{{ route('staff.admin.links.update-order') }}', { links: items })
                        .catch(console.error);
                },
            });
        }

        // ---- Renommage des inputs link[] à la soumission ----
        const staffForm = document.getElementById('staffForm');
        if (staffForm) {
            staffForm.addEventListener('submit', function () {
                let i = 0;
                linksEl.querySelectorAll('.link-parent').forEach(function (el) {
                    el.querySelectorAll('input').forEach(function (input) {
                        input.name = input.name.replace('{index}', i.toString());
                    });
                    i++;
                });
            });
        }

        // ---- Ajout / suppression de liens ----
        function addLinkRemoveListener(btn) {
            btn.addEventListener('click', function () {
                const parent = btn.closest('.link-parent');
                if (parent) parent.remove();
            });
        }

        document.querySelectorAll('.link-remove').forEach(addLinkRemoveListener);

        const addLinkBtn = document.getElementById('addLinkButton');
        if (addLinkBtn) {
            addLinkBtn.addEventListener('click', function () {
                const tpl = document.getElementById('linkRowTemplate');
                const clone = tpl.content.cloneNode(true);
                const wrap = clone.querySelector('.link-parent');
                addLinkRemoveListener(wrap.querySelector('.link-remove'));
                linksEl.appendChild(wrap);
            });
        }
    });
    </script>
@endpush

@section('content')

    {{-- Template lien (static, sécurisé) --}}
    <template id="linkRowTemplate">
        <div class="row g-1 mb-1 align-items-center link-parent">
            <div class="col-auto">
                <i class="bi bi-arrows-move sortable-handle text-muted" style="cursor:grab"></i>
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control form-control-sm"
                       name="link[{index}][icon]"
                       placeholder="{{ trans('messages.fields.icon') }}">
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control form-control-sm"
                       name="link[{index}][name]"
                       placeholder="{{ trans('messages.fields.name') }}">
            </div>
            <div class="col">
                <div class="input-group input-group-sm">
                    <input type="text" class="form-control"
                           name="link[{index}][url]"
                           placeholder="{{ trans('messages.fields.url') }}">
                    <button class="btn btn-outline-danger link-remove" type="button">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
            </div>
        </div>
    </template>

    <div class="card shadow-sm border-0">
        <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('staff.admin.index') }}"
                   class="btn btn-sm btn-outline-secondary"
                   title="{{ trans('messages.actions.back') }}">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <span class="fw-semibold">
                    {{ trans('staff::admin.staff.title-edit') }} :
                    <span class="text-primary">{{ $staff->name }}</span>
                </span>
            </div>
            <a href="{{ route('staff.admin.staff.destroy', $staff) }}"
               class="btn btn-sm btn-danger"
               data-confirm="delete">
                <i class="bi bi-trash-fill me-1"></i> {{ trans('messages.actions.delete') }}
            </a>
        </div>

        <div class="card-body">
            <form action="{{ route('staff.admin.staff.update', $staff) }}"
                  method="POST" id="staffForm" enctype="multipart/form-data">
                @method('PUT')

                @include('admin.elements.editor', [
                    'imagesUploadUrl' => route('admin.posts.attachments.store', $staff)
                ])

                @include('staff::admin.staff._form')

                <div class="d-flex gap-2 mt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> {{ trans('messages.actions.save') }}
                    </button>
                    <a href="{{ route('staff.admin.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> {{ trans('messages.actions.back') }}
                    </a>
                </div>
            </form>
        </div>
    </div>

@endsection
