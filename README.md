# Site du département informatique de l'IUT d'Aix-en-Provence de Aix-Marseille Université

Ce guide vous aidera à naviguer et à utiliser efficacement notre site web du département informatique d'Aix-Marseille conçu pour présenter le département et une partie intranet pour les étudiants.
Que vous soyez un nouvel utilisateur ou un utilisateur expérimenté, ce guide contient toutes les informations nécessaires.
Sur la page d'accueil vous aurez accès à toutes la partie publique de notre site web. Vous pourrez ici consulter toutes les informations essentielles concernant le BUT informatique d'Aix-en-Provence. 
Si vous possédez un compte, vous pourrez consulter la partie intranet de notre site web. Celle-ci contient un ensemble de pages utiles aux étudiants afin de les accompagner dans leur vie universitaire.
Si vous avez un accès en mode administrateur, vous pourrez moidifier l'ensmeble du contenu des pages, en ajouter ou en supprimer à l'aide de templates que nous avons développé, mais également gérer les comptes des utilisateurs.

## Configuration nécéssaire pour lancer sous localhost ou réutiliser le code source afin de développer votre propre site web
Notre site web est totalement générique et toutes les données sont stockées sous base de données. Renseignez-vous grâce à la documentation afin de comprendre comment développer une base de données afin de réutiliser notre modèle de site web.

## Configuration php
Afin de pouvoir réutiliser notre code source, vous devrez utiliser tout d'abord un serveur apache2. Vous devrez ensuite installer la version 8.2 de PHP avec les extensions **pdo_mysql**,**libmysqlclient-dev** et **sendmail** .
Une fois cela fait, activez les dans le fichier **php.ini** (généralement trouvable dans **/etc/php/PHP8.2/cli/**) et passez les tailles max d'upload à 20 mo.
Pour ce qui est de l'IDE installez de préférence **PHPStorm** pour éviter toutes erreurs lors de l'importation du projet. Une fois celui-ci importé, pensez bien à mettre à jour composer afin d'être sûr de pouvoir utiliser toutes les fonctionnalités de celui-ci%.

## Accéder à notre site web

Vous pourrez retrouver notre site à l'adresses suivante : [https://departementinfoaix.alwaysdata.net/].
