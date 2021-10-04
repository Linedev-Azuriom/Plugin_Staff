@csrf
<div class="card-body">
    <div class="form-group">
        <label for="nameInput">{{ trans('messages.fields.name') }}</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="nameInput"
               name="name"
               value="{{ old('name', $tag->name ?? '') }}" required>

        @error('name')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>

    <div class="form-group">
        <label for="colorInput">{{ trans('shop::admin.categories.enable') }}</label>
        <input type="color" class="form-control" id="colorInput"
               name="color" {{(old('color', $tag->color ?? ''))}}>
        @error('color')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
</div>
