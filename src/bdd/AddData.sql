#Ajout du compte visiteur
INSERT INTO Membres(login) value
("Visiteur");

INSERT INTO Membres(login, mdp, mail) VALUES
("Emilien", "bcdebaf4e71d0058e394d9f5de05e1a79e7d80f2", "emilien.dirand21@gmail.com"),
("Laala", "04ef49c51165345c45e2accccd5cc45f293eec2b", "laala.djelouah@etu.u-bordeaux.fr"),
("Samuel", "f84b9d6e4d47f01b5c42b1e35ba6f39edc674279", "samuel.laveau@etu.u-bordeaux.fr");

INSERT INTO Projets(nom, description, flag_Prive, flag_Etat) VALUE 
("ManageYourProject", "Meilleure application de gestion de projet en ligne du moment, ManageYourProject vous permet de 
suivre l'évolution d'un projet en suivant la méthode SCRUM.", 0, 0);

INSERT INTO UserStory(numero, description, effort, priorite, projet_id) VALUES
(1, "En tant que user, je souhaite pouvoir me connecter au site web.", 1, 2, 1),
(2, "En tant que dev, je souhaite pouvoir visualiser/supprimer mes projets.", 2, 2, 1),
(3, "En tant que dev, je souhaite pouvoir créer un nouveau projet public ou privé. ", 2, 2, 1),
(4, "En tant que dev, je souhaite pouvoir ajouter un dev à un projet.", 1, 2, 1),
(5, "En tant que dev, je souhaite pouvoir ajouter les US que j’accepte de traiter en 
indiquant la priorité du PO.", 1, 2, 1),
(6, "En tant que dev/visiteur, je souhaite pouvoir consulter les US acceptées.", 2, 2, 1),
(7, "En tant que dev/visiteur, je souhaite pouvoir consulter l'avancement des US validées 
(matrice de traçabilité).", 3, 2, 1),
(8, "En tant que dev, je souhaite pouvoir planifier un sprint (backlog).", 2, 2, 1),
(9, "En tant que dev/visiteur, je souhaite pouvoir consulter la planification des sprints.",
 2, 2, 1),
(10, "En tant que dev/visiteur, je souhaite pouvoir consulter l'avancement des sprints 
(burndown chart).", 5, 2, 1),
(11, "En tant que dev, je souhaite pouvoir ajouter une tâche à un sprint.", 2, 2, 1),
(12, "En tant que dev, je souhaite pouvoir établir la planification et les 
dépendances des tâches (PERT).", 3, 2, 1),
(13, "En tant que dev/visiteur, je souhaite pouvoir modifier/consulter l'avancement 
de la réalisation des tâches (Kanban).", 8, 2, 1),
(14, "En tant que dev, je souhaite pouvoir établir les règles d’utilisation des dépôts.", 
1, 1, 1),
(15, "En tant que dev/visiteur, je souhaite pouvoir consulter les règles d’utilisation des dépôts.
", 1, 1, 1),
(16, "En tant que dev, je souhaite pouvoir définir les outils de programmation qui seront utilisés.
", 1, 1, 1),
(17, "En tant que dev/visiteur, je souhaite pouvoir consulter les outils de 
programmation qui seront utilisés.", 1, 1, 1),
(18, "En tant que dev, je souhaite pouvoir définir la politique des tests.", 1, 1, 1),
(19, "En tant que dev/visiteur, je souhaite pouvoir consulter la politique des tests.", 
1, 1, 1),
(20, "En tant que dev, je souhaite pouvoir définir des règles et qualités de 
programmation exigées.", 1, 1, 1),
(21, "En tant que dev, je souhaite pouvoir consulter les règles et qualités 
de programmation exigées.", 1, 1, 1);

INSERT INTO Sprints(numero, date_debut, date_fin, projet_id) VALUES
(1,"2016-10-24", "2016-11-04", 1),
(2,"2016-11-07", "2016-11-18",1),
(3, "2016-11-21", "2016-12-02", 1);

INSERT INTO Developpeurs(membre_id, projet_id) VALUES
(2, 1),
(3, 1),
(4, 1);

INSERT INTO Taches(numero, description, cout, etat, date_debut, date_fin, sprint_id,
us, developpeur_id, dependances) VALUES
(1, "Créer la base de données avec les tables Membres, Projets, Users_Story, Log, Sprints, 
Taches, Developpeurs, Documents (ces tables ont été définies dans notre documentation).",
1, 2, "2016-10-24", "2016-10-24", 1, "ALL", 1, ""),
(2, "Créer les requêtes nécessaires, c’est-à-dire d’ajouter un membre, 
de sélectionner les membres, de sélectionner un membre par son login, 
d’ajouter un projet, de lister les projets, d’ajouter un sprint, de lister 
les sprints en fonction d’un projet, d’ajouter les US d’un projet et de lister les US 
d’un projet.",1, 2, "2016-10-25", "2016-10-25", 1, "ALL", 1, ""),
(3, "Créer la page d’inscription permettant à l’utilisateur de s’inscrire en entrant 
un login un mot de passe et une adresse mail.",
1, 2, "2016-10-26", "2016-10-28", 2, "1", 2, "");

INSERT INTO Doc(adresse_dev, adresse_demo, politique_tests, langages_outils, regles_depot, regles_qualite,
projet_id) VALUE
("https://github.com/edirand/ManageYourProjectDev.git", 
"https://github.com/edirand/ManageYourProjectDemo.git",
"Tests de validation obligatoire pour chaque US.", 
"Langages : PHP, SQL\nOutils : MySQLWorkbench, MAMP/WAMP", 
"Sur le dépôt dev, tout le monde peut commiter.\n
Sur le dépôt démo, seul le responsable du dépôt peut commiter. Le responsable doit s'assurer
du fonctionnement de la démo avant de commiter.\nLes dépôts doivent suivre cette arborescence :\n
- Documentation : /doc/ \n
- Sources web : /src/web/ \n
- Sources SQL : /src/bdd/", "Le code fournit doit obtenir au minimum une note de B", 1);

INSERT INTO Log(membre_id, element_modif, date_modif, projet_id) VALUES
(1, "a modifié le KanBan", "2016-10-24", 1),
(2, "a ajouté un développeur", "2016-10-22", 1),
(3, "a supprimé un développeur", "2016-10-23", 1);