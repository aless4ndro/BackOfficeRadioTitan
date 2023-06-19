CREATE TABLE membres
(
    id int(11) NOT NULL AUTO_INCREMENT,
    pseudo varchar(255) NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table podcast
(
    id int NOT NULL AUTO_INCREMENT,
    title varchar(255) NOT NULL,
    file_path varchar(255) NOT NULL,
    rubrique VARCHAR(255),
    emission VARCHAR(255),
    intervue TEXT,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table albums
(
    id int NOT NULL AUTO_INCREMENT,
    title varchar(255) NOT NULL,
    file_path varchar(255) NOT NULL,
    date DATETIME,
    description varchar(255),
    code_color varchar(255),
    img_illustration varchar(255),
    PRIMARY KEY (file_path)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table categorie
(
    id_categorie INT PRIMARY KEY,
    nom_categorie VARCHAR(255) NOT NULL
    title varchar(255) NOT NULL,
    date DATETIME,
    description varchar(255),
    code_color varchar(255),
    img_illustration varchar(255),
    PRIMARY KEY (id_categorie)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table video
(
    id int NOT NULL AUTO_INCREMENT,
    fichier_video varchar(255) NOT NULL,
    titre varchar(255) NOT NULL,
    description varchar(255) NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



insert into membres (pseudo) values ('Aless');
insert into membres (pseudo) values ('Benoit');

create TABLE articles
(
    id int(11) NOT NULL AUTO_INCREMENT,
    titre varchar(255) NOT NULL,
    contenu text NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

alter table categorie add id int(11) NOT NULL AUTO_INCREMENT;
alter table membres add email varchar(255) NOT NULL;
alter table membres add pass varchar(255) NOT NULL;
alter table membres add p varchar(255);
alter table membres drop role;
alter table membres add date_inscription datetime NOT NULL;

ALTER TABLE membres ADD COLUMN role ENUM('admin', 'contributeur', 'user') NOT NULL;


ALTER TABLE membres
DROP COLUMN comfirmation_pass;



create table articles
(
    id int(11) NOT NULL AUTO_INCREMENT,
    titre varchar(255) NOT NULL,
    contenu text NOT NULL,
    id int(11) NOT NULL AUTO_INCREMENT,
    id_categorie int(11),
    PRIMARY KEY (id),
    FOREIGN KEY (id_categorie) REFERENCES categorie(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table albums
(
    id int(11) NOT NULL AUTO_INCREMENT,
    title varchar(255) NOT NULL,
    file_path varchar(255) NOT NULL,
    date DATETIME,
    description varchar(255),
    code_color varchar(255),
    img_illustration varchar(255),
    id_categorie int(11),
    PRIMARY KEY (id),
    FOREIGN KEY (id_categorie) REFERENCES categorie(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table video
(
    fichier_video varchar(255) NOT NULL,
    titre varchar(255) NOT NULL,
    description varchar(255) NOT NULL,
    id_categorie int(11),
    PRIMARY KEY (fichier_video),
    FOREIGN KEY (id_categorie) REFERENCES categorie(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




ALTER TABLE articles
ADD COLUMN id_categorie INT;


ALTER TABLE articles
ADD FOREIGN KEY (id_categorie) REFERENCES categories(id_categorie);
