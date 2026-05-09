#!/bin/bash
# Installation et compilation auto du système SCSS
# Utilisez ce script pour installer et compiler automatiquement

echo "🎨 Installation du système CSS/SCSS..."
echo "======================================"
echo ""

# Vérifier si npm est installé
if ! command -v npm &> /dev/null
then
    echo "❌ npm n'est pas installé!"
    echo "Installez Node.js depuis https://nodejs.org"
    exit 1
fi

echo "✅ npm trouvé"
echo ""

# Installation des dépendances
echo "📦 Installation des dépendances..."
npm install
echo "✅ Dépendances installées!"
echo ""

# Compilation du SCSS
echo "🔨 Compilation du SCSS..."
npm run sass
echo "✅ CSS compilé!"
echo ""

# Afficher le message de fin
echo "======================================"
echo "🎉 Installation complète!"
echo ""
echo "Pour utiliser en développement:"
echo "  npm run sass:watch"
echo ""
echo "Pour la production:"
echo "  npm run sass:prod"
echo ""
echo "📚 Documentation:"
echo "  - QUICK_START.md"
echo "  - SCSS_GUIDE.md"
echo "  - SYSTEMS_SUMMARY.md"
echo "  - public/style/README.md"
echo ""
echo "======================================"
