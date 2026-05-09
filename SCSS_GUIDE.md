# 🎨 Guide d'utilisation du système CSS/SCSS

## ✅ Démarrage rapide

### 1. Installation de Sass

```bash
# Avec npm
npm install

# Ou installer Sass globalement
npm install -g sass
```

### 2. Compiler le SCSS

```bash
# Une seule fois
npm run sass

# Avec surveillance automatique (recommandé)
npm run sass:watch
```

### 3. Vérifier le résultat

Le fichier `public/style/main.css` sera créé automatiquement à partir de `public/style/main.scss`.

## 📊 Organisation du CSS

Votre système CSS est organisé en 7 modules :

```
public/style/
├── main.scss           ← Fichier principal à compiler
├── main.css            ← Fichier compilé (utilisez celui-ci en HTML)
├── _variables.scss     ← Couleurs, espacements, fonts
├── _mixins.scss        ← Fonctions réutilisables
├── _base.scss          ← Reset et styles de base
├── _forms.scss         ← Tous les éléments de formulaire
├── _navbar.scss        ← Barre de navigation responsive
├── _components.scss    ← Cards, badges, alertes, utilitaires
└── _pages.scss         ← Styles spécifiques à chaque page
```

## 🎨 Personnaliser les couleurs

Modifiez `public/style/_variables.scss` :

```scss
// Couleurs primaires
$color-primary: #111827;      // Changer la couleur principale
$color-gold: #c59d00;         // Couleur or (Gold)
$color-success: #10b981;      // Vert (succès)
$color-danger: #ef4444;       // Rouge (erreur)
```

## 🌍 Ajouter une nouvelle page

1. Créez le fichier PHP dans `app/Views/ma-page/index.php`
2. Ajoutez les styles dans `public/style/_pages.scss` :

```scss
// Dans _pages.scss
.ma-page {
  @include container;
  padding-top: $spacing-3xl;
  
  h1 {
    margin-bottom: $spacing-2xl;
  }
}
```

3. Appliquez la classe à votre page :

```php
<div class="ma-page">
  <h1>Ma nouvelle page</h1>
</div>
```

4. Recompilez :

```bash
npm run sass
```

## 📱 Responsive Design

Utilisez les mixins pour les appareils :

```scss
.mon-element {
  display: block;
  
  // Masquer sur mobile et tablette
  @include media-md {
    display: none;
  }
  
  // Afficher sur desktop grand
  @include media-lg {
    display: flex;
  }
}
```

Breakpoints disponibles :
- `@include media-sm` → 640px max
- `@include media-md` → 768px max *(Tablette)*
- `@include media-lg` → 1024px max
- `@include media-xl` → 1280px min *(Desktop grand)*

## 🔧 Composants prêts à l'emploi

### Boutons

```html
<button class="btn-primary">Primaire</button>
<button class="btn-secondary">Secondaire</button>
<button class="btn-danger">Danger</button>
<button class="btn-success">Succès</button>
```

### Cartes

```html
<div class="card">
  <div class="card-header"><h3>Titre</h3></div>
  <div class="card-body">Contenu</div>
  <div class="card-footer">Pied</div>
</div>
```

### Badges

```html
<span class="badge badge-primary">Badge</span>
<span class="badge badge-gold">Or</span>
<span class="badge badge-danger">Danger</span>
```

### Alertes

```html
<div class="alert alert-success">✓ Succès!</div>
<div class="alert alert-danger">✕ Erreur!</div>
<div class="alert alert-warning">⚠ Attention!</div>
<div class="alert alert-info">ℹ Info</div>
```

### Utilitaires d'espacement

```html
<div class="m-2">Marge 16px</div>
<div class="p-3">Padding 20px</div>
<div class="gap-2">Gap 16px</div>
```

### Flexbox

```html
<div class="flex-center">Centré</div>
<div class="flex-between">Espace entre</div>
<div class="flex-col">Colonne</div>
```

## 🎬 Animations

Utilisez les animations intégrées :

```html
<div style="animation: fadeIn 0.3s;">Fade in</div>
<div style="animation: slideUp 0.3s;">Slide up</div>
<div style="animation: scaleIn 0.3s;">Scale in</div>
```

## 🚀 Production

Pour minimifier le CSS :

```bash
npm run sass:prod
```

Cela génère un fichier `main.css` compressé et optimisé.

## 📋 Fichiers HTML/PHP à mettre à jour

Vérifiez que votre layout `app/Views/layout/main.php` contient :

```php
<link rel="stylesheet" href="<?= base_url('/style/main.css') ?>">
```

✅ C'est déjà fait ! Vous pouvez commencer tout de suite.

## 📚 Documentation complète

Voir `public/style/README.md` pour la documentation détaillée.

## ❓ FAQ

**Q : Comment changer la couleur de la navbar ?**
R : Modifiez `$color-bg-secondary` et `$color-text-primary` dans `_variables.scss`

**Q : Pourquoi le CSS ne change pas ?**
R : Vous devez recompiler avec `npm run sass` ou `npm run sass:watch`

**Q : Puis-je modifier le fichier main.css directement ?**
R : ❌ Non ! Les modifications seront perdues à la prochaine compilation. Modifiez uniquement les fichiers SCSS.

**Q : Comment ajouter une nouvelle couleur ?**
R : Ajoutez-la dans `_variables.scss` puis utilisez-la avec `color: $ma-couleur;`

---

🎉 **Vous êtes prêt !** Commencez par compiler le SCSS et personnaliser les couleurs.
