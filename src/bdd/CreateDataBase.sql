drop database if exists MYP;

create database if not exists MYP;

use MYP;

ALTER SCHEMA `MYP`  DEFAULT CHARACTER SET utf8 ;

#Contient la liste des membres du site
CREATE TABLE IF NOT EXISTS Membres
(id int unsigned not null auto_increment primary key,
login varchar(250),
mdp varchar(250),
mail varchar(250)
);

#Contient la liste des projets stockés sur le site. flag_Prive = 0 si le projet est public, 1 si il est privé. flag_Fin = 0 si le projet est en cours, 1 si il est fini
CREATE TABLE IF NOT EXISTS Projets
(id int unsigned not null auto_increment primary key,
nom varchar(250),
description varchar(1024),
temps_jours int,
flag_Prive int,
flag_Etat int
);


#Contient la liste des sprints d'un projet
CREATE TABLE IF NOT EXISTS Sprints
(id int unsigned not null auto_increment primary key,
numero int,
date_debut date,
date_fin date,
projet_id int unsigned not null,
FOREIGN KEY (projet_id) REFERENCES Projets(id) ON DELETE cascade
);

#Contient la liste des users stories d'un projet
CREATE TABLE IF NOT EXISTS UserStory
(id int unsigned not null auto_increment primary key,
numero int,
description varchar(1024),
effort int,
priorite int,
projet_id int unsigned not null,
FOREIGN KEY (projet_id) REFERENCES Projets(id) ON DELETE cascade,
commit_id varchar(512), 
sprint_id int unsigned,
sprint_id_retard int unsigned, 
#Va servir à empécher de valider une tache si elle n'est pas finie quand tous les sprints sont terminés
bloque int,
FOREIGN KEY (sprint_id) REFERENCES Sprints(id) ON DELETE cascade,
FOREIGN KEY (sprint_id_retard) REFERENCES Sprints(id) ON DELETE cascade
);

#Contient la liste des développeurs d'un projet sous forme d'id
CREATE TABLE IF NOT EXISTS Developpeurs
(id int unsigned not null auto_increment primary key,
membre_id int unsigned not null,
foreign key (membre_id) REFERENCES Membres(id) ON DELETE cascade,
projet_id int unsigned not null, 
foreign key (projet_id) REFERENCES Projets(id) ON DELETE cascade
);

#Contient la liste des taches d'un sprint. US est un varchar à cause du ALL
CREATE TABLE IF NOT EXISTS Taches
(id int unsigned not null auto_increment primary key,
numero int,
description varchar(1024),
cout float,
etat int,
date_debut date,
date_fin date,
debut_tot date,
fin_tard date,
sprint_id int unsigned not null,
us varchar(10),
developpeur_id int unsigned not null,
dependances varchar(10),
FOREIGN KEY (sprint_id) REFERENCES Sprints(id) ON DELETE cascade,
FOREIGN KEY (developpeur_id) REFERENCES Developpeurs(id) ON DELETE cascade
);

#Contient la documentation d'un projet
CREATE TABLE IF NOT EXISTS Doc
(id int unsigned not null auto_increment primary key,
adresse_dev varchar(250),
adresse_demo varchar(250),
politique_tests varchar(2048),
langages_outils varchar(2048),
regles_depot varchar(2048),
regles_qualite varchar(2048),
projet_id int unsigned not null,
FOREIGN KEY (projet_id) REFERENCES Projets(id) ON DELETE cascade
);

#Contient la liste des logs afin de repérer les dernières modifications
CREATE TABLE IF NOT EXISTS Log
(id int unsigned not null auto_increment primary key,
membre_id int unsigned not null,
element_modif varchar(512),
date_modif datetime,
projet_id int unsigned not null,
FOREIGN KEY (membre_id) REFERENCES Membres(id) ON DELETE cascade,
FOREIGN KEY (projet_id) REFERENCES Projets(id) ON DELETE cascade
);