# SQLite Database Guide

## 🎉 Pourquoi SQLite ?

SQLite est **parfait pour Vercel** et les déploiements serverless :
- ✅ **Aucune base de données externe nécessaire**
- ✅ **Aucun coût supplémentaire**
- ✅ **Configuration zéro**
- ✅ **Déploiement instantané**
- ✅ **Idéal pour les applications de petite à moyenne taille**

## 🚀 Démarrage rapide

### Configuration locale

#### Windows
```bash
# Exécutez le script d'initialisation
init-sqlite.bat
```

#### Linux/Mac
```bash
# Rendez le script exécutable
chmod +x init-sqlite.sh

# Exécutez-le
./init-sqlite.sh
```

#### Manuellement (si les scripts ne fonctionnent pas)
```bash
# Avec SQLite installé
sqlite3 db/care.db ".read db/init.sqlite.sql"

# OU avec PHP
php -r "$pdo = new PDO('sqlite:db/care.db'); $pdo->exec(file_get_contents('db/init.sqlite.sql'));"
```

### Configuration sur Vercel

**Aucune configuration nécessaire !** 🎉

La base de données est automatiquement initialisée lors du premier démarrage sur Vercel.

Variable d'environnement optionnelle :
```
GROQ_API_KEY=votre_api_key_groq
```

## 📊 Structure de la base de données

### Table: users
```sql
- id: INTEGER PRIMARY KEY AUTOINCREMENT
- name: TEXT NOT NULL
- email: TEXT UNIQUE NOT NULL
- password: TEXT NOT NULL (bcrypt hash)
- is_admin: INTEGER (0 ou 1)
- created_at: DATETIME
```

### Table: testimonials
```sql
- id: INTEGER PRIMARY KEY AUTOINCREMENT
- parent_name: TEXT
- content: TEXT
- user_id: INTEGER (FK -> users.id)
- status: TEXT ('pending', 'approved', 'rejected')
- ai_sentiment: TEXT
- ai_score: REAL (0.0 - 1.0)
- created_at: DATETIME
```

### Table: gallery
```sql
- id: INTEGER PRIMARY KEY AUTOINCREMENT
- image_path: TEXT NOT NULL
- caption: TEXT
- created_at: DATETIME
```

## 🔐 Compte administrateur par défaut

```
Email: admin@gardekids.com
Password: admin123
```

**⚠️ IMPORTANT:** Changez ce mot de passe immédiatement après le premier déploiement !

### Changer le mot de passe admin

#### Méthode 1: Générer un nouveau hash
```bash
# Générer le hash
php -r "echo password_hash('votre_nouveau_mot_de_passe', PASSWORD_BCRYPT);"

# Copier le hash généré (commence par $2y$10$...)
```

Puis modifier `db/init.sqlite.sql`, ligne 35 :
```sql
INSERT OR IGNORE INTO users (name, email, password, is_admin) 
VALUES (
    'Admin',
    'admin@gardekids.com',
    '$2y$10$VOTRE_NOUVEAU_HASH_ICI',  -- <-- Remplacez ici
    1
);
```

#### Méthode 2: Via la base de données
```bash
# Générer le hash
NEW_HASH=$(php -r "echo password_hash('nouveau_password', PASSWORD_BCRYPT);")

# Mettre à jour dans la base
sqlite3 db/care.db "UPDATE users SET password='$NEW_HASH' WHERE email='admin@gardekids.com';"
```

#### Méthode 3: Depuis PHP
Créez un fichier temporaire `update-admin.php` :
```php
<?php
require_once 'config/db.php';

$new_password = 'votre_nouveau_mot_de_passe';
$hash = password_hash($new_password, PASSWORD_BCRYPT);

$stmt = $pdo->prepare("UPDATE users SET password = ? WHERE email = 'admin@gardekids.com'");
$stmt->execute([$hash]);

echo "Password updated successfully!";
?>
```

Exécutez-le une fois, puis supprimez-le.

## 🛠️ Opérations courantes

### Visualiser la base de données

#### Avec SQLite CLI
```bash
# Ouvrir la base
sqlite3 db/care.db

# Lister les tables
.tables

# Voir la structure d'une table
.schema users

# Exécuter des requêtes
SELECT * FROM users;

# Quitter
.quit
```

#### Avec DB Browser (GUI)
1. Téléchargez [DB Browser for SQLite](https://sqlitebrowser.org/)
2. Ouvrez `db/care.db`
3. Interface graphique complète

#### Avec VSCode
1. Installez l'extension "SQLite"
2. Clic droit sur `db/care.db` → "Open Database"

### Sauvegarder la base de données

```bash
# Copie simple
cp db/care.db db/care.backup.db

# Export SQL
sqlite3 db/care.db .dump > backup.sql

# Restaurer depuis un dump
sqlite3 db/care.db < backup.sql
```

### Réinitialiser la base de données

```bash
# Windows
del db\care.db
init-sqlite.bat

# Linux/Mac
rm -f db/care.db
./init-sqlite.sh
```

## ⚙️ Configuration avancée

### Personnaliser le chemin de la base

Créez un fichier `.env` :
```env
DB_PATH=/chemin/personnalisé/ma-base.db
```

### Optimisations de performance

Les paramètres suivants sont déjà configurés dans `config/db.php` :

```php
$pdo->exec('PRAGMA foreign_keys = ON;');       // Active les contraintes FK
$pdo->exec('PRAGMA journal_mode = WAL;');      // Mode Write-Ahead Logging
$pdo->exec('PRAGMA synchronous = NORMAL;');    // Équilibre performance/sécurité
```

## 🔍 Dépannage

### Erreur: "database is locked"
- SQLite supporte un seul writer à la fois
- Configuré en mode WAL pour minimiser les locks
- Fermez les connexions ouvertes (DB Browser, etc.)

### Erreur: "unable to open database file"
- Vérifiez les permissions du dossier `db/`
- Le serveur PHP doit avoir les droits d'écriture
```bash
chmod 755 db/
chmod 644 db/care.db
```

### La base se réinitialise sur Vercel
- Normal ! Le système de fichiers `/tmp` est éphémère
- La base est recréée à chaque cold start
- **Solution:** Utilisez Vercel KV ou Postgres pour persistance

### Performances lentes
- Ajoutez des index sur les colonnes fréquemment recherchées
- Activez le mode WAL (déjà fait dans config/db.php)
- Limitez la taille de la base (< 1 GB recommandé)

## 📈 Migration depuis MySQL

Si vous aviez MySQL avant :

1. ✅ Le schéma est déjà converti
2. ✅ Les types de données sont adaptés
3. ✅ Les contraintes sont migrées
4. ✅ Le code PHP fonctionne sans modification (PDO)

### Différences MySQL → SQLite

| MySQL | SQLite |
|-------|--------|
| `INT AUTO_INCREMENT` | `INTEGER AUTOINCREMENT` |
| `VARCHAR(100)` | `TEXT` |
| `TINYINT` | `INTEGER` |
| `ENUM('a','b')` | `TEXT CHECK(col IN ('a','b'))` |
| `DECIMAL(3,2)` | `REAL` |
| `TIMESTAMP` | `DATETIME` |

## 🚀 Production sur Vercel

### Limitations importantes

⚠️ **Le système de fichiers `/tmp` sur Vercel est éphémère**

Cela signifie :
- ❌ Les données sont perdues après ~15 minutes d'inactivité
- ❌ Chaque région a sa propre base
- ❌ Les données ne persistent pas entre les déploiements

### Solutions pour la persistance

#### Option A: Vercel Postgres (Recommandé pour production)
```bash
# Ajoutez Postgres à votre projet
vercel postgres create

# Plus de détails: https://vercel.com/docs/storage/vercel-postgres
```

#### Option B: Turso (SQLite dans le cloud)
- SQLite distribué et persistant
- Compatible avec le code actuel
- https://turso.tech

#### Option C: Cloudflare D1 (Alternative)
- SQLite as a Service
- Intégration avec Cloudflare Workers
- https://developers.cloudflare.com/d1

## 💾 SQLite est parfait pour :

✅ Sites de démonstration
✅ Prototypes et MVP
✅ Développement local
✅ Applications avec < 100 000 utilisateurs
✅ Lectures fréquentes, écritures occasionnelles
✅ Environnements serverless avec données éphémères

❌ SQLite n'est PAS recommandé pour :

- Applications haute concurrence (> 100 writes/sec)
- Données devant persister entre redémarrages (sur Vercel)
- Bases > 1-2 GB
- Architecture multi-serveurs avec réplication

## 📚 Ressources

- [Documentation SQLite](https://www.sqlite.org/docs.html)
- [SQLite vs MySQL](https://www.sqlite.org/whentouse.html)
- [DB Browser for SQLite](https://sqlitebrowser.org/)
- [Vercel Storage Options](https://vercel.com/docs/storage)

---

**Note:** Pour une application en production avec persistance des données, considérez Vercel Postgres, Turso, ou Railway avec PostgreSQL/MySQL.
