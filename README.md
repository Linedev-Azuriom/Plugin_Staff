# Staff — Plugin Azuriom

> **Version** 1.4.0 · **Auteur** [Latshow](https://linedev.fr) · **Market** [azuriom.com/resources/73](https://market.azuriom.com/resources/73)

---

## 🇫🇷 Français

### Présentation

**Staff** est un plugin pour [Azuriom](https://azuriom.com) qui permet d'afficher les membres de votre équipe directement sur votre site. Il supporte plusieurs styles d'affichage, la gestion des rôles par tags colorés, le tri par glisser-déposer et une interface d'administration entièrement intégrée.

### Fonctionnalités

- **6 styles d'affichage** configurables depuis l'administration
  - `Slider` — Carousel défilant (Glide.js)
  - `List` — Cartes en liste (image pleine largeur)
  - `Rounded` — Avatars circulaires avec taille configurable
  - `Tags — List` — Membres groupés par rôle, style liste
  - `Tags — Rounded` — Membres groupés par rôle, avatars circulaires
  - `Tags — Slider` — Un carousel dédié par groupe de rôles
- **Tags / Rôles** — Créez des rôles colorés et associez-les à chaque membre
- **Liens sociaux** — Ajoutez des liens (Discord, Twitter, etc.) avec icône Bootstrap Icons
- **Tri par glisser-déposer** — Ordonnez les membres et les tags librement
- **Filtres admin** — Recherche par nom, filtre par tag, vue libre ou groupée par rôle
- **Avatars Minecraft** — Récupération automatique du skin via mc-heads.net
- **Paramètres**
  - Affichage de la description inline
  - Nombre de colonnes (1 à 6) avec responsive automatique
  - Alignement du contenu (gauche / centre / droite)
  - Taille des avatars (90 px à 320 px, responsive via CSS `min()`)

### Installation

1. Téléchargez le plugin depuis le [Market Azuriom](https://market.azuriom.com/resources/73)
2. Déposez le dossier `staff` dans `plugins/`
3. Activez le plugin depuis **Administration → Extensions → Plugins**
4. Accédez à **Staff** dans la barre latérale admin pour créer vos membres

### Prérequis

| Élément | Version minimale |
|---|---|
| Azuriom | 1.0.0 |
| PHP | 8.1+ |
| Laravel | 10+ |

### Structure

```
plugins/staff/
├── plugin.json                  # Métadonnées du plugin
├── routes/
│   ├── web.php                  # Route publique /staff
│   └── admin.php                # Routes administration (protégées par can:staff.admin)
├── src/
│   ├── Controllers/
│   │   ├── StaffHomeController  # Page publique
│   │   └── Admin/
│   │       ├── AdminController  # CRUD membres + réordonnancement
│   │       ├── TagController    # CRUD tags + réordonnancement
│   │       ├── LinkController   # Suppression et réordonnancement des liens
│   │       └── SettingController# Sauvegarde des paramètres
│   ├── Models/
│   │   ├── Staff                # Modèle membre (belongsToMany tags, hasMany links)
│   │   ├── Tag                  # Modèle tag/rôle
│   │   └── Link                 # Modèle lien social
│   └── Providers/
│       ├── StaffServiceProvider # Enregistrement du plugin, navigation admin
│       └── RouteServiceProvider # Chargement des routes
├── resources/
│   ├── views/
│   │   ├── index.blade.php      # Vue publique (dispatch des styles)
│   │   ├── styles/              # 6 templates d'affichage + atoms réutilisables
│   │   └── admin/               # Interface d'administration
│   └── lang/
│       ├── fr/                  # Traductions françaises
│       └── en/                  # Traductions anglaises
└── database/migrations/         # Tables : staffs, tags, links, pivot staff_tag
```

### Permissions

| Permission | Description |
|---|---|
| `staff.admin` | Accès complet à l'administration du plugin |

### Captures d'écran

| Style | Aperçu |
|---|---|
| Slider | Carousel 3 cartes / 2 tablette / 1 mobile |
| List | Image pleine largeur, contenu aligné |
| Rounded | Avatar circulaire centré, taille configurable |
| Tags — List | Séparateurs de groupe colorés, style liste |
| Tags — Rounded | Séparateurs de groupe colorés, avatars ronds |
| Tags — Slider | Un slider Glide.js par groupe de rôle |

---

## 🇬🇧 English

### Overview

**Staff** is a plugin for [Azuriom](https://azuriom.com) that lets you showcase your team members on your website. It supports multiple display styles, role management with colored tags, drag-and-drop ordering, and a fully integrated admin interface.

### Features

- **6 configurable display styles** managed from the admin panel
  - `Slider` — Scrolling carousel (Glide.js)
  - `List` — Card list (full-width image)
  - `Rounded` — Circular avatars with configurable size
  - `Tags — List` — Members grouped by role, list layout
  - `Tags — Rounded` — Members grouped by role, circular avatars
  - `Tags — Slider` — A dedicated carousel per role group
- **Tags / Roles** — Create colored role tags and assign them to members
- **Social links** — Add links (Discord, Twitter, etc.) with Bootstrap Icons
- **Drag-and-drop ordering** — Freely reorder members and tags
- **Admin filters** — Search by name, filter by tag, free or role-grouped view
- **Minecraft avatars** — Automatic skin retrieval via mc-heads.net
- **Settings**
  - Inline description display
  - Number of columns (1 to 6) with automatic responsive behavior
  - Content alignment (left / center / right)
  - Avatar size (90 px to 320 px, responsive via CSS `min()`)

### Installation

1. Download the plugin from the [Azuriom Market](https://market.azuriom.com/resources/73)
2. Place the `staff` folder inside `plugins/`
3. Enable it from **Administration → Extensions → Plugins**
4. Go to **Staff** in the admin sidebar to start adding members

### Requirements

| Element | Minimum version |
|---|---|
| Azuriom | 1.0.0 |
| PHP | 8.1+ |
| Laravel | 10+ |

### File Structure

```
plugins/staff/
├── plugin.json                  # Plugin metadata
├── routes/
│   ├── web.php                  # Public route /staff
│   └── admin.php                # Admin routes (protected by can:staff.admin)
├── src/
│   ├── Controllers/
│   │   ├── StaffHomeController  # Public page
│   │   └── Admin/
│   │       ├── AdminController  # Member CRUD + reordering
│   │       ├── TagController    # Tag CRUD + reordering
│   │       ├── LinkController   # Link deletion and reordering
│   │       └── SettingController# Settings persistence
│   ├── Models/
│   │   ├── Staff                # Member model (belongsToMany tags, hasMany links)
│   │   ├── Tag                  # Tag/role model
│   │   └── Link                 # Social link model
│   └── Providers/
│       ├── StaffServiceProvider # Plugin registration, admin navigation
│       └── RouteServiceProvider # Route loading
├── resources/
│   ├── views/
│   │   ├── index.blade.php      # Public view (style dispatcher)
│   │   ├── styles/              # 6 display templates + reusable atoms
│   │   └── admin/               # Admin interface
│   └── lang/
│       ├── fr/                  # French translations
│       └── en/                  # English translations
└── database/migrations/         # Tables: staffs, tags, links, staff_tag pivot
```

### Permissions

| Permission | Description |
|---|---|
| `staff.admin` | Full access to the plugin administration |

### Responsive behavior

| Breakpoint | Columns |
|---|---|
| Mobile `< 768px` | 1 column (forced) |
| Tablet `768–992px` | 2 columns (forced) |
| Desktop `≥ 992px` | Admin-configured (1 to 6) |

Slider styles use Glide.js native breakpoints: 3 per view on desktop, 2 on tablet, 1 on mobile.

---

## Changelog

### 1.4.0
- Full admin UI redesign with Bootstrap 5.3 (no custom CSS dependencies)
- 6 display styles with live preview in settings
- Tabbed admin interface (Staff / Tags / Settings in one page)
- Role-grouped view with drag-and-drop preserved order
- Configurable avatar size (90–320 px) with responsive `min()` CSS
- Automatic responsive columns (lg: configured / md: 2 / xs: 1)
- Tags and Staff now sorted by position in all grouped views
- Glide.js fix for Tags — Slider (multiple carousels on same page)
- Removed unused routes (tags index/create standalone pages)

---

## Author

**Yoan Latchere — Latshow**  
Freelance web developer · Azuriom themes & plugins author  
[linedev.fr](https://linedev.fr) · [Market Azuriom](https://market.azuriom.com/resources/73)
