#Les requêtes sont classées par fonctionnalité

######################Inscription :############################
#Tester si un compte existe déjà pour cette adresse mail#
Select id from Membres where mail = ?;

#Ajouter un nouveau membre#
Insert into Membres(login, mdp, mail) value
(?, ?, ?);

######################Connexion :############################
#Tester le mot de passe (hashage sha-1)
Select mdp from Membres where login = ?;

#Récupère toutes les informations concernant le membre (à voir ce dont on a besoin)
Select * from Membres where login = ?;

######################Page d'accueil :########################
#Récupère la liste des projets auxquels participe un développeur pour l'afficher dans la liste
Select id, nom from Projets where id = (Select projet_id from Developpeurs where membre_id = ?);

#Récupère les 10 derniers logs des projets auxquels participe un développeur
Select M.login, L.element_modif, L.date_modif, P.nom from Log as L 
join Projets as P ON L.projet_id = P.id
join Membres as M ON L.membre_id = M.id
Where P.id IN
(Select Developpeurs.projet_id From Developpeurs where membre_id = ?)
Order by L.date_modif DESC
LIMIT 10;

######################Page Ajout projet :########################
#Tester si le projet existe déjà / recupérer l'id du projet ajouté pour ajouter la doc et les US
Select id from Projets where nom = ?;

#Ajouter un nouveau projet
INSERT INTO Projets(nom, description, flag_Prive, flag_Etat) VALUE 
(?, ?, ?, ?);

#Ajoute les dépôts
INSERT into Doc(adresse_dev, adresse_demo, projet_id) value
(?, ?, ?);

#Ajoute une US (à relancer pour chaque US)
INSERT INTO UserStory(numero, description, effort, priorite, projet_id) Value
(?, ?, ?, ?, ?);

######################Page Description accueil :########################
#Récupère le backlog du projet choisi
Select numero, description, effort, priorite from UserStory where projet_id = ?; 

######################Page Description sprint :########################
#Récupère la liste des sprints pour les afficher
Select * from sprints where projet_id = ?;

#Récupère le Backlog du sprint choisi
Select numero, description, effort, priorite from UserStory where sprint_id = ?;

#Récupère les taches du sprint choisi
Select * from taches where sprint_id = ?;

######################Page Ajout sprint :########################
#Selectionne les US qui n'ont pas encore été traitées pour ce projet
select numero, description, effort, priorite from UserStory
Where projet_id = ? and sprint_id is null;

#Insère une nouvelle tâche pour ce sprint
INSERT INTO Taches(numero, description, cout, etat, date_debut, date_fin, sprint_id, us, developpeur_id, dependances) Value
(?, ?, ?, ?, ?, ?, ?, ?, ?,  ?);

######################Page Equipe :########################
#Recherche par nom (en entrant le début du nom) d'un développeur qui n'appartient pas encore au projet actuel
Select M.id, M.login, M.mail from Membres as M
left join Developpeurs as D
ON M.id = D.membre_id
where M.login like "?%" AND M.id not in
(select membre_id from Developpeurs where projet_id = ?);

#Ajoute un développeur au projet
Insert into Developpeurs(membre_id, projet_id) Value
(?, ?);

#Supprime un développeur du projet
Delete from Developpeurs where membre_id = ? AND projet_id = ?;

#Selectionne tous les membres participants au projet
Select login, mail from Membres where id in
(Select membre_id from Developpeurs where projet_id = ?);

######################Sprint 2 :########################
#Récupère la matrice de traçabilité
Select id, numero, commit_id from UserStory where projet_id = ?;

#Enregistre le commit d'un US validée
Update UserStory
Set commit_id = ?
where id = ? and projet_id = ?;

#Ajoute un sprint
Insert into Sprints(numero, date_debut, date_fin, projet_id) Value
(?, ?, ?, ?);

#Assigne une US à un sprint
Update UserStory
Set sprint_id = ?
where id = ?;


##############Burndownchart###################
#Récupère la liste des sprints du projet
Select * from Sprints where projet_id = ?;

#Calcule les efforts réels et les efforts prévisionnels de chaque sprint
Select * from
((Select Sum(effort) from UserStory where sprint_id = ?)as effort_prevu,
(Select Sum(effort) from UserStory where sprint_id = ? and commit_id is not null)as effort_reel
);
##############################################

#Ajoute une tache
INSERT INTO Taches(numero, description, cout, etat, date_debut, date_fin, sprint_id,
us, developpeur_id, dependances) VALUE
(?, ?,?, ?, ?, ?, ? , ?, ?, ?);

#Récupère les taches d'un sprint
select * from Taches where sprint_id = ?;

#Affiche la doc d'un projet
select * from Doc where projet_id = ?;

#Modifie la doc d'un projet
Update Doc
Set adresse_dev = ?,
adresse_demo = ?, 
politique_tests = ?, 
langages_outils = ?, 
regles_depot = ?, 
regles_qualite = ?
where projet_id = ?;

#Compte le nombre de sprints du projet.
Select Count(*) from Sprints where projet_id = ?;