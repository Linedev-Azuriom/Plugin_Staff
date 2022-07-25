@csrf
<div class="card-body">
    <div class="mb-3">
        <div class="form-check  form-switch">
            <input type="checkbox" class="form-check-input" id="settingDescription" name="description"
                   @if($setting->settings()->settings->description ?? true) checked @endif>
            <label class="form-check-label"
                   for="settingDescription">{{ trans('staff::admin.setting.settings.description') }}</label>
        </div>
    </div>
    <div class="mb-3">
        <div class="form-check  form-switch">
            <input type="checkbox" class="form-check-input" id="settingEffect" name="effect"
                   @if($setting->settings()->settings->effect ?? true) checked @endif>
            <label class="form-check-label"
                   for="settingEffect">{{ trans('staff::admin.setting.settings.effect') }}</label>
        </div>
    </div>
    <div class="card">
        <div class="card-header">Styles</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <label for="exampleFormControlInput1" class="form-label">Style</label>
                    <small class="d-block">{{ trans('staff::admin.setting.settings.style') }}</small>
                    <select class="form-select form-select-lg mb-3" name="style" aria-label="Style">
                        <option value="1" @if(isset($setting->settings()->settings->style) && $setting->settings()->settings->style == '1') selected @endif>Slider
                        </option>
                        <option value="2" @if(isset($setting->settings()->settings->style) && $setting->settings()->settings->style == '2') selected @endif>List
                        </option>
                        <option value="3" @if(isset($setting->settings()->settings->style) && $setting->settings()->settings->style == '3') selected @endif>
                            Rounded
                        </option>
                        <option value="4" @if(isset($setting->settings()->settings->style) && $setting->settings()->settings->style == '4') selected @endif>
                            Tags - List
                        </option>
                        <option value="5" @if(isset($setting->settings()->settings->style) && $setting->settings()->settings->style == '5') selected @endif>
                            Tags - Rounded
                        </option>
                        <option value="6" @if(isset($setting->settings()->settings->style) && $setting->settings()->settings->style == '6') selected @endif>
                            Tags - Slider
                        </option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="exampleFormControlInput1" class="form-label">Column</label>
                    <small class="d-block">{{ trans('staff::admin.setting.settings.column') }}</small>
                    <select class="form-select form-select-lg mb-3" name="column" aria-label="Column">
                        @for($i = 1; $i <= 6; $i++)
                            <option value="{{$i}}"
                                    @if(isset($setting->settings()->settings->column) and $setting->settings()->settings->column == $i) selected @endif>{{$i}}</option>
                        @endfor
                    </select>
                </div>

                <div class="col-md-6 offset-md-6">
                    <label for="exampleFormControlInput1" class="form-label">Alignement</label>
                    <small class="d-block">{{ trans('staff::admin.setting.settings.alignment') }}</small>
                    <select class="form-select form-select-lg mb-3" name="alignment" aria-label="Alignement">
                        <option value="start" @if(isset($setting->settings()->settings->alignment) && $setting->settings()->settings->alignment == 'start') selected @endif>
                            {{ trans('staff::admin.start') }}
                        </option>
                        <option value="center"
                                @if(isset($setting->settings()->settings->alignment) && $setting->settings()->settings->alignment == 'center') selected @endif>
                            {{ trans('staff::admin.center') }}
                        </option>
                        <option value="end" @if(isset($setting->settings()->settings->alignment) && $setting->settings()->settings->alignment == 'end') selected @endif>
                            {{ trans('staff::admin.end') }}
                        </option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

