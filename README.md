# Dashboard

Le Dashboard de Titan-Beard est une application de gestion back-office conçue pour le site web titan-beard.com. Cette application offre aux administrateurs du site une interface intuitive et robuste pour gérer les différentes parties du site web.

## Fonctionnalités principales

1. **Gestion des utilisateurs :** Les administrateurs ont la possibilité de créer, de modifier et de supprimer des utilisateurs. Ils peuvent également attribuer différents rôles aux utilisateurs, tels qu'administrateur, contributeur et utilisateur.

2. **Gestion des articles :** Les administrateurs peuvent créer de nouveaux articles, les modifier et les supprimer. Cela offre un contrôle complet sur le contenu du site. Création article avec l'éditeur TinyMCE 'WYSIWYG' What You See Is What You Get

3. **Gestion des albums et des podcasts :** Outre les articles, les administrateurs peuvent également gérer les albums et les podcasts. Ils peuvent créer de nouveaux albums et podcasts, les modifier et les supprimer. Gestion des catégories.

4. **Visualisation de la base de données :** Les administrateurs ont une vue d'ensemble de la base de données, leur permettant de comprendre facilement la structure de la base de données et d'effectuer des modifications en conséquence.

docker-compose up -d

mysql -u root -pmy-secret-pw

Debeug:
```bash
 ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
```

![Screenshot du Dashboard](/espace_admin/img_maquette/dashboard.png)

![Screenshot du Dashboard](/espace_admin/img_maquette/dashboard1.png)

![Screenshot du Dashboard](/espace_admin/img_maquette/form.png)

![Screenshot du Dashboard](/espace_admin/img_maquette/podcast.png)

![Screenshot du Dashboard](/espace_admin/img_maquette/tiny.png)

![Screenshot du Dashboard](/espace_admin/img_maquette/maquette.png)

## Color Reference
## Color Reference

| Color             | Hex                                                                |
| ----------------- | ------------------------------------------------------------------ |
| White             | ![#FFFFFF](https://via.placeholder.com/10/FFFFFF?text=+) #FFFFFF |
| Blue              | ![#0000FF](https://via.placeholder.com/10/0000FF?text=+) #0000FF |
| Green             | ![#008000](https://via.placeholder.com/10/008000?text=+) #008000 |
| Orange            | ![#FFA500](https://via.placeholder.com/10/FFA500?text=+) #FFA500 |
com/10/00b48a?text=+) #00d1a0 |

## Run Locally

Clone the project

```bash
  git clone https://github.com/aless4ndro/BackOfficeRadioTitan.git
```

Go to the project directory

```bash
  cd espace_admin
```

Install dependencies

```bash
  Bootstrap cdn version 4.3.0 and 5.3.0
```

Start the server

```bash
  extension vscode php server
```

## Tech Stack

**Client:** HTML5, CSS3, Bootstrap

**Server:** PHP, MySQL, PHPMYADMIN

**Design/maquette:** Figma

