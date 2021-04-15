CREATE TABLE `Vartotojai` (
	`El_pastas` varchar(255) NOT NULL,
	`Slaptazodis` varchar(64) NOT NULL,
	`Vardas` varchar(255) NOT NULL,
	`Pavarde` varchar(255) NOT NULL,
	`Vartotojo_id` INT NOT NULL,
	PRIMARY KEY (`Vartotojo_id`)
);

CREATE TABLE `Projektai` (
	`Projekto_id` INT NOT NULL,
	`Pavadinimas` varchar(255) NOT NULL,
	`Aprasymas` TEXT NOT NULL,
	`Busena` varchar(255) NOT NULL,
	`Sukurimo_data` DATE NOT NULL,
	PRIMARY KEY (`Projekto_id`)
);

CREATE TABLE `Uzduotys` (
	`Uzduoties_id` INT NOT NULL,
	`Pavadinimas` varchar(255) NOT NULL,
	`Aprasymas` varchar(255) NOT NULL,
	`Prioritetas` varchar(255) NOT NULL,
	`Busena` varchar(255) NOT NULL,
	`Sukurimo_data` DATE NOT NULL,
	`Naujinimo_data` DATE NOT NULL,
	PRIMARY KEY (`Uzduoties_id`)
);

CREATE TABLE `Projektu_uzduotys` (
	`Projekto_id` INT NOT NULL,
	`Uzduoties_id` INT NOT NULL
);

CREATE TABLE `Komandos` (
	`Projekto_id` INT NOT NULL,
	`Role` INT NOT NULL,
	`Vartotojas` INT NOT NULL
);

CREATE TABLE `Roles` (
	`Roles_id` INT NOT NULL,
	`Pavadinimas` varchar(255) NOT NULL,
	`Aprasymas` varchar(255) NOT NULL,
	PRIMARY KEY (`Roles_id`)
);

ALTER TABLE `Projektu_uzduotys` ADD CONSTRAINT `Projektu_uzduotys_fk0` FOREIGN KEY (`Projekto_id`) REFERENCES `Projektai`(`Projekto_id`);

ALTER TABLE `Projektu_uzduotys` ADD CONSTRAINT `Projektu_uzduotys_fk1` FOREIGN KEY (`Uzduoties_id`) REFERENCES `Uzduotys`(`Uzduoties_id`);

ALTER TABLE `Komandos` ADD CONSTRAINT `Komandos_fk0` FOREIGN KEY (`Projekto_id`) REFERENCES `Projektai`(`Projekto_id`);

ALTER TABLE `Komandos` ADD CONSTRAINT `Komandos_fk1` FOREIGN KEY (`Role`) REFERENCES `Roles`(`Roles_id`);

ALTER TABLE `Komandos` ADD CONSTRAINT `Komandos_fk2` FOREIGN KEY (`Vartotojas`) REFERENCES `Vartotojai`(`Vartotojo_id`);

