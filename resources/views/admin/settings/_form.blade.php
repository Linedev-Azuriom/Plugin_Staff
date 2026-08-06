@csrf

<style>
    /* ---- Style picker cards ------------------------------------------ */
    .style-picker-grid {
        display: grid;
        grid-template-columns:repeat(3, 1fr);
        gap: .75rem;
        margin-bottom: 1rem;
    }

    @media (max-width: 576px) {
        .style-picker-grid {
            grid-template-columns:repeat(2, 1fr);
        }
    }

    .style-card {
        position: relative;
        cursor: pointer;
        border: 2px solid var(--bs-border-color, #dee2e6);
        border-radius: .6rem;
        padding: .85rem .6rem .7rem;
        text-align: center;
        transition: border-color .18s, box-shadow .18s, transform .1s;
        background: var(--bs-body-bg, #fff);
    }

    .style-card:hover {
        border-color: #0d6efd55;
        box-shadow: 0 0 0 3px #0d6efd18;
        transform: translateY(-1px);
    }

    .style-card.selected {
        border-color: #0d6efd;
        box-shadow: 0 0 0 3px #0d6efd22;
    }

    .style-card input[type="radio"] {
        position: absolute;
        opacity: 0;
        pointer-events: none;
        width: 0;
        height: 0;
    }

    .style-card-icon {
        font-size: 1.55rem;
        line-height: 1;
        margin-bottom: .4rem;
        display: block;
    }

    .style-card-label {
        font-size: .78rem;
        font-weight: 600;
        color: var(--bs-body-color);
        line-height: 1.25;
        margin-bottom: .2rem;
        display: block;
    }

    .style-card-desc {
        font-size: .68rem;
        color: var(--bs-secondary-color, #6c757d);
        line-height: 1.3;
        display: block;
    }

    .style-card .style-check {
        position: absolute;
        top: .45rem;
        right: .55rem;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background: #0d6efd;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity .15s;
    }

    .style-card.selected .style-check {
        opacity: 1;
    }

    .style-check-icon {
        color: #fff;
        font-size: .6rem;
        line-height: 1;
    }

    /* ---- Range avatar_size ------------------------------------------- */
    #avatarSizeRange {
        cursor: ew-resize;
        height: 1.5rem;
        padding: 0;
        touch-action: pan-x;
    }

    #avatarSizeRange::-webkit-slider-thumb {
        width: 1.5rem;
        height: 1.5rem;
        margin-top: -.5rem;
        background-color: #0d6efd;
        border: 0;
        border-radius: 50%;
        cursor: grab;
        box-shadow: 0 0 0 4px rgba(13, 110, 253, .2);
        -webkit-appearance: none;
        appearance: none;
        transition: transform .1s, box-shadow .15s;
    }

    #avatarSizeRange::-webkit-slider-thumb:active {
        cursor: grabbing;
        transform: scale(1.15);
        box-shadow: 0 0 0 6px rgba(13, 110, 253, .25);
    }

    #avatarSizeRange::-moz-range-thumb {
        width: 1.5rem;
        height: 1.5rem;
        background-color: #0d6efd;
        border: 0;
        border-radius: 50%;
        cursor: grab;
        box-shadow: 0 0 0 4px rgba(13, 110, 253, .2);
    }

    #avatarSizeRange::-webkit-slider-runnable-track {
        height: .4rem;
        border-radius: .2rem;
        background: rgba(0, 103, 255, 0.5)
    }

    /* ---- Preview strip (slider d'aperçu) ----------------------------- */
    .style-preview-strip {
        border: 1px solid var(--bs-border-color, #dee2e6);
        border-radius: .55rem;
        overflow: hidden;
        margin-bottom: 1.25rem;
    }

    .style-preview-header {
        padding: .55rem .85rem;
        background: rgba(13, 110, 253, .06);
        border-bottom: 1px solid var(--bs-border-color, #dee2e6);
        font-size: .75rem;
        font-weight: 600;
        color: #0d6efd;
        display: flex;
        align-items: center;
        gap: .4rem;
    }

    .style-preview-body {
        padding: .8rem;
    }

    .preview-panel {
        display: none;
    }

    .preview-panel.active {
        display: block;
    }

    .preview-illustration {
        display: flex;
        gap: .5rem;
        align-items: center;
        justify-content: center;
        height: 54px;
    }

    .prev-card {
        width: 38px;
        height: 44px;
        border-radius: .35rem;
        background: linear-gradient(145deg, #e9ecef, #dee2e6);
        border: 1px solid #d0d5dc;
        flex-shrink: 0;
    }

    .prev-card-sm {
        width: 28px;
        height: 34px;
        border-radius: .3rem;
        background: linear-gradient(145deg, #e9ecef, #dee2e6);
        border: 1px solid #d0d5dc;
        flex-shrink: 0;
    }

    .prev-row {
        display: flex;
        flex-direction: column;
        gap: 4px;
        flex: 1;
        max-width: 80px;
    }

    .prev-line {
        height: 6px;
        border-radius: 3px;
        background: #d0d5dc;
    }

    .prev-line-sm {
        height: 4px;
        border-radius: 2px;
        background: #e2e5e9;
    }

    .prev-arrow {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        border: 1.5px solid #0d6efd;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #0d6efd;
        font-size: .65rem;
        flex-shrink: 0;
    }

    .prev-tag {
        height: 10px;
        border-radius: 20px;
        background: #0d6efd44;
        margin-bottom: 4px;
    }

    .preview-desc {
        font-size: .72rem;
        color: var(--bs-secondary-color, #6c757d);
        margin-top: .5rem;
        line-height: 1.4;
    }

    /* ------------------------------------------------------------------ */
</style>

<div class="row g-4">

    {{-- ====================== Affichage ====================== --}}
    <div class="col-md-6">
        <p class="fw-semibold mb-2 d-flex align-items-center gap-1">
            <i class="bi bi-toggles text-primary"></i> {{ trans('staff::admin.setting.display') }}
        </p>

        <div class="d-flex flex-column gap-2">
            <div class="form-check form-switch">
                <input type="checkbox" class="form-check-input" id="settingDescription"
                       name="description" @if($setting['description'] ?? true) checked @endif>
                <label class="form-check-label" for="settingDescription">
                    {{ trans('staff::admin.setting.settings.description') }}
                </label>
            </div>
            <div class="form-check form-switch">
                <input type="checkbox" class="form-check-input" id="settingEffect"
                       name="effect" @if($setting['effect'] ?? true) checked @endif>
                <label class="form-check-label" for="settingEffect">
                    {{ trans('staff::admin.setting.settings.effect') }}
                </label>
            </div>
        </div>
    </div>

    {{-- ====================== Mise en page ====================== --}}
    <div class="col-md-6">
        <p class="fw-semibold mb-2 d-flex align-items-center gap-1">
            <i class="bi bi-layout-three-columns text-primary"></i> {{ trans('staff::admin.setting.layout') }}
        </p>

        <div class="row g-2">
            <div class="col-6">
                <label class="form-label small fw-semibold mb-1">
                    {{ trans('staff::admin.setting.columns') }}
                    <span class="text-muted fw-normal">{{ trans('staff::admin.setting.settings.column') }}</span>
                </label>
                <select class="form-select form-select-sm" name="column">
                    @for($i = 1; $i <= 6; $i++)
                        <option value="{{ $i }}" @selected(isset($setting['column']) && $setting['column'] == $i)>
                            {{ $i }} {{ trans_choice('staff::admin.setting.column-unit', $i) }}
                        </option>
                    @endfor
                </select>
            </div>
            <div class="col-6">
                <label class="form-label small fw-semibold mb-1">
                    {{ trans('staff::admin.setting.alignment-label') }}
                    <span class="text-muted fw-normal">{{ trans('staff::admin.setting.settings.alignment') }}</span>
                </label>
                <select class="form-select form-select-sm" name="alignment">
                    <option value="start"
                        @selected(isset($setting['alignment']) && $setting['alignment'] === 'start')>
                        <i class="bi bi-align-start"></i> {{ trans('staff::admin.start') }}
                    </option>
                    <option value="center"
                        @selected(isset($setting['alignment']) && $setting['alignment'] === 'center')>
                        {{ trans('staff::admin.center') }}
                    </option>
                    <option value="end"
                        @selected(isset($setting['alignment']) && $setting['alignment'] === 'end')>
                        {{ trans('staff::admin.end') }}
                    </option>
                </select>
            </div>
        </div>
    </div>

    {{-- ====================== Taille des avatars ====================== --}}
    <div class="col-12">
        <p class="fw-semibold mb-2 d-flex align-items-center gap-1">
            <i class="bi bi-person-circle text-primary"></i> {{ trans('staff::admin.setting.avatar-size') }}
            <small class="text-muted fw-normal ms-1">{{ trans('staff::admin.setting.avatar-size-note') }}</small>
        </p>
        <div class="d-flex align-items-center gap-3">
            <input type="range" class="form-range flex-grow-1"
                   name="avatar_size" id="avatarSizeRange"
                   min="90" max="320" step="10"
                   value="{{ $setting['avatar_size'] ?? 120 }}">
            <span class="badge bg-primary fs-6 px-3 py-2" id="avatarSizeValue" style="min-width:64px;text-align:center">
                {{ ($setting['avatar_size'] ?? 120) }}px
            </span>
        </div>
        <div class="d-flex justify-content-between mt-1">
            <small class="text-muted">90px</small>
            <small class="text-muted">320px</small>
        </div>
        <p class="text-muted small mt-1 mb-0">
            <i class="bi bi-phone me-1"></i>{{ trans('staff::admin.setting.avatar-mobile-note') }}
        </p>
    </div>

    {{-- ====================== Sélecteur de style (full width) ====================== --}}
    <div class="col-12">
        <p class="fw-semibold mb-2 d-flex align-items-center gap-1">
            <i class="bi bi-grid-1x2 text-primary"></i> {{ trans('staff::admin.setting.display-style') }}
            <small class="text-muted fw-normal ms-1">{{ trans('staff::admin.setting.settings.style') }}</small>
        </p>

        {{-- Aperçu du style sélectionné --}}
        <div class="style-preview-strip" id="stylePreviewStrip">
            <div class="style-preview-header">
                <i class="bi bi-eye"></i>
                <span id="stylePreviewTitle">{{ trans('staff::admin.setting.style-preview') }}</span>
            </div>
            <div class="style-preview-body">

                {{-- Panel 1 — Slider --}}
                <div class="preview-panel" data-preview="1" id="preview1">
                    <div class="preview-illustration">
                        <div class="prev-arrow"><i class="bi bi-chevron-left"></i></div>
                        <div class="prev-card" style="width:54px;height:52px"></div>
                        <div class="prev-card"></div>
                        <div class="prev-card d-none d-md-block"></div>
                        <div class="prev-arrow"><i class="bi bi-chevron-right"></i></div>
                    </div>
                    <p class="preview-desc text-center">
                        {{ trans('staff::admin.setting.styles.1.desc') }}
                    </p>
                </div>

                {{-- Panel 2 — List --}}
                <div class="preview-panel" data-preview="2" id="preview2">
                    <div class="preview-illustration" style="flex-direction:column;height:auto;gap:6px">
                        @for($i=0;$i<3;$i++)
                            <div class="d-flex align-items-center gap-2"
                                 style="width:100%;max-width:200px;margin:0 auto">
                                <div class="prev-card-sm" style="border-radius:50%"></div>
                                <div class="flex-grow-1">
                                    <div class="prev-line" style="width:60%"></div>
                                    <div class="prev-line-sm mt-1" style="width:40%"></div>
                                </div>
                            </div>
                        @endfor
                    </div>
                    <p class="preview-desc text-center">
                        {{ trans('staff::admin.setting.styles.2.desc') }}
                    </p>
                </div>

                {{-- Panel 3 — Rounded --}}
                <div class="preview-panel" data-preview="3" id="preview3">
                    <div class="preview-illustration" style="gap:.75rem">
                        @for($i=0;$i<3;$i++)
                            <div class="text-center" style="width:50px">
                                <div class="prev-card"
                                     style="width:42px;height:42px;border-radius:50%;margin:0 auto 4px"></div>
                                <div class="prev-line" style="width:100%"></div>
                                <div class="prev-line-sm mt-1" style="width:70%;margin:0 auto"></div>
                            </div>
                        @endfor
                    </div>
                    <p class="preview-desc text-center">
                        {{ trans('staff::admin.setting.styles.3.desc') }}
                    </p>
                </div>

                {{-- Panel 4 — Tags - List --}}
                <div class="preview-panel" data-preview="4" id="preview4">
                    <div class="preview-illustration" style="flex-direction:column;height:auto;gap:6px">
                        <div style="width:100%;max-width:220px;margin:0 auto">
                            <div class="prev-tag" style="width:50px"></div>
                            <div class="d-flex gap-1 mt-1">
                                <div class="prev-card-sm" style="border-radius:50%"></div>
                                <div class="prev-card-sm" style="border-radius:50%"></div>
                            </div>
                        </div>
                        <div style="width:100%;max-width:220px;margin:0 auto">
                            <div class="prev-tag" style="width:65px"></div>
                            <div class="d-flex gap-1 mt-1">
                                <div class="prev-card-sm" style="border-radius:50%"></div>
                            </div>
                        </div>
                    </div>
                    <p class="preview-desc text-center">
                        {{ trans('staff::admin.setting.styles.4.desc') }}
                    </p>
                </div>

                {{-- Panel 5 — Tags - Rounded --}}
                <div class="preview-panel" data-preview="5" id="preview5">
                    <div class="preview-illustration" style="flex-direction:column;height:auto;gap:6px">
                        <div style="width:100%;max-width:220px;margin:0 auto">
                            <div class="prev-tag" style="width:50px"></div>
                            <div class="d-flex gap-2 mt-1">
                                <div class="text-center" style="width:36px">
                                    <div class="prev-card"
                                         style="width:32px;height:32px;border-radius:50%;margin:0 auto 2px"></div>
                                    <div class="prev-line-sm" style="width:100%"></div>
                                </div>
                                <div class="text-center" style="width:36px">
                                    <div class="prev-card"
                                         style="width:32px;height:32px;border-radius:50%;margin:0 auto 2px"></div>
                                    <div class="prev-line-sm" style="width:100%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p class="preview-desc text-center">
                        {{ trans('staff::admin.setting.styles.5.desc') }}
                    </p>
                </div>

                {{-- Panel 6 — Tags - Slider --}}
                <div class="preview-panel" data-preview="6" id="preview6">
                    <div class="preview-illustration" style="flex-direction:column;height:auto;gap:6px">
                        <div class="prev-tag" style="width:55px"></div>
                        <div class="d-flex align-items-center gap-1">
                            <div class="prev-arrow"><i class="bi bi-chevron-left"></i></div>
                            <div class="prev-card" style="flex:1;max-width:80px;height:42px"></div>
                            <div class="prev-card" style="flex:1;max-width:80px;height:42px"></div>
                            <div class="prev-arrow"><i class="bi bi-chevron-right"></i></div>
                        </div>
                    </div>
                    <p class="preview-desc text-center">
                        {{ trans('staff::admin.setting.styles.6.desc') }}
                    </p>
                </div>

            </div>
        </div>

        {{-- Grille de sélection de style --}}
        @php
            $styleOptions = [
                ['value' => '1', 'icon' => 'bi-collection-play', 'label' => 'Slider',        'desc' => trans('staff::admin.setting.styles.1.label')],
                ['value' => '2', 'icon' => 'bi-view-list',       'label' => 'List',           'desc' => trans('staff::admin.setting.styles.2.label')],
                ['value' => '3', 'icon' => 'bi-grid',            'label' => 'Rounded',        'desc' => trans('staff::admin.setting.styles.3.label')],
                ['value' => '4', 'icon' => 'bi-tags',            'label' => 'Tags — List',    'desc' => trans('staff::admin.setting.styles.4.label')],
                ['value' => '5', 'icon' => 'bi-person-badge',    'label' => 'Tags — Rounded', 'desc' => trans('staff::admin.setting.styles.5.label')],
                ['value' => '6', 'icon' => 'bi-collection',      'label' => 'Tags — Slider',  'desc' => trans('staff::admin.setting.styles.6.label')],
            ];
            $currentStyle = $setting['style'] ?? '1';
        @endphp

        <div class="style-picker-grid" id="stylePickerGrid">
            @foreach($styleOptions as $opt)
                <label class="style-card {{ $currentStyle == $opt['value'] ? 'selected' : '' }}"
                       data-style="{{ $opt['value'] }}"
                       onclick="selectStyle('{{ $opt['value'] }}')">
                    <input type="radio" name="style" value="{{ $opt['value'] }}"
                        @checked($currentStyle == $opt['value'])>
                    <span class="style-check"><i class="bi bi-check style-check-icon"></i></span>
                    <i class="{{ $opt['icon'] }} style-card-icon text-primary"></i>
                    <span class="style-card-label">{{ $opt['label'] }}</span>
                    <span class="style-card-desc">{{ $opt['desc'] }}</span>
                </label>
            @endforeach
        </div>

    </div>
</div>

<script>
    (function () {
        const styleLabels = {
            '1': @json(trans('staff::admin.setting.styles.1.full')),
            '2': @json(trans('staff::admin.setting.styles.2.full')),
            '3': @json(trans('staff::admin.setting.styles.3.full')),
            '4': @json(trans('staff::admin.setting.styles.4.full')),
            '5': @json(trans('staff::admin.setting.styles.5.full')),
            '6': @json(trans('staff::admin.setting.styles.6.full')),
        };

        function selectStyle(value) {
            // Mettre à jour les cartes
            document.querySelectorAll('.style-card').forEach(function (card) {
                const isSelected = card.dataset.style === String(value);
                card.classList.toggle('selected', isSelected);
                const radio = card.querySelector('input[type="radio"]');
                if (radio) radio.checked = isSelected;
            });

            // Mettre à jour l'aperçu
            document.querySelectorAll('.preview-panel').forEach(function (panel) {
                panel.classList.toggle('active', panel.dataset.preview === String(value));
            });

            const titleEl = document.getElementById('stylePreviewTitle');
            if (titleEl) titleEl.textContent = styleLabels[value] || ('Style ' + value);
        }

        // Exposer globalement pour les onclick Blade
        window.selectStyle = selectStyle;

        // Initialiser l'aperçu au chargement
        document.addEventListener('DOMContentLoaded', function () {
            const activeCard = document.querySelector('.style-card.selected');
            const initialValue = activeCard ? activeCard.dataset.style : '1';
            selectStyle(initialValue);

            // Range avatar_size — listener JS (plus fiable que oninput inline)
            const range = document.getElementById('avatarSizeRange');
            const badge = document.getElementById('avatarSizeValue');
            if (range && badge) {
                range.addEventListener('input', function () {
                    badge.textContent = this.value + 'px';
                });
            }
        });
    }());
</script>
