@csrf
<div class="card-body">
    <div class="form-group">
        <label for="pseudoInput">{{ trans('messages.fields.name') }}</label>
        <input type="text" class="form-control @error('pseudo') is-invalid @enderror" id="pseudoInput"
               name="pseudo"
               value="{{ old('pseudo', $staff->pseudo ?? '') }}" required>

        @error('pseudo')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
    <div class="form-group">
        <label for="descriptionInput">{{ trans('messages.fields.description') }}</label>
        <input type="text" class="form-control @error('description') is-invalid @enderror" id="descriptionInput"
               name="description"
               value="{{ old('description', $staff->description ?? '') }}">

        @error('description')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
    <div class="form-group">
        <label for="imageInput">{{ trans('messages.fields.image') }}</label>
        <div class="custom-file">
            <input type="file" class="custom-file-input  @error('avatar') is-invalid @enderror" id="imageInput"
                   name="avatar" accept=".jpg,.jpeg,.jpe,.png,.gif,.bmp,.svg,.webp"
                   data-image-preview="imagePreview">
            <label class="custom-file-label"
                   data-browse="{{ trans('messages.actions.browse') }}">{{ trans('messages.actions.choose-file') }}</label>

            @error('avatar')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>

        <img src="{{ ($staff->avatar ?? false) ? '' : '#' }}"
             class="mt-2 img-fluid rounded img-preview {{ ($staff->avatar ?? false) ? '' : 'd-none' }}"
             alt="Image" id="imagePreview">
    </div>
    <div class="form-group">
        <label for="">Tags</label>
        <select name="tags[]" class="form-control" multiple="multiple">
            @foreach($tags as $tag)
                <option value="{{ $tag->id }}" {{isset($staff) ?$staff->isSelected($tag->id):""}}>
                    {{ $tag->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <div class="card-text mb-2">
            {{ trans('theme::lang.fontawesome') }}
            <a href="https://fontawesome.com/icons?d=gallery" title="fontawesome" target="_blank">fontawesome</a>
        </div>
        <div id="links">
            @forelse($staff->links ?? [] as $link)
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <input type="text" class="form-control @error('link.*.icon') is-invalid @enderror"
                               name="link[*][icon]"
                               placeholder="{{ trans('theme::lang.icon') }}"
                               value="{{old('link.*.icon', $link->icon ?? '')}}">
                        @error('link.*.icon')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <input type="text" class="form-control  @error('link.*.name') is-invalid @enderror"
                               name="link[*][name]"
                               placeholder="{{ trans('theme::lang.name') }}"
                               value="{{old('link.*.name', $link->name ?? '')}}">
                        @error('link.*.name')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <div class="input-group">
                            <input type="text" class="form-control  @error('link.*.url') is-invalid @enderror"
                                   name="link[*][url]"
                                   placeholder="{{ trans('theme::lang.link') }}"
                                   value="{{ old('link.*.url', $link->url ?? '')}}">
                            <div class="input-group-append">
                                <button class="btn btn-outline-danger link-remove" type="button">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            @error('link.*.url')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>
                </div>
            @empty
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <input type="text" class="form-control @error('link.*.icon') is-invalid @enderror"
                               name="link[*][icon]"
                               placeholder="{{ trans('theme::lang.icon') }}"
                               value="{{old('link.*.icon', $staff->link->icon ?? '')}}">
                        @error('link.*.icon')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <input type="text" class="form-control  @error('link.*.name') is-invalid @enderror"
                               name="link[*][name]"
                               placeholder="{{ trans('theme::lang.name') }}"
                               value="{{old('link.*.name', $staff->link->name ?? '')}}">
                        @error('link.*.name')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <div class="input-group">
                            <input type="text" class="form-control  @error('link.*.url') is-invalid @enderror"
                                   name="link[*][url]"
                                   placeholder="{{ trans('theme::lang.link') }}"
                                   value="{{ old('link.*.url', $staff->link->url ?? '')}}">
                            <div class="input-group-append">
                                <button class="btn btn-outline-danger link-remove" type="button">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            @error('link.*.url')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
        <div class="mb-2">
            <button type="button" id="addLinkButton" class="btn btn-sm btn-success">
                <i class="fas fa-plus"></i> {{ trans('messages.actions.add') }}
            </button>
        </div>
    </div>
</div>

