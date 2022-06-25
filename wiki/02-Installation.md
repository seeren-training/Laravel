# Installation

* 🔖 **Installation**
* 🔖 **Server**
* 🔖 **Docker**
* 🔖 **Structure**

___

## 📑 Installation


### 🏷️ **Composer**

Un create proejct ave composer est disponible.

```bash
composer create-project laravel/laravel example-app
```

### 🏷️ **CLI**

Il existe un CLI global qui peut être utilisé

```php
composer global require laravel/installer
```

Vous devez ajouter à votre PATH le dossier vendor global

*Exemple sur mac avec le fichier .zshrc*
```bash
# Allow composer global package
export PATH=$HOME/.composer/vendor/bin
```

[The Laravel installer](https://laravel.com/docs/9.x/installation#the-laravel-installer)

___

## 📑 Server

Le projet etant en place vous pouvez démarrer le server

### 🏷️ **Démarrer**

```bash
php artisan serve
```

### 🏷️ **Arreter**

Il n'y a pas de commandes pour tuer le process. Un gracefull shutdown avec CTRL + C arrête le server. S'il plante vous devez tuer le process vous même.

*Exemple sur Linux*

```bash
ps aux | grep artisan
# get the PID from the list
kill <PID NUMBER>
```

___

## 📑 Docker

Une image est disponible sur le Docker Hub

[bitnami/laravel](https://hub.docker.com/r/bitnami/laravel)

```php
mkdir myapp && cd myapp
curl -LO https://raw.githubusercontent.com/bitnami/bitnami-docker-laravel/master/docker-compose.yml
docker-compose up -d
```

Vous pouvez alors naviguer à l'adresse http://localhost:8000

Pour exécuter des commandes dans un container utilisez docker.

```bash
docker-compose exec <service> <command>
```

Donc dans notre exemple:

```bash
docker-compose exec myapp php artisan
```

___

## 📑 Structure

La structure est détaillée sur la documentation:

[Structure](https://laravel.com/docs/9.x/structure)