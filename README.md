Instructions pour le Lancement du Projet
Pour exécuter correctement le projet en local, veuillez suivre les étapes ci-dessous :

1. Placement du dossier du projet
Déplacez le dossier du projet dans l’un des répertoires suivants :

Si vous utilisez XAMPP : placez-le dans le dossier htdocs (généralement situé dans C:\xampp\htdocs)

Si vous utilisez WAMP : placez-le dans le dossier www (généralement dans C:\wamp64\www)

2. Ouverture dans un éditeur de code
Ouvrez le dossier du projet avec un éditeur de code tel que :

Visual Studio Code

Sublime Text

3. Configuration de la base de données
Dans le dossier /docs, vous trouverez un fichier contenant le code SQL nécessaire à la création de la base de données.

Rendez-vous sur le site phpMyAdmin via http://localhost/phpmyadmin

Créez une nouvelle base de données en veillant à bien respecter le nom mentionné dans le code (pour éviter toute erreur de connexion).

Dans l’onglet SQL, collez le code SQL fourni, puis cliquez sur Exécuter.

4. Lancement du projet dans le navigateur
Une fois la base de données créée et les tables importées, ouvrez votre navigateur web.

Tapez l’adresse suivante dans la barre de recherche :
Copier
Modifier
http://localhost/nom_du_projet
Remplacez nom_du_projet par le nom exact du dossier que vous avez déplacé dans htdocs ou www.

Ressources utiles utilisées pour le projet
Formulaires Bootstrap 5.3 :
https://getbootstrap.com/docs/5.3/forms/form-control/

Tables Bootstrap 5.3 :
https://getbootstrap.com/docs/5.3/content/tables/

Tutoriels de gestion des erreurs (YouTube) :
Nous avons consulté plusieurs tutoriels disponibles sur YouTube afin de résoudre des problèmes liés aux erreurs courantes en PHP et MySQL (connexion, affichage,).


lien du figma : https://www.figma.com/design/JFbKwnY38rov6Niycjx3dl/Projet-oselo?node-id=2001-161&t=UmwxbpEPyxbRPL7O-1