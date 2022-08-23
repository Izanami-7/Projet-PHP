# Projet-PHP

L'objectif est de créer une application de gestion d'un cabinet médical permettant au secrétariat de saisir les rendez-vous de consultation.
Elle doit permettre de gérer la liste des usagers du centre (avec leurs civilités, leurs noms et prénoms, leurs adresses complètes, leurs dates et lieux de naissance, 
et leurs numéros de sécurité sociale) ainsi que la liste des médecins (avec leurs civilités, noms, et prénoms). 
Chaque usager pourra avoir un médecin référent parmi ceux du centre. 
Le secrétariat devra pouvoir saisir les rendez-vous en choisissant l'usager et 
le médecin dans des listes et en saisissant la date, l'heure, et la durée de la consultation (30 min par défaut).

Gardez à l'esprit que l'application devra être pratique à utiliser et accessible à des néophytes. Imaginez ce que ça ferait si vous deviez l'utiliser tous les jours.

Pour tester à 100% ce projet, il vous faudra d'abord créer une base de données "cabinet".
Pour vous faciliter la tâche, dans le dossier "db" il y a un déjà un fichier .sql contenant toutes les tables nécessaires et remplies avec des consultations, médecins et patients.
Vous n'aurez donc qu'à importer les tables dans la base "cabinet" que vous avez créé.
