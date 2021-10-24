@csrf
<input type="hidden" name="name" value="global">
<div class="card-body">
    @php(dump($setting->setting))
    <div class="form-group custom-control custom-switch">
        <input type="checkbox" class="custom-control-input" id="settingDescription" name="settings[0][description]" @if($setting->setting->description ?? true) checked @endif>
        <label class="custom-control-label" for="settingDescription">Afficher la désription directement dans le fenettre du staff</label>
    </div>
    <div class="form-group custom-control custom-switch">
        <input type="checkbox" class="custom-control-input" id="settingEffect" name="settings[0][effect]" @if($setting->setting->effect ?? true) checked @endif>
        <label class="custom-control-label" for="settingEffect">Afficher l'éffet au survol de la fenetre</label>
    </div>
</div>

