@csrf
<div class="card-body">
    <div class="form-check">
        <input type="checkbox" class="form-check-input" id="settingDescription" name="description" @if($setting->settings()->settings->description ?? true) checked @endif>
        <label class="form-check-label" for="settingDescription">{{ trans('staff::admin.setting.settings.description') }}</label>
    </div>
    <div class="form-check">
        <input type="checkbox" class="form-check-input" id="settingEffect" name="effect" @if($setting->settings()->settings->effect ?? true) checked @endif>
        <label class="form-check-label" for="settingEffect">{{ trans('staff::admin.setting.settings.effect') }}</label>
    </div>
</div>

