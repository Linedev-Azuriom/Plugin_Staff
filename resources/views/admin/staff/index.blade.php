@extends('admin.layouts.admin')

@section('title', trans('staff::admin.title'))

@push('footer-scripts')
    <script src="{{ asset('vendor/sortablejs/Sortable.min.js') }}"></script>
    <script>
    /* =====================================================================
       Staff Admin — JS : sortable, filtres, modes, liens
       ===================================================================== */

    // ---- Sortable ----
    let sortableInst = null;

    function initSortable() {
        if (sortableInst) { sortableInst.destroy(); sortableInst = null; }
        const el = document.getElementById('staffs');
        if (!el) return;
        sortableInst = Sortable.create(el, {
            animation: 150,
            handle: '.sortable-handle',
            onEnd: function () {
                axios.post('{{ route('staff.admin.staff.update-order') }}', {
                    staffs: serializeList(el)
                }).catch(console.error);
            },
        });
    }

    function serializeList(el) {
        return Array.from(el.children)
            .filter(function(c) { return c.dataset.staffId; })
            .map(function(c) { return { id: c.dataset.staffId }; });
    }

    // ---- Formulaire création — renommage des inputs link[] ----
    document.addEventListener('DOMContentLoaded', function () {
        const staffForm = document.getElementById('staffForm');
        if (staffForm) {
            staffForm.addEventListener('submit', function () {
                let i = 0;
                document.getElementById('links').querySelectorAll('.link-parent').forEach(function (el) {
                    el.querySelectorAll('input').forEach(function (input) {
                        input.name = input.name.replace('{index}', i.toString());
                    });
                    i++;
                });
            });
        }

        // ---- Liens : ajout / suppression ----
        function addLinkRemoveListener(btn) {
            btn.addEventListener('click', function () {
                const parent = btn.closest('.link-parent');
                if (parent) parent.remove();
            });
        }

        document.querySelectorAll('.link-remove').forEach(addLinkRemoveListener);

        const addLinkBtn = document.getElementById('addLinkButton');
        if (addLinkBtn) {
            addLinkBtn.addEventListener('click', function () {
                // Cloner le template HTML (sécurisé, contenu statique uniquement)
                const tpl = document.getElementById('linkRowTemplate');
                const clone = tpl.content.cloneNode(true);
                const wrap = clone.querySelector('.link-parent');
                addLinkRemoveListener(wrap.querySelector('.link-remove'));
                document.getElementById('links').appendChild(wrap);
            });
        }

        initSortable();
    });

    // ---- Filtres / modes ----
    let currentMode  = 'free'; // 'free' | 'role'
    let activeTagId  = 'all';
    let searchQuery  = '';

    // Tags data passés depuis Blade (valeurs échappées)
    const tagsData = @json($tags->map(fn($t) => ['id' => (int)$t->id, 'name' => $t->name, 'color' => $t->color]));

    function getRows() {
        return Array.from(document.querySelectorAll('#staffs [data-staff-id]'));
    }

    function rowMatchesFilters(row) {
        const tagsAttr = row.dataset.tags || '';
        const rowTags  = tagsAttr ? tagsAttr.split(',') : [];
        const name     = (row.dataset.name || '').toLowerCase();
        const matchTag = activeTagId === 'all' || rowTags.includes(String(activeTagId));
        const matchSrc = !searchQuery || name.includes(searchQuery);
        return matchTag && matchSrc;
    }

    function applyFreeFilters() {
        getRows().forEach(function(row) {
            row.style.display = rowMatchesFilters(row) ? '' : 'none';
        });
    }

    /* Construit un groupe par rôle en utilisant uniquement des méthodes DOM sécurisées */
    function buildRoleGroup(tagName, tagColor, rows) {
        if (rows.length === 0) return null;

        const section = document.createElement('div');
        section.className = 'mb-3';

        // En-tête du groupe
        const header = document.createElement('div');
        header.className = 'd-flex align-items-center gap-2 mb-2 px-1';

        const badge = document.createElement('span');
        badge.className = 'badge rounded-pill px-3 py-2';
        badge.style.background = tagColor || '#6c757d';
        badge.textContent = tagName; // textContent = pas de XSS

        const count = document.createElement('small');
        count.className = 'text-muted';
        count.textContent = rows.length + ' membre' + (rows.length > 1 ? 's' : '');

        header.appendChild(badge);
        header.appendChild(count);

        // Table
        const table = document.createElement('table');
        table.className = 'table table-hover table-sm align-middle mb-0';

        const tbody = document.createElement('tbody');
        rows.forEach(function(row) {
            const clone = row.cloneNode(true);
            const handle = clone.querySelector('.sortable-handle');
            if (handle) handle.style.visibility = 'hidden';
            tbody.appendChild(clone);
        });

        table.appendChild(tbody);
        section.appendChild(header);
        section.appendChild(table);
        return section;
    }

    function renderRoleMode() {
        const container = document.getElementById('roleView');
        // Vider proprement le conteneur
        while (container.firstChild) container.removeChild(container.firstChild);

        const tagMap = {};
        const noTagRows = [];

        getRows().forEach(function(row) {
            if (!rowMatchesFilters(row)) return;
            const tagsAttr = row.dataset.tags || '';
            const rowTags  = tagsAttr ? tagsAttr.split(',') : [];

            if (rowTags.length === 0) {
                noTagRows.push(row);
                return;
            }
            rowTags.forEach(function(tid) {
                if (activeTagId !== 'all' && tid !== String(activeTagId)) return;
                const tagInfo = tagsData.find(function(t) { return String(t.id) === String(tid); });
                if (!tagInfo) return;
                if (!tagMap[tid]) tagMap[tid] = { tag: tagInfo, rows: [] };
                if (!tagMap[tid].rows.includes(row)) tagMap[tid].rows.push(row);
            });
        });

        let hasContent = false;

        // Itérer dans l'ordre de position des tags (tagsData est trié par position côté PHP)
        tagsData.forEach(function(tagInfo) {
            const entry = tagMap[String(tagInfo.id)];
            if (entry) {
                const grp = buildRoleGroup(entry.tag.name, entry.tag.color, entry.rows);
                if (grp) { container.appendChild(grp); hasContent = true; }
            }
        });

        if (noTagRows.length > 0) {
            const grp = buildRoleGroup('Sans rôle', '#6c757d', noTagRows);
            if (grp) { container.appendChild(grp); hasContent = true; }
        }

        if (!hasContent) {
            const msg = document.createElement('p');
            msg.className = 'text-muted small px-1 py-3 text-center';
            msg.textContent = 'Aucun membre ne correspond aux filtres.';
            container.appendChild(msg);
        }
    }

    function setMode(mode) {
        currentMode = mode;
        const freeView = document.getElementById('freeView');
        const roleView = document.getElementById('roleView');
        const btnFree  = document.getElementById('btnFreeOrder');
        const btnRole  = document.getElementById('btnByRole');

        if (mode === 'free') {
            freeView.style.display = '';
            roleView.style.display = 'none';
            btnFree.classList.add('active');
            btnRole.classList.remove('active');
            initSortable();
            applyFreeFilters();
        } else {
            freeView.style.display = 'none';
            roleView.style.display = '';
            btnFree.classList.remove('active');
            btnRole.classList.add('active');
            if (sortableInst) { sortableInst.destroy(); sortableInst = null; }
            renderRoleMode();
        }
    }

    function filterByTag(tagId) {
        activeTagId = String(tagId);
        document.querySelectorAll('[data-tag-filter]').forEach(function(btn) {
            btn.classList.toggle('active', btn.dataset.tagFilter === activeTagId);
        });
        if (currentMode === 'free') applyFreeFilters();
        else renderRoleMode();
    }

    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('staffSearch');
        if (searchInput) {
            searchInput.addEventListener('input', function () {
                searchQuery = this.value.toLowerCase().trim();
                if (currentMode === 'free') applyFreeFilters();
                else renderRoleMode();
            });
        }
    });

    // ---- Sortable des tags (tab Tags) ----
    document.addEventListener('DOMContentLoaded', function () {
        const tagsEl = document.getElementById('tags');
        if (tagsEl) {
            Sortable.create(tagsEl, {
                animation: 150,
                handle: '.sortable-handle',
                onEnd: function () {
                    const items = Array.from(tagsEl.children)
                        .filter(function(c) { return c.dataset.tagId; })
                        .map(function(c) { return { id: c.dataset.tagId }; });
                    axios.post('{{ route('staff.admin.tags.update-order') }}', { tags: items })
                        .catch(console.error);
                },
            });
        }
    });
    </script>
@endpush

@section('content')

    {{-- Template HTML pour l'ajout de lien (static, sécurisé) --}}
    <template id="linkRowTemplate">
        <div class="row g-1 mb-1 align-items-center link-parent">
            <div class="col-auto">
                <i class="bi bi-arrows-move sortable-handle text-muted" style="cursor:grab"></i>
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control form-control-sm"
                       name="link[{index}][icon]"
                       placeholder="{{ trans('messages.fields.icon') }}">
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control form-control-sm"
                       name="link[{index}][name]"
                       placeholder="{{ trans('messages.fields.name') }}">
            </div>
            <div class="col">
                <div class="input-group input-group-sm">
                    <input type="text" class="form-control"
                           name="link[{index}][url]"
                           placeholder="{{ trans('messages.fields.url') }}">
                    <button class="btn btn-outline-danger link-remove" type="button">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
            </div>
        </div>
    </template>

    {{-- =====================================================================
         BLOC PROMO LINEDEV
         ===================================================================== --}}
    @php
        $promoAzuriom = [
            ['id' => 73,  'name' => 'Plugin Staff', 'type' => 'Plugin', 'type_color' => 'success', 'description' => 'Affichez facilement votre équipe sur votre site.'],
            ['id' => 30,  'name' => 'Modern Pro',   'type' => 'Thème',  'type_color' => 'primary', 'description' => 'Thème moderne et modulable pour votre communauté.'],
            ['id' => 71,  'name' => 'Rainbow',      'type' => 'Thème',  'type_color' => 'primary', 'description' => 'Thème 100% personnalisable, couleurs et animations infinies.'],
            ['id' => 171, 'name' => 'ZodPress',     'type' => 'Thème',  'type_color' => 'primary', 'description' => 'Thème récent, design propre et performances optimisées.'],
        ];
        $promoExternal = [
            ['name' => 'LineDev',      'url' => 'https://lank.li/linedev',        'type' => 'Site', 'type_color' => 'secondary', 'description' => 'Portfolio et hub de toutes mes créations.'],
            ['name' => 'ServeurListe', 'url' => 'https://lank.li/serveurliste-1', 'type' => 'Site', 'type_color' => 'secondary', 'description' => "Plateforme d'ajout et de vote pour serveurs de jeu. Référencez le vôtre."],
            ['name' => 'Lank',         'url' => 'https://lank.li/lank-li',         'type' => 'Site', 'type_color' => 'secondary', 'description' => 'Raccourcisseur de liens avancé avec stats de trafic détaillées.'],
        ];
        $promoResources = array_map(function ($res) {
            $res['likes']    = null;
            $res['url']      = 'https://market.azuriom.com/resources/' . $res['id'];
            $res['like_url'] = 'https://market.azuriom.com/resources/' . $res['id'] . '#if-you-like-the-theme-you-can-like-it';
            try {
                $resp = \Illuminate\Support\Facades\Http::timeout(2)->get('https://market.azuriom.com/api/resources/' . $res['id']);
                if ($resp->successful()) $res['likes'] = $resp->json('likes');
            } catch (\Throwable $e) {}
            return $res;
        }, $promoAzuriom);
    @endphp

    <style>
/* LINEDEV PROMO BLOCK v2 ------------------------------------------ */
.ldp2-label{font-size:.62rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;display:flex;align-items:center;gap:.45rem;margin-bottom:.6rem;color:var(--bs-secondary-color,#6c757d);}
.ldp2-label::before{content:'';width:3px;height:11px;border-radius:2px;background:var(--ldp2-c,#4f8ef7);flex-shrink:0;}
.ldp2-accordion{border:1px solid var(--bs-border-color,#dee2e6);border-radius:.45rem;overflow:hidden;}
details.ldp2-item{border-bottom:1px solid var(--bs-border-color,#dee2e6);}
details.ldp2-item:last-child{border-bottom:none;}
details.ldp2-item>summary{display:flex;align-items:center;gap:.45rem;padding:.55rem .8rem;cursor:pointer;list-style:none;user-select:none;transition:background .12s;}
details.ldp2-item>summary::-webkit-details-marker{display:none;}
details.ldp2-item>summary:hover{background:rgba(0,0,0,.03);}
details.ldp2-item[open]>summary{background:rgba(0,0,0,.025);}
.ldp2-name{font-size:.83rem;font-weight:600;flex:1;min-width:0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;}
.ldp2-badge{font-size:.56rem;font-weight:700;letter-spacing:.07em;text-transform:uppercase;padding:.18em .5em;border-radius:20px;flex-shrink:0;}
.ldp2-badge-success{background:rgba(32,201,151,.1);color:#198754;}
.ldp2-badge-primary{background:rgba(79,142,247,.12);color:#0d6efd;}
.ldp2-badge-secondary{background:rgba(108,117,125,.1);color:#6c757d;}
.ldp2-pill{display:inline-flex;align-items:center;gap:.22rem;background:rgba(220,53,69,.07);border:1px solid rgba(220,53,69,.2);border-radius:20px;padding:.13rem .52rem;flex-shrink:0;}
.ldp2-pill-n{font-size:.83rem;font-weight:800;color:#dc3545;line-height:1;}
.ldp2-pill-ico{color:#dc3545;font-size:.62rem;}
.ldp2-btn{display:inline-flex;align-items:center;gap:.22rem;padding:.17rem .62rem;border-radius:20px;font-size:.71rem;font-weight:600;border:1.5px solid;text-decoration:none!important;transition:background .14s,color .14s;line-height:1.4;flex-shrink:0;white-space:nowrap;}
.ldp2-btn-like{color:#dc3545;border-color:rgba(220,53,69,.38);}
.ldp2-btn-like:hover{background:#dc3545;color:#fff!important;border-color:#dc3545;}
.ldp2-btn-visit{color:#0d6efd;border-color:rgba(13,110,253,.32);}
.ldp2-btn-visit:hover{background:#0d6efd;color:#fff!important;border-color:#0d6efd;}
.ldp2-chevron{font-size:.7rem;color:var(--bs-secondary-color,#6c757d);flex-shrink:0;line-height:1;}
.ldp2-chevron i{display:inline-block;transition:transform .18s;}
details.ldp2-item[open] .ldp2-chevron i{transform:rotate(180deg);}
.ldp2-body{padding:.5rem .8rem .65rem;font-size:.78rem;color:var(--bs-secondary-color,#6c757d);line-height:1.5;border-top:1px solid var(--bs-border-color,#dee2e6);}
.ldp2-creator{border:1px solid var(--bs-border-color,#dee2e6);border-radius:.45rem;padding:.8rem;margin-bottom:.75rem;display:flex;gap:.7rem;align-items:flex-start;}
.ldp2-creator-ico{width:36px;height:36px;border-radius:.35rem;background:linear-gradient(135deg,#6366f1,#8b5cf6);display:flex;align-items:center;justify-content:center;color:#fff;font-size:1rem;flex-shrink:0;}
.ldp2-creator-name{font-size:.86rem;font-weight:700;margin:0 0 .12rem;}
.ldp2-creator-role{font-size:.73rem;color:var(--bs-secondary-color,#6c757d);margin:0 0 .45rem;line-height:1.35;}
.ldp2-tags{display:flex;flex-wrap:wrap;gap:.28rem;}
.ldp2-tag{font-size:.58rem;font-weight:600;padding:.16em .55em;border-radius:20px;background:rgba(99,102,241,.09);color:#6366f1;border:1px solid rgba(99,102,241,.2);}
.ldp2-favicon{width:15px;height:15px;border-radius:2px;object-fit:contain;flex-shrink:0;}
.ldp2-btn-discord{color:#5865F2;border-color:rgba(88,101,242,.35);}
.ldp2-btn-discord:hover{background:#5865F2;color:#fff!important;border-color:#5865F2;}
.ldp2-btn-tiktok{color:#010101;border-color:rgba(0,0,0,.25);}
.ldp2-btn-tiktok:hover{background:#010101;color:#fff!important;border-color:#010101;}
.ldp2-btn-youtube{color:#FF0000;border-color:rgba(255,0,0,.32);}
.ldp2-btn-youtube:hover{background:#FF0000;color:#fff!important;border-color:#FF0000;}
/* ----------------------------------------------------------------- */

/* Navigation pills -------------------------------------------------  */
#staffAdminTabs .nav-link {
    background-color: var(--bs-secondary);
    color: #fff;
    border: none;
    transition: background-color .15s, opacity .15s;
}
#staffAdminTabs .nav-link:hover:not(.active) {
    background-color: var(--bs-secondary);
    opacity: .82;
    color: #fff;
}
#staffAdminTabs .nav-link.active {
    background-color: var(--bs-primary) !important;
    color: #fff !important;
}
#staffAdminTabs .nav-link .staff-tab-badge {
    background-color: rgba(255,255,255,.25);
    color: #fff;
}
#staffAdminTabs .nav-link.active .staff-tab-badge {
    background-color: rgba(255,255,255,.3);
}
/* Staff admin UX --------------------------------------------------- */
.staff-avatar{width:38px;height:38px;object-fit:cover;border-radius:.4rem;}
.staff-avatar-placeholder{width:38px;height:38px;border-radius:.4rem;background:linear-gradient(135deg,#e9ecef,#dee2e6);display:flex;align-items:center;justify-content:center;color:#adb5bd;font-size:1.1rem;}
.tag-pill-filter{cursor:pointer;border:none;transition:opacity .15s,transform .1s;}
.tag-pill-filter:not(.active){opacity:.5;}
.tag-pill-filter.active{opacity:1;transform:scale(1.08);}
.tag-pill-filter:hover{opacity:.85;}
/* ----------------------------------------------------------------- */
    </style>

    <div class="row g-3 mb-3">
        <div class="col-12">
            <div class="ldp2-creator">
                <div class="ldp2-creator-ico"><i class="bi bi-code-slash"></i></div>
                <div>
                    <p class="ldp2-creator-name">Yoan Latchere — Latshow</p>
                    <p class="ldp2-creator-role">Créateur freelance — Vitrine, E-Commerce &amp; Application Web. Auteur de thèmes et plugins Azuriom premium.</p>
                    <div class="ldp2-tags">
                        <span class="ldp2-tag">Vitrine</span>
                        <span class="ldp2-tag">E-Commerce</span>
                        <span class="ldp2-tag">Application Web</span>
                        <span class="ldp2-tag">Thèmes Azuriom</span>
                        <span class="ldp2-tag">Plugins</span>
                    </div>
                    <div class="d-flex flex-wrap gap-2 mt-2">
                        <a href="https://lank.li/discord-linedev" target="_blank" rel="noopener"
                           class="ldp2-btn ldp2-btn-discord">
                            <i class="bi bi-discord"></i> Support &amp; tickets
                        </a>
                        <a href="https://www.tiktok.com/@linedev_" target="_blank" rel="noopener"
                           class="ldp2-btn ldp2-btn-tiktok">
                            <i class="bi bi-tiktok"></i> @linedev_
                        </a>
                        <a href="https://www.youtube.com/playlist?list=PLEF6-BIiO7ACVXzouHHSg_gW75Pq5HPDd" target="_blank" rel="noopener"
                           class="ldp2-btn ldp2-btn-youtube">
                            <i class="bi bi-youtube"></i> Tutoriels
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="ldp2-label" style="--ldp2-c:#6c757d">Mes sites</div>
            <div class="ldp2-accordion">
                @foreach($promoExternal as $extItem)
                    <details class="ldp2-item">
                        <summary>
                            <img src="https://www.google.com/s2/favicons?sz=32&domain={{ parse_url($extItem['url'], PHP_URL_HOST) }}"
                                 width="15" height="15" class="ldp2-favicon" alt="">
                            <span class="ldp2-name">{{ $extItem['name'] }}</span>
                            <a href="{{ $extItem['url'] }}" target="_blank" rel="noopener"
                               class="ldp2-btn ldp2-btn-visit" onclick="event.stopPropagation()">
                                <i class="bi bi-arrow-up-right-square"></i> Visiter
                            </a>
                            <span class="ldp2-chevron"><i class="bi bi-chevron-down"></i></span>
                        </summary>
                        <div class="ldp2-body">{{ $extItem['description'] }}</div>
                    </details>
                @endforeach
            </div>
        </div>
        <div class="col-md-6">
            <div class="ldp2-label" style="--ldp2-c:#4f8ef7">Mes ressources Azuriom</div>
            <div class="ldp2-accordion">
                @foreach($promoResources as $promoItem)
                    <details class="ldp2-item">
                        <summary>
                            <span class="ldp2-name">{{ $promoItem['name'] }}</span>
                            <span class="ldp2-badge ldp2-badge-{{ $promoItem['type_color'] }}">{{ $promoItem['type'] }}</span>
                            <span class="ldp2-pill">
                                <i class="bi bi-heart-fill ldp2-pill-ico"></i>
                                <span class="ldp2-pill-n">{{ $promoItem['likes'] !== null ? $promoItem['likes'] : '--' }}</span>
                            </span>
                            <a href="{{ $promoItem['like_url'] }}" target="_blank" rel="noopener"
                               class="ldp2-btn ldp2-btn-like" onclick="event.stopPropagation()">
                                <i class="bi bi-heart"></i> Liker
                            </a>
                            <span class="ldp2-chevron"><i class="bi bi-chevron-down"></i></span>
                        </summary>
                        <div class="ldp2-body">{{ $promoItem['description'] }}</div>
                    </details>
                @endforeach
            </div>
        </div>
    </div>

    <hr class="my-3">
    {{-- FIN BLOC PROMO LINEDEV --}}

    {{-- =====================================================================
         NAVIGATION TABS
         ===================================================================== --}}
    <ul class="nav nav-pills mb-2 gap-1" id="staffAdminTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="tab-staff-btn" data-bs-toggle="tab"
                    data-bs-target="#tab-staff" type="button" role="tab">
                <i class="bi bi-people-fill me-1"></i>
                {{ trans('staff::admin.staff.title') }}
                <span class="badge ms-1 staff-tab-badge">{{ $staffs->count() }}</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-tags-btn" data-bs-toggle="tab"
                    data-bs-target="#tab-tags" type="button" role="tab">
                <i class="bi bi-tags-fill me-1"></i>
                {{ trans('staff::admin.tag.title') }}
                <span class="badge ms-1 staff-tab-badge">{{ $tags->count() }}</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-settings-btn" data-bs-toggle="tab"
                    data-bs-target="#tab-settings" type="button" role="tab">
                <i class="bi bi-sliders me-1"></i>
                {{ trans('staff::admin.setting.title') }}
            </button>
        </li>
    </ul>

    <div class="tab-content border rounded bg-body shadow-sm">

        {{-- ==================== TAB STAFF ==================== --}}
        <div class="tab-pane fade show active" id="tab-staff" role="tabpanel">
            <div class="row g-3">

                {{-- ---- Formulaire de création ---- --}}
                <div class="col-xl-5">
                    <div class="card border-0 shadow-sm mb-0 h-100">
                        <div class="card-header bg-primary text-white d-flex align-items-center gap-2">
                            <i class="bi bi-person-plus-fill"></i>
                            <span class="fw-semibold">{{ trans('staff::admin.staff.title') }}</span>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('staff.admin.staff.store') }}" method="POST"
                                  id="staffForm" enctype="multipart/form-data">
                                <input type="hidden" name="pending_id" value="{{ $pendingId }}">

                                @include('admin.elements.editor', [
                                    'imagesUploadUrl' => route('admin.posts.attachments.pending', $pendingId)
                                ])

                                @include('staff::admin.staff._form')

                                <button type="submit" class="btn btn-primary w-100 mt-2">
                                    <i class="bi bi-save me-1"></i> {{ trans('messages.actions.save') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- ---- Liste des staffs ---- --}}
                <div class="col-xl-7">
                    <div class="card border-0 shadow-sm mb-0">
                        <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
                            <span class="fw-semibold d-flex align-items-center gap-2">
                                <i class="bi bi-list-ul"></i>
                                {{ trans('staff::admin.staff.title-list') }}
                            </span>
                            {{-- Basculement de mode --}}
                            <div class="btn-group btn-group-sm" role="group">
                                <button type="button" id="btnFreeOrder"
                                        class="btn btn-outline-secondary active"
                                        onclick="setMode('free')"
                                        title="Ordre libre (glisser-déposer)">
                                    <i class="bi bi-arrows-move me-1"></i>Ordre libre
                                </button>
                                <button type="button" id="btnByRole"
                                        class="btn btn-outline-secondary"
                                        onclick="setMode('role')"
                                        title="Grouper par rôle / tag">
                                    <i class="bi bi-tags me-1"></i>Par rôle
                                </button>
                            </div>
                        </div>

                        <div class="card-body pb-2">
                            {{-- Barre de recherche + filtres tags --}}
                            <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                                <div class="input-group input-group-sm" style="max-width:220px">
                                    <span class="input-group-text bg-transparent">
                                        <i class="bi bi-search"></i>
                                    </span>
                                    <input type="text" id="staffSearch" class="form-control border-start-0"
                                           placeholder="Rechercher un membre…">
                                </div>
                                <div class="d-flex flex-wrap gap-1 align-items-center">
                                    <button type="button"
                                            class="badge rounded-pill tag-pill-filter active py-2 px-3"
                                            style="background:#6c757d;color:#fff"
                                            data-tag-filter="all"
                                            onclick="filterByTag('all')">
                                        Tous
                                    </button>
                                    @foreach($tags as $tag)
                                        <button type="button"
                                                class="badge rounded-pill tag-pill-filter py-2 px-3"
                                                style="background:{{ $tag->color }};color:#fff"
                                                data-tag-filter="{{ $tag->id }}"
                                                onclick="filterByTag('{{ $tag->id }}')">
                                            {{ $tag->name }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Vue LIBRE (drag & drop) --}}
                            <div id="freeView">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="width:40px"></th>
                                                <th style="width:46px"></th>
                                                <th>{{ trans('messages.fields.name') }}</th>
                                                <th>Rôles</th>
                                                <th style="width:100px" class="text-end">
                                                    {{ trans('messages.fields.action') }}
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="staffs">
                                        @forelse($staffs as $staff)
                                            <tr class="staff-parent"
                                                data-staff-id="{{ $staff->id }}"
                                                data-name="{{ strtolower($staff->name) }}"
                                                data-tags="{{ $staff->tags->pluck('id')->join(',') }}">
                                                <td>
                                                    <i class="bi bi-arrows-move sortable-handle text-muted"
                                                       style="cursor:grab"></i>
                                                </td>
                                                <td>
                                                    @if($staff->image)
                                                        <img src="{{ image_url('../staff/'.$staff->image) }}"
                                                             alt="{{ $staff->name }}"
                                                             class="staff-avatar">
                                                    @elseif(game()->name() === 'Minecraft')
                                                        <img src="https://mc-heads.net/avatar/{{ urlencode($staff->name) }}/40"
                                                             alt="{{ $staff->name }}"
                                                             class="staff-avatar">
                                                    @else
                                                        <div class="staff-avatar-placeholder">
                                                            <i class="bi bi-person"></i>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="fw-semibold">{{ $staff->name }}</td>
                                                <td>
                                                    <div class="d-flex flex-wrap gap-1">
                                                        @forelse($staff->tags as $tag)
                                                            <span class="badge rounded-pill"
                                                                  style="background:{{ $tag->color }}">
                                                                {{ $tag->name }}
                                                            </span>
                                                        @empty
                                                            <span class="text-muted small">—</span>
                                                        @endforelse
                                                    </div>
                                                </td>
                                                <td class="text-end">
                                                    <a href="{{ route('staff.admin.staff.edit', $staff) }}"
                                                       class="btn btn-sm btn-outline-primary me-1"
                                                       title="{{ trans('messages.actions.edit') }}">
                                                        <i class="bi bi-pen-fill"></i>
                                                    </a>
                                                    <a href="{{ route('staff.admin.staff.destroy', $staff) }}"
                                                       class="btn btn-sm btn-outline-danger"
                                                       title="{{ trans('messages.actions.delete') }}"
                                                       data-confirm="delete">
                                                        <i class="bi bi-trash-fill"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted py-4">
                                                    <i class="bi bi-people fs-3 d-block mb-1 opacity-25"></i>
                                                    Vous n'avez créé aucun membre.
                                                </td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- Vue PAR RÔLE (groupée, générée par JS) --}}
                            <div id="roleView" style="display:none"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>{{-- /tab-staff --}}

        {{-- ==================== TAB TAGS ==================== --}}
        <div class="tab-pane fade" id="tab-tags" role="tabpanel">
            <div class="row g-3">

                {{-- Formulaire création tag --}}
                <div class="col-md-5">
                    <div class="card border-0 shadow-sm mb-0">
                        <div class="card-header bg-success text-white d-flex align-items-center gap-2">
                            <i class="bi bi-tag-fill"></i>
                            <span class="fw-semibold">{{ trans('staff::admin.tag.title') }}</span>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('staff.admin.tags.store') }}" method="POST">
                                @include('staff::admin.tags._form')
                                <button type="submit" class="btn btn-success w-100 mt-2">
                                    <i class="bi bi-save me-1"></i> {{ trans('messages.actions.save') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Liste des tags --}}
                <div class="col-md-7">
                    <div class="card border-0 shadow-sm mb-0">
                        <div class="card-header d-flex align-items-center gap-2">
                            <i class="bi bi-list-ul"></i>
                            <span class="fw-semibold">{{ trans('staff::admin.tag.title-list') }}</span>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width:40px"></th>
                                            <th>{{ trans('messages.fields.name') }}</th>
                                            <th style="width:100px" class="text-end">
                                                {{ trans('messages.fields.action') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="sortable" id="tags">
                                    @forelse($tags as $tag)
                                        <tr class="tag-parent" data-tag-id="{{ $tag->id }}">
                                            <td>
                                                <i class="bi bi-arrows-move sortable-handle text-muted"
                                                   style="cursor:grab"></i>
                                            </td>
                                            <td>
                                                <span class="badge rounded-pill px-3 py-2"
                                                      style="background:{{ $tag->color }}">
                                                    {{ $tag->name }}
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                <a href="{{ route('staff.admin.tags.edit', $tag) }}"
                                                   class="btn btn-sm btn-outline-primary me-1"
                                                   title="{{ trans('messages.actions.edit') }}">
                                                    <i class="bi bi-pen-fill"></i>
                                                </a>
                                                <a href="{{ route('staff.admin.tags.destroy', $tag) }}"
                                                   class="btn btn-sm btn-outline-danger"
                                                   title="{{ trans('messages.actions.delete') }}"
                                                   data-confirm="delete">
                                                    <i class="bi bi-trash-fill"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted py-4">
                                                <i class="bi bi-tags fs-3 d-block mb-1 opacity-25"></i>
                                                Aucun tag créé.
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>{{-- /tab-tags --}}

        {{-- ==================== TAB PARAMÈTRES ==================== --}}
        <div class="tab-pane fade" id="tab-settings" role="tabpanel">
            <div class="card border-0 shadow-sm mb-0">
                <div class="card-header d-flex align-items-center gap-2">
                    <i class="bi bi-sliders"></i>
                    <span class="fw-semibold">{{ trans('staff::admin.setting.title') }}</span>
                </div>
                <div class="card-body">
                    <form action="{{ route('staff.admin.settings.update') }}" method="POST">
                        @method('PUT')
                        @include('staff::admin.settings._form')
                        <button type="submit" class="btn btn-primary mt-3">
                            <i class="bi bi-save me-1"></i> {{ trans('messages.actions.save') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>{{-- /tab-settings --}}

    </div>{{-- /tab-content --}}

@endsection
