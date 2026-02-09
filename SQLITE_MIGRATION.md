# Migration MySQL → SQLite - Résumé

## ✅ Migration terminée !

Votre application utilise maintenant **SQLite** au lieu de MySQL. C'est **beaucoup plus simple** pour Vercel !

## 🎉 Changements effectués

### Fichiers créés

#### Schémas SQLite
- ✅ `db/init.sqlite.sql` - Schéma d'initialisation SQLite
- ✅ `db/schema.sqlite.sql` - Schéma complet SQLite

#### Scripts d'initialisation
- ✅ `init-sqlite.bat` - Script Windows pour créer la base
- ✅ `init-sqlite.sh` - Script Linux/Mac pour créer la base

#### Documentation
- ✅ `SQLITE_GUIDE.md` - Guide complet SQLite
- ✅ `SQLITE_MIGRATION.md` - Ce fichier

### Fichiers modifiés

#### Configuration
- 📝 `config/db.php` - Utilise maintenant SQLite PDO
  - Auto-initialisation sur Vercel
  - Support performance optimizations (WAL, pragmas)
  - Détection environnement Vercel

#### Configuration Vercel
- 📝 `vercel.json` - Variables DB supprimées (plus nécessaires!)
- 📝 `.env.example` - Simplifié, plus de credentials DB
- 📝 `.gitignore` - Exclut les fichiers *.db

#### Documentation
- 📝 `README.md` - Instructions simplifiées
- 📝 `QUICKSTART_VERCEL.md` - Déploiement en 2 minutes
- 📝 `VERCEL_DEPLOYMENT.md` - Guide simplifié
- 📝 `MIGRATION_SUMMARY.md` - Notes sur SQLite

### Fichiers conservés (référence)
- 📄 `db/init.sql` - Schéma MySQL original (backup)
- 📄 `db/schema.sql` - Schéma MySQL original (backup)

## 🚀 Démarrage rapide

### Développement local

#### Windows
```bash
# Créer la base SQLite
init-sqlite.bat

# Démarrer le serveur
php -S localhost:8000
```

#### Linux/Mac
```bash
# Créer la base SQLite
chmod +x init-sqlite.sh
./init-sqlite.sh

# Démarrer le serveur
php -S localhost:8000
```

### Déploiement Vercel

**Super simple maintenant !**

```bash
# Pousser sur GitHub
git add .
git commit -m "Migration vers SQLite"
git push

# Déployer sur Vercel
vercel

# OU via le dashboard : vercel.com → Import GitHub
```

**C'est tout !** La base de données est automatiquement créée. ✨

## 📊 Différences MySQL vs SQLite

### Types de données convertis

| MySQL | SQLite | Note |
|-------|--------|------|
| `INT AUTO_INCREMENT` | `INTEGER AUTOINCREMENT` | IDs auto |
| `VARCHAR(100)` | `TEXT` | Texte variable |
| `TINYINT` | `INTEGER` | 0 ou 1 |
| `ENUM('a','b','c')` | `TEXT CHECK(...)` | Contrainte CHECK |
| `DECIMAL(3,2)` | `REAL` | Nombres décimaux |
| `TIMESTAMP` | `DATETIME` | Dates |

### Syntaxe modifiée

| MySQL | SQLite |
|-------|--------|
| `ENGINE=InnoDB` | *(supprimé)* |
| `CHARSET=utf8mb4` | *(supprimé, UTF-8 par défaut)* |
| `ON DUPLICATE KEY UPDATE` | `INSERT OR IGNORE` |
| Foreign keys auto | `PRAGMA foreign_keys = ON;` |

### Code PHP

**Aucun changement nécessaire !** 🎉

Le code utilise PDO, qui fonctionne identiquement avec SQLite et MySQL.

## ⚠️ Important à savoir

### Sur Vercel

SQLite utilise le dossier `/tmp` qui est **éphémère** :

**Implications :**
- ✅ Base auto-initialisée au démarrage
- ✅ Parfait pour demos, prototypes, MVPs
- ⚠️ Données réinitialisées après ~15 min d'inactivité
- ⚠️ Données non persistantes entre déploiements

**Idéal pour :**
- 🎯 Sites de démonstration
- 🎯 Prototypes et POCs
- 🎯 Applications de test
- 🎯 Sites avec < 1000 utilisateurs

**Pour la production avec persistance :**
- Utilisez Vercel Postgres
- Ou Turso (SQLite distribué)
- Ou Railway (meilleur pour PHP)
- Voir [SQLITE_GUIDE.md](SQLITE_GUIDE.md)

### En local

SQLite crée un fichier `db/care.db` :
- ✅ Données persistantes
- ✅ Fichier unique, facile à sauvegarder
- ✅ Pas de serveur DB à démarrer
- ✅ Interface avec DB Browser ou VSCode

## 🔐 Sécurité

### Compte admin par défaut

```
Email: admin@gardekids.com
Password: admin123
```

**⚠️ Changez-le immédiatement !**

Voir [ADMIN_CREDENTIALS.md](ADMIN_CREDENTIALS.md)

### Variables d'environnement

Plus besoin de :
- ❌ `DB_HOST`
- ❌ `DB_NAME`
- ❌ `DB_USER`
- ❌ `DB_PASS`

Seulement :
- ✅ `GROQ_API_KEY` (optionnel, pour le chatbot)

## 🛠️ Opérations courantes

### Visualiser la base

```bash
# Avec SQLite CLI
sqlite3 db/care.db
.tables
SELECT * FROM users;

# Avec DB Browser (GUI)
# Téléchargez : https://sqlitebrowser.org/

# Avec VSCode
# Extension : alexcvzz.vscode-sqlite
```

### Sauvegarder

```bash
# Copie simple
cp db/care.db db/care.backup.db

# Export SQL
sqlite3 db/care.db .dump > backup.sql
```

### Réinitialiser

```bash
# Windows
del db\care.db
init-sqlite.bat

# Linux/Mac
rm -f db/care.db
./init-sqlite.sh
```

## 📈 Avantages de SQLite

### Pour Vercel

✅ **Aucune configuration** - Déploiement en 1 clic
✅ **Aucun coût** - Pas de service DB externe
✅ **Aucune latence** - Base locale
✅ **Démarrage rapide** - Initialisée automatiquement
✅ **Simple** - Un seul fichier

### Pour le développement

✅ **Installation zéro** - Inclus dans PHP
✅ **Portable** - Un fichier db/care.db
✅ **Rapide** - Pas de réseau
✅ **Debugging facile** - Outils visuels gratuits
✅ **Versionnable** - Git-friendly (avec .gitignore)

## 🔄 Retour à MySQL (si nécessaire)

Si vous devez revenir à MySQL :

1. Restaurez `config/db.php` depuis Git
2. Utilisez `db/init.sql` et `db/schema.sql`
3. Configurez les variables d'environnement DB_*
4. Mettez à jour `vercel.json`

## 📚 Documentation

- **[SQLITE_GUIDE.md](SQLITE_GUIDE.md)** - Guide complet SQLite
- **[QUICKSTART_VERCEL.md](QUICKSTART_VERCEL.md)** - Déploiement rapide
- **[VERCEL_DEPLOYMENT.md](VERCEL_DEPLOYMENT.md)** - Guide détaillé
- **[README.md](README.md)** - Vue d'ensemble

## 🆘 Besoin d'aide ?

### Problèmes courants

**La base ne se crée pas localement**
```bash
# Vérifiez que PHP est installé
php --version

# Créez manuellement
php -r "$pdo = new PDO('sqlite:db/care.db'); $pdo->exec(file_get_contents('db/init.sqlite.sql'));"
```

**Erreur "database is locked"**
- Fermez DB Browser ou autres connexions
- SQLite supporte 1 writer à la fois (mode WAL activé)

**Les données disparaissent sur Vercel**
- Normal ! Voir section "Important à savoir" ci-dessus
- Solutions dans [SQLITE_GUIDE.md](SQLITE_GUIDE.md)

## 🎯 Prochaines étapes

1. ✅ Testez localement avec `init-sqlite.bat` ou `.sh`
2. ✅ Déployez sur Vercel (automatique)
3. ✅ Changez le mot de passe admin
4. ✅ Configurez Cloudinary pour les uploads (optionnel)
5. ✅ Ajoutez GROQ_API_KEY pour le chatbot (optionnel)

## 💡 Conseil

**Pour une application de production** avec beaucoup de données :

👉 Considérez **Railway** au lieu de Vercel :
```bash
npm install -g @railway/cli
railway login
railway init
railway up
```

Railway offre :
- Base de données persistante (MySQL/Postgres/SQLite)
- Système de fichiers persistant
- Support PHP natif excellent
- Prix très compétitifs

---

**Profitez de votre déploiement simplifié ! 🚀✨**

Pour toute question, consultez [SQLITE_GUIDE.md](SQLITE_GUIDE.md)
