@csrf
<div class="card-body">
    <input type="hidden" class="form-control" id="nameInput" name="name"
           value="global" required>
d
    @foreach($setting->setting ?? [] as $setting)
        <div class="form-group">
            <label for="descriptionInput">{{ trans('messages.fields.description') }}</label>
            <input type="text" class="form-control @error('setting.description') is-invalid @enderror"
                   id="descriptionInput"
                   name="setting[description]"
                   value="{{ old('description', $setting->description ?? '') }}">

            @error('setting.description')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
    @endforeach
</div>

