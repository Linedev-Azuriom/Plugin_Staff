@csrf
<div class="card-body">
    <div class="form-group">
        <label for="nameInput">{{ trans('messages.fields.name') }}</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="nameInput"
               name="name"
               value="{{ old('name', $staff->name ?? '') }}" required>

        @error('name')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
    <div class="form-group">
        <label for="descriptionInput">{{ trans('messages.fields.description') }}</label>
        <input type="text" class="form-control @error('description') is-invalid @enderror" id="descriptionInput"
               name="description"
               value="{{ old('description', $staff->description ?? '') }}" required>

        @error('description')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
    <div class="form-group col-md-6">
        <label for="imageInput">{{ trans('messages.fields.image') }}</label>
        <div class="custom-file">
            <input type="file" class="custom-file-input  @error('avatar') is-invalid @enderror" id="imageInput" name="avatar" accept=".jpg,.jpeg,.jpe,.png,.gif,.bmp,.svg,.webp" data-image-preview="imagePreview">
            <label class="custom-file-label" data-browse="{{ trans('messages.actions.browse') }}">{{ trans('messages.actions.choose-file') }}</label>

            @error('avatar')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>

        <img src="{{ ($staff->avatar ?? false) ? $staff->imageUrl() : '#' }}" class="mt-2 img-fluid rounded img-preview {{ ($staff->staff ?? false) ? '' : 'd-none' }}" alt="Image" id="imagePreview">
    </div>

{{--    <div class="form-group">--}}
{{--        <label for="colorInput">{{ trans('shop::admin.categories.enable') }}</label>--}}
{{--        <input type="color" class="form-control" id="colorInput"--}}
{{--               name="color" {{(old('color', $staff->color ?? ''))}}>--}}
{{--        @error('color')--}}
{{--        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>--}}
{{--        @enderror--}}
{{--    </div>--}}
</div>
