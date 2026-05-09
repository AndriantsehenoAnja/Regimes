# 🎨 Système CSS/SCSS - Regimes Project

## 📋 Vue d'ensemble

Ce projet utilise un système CSS moderne basé sur **SCSS** avec une architecture modulaire et maintenable. Les fichiers sont organisés en modules séparés pour faciliter la maintenabilité et l'extensibilité.

## 📁 Structure des fichiers

```
public/style/
├── main.scss              # 📌 Fichier principal (à compiler)
├── main.css               # 🎯 Fichier compilé (utilisé en production)
├── _variables.scss        # 🎨 Variables et configuration
├── _mixins.scss          # 🔧 Mixins réutilisables
├── _base.scss            # 📝 Styles de base et reset
├── _forms.scss           # 📋 Styles des formulaires
├── _navbar.scss          # 📍 Styles de la navbar
├── _components.scss      # 🧩 Composants réutilisables
└── _pages.scss           # 📄 Styles spécifiques aux pages
```

## 🚀 Installation et Compilation

### Option 1 : Installation globale de Sass

```bash
# Installer Sass globalement
npm install -g sass

# Compiler le fichier SCSS
sass public/style/main.scss public/style/main.css

# En mode watch (surveillance automatique)
sass --watch public/style:public/style
```

### Option 2 : Installation locale avec npm

```bash
# Initialiser npm (si pas fait)
npm init -y

# Installer Sass comme dépendance de développement
npm install --save-dev sass

# Ajouter dans package.json :
"scripts": {
  "sass": "sass public/style/main.scss public/style/main.css",
  "sass:watch": "sass --watch public/style:public/style"
}

# Compiler
npm run sass

# Compiler en mode watch
npm run sass:watch
```

### Option 3 : Avec Gulp (avancé)

```bash
npm install --save-dev gulp gulp-sass sass

# Créer un gulpfile.js
const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));

gulp.task('sass', function() {
  return gulp.src('public/style/main.scss')
    .pipe(sass())
    .pipe(gulp.dest('public/style'));
});

gulp.task('watch', function() {
  gulp.watch('public/style/**/*.scss', gulp.series('sass'));
});

# Compiler
npx gulp sass

# Compiler en mode watch
npx gulp watch
```

## 📝 Utilisation en HTML

Dans votre `layout/main.php`, remplacer :

```php
<!-- Ancien -->
<link rel="stylesheet" href="<?= base_url('/style/layout-main.css') ?>">

<!-- Nouveau (après compilation) -->
<link rel="stylesheet" href="<?= base_url('/style/main.css') ?>">
```

## 🎨 Variables disponibles

### Couleurs

```scss
// Primaire
$color-primary: #111827;        // Dark Navy
$color-primary-light: #1f2937;  // Light Navy

// Accents
$color-gold: #c59d00;           // Or Premium
$color-success: #10b981;        // Vert
$color-danger: #ef4444;         // Rouge
$color-warning: #f59e0b;        // Orange
$color-info: #3b82f6;           // Bleu
```

### Espacements

```scss
$spacing-xs: 4px;
$spacing-sm: 8px;
$spacing-md: 12px;
$spacing-lg: 16px;
$spacing-xl: 20px;
$spacing-2xl: 24px;
$spacing-3xl: 32px;
```

### Breakpoints Media Queries

```scss
$breakpoint-xs: 320px;         // Mobile
$breakpoint-sm: 640px;         // Petite tablette
$breakpoint-md: 768px;         // Tablette
$breakpoint-lg: 1024px;        // Desktop
$breakpoint-xl: 1280px;        // Large Desktop
$breakpoint-2xl: 1536px;       // Extra Large
```

## 🔧 Mixins utiles

### Flexbox

```scss
.my-container {
  @include flex-center;        // Centre horizontal et vertical
  @include flex-between;       // Space-between
  @include flex-column;        // Flex column
}
```

### Boutons

```scss
.my-button {
  @include button-primary;     // Bouton primaire
  @include button-secondary;   // Bouton secondaire
  @include button-danger;      // Bouton danger
}
```

### Cards

```scss
.my-card {
  @include card;               // Card avec ombre et bordure
  @include hover-lift;         // Effet survol avec élévation
}
```

### Responsive

```scss
.navbar-center {
  display: flex;
  
  @include media-md {          // Sur mobile et tablette
    display: none;
  }
  
  @include media-lg {          // Sur desktop large
    gap: 20px;
  }
}
```

## 📱 Breakpoints

Les media queries sont prédéfinies :

- **Mobile (XS)** : 320px
- **Tablette (SM)** : 640px
- **Tablette (MD)** : 768px - `@include media-md { }`
- **Desktop (LG)** : 1024px - `@include media-lg { }`
- **Desktop XL** : 1280px - `@include media-xl { }`
- **Desktop 2XL** : 1536px

## 🎯 Palette de couleurs

| Nom | Couleur | Hex | Utilité |
|-----|---------|-----|---------|
| Primary | ![#111827](https://via.placeholder.com/20/111827) | #111827 | Texte, arrière-plans |
| Gold | ![#c59d00](https://via.placeholder.com/20/c59d00) | #c59d00 | Premium, Gold |
| Success | ![#10b981](https://via.placeholder.com/20/10b981) | #10b981 | Succès, validation |
| Danger | ![#ef4444](https://via.placeholder.com/20/ef4444) | #ef4444 | Erreurs |
| Warning | ![#f59e0b](https://via.placeholder.com/20/f59e0b) | #f59e0b | Avertissements |
| Info | ![#3b82f6](https://via.placeholder.com/20/3b82f6) | #3b82f6 | Information |

## 🧩 Composants disponibles

### Boutons

```html
<!-- Primaire -->
<button class="btn-primary">Soumettre</button>

<!-- Secondaire -->
<button class="btn-secondary">Annuler</button>

<!-- Danger -->
<button class="btn-danger">Supprimer</button>

<!-- Succès -->
<button class="btn-success">Valider</button>

<!-- Tailles -->
<button class="btn-sm">Petit</button>
<button class="btn-lg">Grand</button>

<!-- Pleine largeur -->
<button class="btn-block">Pleine largeur</button>
```

### Cartes

```html
<div class="card">
  <div class="card-header">
    <h3>Titre</h3>
  </div>
  <div class="card-body">
    Contenu de la carte
  </div>
  <div class="card-footer">
    Pied de page
  </div>
</div>
```

### Badges

```html
<span class="badge">Par défaut</span>
<span class="badge badge-success">Succès</span>
<span class="badge badge-danger">Danger</span>
<span class="badge badge-gold">Gold</span>
```

### Alertes

```html
<!-- Succès -->
<div class="alert alert-success">
  <span class="alert-title">Succès!</span>
  Votre action a été complétée avec succès.
</div>

<!-- Erreur -->
<div class="alert alert-danger">
  <span class="alert-title">Erreur!</span>
  Une erreur s'est produite.
</div>

<!-- Avertissement -->
<div class="alert alert-warning">
  Attention, veuillez vérifier.
</div>

<!-- Information -->
<div class="alert alert-info">
  Information utile.
</div>
```

### Utilitaires de texte

```html
<p class="text-center">Texte centré</p>
<p class="text-primary">Texte couleur primaire</p>
<p class="text-danger">Texte couleur danger</p>
<p class="text-bold">Texte gras</p>
<p class="text-muted">Texte grisé</p>
<p class="text-truncate">Texte tronqué...</p>
<p class="text-clamp-2">Texte limité à 2 lignes...</p>
```

### Utilitaires d'espacement

```html
<!-- Marges -->
<div class="m-0">Pas de marge</div>
<div class="m-1">Petite marge (8px)</div>
<div class="m-2">Marge moyenne (16px)</div>
<div class="m-3">Marge grande (20px)</div>
<div class="m-4">Marge très grande (24px)</div>
<div class="mx-auto">Marge auto (centré)</div>

<!-- Padding -->
<div class="p-0">Pas de padding</div>
<div class="p-1">Petit padding (8px)</div>
<div class="p-2">Padding moyen (16px)</div>
<div class="p-3">Padding grand (20px)</div>
<div class="p-4">Padding très grand (24px)</div>
```

### Utilitaires de Flex

```html
<div class="flex-center">Centré horizontalement et verticalement</div>
<div class="flex-between">Espace entre les éléments</div>
<div class="flex-col">Flex colonne</div>
<div class="gap-1">Petit gap</div>
<div class="gap-2">Gap moyen</div>
<div class="gap-3">Grand gap</div>
```

## 📄 Créer une nouvelle page

1. Ajouter une section dans `_pages.scss` :

```scss
// Dans _pages.scss
.my-page {
  @include container;
  padding-top: $spacing-3xl;
  padding-bottom: $spacing-3xl;

  h1 {
    margin-bottom: $spacing-2xl;
  }

  .my-section {
    @include card;
    margin-bottom: $spacing-2xl;
  }
}
```

2. Ajouter la classe à votre page HTML/PHP :

```php
<div class="my-page">
  <h1>Ma nouvelle page</h1>
  <div class="my-section">
    Contenu
  </div>
</div>
```

3. Recompiler le SCSS :

```bash
sass public/style/main.scss public/style/main.css
```

## 🌐 Responsive Design

Le système utilise des media queries prédéfinies :

```scss
// Mobile
@include media-md {
  .navbar-center {
    display: none;
  }
}

// Tablette et plus
@media (min-width: 768px) {
  .my-element {
    width: 50%;
  }
}

// Desktop large
@include media-xl {
  .container {
    max-width: 1200px;
  }
}
```

## 🎬 Animations disponibles

```scss
@keyframes fadeIn;      // Fade in
@keyframes slideUp;     // Slide up
@keyframes slideDown;   // Slide down
@keyframes slideLeft;   // Slide left
@keyframes slideRight;  // Slide right
@keyframes scaleIn;     // Scale in
@keyframes pulse;       // Pulse
@keyframes shimmer;     // Shimmer (loading)
@keyframes spin;        // Spin
```

Utilisation :

```scss
.my-element {
  animation: fadeIn 0.3s ease-in-out;
}
```

## 🔒 Bonnes pratiques

### ✅ À faire

- Utiliser les variables pour les couleurs et espacements
- Utiliser les mixins pour le code réutilisable
- Organiser le code par sections
- Utiliser les breakpoints media queries prédéfinis
- Compiler le SCSS avant de déployer

### ❌ À éviter

- Hardcoder les couleurs (utiliser les variables)
- CSS inline (utiliser les classes)
- Nesting excessif (max 3 niveaux)
- Utiliser `!important` (sauf dernier recours)
- Compiler le SCSS et modifier directement le CSS

## 🐛 Dépannage

### Le CSS n'a pas changé après modification du SCSS

```bash
# Recompiler manuellement
sass public/style/main.scss public/style/main.css

# Ou utiliser le mode watch
sass --watch public/style:public/style
```

### Les media queries ne fonctionnent pas

Vérifier que le viewport est défini dans le HTML :

```html
<meta name="viewport" content="width=device-width, initial-scale=1.0">
```

### Les styles de la navbar ne s'appliquent pas

S'assurer que le fichier main.css est lié dans le layout :

```php
<link rel="stylesheet" href="<?= base_url('/style/main.css') ?>">
```

## 📚 Ressources utiles

- [Documentation Sass](https://sass-lang.com/documentation)
- [Guide Sass BeginnerS](https://sass-lang.com/guide)
- [SCSS vs CSS](https://www.geeksforgeeks.org/difference-between-css-and-scss/)

## 📞 Points de contact

Pour toute question sur le système CSS/SCSS, consultez :
- Les commentaires dans les fichiers SCSS
- Ce fichier README
- La documentation Sass officielle

---

**Dernière mise à jour :** 9 mai 2026  
**Version :** 1.0.0  
**Auteur :** Équipe développement
