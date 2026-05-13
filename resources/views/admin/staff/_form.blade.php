@csrf
@if(isset($staffs))
    <input type="hidden" name="position" value="{{ $staffs->count() + 1 }}">
@endif

<div class="mb-3">
    <label class="form-label fw-semibold" for="nameInput">{{ trans('messages.fields.name') }}</label>
    <input type="text" class="form-control @error('name') is-invalid @enderror"
           id="nameInput" name="name"
           value="{{ old('name', $staff->name ?? '') }}" required>
    @error('name')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label fw-semibold" for="descriptionInput">
        {{ trans('messages.fields.description') }}
    </label>
    <textarea class="form-control html-editor @error('description') is-invalid @enderror"
              id="descriptionInput" name="description"
              rows="1">{{ old('description', $staff->description ?? '') }}</textarea>
    @error('description')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
</div>

<div class="row g-3 mb-3">
    <div>
        <label class="form-label fw-semibold" for="imageInput">{{ trans('messages.fields.image') }}</label>
        @if(game()->name() === 'Minecraft')
            <div class="small text-muted mb-1">{{ trans('staff::admin.staff.default-skin') }}</div>
        @endif
        <input type="file" class="form-control @error('image') is-invalid @enderror"
               id="imageInput" name="image"
               accept=".jpg,.jpeg,.jpe,.png,.gif,.bmp,.svg,.webp"
               data-image-preview="imagePreview">
        @error('image')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
        <img src="{{ ($staff->image ?? false) ? $staff->imageUrl() : '#' }}"
             class="mt-2 img-fluid rounded img-preview {{ ($staff->image ?? false) ? '' : 'd-none' }}"
             style="max-height:120px;object-fit:cover"
             alt="Image" id="imagePreview">
    </div>
    <div>
        <label class="form-label fw-semibold">Tags</label>
        <select name="tags[]" class="form-control" multiple="multiple" size="4">
            @foreach($tags as $tag)
                <option value="{{ $tag->id }}"
                        {{ isset($staff) ? $staff->isSelected($tag->id) : '' }}>
                    {{ $tag->name }}
                </option>
            @endforeach
        </select>
    </div>
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">{{ trans('staff::admin.link.index') }}</label>
    <div id="links" class="d-flex flex-column gap-1">
        @forelse($staff->links ?? [] as $key => $link)
            <input type="hidden" name="link[{{ $key }}][id]" value="{{ $link->id }}">
            <div class="row g-1 align-items-center link-parent" data-link-id="{{ $link->id }}">
                <div class="col-auto">
                    <i class="bi bi-arrows-move sortable-handle text-muted" style="cursor:grab"></i>
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control form-control-sm"
                           name="link[{{ $key }}][icon]"
                           placeholder="{{ trans('messages.fields.icon') }}"
                           value="{{ old('link.'.$key.'.icon', $link->icon ?? '') }}">
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control form-control-sm"
                           name="link[{{ $key }}][name]"
                           placeholder="{{ trans('messages.fields.name') }}"
                           value="{{ old('link.'.$key.'.name', $link->name ?? '') }}">
                </div>
                <div class="col">
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control"
                               name="link[{{ $key }}][url]"
                               placeholder="{{ trans('messages.fields.url') }}"
                               value="{{ old('link.'.$key.'.url', $link->url ?? '') }}">
                        <a href="{{ route('staff.admin.links.destroy', $link->id) }}"
                           class="btn btn-outline-danger"
                           title="{{ trans('messages.actions.delete') }}"
                           data-confirm="delete">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="row g-1 mb-1 align-items-center link-parent">
                <div class="col-auto">
                    <i class="bi bi-arrows-move sortable-handle text-muted" style="cursor:grab;visibility:hidden"></i>
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
        @endforelse
    </div>

    <div class="mt-2 text-end">
        <button type="button" id="addLinkButton" class="btn btn-sm btn-outline-success">
            <i class="bi bi-plus-lg me-1"></i> {{ trans('messages.actions.add') }}
        </button>
    </div>
    <p class="small text-muted mt-2 mb-0">
        @lang('messages.icons')
        <br><span class="text-warning-emphasis">{{ trans('staff::admin.link.is-create') }}</span>
    </p>
</div>
