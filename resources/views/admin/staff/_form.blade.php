@csrf
<div class="card-body">
    @if(isset($staffs))
        <input type="hidden" name="position" value="{{$staffs->count() + 1}}">
    @endif
    <div class="form-group">
        <label class="form-label" for="nameInput">{{ trans('messages.fields.name') }}</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="nameInput"
               name="name"
               value="{{ old('name', $staff->name ?? '') }}" required>

        @error('name')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
    <div class="form-group">
        <label class="form-label" for="descriptionInput">{{ trans('messages.fields.description') }}</label>

        <textarea class="form-control html-editor @error('description') is-invalid @enderror" id="descriptionInput"
                  name="description" rows="1">{{ old('description', $staff->description ?? '') }}</textarea>

        @error('description')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
    <div class="form-group">
        <label class="form-label" for="imageInput">{{ trans('messages.fields.image') }}</label>
        @if(game()->name() === 'Minecraft')
            <div class="small">{{ trans('staff::admin.staff.default-skin') }}</div>
        @endif
        <div class="custom-file">
            <input type="file" class="form-control  @error('image') is-invalid @enderror" id="imageInput"
                   name="image" accept=".jpg,.jpeg,.jpe,.png,.gif,.bmp,.svg,.webp" data-image-preview="imagePreview">
            <label class="form-label"
                   data-browse="{{ trans('messages.actions.browse') }}">{{ trans('messages.actions.choose_file') }}</label>

            @error('image')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>

        <img src="{{ ($staff->image ?? false) ? $staff->imageUrl() : '#' }}"
             class="mt-2 img-fluid rounded img-preview {{ ($staff->image ?? false) ? '' : 'd-none' }}" alt="Image"
             id="imagePreview">
    </div>
    <div class="form-group">
        <label class="form-label" for="">Tags</label>
        <select name="tags[]" class="form-control" multiple="multiple">
            @foreach($tags as $tag)
                <option value="{{ $tag->id }}" {{isset($staff) ?$staff->isSelected($tag->id):""}}>
                    {{ $tag->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <div class="card-text my-2">
            {{ trans('staff::admin.fontawesome') }}
            <a href="https://fontawesome.com/icons?d=gallery" title="fontawesome" target="_blank">fontawesome</a>
            <div class="small color-error">{{ trans('staff::admin.link.is-create') }}</div>
        </div>

        <div class="my-2">
            <button type="button" id="addLinkButton" class="btn btn-sm btn-success">
                <i class="fas fa-plus"></i> {{ trans('messages.actions.add') }}
            </button>
        </div>
        <div id="links">
            @forelse($staff->links ?? [] as $key => $link)
                <input type="hidden" name="link[{{$key}}][id]" value="{{ $link->id }}">
                <div class="row g-0 sortable-dropdown link-parent" data-link-id="{{ $link->id }}">
                    <div class="col-auto">
                        <i class="fas fa-arrows-alt sortable-handle"></i>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="link[{{$key}}][icon]"
                               placeholder="{{ trans('messages.fields.icon') }}"
                               value="{{old('link.'.$key.'.icon', $link->icon ?? '')}}">
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="link[{{$key}}][name]"
                               placeholder="{{ trans('messages.fields.name') }}"
                               value="{{old('link'.$key.'name', $link->name ?? '')}}">
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" class="form-control" name="link[{{$key}}][url]"
                                   placeholder="{{ trans('messages.fields.url') }}"
                                   value="{{ old('link'.$key.'url', $link->url ?? '')}}">
                            <div class="input-group-append">
                                <a href="{{ route('staff.admin.links.destroy', old('link'.$key.'url', $link ?? '')) }}"
                                   class="btn btn-outline-danger " title="{{ trans('messages.actions.delete') }}"
                                   data-toggle="tooltip" data-confirm="delete">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="row g-0">
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="link[{index}][icon]"
                               placeholder="{{ trans('messages.fields.icon') }}"
                               value="{{old('link.*.icon', $staff->link->icon ?? '')}}">

                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="link[{index}][name]"
                               placeholder="{{ trans('messages.fields.name') }}"
                               value="{{old('link.*.name', $staff->link->name ?? '')}}">
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" class="form-control" name="link[{index}][url]"
                                   placeholder="{{ trans('messages.fields.url') }}"
                                   value="{{ old('link.*.url', $staff->link->url ?? '')}}">
                            <div class="input-group-append">
                                <button class="btn btn-outline-danger link-remove" type="button">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>

