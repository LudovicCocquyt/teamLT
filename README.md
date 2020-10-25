#Vitrine team esport
Site vitrine pour une équipe esport.
Possibilité d'afficher:
- des jeux
- les joueurs
- les équipes
- les résultats de match
- le palmarés
- des actualités
- personaliser la page d'accueil
- formulaire de contact
- bloc note coté admin

"php": ">=7.2.5"
"symfony/asset": "5.1.*",

##Bundle
symfony/webpack-encore-bundle": "^1.7",
composer require symfony/security-bundle

###Datafixtures
Mise en place du user super admin.
Ne pas modifier l'ordre du contenu statique

####Database
bin/console d:d:drop --force
bin/console d:d:create
bin/console d:s:u --force
bin/console d:f:l

#####User super admin
login:    "admin@admin.com"
password: "admin"