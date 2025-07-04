# 🏃‍♂️ Projet Laravel – Gestion de Course Marathon

Ce projet est une application web de gestion de course marathon, développée avec **Laravel** et **PostgreSQL**.

## 🚀 Fonctionnalités principales

- Gestion des participants et des équipes
- Gestion des étapes et chronométrage
- Classements individuels et par équipe
- Import/export CSV
- Génération de PDF des résultats
- Interface admin + équipe

## 🛠️ Technologies utilisées

- PHP / Laravel
- PostgreSQL
- Bootstrap / Blade
- Git & GitHub

## ⚙️ Installation locale

```bash
git clone https://github.com/tsanta001/-Gestion-de-course-_Marathon.git
cd gestion-course-marathon
composer install
cp .env.example .env
php artisan key:generate
# Configurer votre .env pour PostgreSQL
php artisan migrate
php artisan serve

## 📸 Captures d’écran

### 🏠 Page d'accueil
![Ajout](https://raw.githubusercontent.com/tsanta001/-Gestion-de-course-_Marathon/main/screenshots/Ajout.jpg?<?=time()?>)

### 🏁 Classement final
![Classement](https://raw.githubusercontent.com/tsanta001/-Gestion-de-course-_Marathon/main/screenshots/Classement.jpg?<?=time()?>)

### 📝 Formulaire d'inscription
![Importation](https://raw.githubusercontent.com/tsanta001/-Gestion-de-course-_Marathon/main/screenshots/Importation.jpg?<?=time()?>)
