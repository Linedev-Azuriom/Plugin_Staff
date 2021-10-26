@csrf
<div class="card-body">
    <div class="form-group custom-control custom-switch">
        <input type="checkbox" class="custom-control-input" id="settingDescription" name="description" @if($setting->settings()->settings->description ?? true) checked @endif>
        <label class="custom-control-label" for="settingDescription">{{ trans('staff::admin.setting.settings.description') }}</label>
    </div>
    <div class="form-group custom-control custom-switch">
        <input type="checkbox" class="custom-control-input" id="settingEffect" name="effect" @if($setting->settings()->settings->effect ?? true) checked @endif>
        <label class="custom-control-label" for="settingEffect">{{ trans('staff::admin.setting.settings.effect') }}</label>
    </div>
</div>

