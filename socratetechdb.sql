CREATE DATABASE socrate_tech_institute;
USE socrate_tech_institute;

CREATE TABLE users(
user_id INT AUTO_INCREMENT PRIMARY KEY,
email VARCHAR(100) NOT NULL,
password VARCHAR(20) NOT NULL,
role VARCHAR(30) NOT NULL,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
last_login TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE students(
student_id INT AUTO_INCREMENT PRIMARY KEY,
first_name VARCHAR(50) NOT NULL,
last_name VARCHAR(50) NOT NULL,
date_of_birth TIMESTAMP,
gender VARCHAR(20) NOT NULL,
grade_level VARCHAR(40) NOT NULL,
classroom_id INT NOT NULL,
parent_id INT NOT NULL,
enrollment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
status VARCHAR(50) NOT NULL
);

CREATE TABLE parents(
parent_id INT AUTO_INCREMENT PRIMARY KEY,
user_id INT NOT NULL,
first_name VARCHAR(100) NOT NULL,
last_name VARCHAR(100) NOT NULL,
phone VARCHAR(20) NOT NULL,
email VARCHAR(100) NOT NULL,
address VARCHAR(200) NOT NULL
);

CREATE TABLE teachers(
teacher_id INT AUTO_INCREMENT PRIMARY KEY,
user_id INT NOT NULL,
first_name VARCHAR(100) NOT NULL,
last_name VARCHAR(100) NOT NULL,
department_id INT NOT NULL,
email VARCHAR(100) NOT NULL,
phone VARCHAR(100) NOT NULL
);

CREATE TABLE subjects(
subject_id INT AUTO_INCREMENT PRIMARY KEY,
subject_name VARCHAR(200),
description VARCHAR(500),
grade_level VARCHAR(200)
);

CREATE TABLE classrooms(
classroom_id INT AUTO_INCREMENT PRIMARY KEY,
classroom_name VARCHAR(300),
description VARCHAR(500),
grade_level VARCHAR(200) NOT NULL
);

CREATE TABLE courses(
course_id INT AUTO_INCREMENT PRIMARY KEY,
subject_id INT,
classroom_id INT,
teacher_id INT,
year date,
FOREIGN KEY (subject_id) REFERENCES subjects(subject_id),
FOREIGN KEY (classroom_id) REFERENCES classrooms(classroom_id),
FOREIGN KEY (teacher_id) REFERENCES teachers(teacher_id)
);
CREATE TABLE grades(
grade_id INT AUTO_INCREMENT PRIMARY KEY,
student_id INT NOT NULL,
course_id INT NOT NULL,
term VARCHAR(50) NOT NULL,
score DECIMAL(5,2) CHECK (score >= 0 AND score <= 100),
comments VARCHAR(200),

FOREIGN KEY (student_id) REFERENCES students(student_id),
FOREIGN KEY (course_id) REFERENCES  courses(course_id)
);
 
 CREATE TABLE attendance(
 attendance_id INT AUTO_INCREMENT PRIMARY KEY,
 student_id INT NOT NULL,
 course_id INT NOT NULL,
 date DATE NOT NULL,
 status VARCHAR(50) NOT NULL,
 remarks VARCHAR(200) NOT NULL,

 FOREIGN KEY (student_id) REFERENCES students(student_id),
 FOREIGN KEY (course_id) REFERENCES courses(course_id)
 );
 
 INSERT INTO users (email, password, role) VALUES
('jeanpaul@gmail.com', 'pass123', 'parent'),
('sophie.charles@gmail.com', 'secret789', 'student'),
('mdesir@sti.edu', 'teach456', 'teacher'),
('admin@sti.edu', 'admin321', 'admin'),
('marc.martelly@sti.edu', 'teacher123', 'teacher'),
('stephanie.benoit@sti.edu', 'teacher123', 'teacher');

INSERT INTO parents (user_id, first_name, last_name, phone, email, address) VALUES
(1, 'Jean', 'Paul', '+509-3812-4455', 'jeanpaul@gmail.com', 'Carrefour, Haiti'),
(1, 'Nadine', 'Pierre', '+509-4212-3345', 'nadinep@gmail.com', 'Delmas 33, Haiti');

INSERT INTO students (first_name, last_name, date_of_birth, gender, grade_level, classroom_id, parent_id, status) VALUES
('Sophie', 'Charles', '2009-08-12', 'F', 'NS1', 1, 1, 'enrolled'),
('Samuel', 'Jean', '2010-01-05', 'M', 'NS1', 1, 1, 'enrolled'),
('Laura', 'Benoit', '2008-03-25', 'F', 'NS2', 2, 2, 'enrolled');

INSERT INTO classrooms (classroom_name, description, grade_level) VALUES
('NS1-A', 'Salle principale NS1', 'NS1'),
('NS2-B', 'Salle NS2 secondaire', 'NS2'),
('7e-A', 'Salle des élèves fondamentaux', '7e');

INSERT INTO teachers (user_id, first_name, last_name, department_id, email, phone) VALUES
(3, 'Marie', 'Desir', 1, 'mdesir@sti.edu', '+509-3456-7890'),
(5, 'Marc', 'Martelly', 2, 'marc.martelly@sti.edu', '+509-3312-9988'),
(6, 'Stephanie', 'Benoit', 1, 'stephanie.benoit@sti.edu', '+509-4412-0000');

INSERT INTO subjects (subject_name, description, grade_level) VALUES
('Mathématiques', 'Algèbre, géométrie, arithmétique', 'NS1'),
('Biologie', 'Corps humain, écosystèmes', 'NS1'),
('Français', 'Grammaire, lecture, rédaction', 'NS2'),
('Histoire', 'Histoire d\'Haïti et du monde', '7e');

INSERT INTO courses (subject_id, classroom_id, teacher_id, year) VALUES
(1, 1, 1, '2025-08-01'),
(2, 1, 1, '2025-08-01'),
(3, 2, 2, '2025-08-01'),
(4, 3, 3, '2025-08-01');

INSERT INTO grades (student_id, course_id, term, score, comments) VALUES
(1, 1, 'Trimestre 1', 85.5, 'Excellent travail'),
(2, 1, 'Trimestre 1', 78.0, 'Bonne participation'),
(1, 2, 'Trimestre 1', 92.3, 'Très bien'),
(3, 3, 'Trimestre 1', 88.7, 'Active et motivée');

INSERT INTO attendance (student_id, course_id, date, status, remarks) VALUES
(1, 1, '2025-08-20', 'Présente', '-'),
(2, 1, '2025-08-20', 'Absente', 'Justifié - maladie'),
(3, 3, '2025-08-20', 'Présente', '-'),
(1, 2, '2025-08-21', 'Présente', '-'),
(2, 2, '2025-08-21', 'Présente', '-');



USE socrate_tech_institute;
SELECT * FROM users WHERE password = 'pass123';

ALTER TABLE parents
ADD COLUMN relation VARCHAR(50);

ALTER TABLE users
ADD COLUMN username VARCHAR(100) AFTER user_id;

ALTER TABLE users
MODIFY password VARCHAR(100) NOT NULL;

SELECT * FROM users;

USE socrate_tech_institute;

CREATE TABLE admin(
admin_id INT AUTO_INCREMENT PRIMARY KEY,
admin_firstname VARCHAR(100) NOT NULL,
admin_lastname VARCHAR(100) NOT NULL,
admin_age INT NOT NULL,
admin_function VARCHAR(100)
);
ALTER TABLE admin
ADD COLUMN phone VARCHAR(100),
ADD COLUMN email VARCHAR(150);

INSERT INTO parents (user_id, first_name, last_name, phone, email, address, relation) VALUES
(1,'Jean','Paul','+509-3812-4455','jean.paul1@sti.edu','Carrefour, Haiti','father'),
(2,'Nadine','Pierre','+509-4212-3345','nadine.pierre2@sti.edu','Delmas 33, Haiti','mother'),
(3,'Wilfrid','Desir','+509-3011-2200','wilfrid.desir3@sti.edu','Pétion-Ville, Haiti','father'),
(4,'Mireille','Jean','+509-3011-2201','mireille.jean4@sti.edu','Tabarre, Haiti','mother'),
(5,'Rony','Charles','+509-3011-2202','rony.charles5@sti.edu','Léogâne, Haiti','father'),
(6,'Claudia','Benoit','+509-3011-2203','claudia.benoit6@sti.edu','Gressier, Haiti','mother'),
(7,'Patrick','Louis','+509-3011-2204','patrick.louis7@sti.edu','Carrefour, Haiti','father'),
(8,'Sandra','Marcelin','+509-3011-2205','sandra.marcelin8@sti.edu','Delmas, Haiti','mother'),
(9,'Fritz','Joseph','+509-3011-2206','fritz.joseph9@sti.edu','Croix-des-Bouquets, Haiti','father'),
(10,'Rose','Michel','+509-3011-2207','rose.michel10@sti.edu','Pétion-Ville, Haiti','mother');

INSERT INTO students
(first_name, last_name, date_of_birth, gender, grade_level, classroom_id, parent_id, enrollment_date, status) VALUES
('Sophie','Charles','2009-08-12','F','NS1',1,1,NOW(),'enrolled'),
('Samuel','Jean','2010-01-05','M','NS1',1,1,NOW(),'enrolled'),
('Laura','Benoit','2008-03-25','F','NS2',2,2,NOW(),'enrolled'),
('Kevin','Desir','2009-11-10','M','NS1',1,3,NOW(),'enrolled'),
('Nadia','Pierre','2010-06-03','F','NS2',2,4,NOW(),'enrolled'),
('Alex','Louis','2009-02-18','M','NS1',1,5,NOW(),'enrolled'),
('Mika','Marcelin','2011-09-09','F','NS2',2,6,NOW(),'enrolled'),
('Ralph','Joseph','2008-12-22','M','NS1',1,7,NOW(),'enrolled'),
('Ines','Michel','2010-04-14','F','NS2',2,8,NOW(),'enrolled'),
('Chris','Paul','2009-07-07','M','NS1',1,9,NOW(),'enrolled');
-- Keep adding rows, cycling valid classroom_id and parent_id you created in parents, until 100


INSERT INTO admin
(admin_firstname, admin_lastname, admin_age, admin_function, phone, email) VALUES
('Marie','Desir',32,'Registrar','+509-4412-0001','marie.desir@sti.edu'),
('Marc','Martelly',40,'HR','+509-4412-0002','marc.martelly@sti.edu'),
('Stephanie','Benoit',29,'Discipline','+509-4412-0003','stephanie.benoit@sti.edu'),
('Wilna','Charles',35,'Finance','+509-4412-0004','wilna.charles@sti.edu');

INSERT INTO teachers
(first_name, last_name, department_id, email, phone, user_id) VALUES
('Marie','Desir',1,'mdesir@sti.edu','+509-3456-7890',3),
('Marc','Martelly',2,'marc.martelly@sti.edu','+509-3312-9988',5),
('Stephanie','Benoit',1,'stephanie.benoit@sti.edu','+509-4412-0000',6),
('Ralph','Joseph',2,'ralph.joseph@sti.edu','+509-3011-2301',7),
('Sandra','Marcelin',1,'sandra.marcelin@sti.edu','+509-3011-2302',8),
('Fritz','Michel',2,'fritz.michel@sti.edu','+509-3011-2303',9),
('Nadia','Pierre',1,'nadia.pierre@sti.edu','+509-3011-2304',10),
('Alex','Louis',2,'alex.louis@sti.edu','+509-3011-2305',11),
('Ines','Charles',1,'ines.charles@sti.edu','+509-3011-2306',12),
('Chris','Paul',2,'chris.paul@sti.edu','+509-3011-2307',13);

USE socrate_tech_institute;

DROP TABLE IF EXISTS classrooms;

DROP TABLE subjects;

USE socrate_tech_institute;

SET FOREIGN_KEY_CHECKS = 0;

SELECT * FROM subjects;

SELECT * FROM courses;

ALTER TABLE courses
DROP COLUMN subject_id;

SELECT * FROM subjects;

SELECT * FROM subjects;
CREATE TABLE classes(
class_id INT AUTO_INCREMENT PRIMARY KEY,
class_name VARCHAR(100) NOT NULL
);
CREATE TABLE courses(
course_id INT AUTO_INCREMENT PRIMARY KEY,
course_name VARCHAR(100) NOT NULL,
coefficient TINYINT NOT NULL,
description VARCHAR(200) NOT NULL,
class_id INT,
teacher_id INT,
FOREIGN KEY(class_id) REFERENCES classes(class_id),
FOREIGN KEY(teacher_id) REFERENCES teachers(teacher_id)
);
SELECT * FROM courses;
CREATE TABLE time_slots(
time_id INT AUTO_INCREMENT PRIMARY KEY,
start_time TIME,
end_time TIME

);

CREATE TABLE days(
day_id INT AUTO_INCREMENT PRIMARY KEY,
day VARCHAR(100) NOT NULL 
);



CREATE TABLE schedule(
schedule_id INT AUTO_INCREMENT PRIMARY KEY,
day_id INT,
time_id INT,
course_id INT,
class_id INT,

FOREIGN KEY(day_id) REFERENCES days(day_id),
FOREIGN KEY(time_id) REFERENCES time_slots(time_id),
FOREIGN KEY (course_id) REFERENCES courses(course_id),
FOREIGN KEY (class_id) REFERENCES classes(class_id)
);
SELECT * FROM schedule;

INSERT INTO time_slots(start_time, end_time) VALUES
  ('08:00:00', '10:00:00'),  
  ('10:00:00', '12:00:00'), 
  ('12:00:00', '13:00:00'),  
  ('13:00:00', '15:00:00'), 
  ('15:00:00', '15:30:00'),  
  ('15:30:00', '17:00:00');  

INSERT INTO days (day) VALUES
  ('Monday'),
  ('Tuesday'),
  ('Wednesday'),
  ('Thursday'),
  ('Friday'),
  ('Saturday');

INSERT INTO classes (class_name) VALUES
  ('7e'),
  ('8e'),
  ('9e'),
  ('NS1'),
  ('NS2'),
  ('NS3'),
  ('NS4');

INSERT INTO courses (course_name, coefficient, description, class_id, teacher_id) VALUES
-- 7e (class_id = 1)
('Haitian Creole',           3, 'Reading and writing in Creole.',                     1, 1),
('French',                   3, 'Basic French grammar and vocabulary.',              1, 1),
('English',                  2, 'Simple English communication.',                     1, 3),
('Mathematics',              4, 'Arithmetic and problem solving.',                   1, 17),
('Integrated Science',       3, 'Life and physical science basics.',                 1, 18),
('Social Sciences',          2, 'History and geography of Haiti.',                   1, 2),
('Civic & Moral Education',  2, 'Values, respect and responsibilities.',             1, 2),
('Visual Arts',              1, 'Drawing and creative expression.',                  1, 3),
('Physical Education',       1, 'Fitness and team sports.',                          1, 23),
('Introduction to Computers',2, 'Keyboard, mouse and basic software.',               1, 19),

-- 8e (class_id = 2)
('Haitian Creole',           3, 'Advanced reading and writing.',                     2, 1),
('French',                   3, 'Texts, grammar and oral practice.',                2, 1),
('English',                  2, 'Everyday English expressions.',                    2, 3),
('Mathematics',              4, 'Fractions, percentages and equations.',            2, 17),
('Natural Sciences',         3, 'Biology and earth science concepts.',              2, 18),
('Social Sciences',          2, 'Caribbean history and geography.',                 2, 2),
('Civic & Citizenship',      2, 'Citizenship and community life.',                  2, 2),
('Arts & Music',             1, 'Art projects and music basics.',                   2, 3),
('Physical Education',       1, 'Games and physical skills.',                       2, 23),
('ICT Skills I',             2, 'Word processing and presentations.',               2, 19),

-- 9e (class_id = 3)
('Haitian Creole',           3, 'Analysis of Creole texts.',                        3, 1),
('French',                   3, 'Literary texts and composition.',                  3, 1),
('English',                  2, 'Short texts and conversations.',                   3, 3),
('Mathematics',              4, 'Algebra basics and geometry.',                     3, 17),
('Physics & Chemistry',      3, 'Forces, matter and simple reactions.',             3, 19),
('Biology',                  3, 'Cells, systems and environment.',                  3, 18),
('Social Sciences',          2, 'Modern history and civic issues.',                 3, 2),
('Civic & Citizenship',      2, 'Rights, duties and institutions.',                 3, 2),
('Arts & Music',             1, 'Artistic projects and music practice.',            3, 3),
('ICT Skills II',            2, 'Spreadsheets and digital organization.',           3, 19),

-- NS1 (class_id = 4)
('Haitian Creole',           2, 'Communication and analysis in Creole.',            4, 1),
('French',                   3, 'Advanced grammar and essays.',                     4, 1),
('English',                  3, 'Reading, writing and listening.',                  4, 3),
('Spanish I',                2, 'Introduction to Spanish.',                         4, 20),
('Mathematics',              4, 'Functions and algebra review.',                    4, 17),
('Physics',                  3, 'Motion, forces and energy.',                       4, 17),
('Chemistry',                3, 'Structure of matter and reactions.',               4, 19),
('Biology',                  3, 'Cells, systems and environment.',                  4, 18),
('Social Sciences',          2, 'History, geography and economics.',                4, 2),
('Introduction to Informatics',2,'Hardware, OS and file management.',               4, 19),
('Office & Internet Tools',  2, 'Office suite and email usage.',                    4, 19),
('Physical Education',       1, 'Sports and physical condition.',                   4, 23),

-- NS2 (class_id = 5)
('Haitian Creole',           2, 'Debate and written expression.',                   5, 1),
('French',                   3, 'Text analysis and argumentation.',                 5, 1),
('English',                  3, 'Intermediate English skills.',                     5, 3),
('Spanish II',               2, 'Conversation and reading in Spanish.',             5, 20),
('Mathematics',              4, 'Functions, sequences and statistics.',             5, 17),
('Physics',                  3, 'Mechanics and energy transformations.',            5, 17),
('Chemistry',                3, 'Solutions and chemical reactions.',                5, 19),
('Biology',                  3, 'Human body and ecosystems.',                       5, 18),
('Social Sciences',          2, 'Society and economic life.',                       5, 2),
('Algorithms & Programming I',3,'Programming basics and problem solving.',          5, 21),
('Web Design Basics',        2, 'HTML and CSS for simple websites.',                5, 21),
('Physical Education',       1, 'Team sports and training.',                        5, 23),

-- NS3 (class_id = 6)
('Haitian Creole',           2, 'Critical reading of Creole texts.',                6, 1),
('French',                   3, 'Literature and advanced writing.',                 6, 1),
('English',                  3, 'Fluent communication and writing.',                6, 3),
('Spanish III',              2, 'Intermediate Spanish practice.',                   6, 20),
('Advanced Mathematics',     4, 'Trigonometry and advanced algebra.',               6, 17),
('Physics',                  3, 'Electricity and wave phenomena.',                  6, 17),
('Chemistry',                3, 'Organic chemistry introduction.',                  6, 19),
('Biology',                  3, 'Genetics and evolution.',                          6, 18),
('Social Sciences',          2, 'Economics and sociology basics.',                  6, 22),
('Philosophy I',             2, 'Logic and critical thinking.',                     6, 3),
('Algorithms & Programming II',3,'Data structures and larger projects.',            6, 21),
('Database Fundamentals',    2, 'Relational databases and SQL.',                    6, 21),
('Networking Basics',        2, 'Internet, IP and local networks.',                 6, 21),
('Physical Education',       1, 'Health and fitness activities.',                   6, 23),

-- NS4 (class_id = 7)
('Haitian Creole',           2, 'Creole literature and expression.',                7, 1),
('French',                   3, 'Advanced French composition.',                     7, 1),
('English',                  3, 'Preparation for exams and real use.',              7, 3),
('Spanish IV',               2, 'Advanced Spanish communication.',                  7, 20),
('Advanced Mathematics',     4, 'Analysis and probability.',                        7, 17),
('Physics',                  3, 'Modern physics and review.',                       7, 17),
('Chemistry',                3, 'Organic and applied chemistry.',                   7, 19),
('Biology',                  3, 'Human health and environment.',                    7, 18),
('Social Sciences',          2, 'Haitian and world issues.',                        7, 22),
('Philosophy II',            2, 'Ethics and philosophy of society.',                7, 3),
('Web Development Project',  3, 'Complete website project.',                        7, 21),
('Software Development Project',3,'Small application from design to code.',         7, 21),
('Robotics & Embedded Systems',2,'Basics of electronics and microcontrollers.',     7, 21),
('Entrepreneurship & Project Management',2,'Planning and launching projects.',      7, 22),
('Physical Education',       1, 'Physical activity and wellness.',                  7, 23);


INSERT INTO schedule (day_id, time_id, course_id, class_id) VALUES
  -- Monday
  (1, 2, 3, 1), 
  (1, 4, 2, 1),  
  (1, 6, 4, 1), 

  -- Tuesday
  (2, 2, 1, 1), 
  (2, 4, 5, 1),  
  (2, 6, 6, 1),  

  -- Wednesday
  (3, 2, 3, 1),
  (3, 4, 4, 1),  
  (3, 6, 8, 1),  

  -- Thursday
  (4, 2, 2, 1),  
  (4, 4, 7, 1),  
  (4, 6, 9, 1),  

  -- Friday
  (5, 2, 1, 1),  
  (5, 4,10, 1),  
  (5, 6, 3, 1); 
  


ALTER TABLE courses
MODIFY description VARCHAR(200) NULL;

INSERT INTO courses (course_name, coefficient, description,class_id,teacher_id)
VALUES ('Break', 0, NULL,NULL,NULL);

ALTER TABLE courses
MODIFY teacher_id INT NULL;

INSERT INTO courses (course_name, coefficient, description, class_id, teacher_id)
VALUES
  ('Break',              0, 'Midday break',       NULL, NULL),
  ('Short Break',        0, 'Afternoon break',    NULL, NULL);

INSERT INTO schedule (day_id, time_id, course_id, class_id)
VALUES
  (1, 3, 85, 1),  -- Monday  break
  (2, 3, 85, 1),  -- Tuesday break
  (3, 3, 85, 1),
  (4, 3, 85, 1),
  (5, 3, 85, 1);

-- Short break, every weekday
INSERT INTO schedule (day_id, time_id, course_id, class_id)
VALUES
  (1, 5, 86, 1),  -- Monday  short break
  (2, 5, 86, 1),
  (3, 5, 86, 1),
  (4, 5, 86, 1),
  (5, 5, 86, 1);

CREATE TABLE student_parents (
    student_id INT NOT NULL,
    parent_id  INT NOT NULL,
    relation   ENUM('father','mother') NOT NULL,
    PRIMARY KEY (student_id, parent_id),
    FOREIGN KEY (student_id) REFERENCES students(student_id),
    FOREIGN KEY (parent_id)  REFERENCES parents(parent_id)
);
ALTER TABLE students
DROP classroom_id;

ALTER TABLE students
DROP parent_id;

DROP TABLE students;

ALTER TABLE students
DROP FOREIGN KEY student_id;

ALTER TABLE attendance
DROP FOREIGN KEY student_id;

DROP TABLE attendance;

ALTER TABLE students
DROP student_id;

DROP TABLE student_parents;
DROP TABLE students;
DROP TABLE parents;

CREATE TABLE gender(
gender_id INT PRIMARY KEY AUTO_INCREMENT,
gender_name VARCHAR(50)
);
CREATE TABLE relation(
relation_id INT PRIMARY KEY AUTO_INCREMENT,
relation_name VARCHAR(50) NOT NULL
);

INSERT INTO relation (relation_name)
VALUES ('Mother'), ('Father'), ('Uncle'), ('Aunt'),
       ('Grandmother'), ('Grandfather'), ('Legal Guardian');



CREATE TABLE students(
 student_id INT PRIMARY KEY AUTO_INCREMENT,
 first_name VARCHAR(150) NOT NULL,
 last_name VARCHAR(150) NOT NULL,
 date_of_birth DATE NOT NULL,
 phone VARCHAR(50) NOT NULL,
 email VARCHAR(200) NOT NULL,
 place_of_birth VARCHAR(100) NOT NULL,
 address VARCHAR(200) NOT NULL,
 age INT NOT NULL,
 gender_id INT,
 
 FOREIGN KEY (gender_id) REFERENCES gender(gender_id)

);

ALTER TABLE students
ADD user_id INT;

ALTER TABLE students
ADD FOREIGN KEY (user_id) REFERENCES users(user_id);

CREATE TABLE parents(
parent_id INT PRIMARY KEY AUTO_INCREMENT,
user_id INT,
first_name VARCHAR(150) NOT NULL,
last_name VARCHAR(150) NOT NULL,
phone VARCHAR(80) NOT NULL,
email VARCHAR(200) NOT NULL
);
ALTER TABLE parents 
ADD FOREIGN KEY (user_id) REFERENCES users(user_id);


CREATE TABLE student_parents(
student_parents_id INT PRIMARY KEY AUTO_INCREMENT,
parent_id INT,
student_id INT,
relation_id INT,

FOREIGN KEY (parent_id) REFERENCES parents(parent_id),
FOREIGN KEY (student_id) REFERENCES students(student_id),
FOREIGN KEY (relation_id) REFERENCES relation(relation_id)
);

ALTER TABLE students
ADD class_id INT;

ALTER TABLE students
ADD FOREIGN KEY (class_id) REFERENCES classes(class_id);

INSERT INTO gender (gender_id, gender_name) VALUES
(1, 'Male'),
(2, 'Female');

INSERT INTO relation (relation_id, relation_name) VALUES
(1, 'Mother'),
(2, 'Father'),
(3, 'Legal Guardian'),
(4,'Uncle'),
(5,'Aunt'),
(6,'GrandMother'),
(7,'GrandFather'),
(8,'Cousin');
INSERT INTO students
(student_id, first_name, last_name, date_of_birth, phone, email,
 place_of_birth, address, age, gender_id, user_id, class_id)
VALUES
(1, 'Sophie',  'Charles', '2012-08-12', '50931234501', 'sophie.charles@sti.ht',
 'Port-au-Prince', 'Carrefour', 13, 2, 2, 1),
(2, 'Samuel',  'Pierre',  '2012-04-03', '50931234502', 'samuel.pierre@sti.ht',
 'Cap-Haïtien', 'Delmas', 13, 1, NULL, 1),
(3, 'Laura',   'Benoit',  '2011-11-30', '50931234503', 'laura.benoit@sti.ht',
 'Jacmel', 'Pétion-Ville', 14, 2, NULL, 1),
(4, 'Kevin',   'Louis',   '2012-02-18', '50931234504', 'kevin.louis@sti.ht',
 'Gonaïves', 'Croix-des-Bouquets', 13, 1, NULL, 1),
(5, 'Ruth',    'Jean',    '2011-09-09', '50931234505', 'ruth.jean@sti.ht',
 'Léogâne', 'Carrefour', 14, 2, NULL, 1);
 
 INSERT INTO parents
(parent_id, user_id, first_name, last_name, phone, email)
VALUES
(1, NULL, 'David',   'Charles', '50936234501', 'david.charles@sti.ht'),
(2, NULL, 'Eliane',  'Charles', '50936234502', 'eliane.charles@sti.ht'),
(3, NULL, 'Jean',    'Pierre',  '50936234503', 'jean.pierre@sti.ht'),
(4, NULL, 'Marie',   'Pierre',  '50936234504', 'marie.pierre@sti.ht'),
(5, NULL, 'Michel',  'Benoit',  '50936234505', 'michel.benoit@sti.ht'),
(6, NULL, 'Claire',  'Benoit',  '50936234506', 'claire.benoit@sti.ht'),
(7, NULL, 'Paul',    'Louis',   '50936234507', 'paul.louis@sti.ht'),
(8, NULL, 'Sandra',  'Louis',   '50936234508', 'sandra.louis@sti.ht'),
(9, NULL, 'Richard', 'Jean',    '50936234509', 'richard.jean@sti.ht'),
(10,NULL, 'Nadine',  'Jean',    '50936234510', 'nadine.jean@sti.ht');

INSERT INTO student_parents
(student_parents_id, parent_id, student_id, relation_id)
VALUES
(1, 1, 1, 2),
(2, 2, 1, 1),
(3, 3, 2, 2),
(4, 4, 2, 1),
(5, 5, 3, 2),
(6, 6, 3, 1),
(7, 7, 4, 2),
(8, 8, 4, 1),
(9, 9, 5, 2),
(10,10,5, 1);
SELECT * FROM students;
SELECT * FROM parents;
SELECT * FROM student_parents;
SELECT * FROM relation;
SELECT * FROM gender;

INSERT INTO students (student_id, first_name, last_name, class_id, date_of_birth, gender_id, phone, email, place_of_birth, address, age)
VALUES
(6, 'Nadia', 'Pierre', 1, '2011-05-02', 2, '50931234506', 'nadia.pierre@sti.ht', 'Cap-Haïtien', 'Delmas', 14),
(7, 'Michael', 'Joseph', 1, '2012-01-16', 1, '50931234507', 'michael.joseph@sti.ht', 'Port-au-Prince', 'Tabarre', 13),
(8, 'Isabelle', 'Louis', 1, '2011-07-09', 2, '50931234508', 'isabelle.louis@sti.ht', 'Jacmel', 'Pétion-Ville', 14),
(9, 'James', 'Michel', 1, '2011-02-27', 1, '50931234509', 'james.michel@sti.ht', 'Gonaïves', 'Carrefour', 14),
(10, 'Naomi', 'Jean-Baptiste', 1, '2012-06-10', 2, '50931234510', 'naomi.jeanbaptiste@sti.ht', 'Saint-Marc', 'Delmas', 13),
(11, 'Patrick', 'François', 1, '2011-03-25', 1, '50931234511', 'patrick.francois@sti.ht', 'Hinche', 'Cité-Soleil', 14),
(12, 'Sophia', 'Joseph', 1, '2012-09-02', 2, '50931234512', 'sophia.joseph@sti.ht', 'Jacmel', 'Pétion-Ville', 13),
(13, 'Ethan', 'Pierre-Louis', 1, '2011-12-17', 1, '50931234513', 'ethan.pierrelouis@sti.ht', 'Les Cayes', 'Carrefour', 14),
(14, 'Grace', 'Paul', 1, '2011-08-20', 2, '50931234514', 'grace.paul@sti.ht', 'Gonaïves', 'Delmas', 14),
(15, 'Daniel', 'Louis-Charles', 1, '2012-05-29', 1, '50931234515', 'daniel.louischarles@sti.ht', 'Port-au-Prince', 'Pétion-Ville', 13),
(16, 'Mika', 'Desir', 1, '2011-01-10', 2, '50931234516', 'mika.desir@sti.ht', 'Cap-Haïtien', 'Croix-des-Bouquets', 14),
(17, 'Samuel', 'Jean-François', 1, '2012-10-15', 1, '50931234517', 'samuel.jeanfrancois@sti.ht', 'Hinche', 'Delmas', 13),
(18, 'Chloe', 'Benoit', 1, '2011-03-05', 2, '50931234518', 'chloe.benoit@sti.ht', 'Jacmel', 'Carrefour', 14),
(19, 'Nathan', 'Charles', 1, '2012-07-08', 1, '50931234519', 'nathan.charles@sti.ht', 'Port-de-Paix', 'Pétion-Ville', 13),
(20, 'Alicia', 'Paul', 1, '2011-09-22', 2, '50931234520', 'alicia.paul@sti.ht', 'Les Cayes', 'Delmas', 14),
(21, 'Leon', 'Michel', 1, '2012-02-13', 1, '50931234521', 'leon.michel@sti.ht', 'Gonaïves', 'Croix-des-Bouquets', 13),
(22, 'Julia', 'Francois', 1, '2011-12-09', 2, '50931234522', 'julia.francois@sti.ht', 'Cap-Haïtien', 'Delmas', 14),
(23, 'Anthony', 'Jean', 1, '2012-04-11', 1, '50931234523', 'anthony.jean@sti.ht', 'Saint-Marc', 'Pétion-Ville', 13),
(24, 'Victoria', 'Pierre', 1, '2011-06-18', 2, '50931234524', 'victoria.pierre@sti.ht', 'Jacmel', 'Carrefour', 14),
(25, 'Ryan', 'Joseph', 1, '2011-10-04', 1, '50931234525', 'ryan.joseph@sti.ht', 'Hinche', 'Delmas', 14),
(26, 'Ella', 'Louis', 1, '2012-08-28', 2, '50931234526', 'ella.louis@sti.ht', 'Port-au-Prince', 'Croix-des-Bouquets', 13),
(27, 'Gabriel', 'Paul', 1, '2011-05-14', 1, '50931234527', 'gabriel.paul@sti.ht', 'Les Cayes', 'Carrefour', 14),
(28, 'Luna', 'Benoit', 1, '2012-03-07', 2, '50931234528', 'luna.benoit@sti.ht', 'Jacmel', 'Delmas', 13),
(29, 'Marcus', 'Louis', 1, '2011-11-19', 1, '50931234529', 'marcus.louis@sti.ht', 'Cap-Haïtien', 'Tabarre', 14),
(30, 'Clara', 'Jean-Pierre', 1, '2012-09-09', 2, '50931234530', 'clara.jeanpierre@sti.ht', 'Port-au-Prince', 'Delmas', 13);

INSERT INTO parents (parent_id, first_name, last_name, phone, email)
VALUES
(11, 'Pierre', 'Pierre', '50936234511', 'pierre.pierre@sti.ht'),
(12, 'Nadia', 'Pierre', '50936234512', 'nadia.pierre@sti.ht'),
(13, 'Joseph', 'Joseph', '50936234513', 'joseph.joseph@sti.ht'),
(14, 'Marie', 'Joseph', '50936234514', 'marie.joseph@sti.ht'),
(15, 'Louis', 'Louis', '50936234515', 'louis.louis@sti.ht'),
(16, 'Sophie', 'Louis', '50936234516', 'sophie.louis@sti.ht'),
(17, 'Michel', 'Michel', '50936234517', 'michel.michel@sti.ht'),
(18, 'Laura', 'Michel', '50936234518', 'laura.michel@sti.ht'),
(19, 'Jean-Baptiste', 'Jean-Baptiste', '50936234519', 'jeanbaptiste.jeanbaptiste@sti.ht'),
(20, 'Naomi', 'Jean-Baptiste', '50936234520', 'naomi.jeanbaptiste@sti.ht'),
(21, 'François', 'François', '50936234521', 'francois.francois@sti.ht'),
(22, 'Patricia', 'François', '50936234522', 'patricia.francois@sti.ht'),
(23, 'Pierre-Louis', 'Pierre-Louis', '50936234523', 'pierre.louis@sti.ht'),
(24, 'Claire', 'Pierre-Louis', '50936234524', 'claire.pierrelouis@sti.ht'),
(25, 'Paul', 'Paul', '50936234525', 'paul.paul@sti.ht'),
(26, 'Grace', 'Paul', '50936234526', 'grace.paul@sti.ht'),
(27, 'Louis-Charles', 'Louis-Charles', '50936234527', 'louischarles.louischarles@sti.ht'),
(28, 'Daniel', 'Louis-Charles', '50936234528', 'daniel.louischarles@sti.ht'),
(29, 'Desir', 'Desir', '50936234529', 'desir.desir@sti.ht'),
(30, 'Mika', 'Desir', '50936234530', 'mika.desir@sti.ht'),
(31, 'Jean-François', 'Jean-François', '50936234531', 'jeanfrancois.jeanfrancois@sti.ht'),
(32, 'Samuel', 'Jean-François', '50936234532', 'samuel.jeanfrancois@sti.ht'),
(33, 'Benoit', 'Benoit', '50936234533', 'benoit.benoit@sti.ht'),
(34, 'Chloe', 'Benoit', '50936234534', 'chloe.benoit@sti.ht'),
(35, 'Charles', 'Charles', '50936234535', 'charles.charles@sti.ht'),
(36, 'Nathan', 'Charles', '50936234536', 'nathan.charles@sti.ht'),
(37, 'Paul', 'Paul', '50936234537', 'paul2.paul@sti.ht'),
(38, 'Alicia', 'Paul', '50936234538', 'alicia.paul@sti.ht'),
(39, 'Michel', 'Michel', '50936234539', 'michel2.michel@sti.ht'),
(40, 'Leon', 'Michel', '50936234540', 'leon.michel@sti.ht');


INSERT INTO student_parents (student_id, parent_id)
VALUES
(6, 11), (6, 12),
(7, 13), (7, 14),
(8, 15), (8, 16),
(9, 17), (9, 18),
(10, 19), (10, 20),
(11, 21), (11, 22),
(12, 23), (12, 24),
(13, 25), (13, 26),
(14, 27), (14, 28),
(15, 29), (15, 30),
(16, 31), (16, 32),
(17, 33), (17, 34),
(18, 35), (18, 36),
(19, 37), (19, 38),
(20, 39), (20, 40),
(21, 7),  (21, 8),
(22, 9),  (22, 10),
(23, 1),  (23, 2),
(24, 3),  (24, 4),
(25, 5),  (25, 6),
(26, 7),  (26, 8),
(27, 9),  (27, 10),
(28, 1),  (28, 2),
(29, 3),  (29, 4),
(30, 5),  (30, 6);

USE socrate_tech_institute;

ALTER TABLE courses
ADD COLUMN course_code VARCHAR(20);

UPDATE courses 
SET course_code = CONCAT(UPPER(SUBSTRING(course_name,1,3)), course_id)
WHERE course_id = LAST_INSERT_ID();

INSERT INTO courses (course_name, coefficient, description, class_id, teacher_id)
VALUES ('Biology I', 3, 'Fundamentals…', 1, 2);

DELIMITER $$

CREATE TRIGGER trg_generate_course_code
AFTER INSERT ON courses
FOR EACH ROW
BEGIN
    UPDATE courses
    SET course_code = CONCAT(
        UPPER(SUBSTRING(NEW.course_name, 1, 3)),
        NEW.course_id
    )
    WHERE course_id = NEW.course_id;
END $$

DELIMITER ;
INSERT INTO courses (course_name, coefficient, description, class_id, teacher_id)
VALUES ('Biology I', 3, 'Fundamentals…', 1, 2);


SELECT * FROM classes;
SELECT * FROM teachers;

INSERT INTO courses (course_name, coefficient, description, class_id, teacher_id)
VALUES (
  'Biology I',
  3,
  'Fundamentals of living organisms: cell structure, human biology, and ecology.',
  1,  -- must exist in classes
  1   -- must exist in teachers
);

DROP TABLE IF EXISTS classes;

SHOW CREATE TABLE courses;

ALTER TABLE courses
DROP FOREIGN KEY courses_ibfk_1;

ALTER TABLE courses
DROP FOREIGN KEY courses_ibfk_2;

SELECT 
    TABLE_NAME,
    COLUMN_NAME,
    CONSTRAINT_NAME
FROM information_schema.KEY_COLUMN_USAGE
WHERE 
    TABLE_SCHEMA = 'socrate_tech_institute'
    AND REFERENCED_TABLE_NAME = 'courses';

ALTER TABLE schedule
DROP FOREIGN KEY schedule_ibfk_3;

DROP TABLE courses;

INSERT INTO courses (course_name, coefficient, description,class_id,teacher_id)
VALUES ('Break', 0, NULL,NULL,NULL);

CREATE TABLE courses (
  course_id    INT PRIMARY KEY AUTO_INCREMENT,
  course_name  VARCHAR(150) NOT NULL,
  coefficient  TINYINT      NOT NULL,
  description  VARCHAR(150) NOT NULL,
  class_id     INT,
  teacher_id   INT,
  course_code  VARCHAR(20),          -- normal column, can be NULL at insert

  FOREIGN KEY (class_id)   REFERENCES classes(class_id),
  FOREIGN KEY (teacher_id) REFERENCES teachers(teacher_id)
);
INSERT INTO courses (course_name, coefficient, description, class_id, teacher_id)
VALUES
('Haitian Creole', 3, 'Reading and writing in Haitian Creole.', 1, 1),
('French', 3, 'Basic French grammar and vocabulary.', 1, 2),
('English', 2, 'Simple English communication.', 1, 3),
('Mathematics', 4, 'Arithmetic and problem-solving.', 1, 4),
('Integrated Science', 3, 'Life and physical science basics.', 1, 5),
('Social Sciences', 2, 'Haitian history and geography.', 1, 6),
('Civic & Moral Education', 2, 'Values, respect, and citizenship.', 1, 7),
('Visual Arts', 1, 'Drawing and creative expression.', 1, 8),
('Physical Education', 1, 'Games, sports, physical fitness.', 1, 9),
('ICT Skills I', 2, 'Keyboard, mouse, and basic computer software training.', 1, 10);

INSERT INTO courses (course_name, coefficient, description, class_id, teacher_id)
VALUES
('Haitian Creole',      3, 'Reading and writing in Haitian Creole.',           1, 1),
('French',              3, 'Basic French grammar and vocabulary.',             1, 2),
('English',             2, 'Simple English communication.',                    1, 3),
('Mathematics',         4, 'Arithmetic and problem-solving.',                  1, 14),
('Integrated Science',  3, 'Life and physical science basics.',                1, 15),
('Social Sciences',     2, 'Haitian history and geography.',                   1, 16),
('Civic Education',     2, 'Values, respect, and citizenship.',                1, 17),
('Visual Arts',         1, 'Drawing and creative expression.',                 1, 18),
('Physical Education',  1, 'Games, sports, physical fitness.',                 1, 19),
('ICT Skills I',        2, 'Keyboard, mouse, and basic computer skills.',      1, 20);




 SET SQL_SAFE_UPDATES = 0;
 UPDATE courses
SET course_code = CONCAT(UPPER(SUBSTRING(course_name, 1, 3)), course_id)
WHERE course_code IS NULL OR course_code = '';

INSERT INTO courses (course_name, coefficient, description, class_id, teacher_id)
VALUES
('Biology', 3, 'Introduction to biological systems, cells, and ecosystems.', 4, 1),
('Chemistry', 3, 'Basic chemistry principles, reactions, and laboratory safety.', 4, 2),
('Physics', 3, 'Motion, energy, waves, and fundamental physics concepts.', 4, 3),
('Geography', 2, 'World geography, maps, climates, and global regions.', 3, 4),
('History of Haiti', 2, 'Important events, figures, and cultural development of Haiti.', 3, 5),
('World History', 3, 'Historical events from ancient to modern civilizations.', 3, 6),
('Algebra II', 4, 'Advanced algebraic expressions, equations, and graphs.', 4, 7),
('Geometry', 4, 'Shapes, proofs, angles, and spatial reasoning.', 4, 8),
('Statistics', 3, 'Data analysis, probability, interpretation, and real applications.', 4, 9),
('Philosophy', 2, 'Introduction to logic, ethics, and philosophical thought.', 5, 10),
('Sociology', 2, 'Study of society, culture, and social behavior.', 5, 11),
('Economics', 3, 'Microeconomics and macroeconomics fundamentals.', 5, 12),
('Business Management', 3, 'Leadership, entrepreneurship, and business operations.', 5, 1),
('Programming I', 4, 'Introduction to algorithms, logic, and basic programming.', 6, 2),
('Programming II', 4, 'Object-oriented programming and data structures concepts.', 6, 3),
('Computer Networking', 3, 'Basics of computer networks, protocols, and configurations.', 6, 4),
('Database Systems', 3, 'SQL queries, database design, and relational models.', 6, 5),
('Web Development', 3, 'HTML, CSS, JavaScript basics, and website creation.', 6, 6),
('Digital Literacy', 1, 'Computer basics, typing, and safe internet usage.', 1, 7),
('Music Education', 1, 'Introduction to rhythm, instruments, and music theory.', 1, 8);


INSERT INTO courses (course_name, coefficient, description, class_id, teacher_id)
VALUES
('Biology',            3, 'Introduction to biological systems, cells, and ecosystems.',                                  4, 14),
('Chemistry',          3, 'Basic chemistry principles, reactions, and laboratory safety.',                               4, 15),
('Physics',            3, 'Motion, energy, waves, and fundamental physics concepts.',                                    4, 16),
('Geography',          2, 'World geography, maps, climates, and global regions.',                                        3, 17),
('History of Haiti',   2, 'Important events, figures, and cultural development of Haiti.',                               3, 18),
('World History',      3, 'Historical events from ancient to modern civilizations.',                                     3, 19),
('Algebra II',         4, 'Advanced algebraic expressions, equations, and graphs.',                                      4, 20),
('Geometry',           4, 'Shapes, proofs, angles, and spatial reasoning.',                                             4, 21),
('Statistics',         3, 'Data analysis, probability, interpretation, and real applications.',                          4, 22),
('Philosophy',         2, 'Introduction to logic, ethics, and philosophical thought.',                                   5, 23),
('Sociology',          2, 'Study of society, culture, and social behavior.',                                             5, 14),
('Economics',          3, 'Microeconomics and macroeconomics fundamentals.',                                             5, 15),
('Business Management',3, 'Leadership, entrepreneurship, and business operations.',                                      5, 16),
('Programming I',      4, 'Introduction to algorithms, logic, and basic programming.',                                   6, 17),
('Programming II',     4, 'Object-oriented programming and data structures concepts.',                                   6, 18),
('Computer Networking',3, 'Basics of computer networks, protocols, and configurations.',                                 6, 19),
('Database Systems',   3, 'SQL queries, database design, and relational models.',                                        6, 20),
('Web Development',    3, 'HTML, CSS, JavaScript basics, and website creation.',                                         6, 21),
('Digital Literacy',   1, 'Computer basics, typing, and safe internet usage.',                                           1, 22),
('Music Education',    1, 'Introduction to rhythm, instruments, and music theory.',                                      1, 23);

UPDATE courses
SET course_code = CONCAT(UPPER(SUBSTRING(course_name, 1, 3)), course_id)
WHERE course_code IS NULL OR course_code = '';



  
  INSERT INTO courses (course_name, coefficient, description, class_id, teacher_id)
VALUES
  ('Vocabulary', 1, 'Learning and practicing new words in context.', 1, 17),
  ('Stylistic', 1, 'Introduction to writing style, tone, and sentence structure.', 1, 18),
  ('Reading', 1, 'Reading short texts and developing comprehension skills.', 1, 19);

INSERT INTO schedule (class_id, day_id, time_id, course_id)
VALUES
  -- Friday 10:00 - 12:00 : Vocabulary
  (1, 5, 2,
    (SELECT course_id FROM courses
     WHERE course_name = 'Vocabulary'
       AND class_id = 1
     LIMIT 1)
  ),

  -- Friday 13:00 - 15:00 : Stylistic
  (1, 5, 4,
    (SELECT course_id FROM courses
     WHERE course_name = 'Stylistic'
       AND class_id = 1
     LIMIT 1)
  ),

  -- Friday 15:30 - 17:00 : Reading
  (1, 5, 6,
    (SELECT course_id FROM courses
     WHERE course_name = 'Reading'
       AND class_id = 1
     LIMIT 1)
  );
  UPDATE courses
SET course_code = CONCAT(UPPER(SUBSTRING(course_name, 1, 3)), course_id)
WHERE (course_code IS NULL OR course_code = '')
  AND course_id > 0;

ALTER TABLE classes
ADD COLUMN classroom INT;

ALTER TABLE classes
ADD COLUMN start_academic_year INT;

ALTER TABLE classes
ADD COLUMN end_academic_year INT;

ALTER TABLE classes
ADD COLUMN capacity INT,
ADD CONSTRAINT check_capacity CHECK(capacity < 100);

UPDATE classes SET 
    classroom = 701,
    start_academic_year = 2025,
    end_academic_year = 2026,
    capacity = 62
WHERE class_name = '7e';

UPDATE classes SET 
    classroom = 801,
    start_academic_year = 2025,
    end_academic_year = 2026,
    capacity = 65
WHERE class_name = '8e';

UPDATE classes SET 
    classroom = 901,
    start_academic_year = 2025,
    end_academic_year = 2026,
    capacity = 68
WHERE class_name = '9e';

UPDATE classes SET 
    classroom = 1001,
    start_academic_year = 2025,
    end_academic_year = 2026,
    capacity = 72
WHERE class_name = 'NS1';

UPDATE classes SET 
    classroom = 1100,
    start_academic_year = 2025,
    end_academic_year = 2026,
    capacity = 75
WHERE class_name = 'NS2';

UPDATE classes SET 
    classroom = 1200,
    start_academic_year = 2025,
    end_academic_year = 2026,
    capacity = 80
WHERE class_name = 'NS3';

UPDATE classes SET 
    classroom = 1300,
    start_academic_year = 2025,
    end_academic_year = 2026,
    capacity = 85
WHERE class_name = 'NS4';

CREATE TABLE majors (
    major_id   INT PRIMARY KEY AUTO_INCREMENT,
    major_name VARCHAR(100) NOT NULL,
    description VARCHAR(255) NULL
);
INSERT INTO majors (major_name, description) VALUES
('Mathematics & Science', 'Math, physics, chemistry, and general science teaching.'),
('Humanities & Languages', 'French, English, Creole, history, philosophy, and literature.'),
('Social Sciences', 'Geography, sociology, civic education, and social studies.'),
('Economics & Management', 'Economics, business, management, and entrepreneurship.'),
('Computer Science & ICT', 'Programming, databases, networking, and ICT skills.'),
('Arts & Music', 'Visual arts, creative expression, and music.'),
('Physical Education & Sports', 'Physical education, training, and school sports.');

ALTER TABLE teachers
  ADD COLUMN degree VARCHAR(150) AFTER last_name,
  ADD COLUMN experience VARCHAR(300) AFTER degree,
  ADD COLUMN major_id INT AFTER department_id;

ALTER TABLE teachers
  ADD CONSTRAINT fk_teachers_major
  FOREIGN KEY (major_id) REFERENCES majors(major_id);
  -- Example: Marie Desir – Mathematics & Science
UPDATE teachers
SET 
  degree = 'BSc in Mathematics and Physics',
  experience = 'Over 8 years teaching mathematics and physics with a focus on problem solving and clear explanations.',
  major_id = 1  -- Mathematics & Science
WHERE teacher_id = 1;

-- Marc Martelly – Social Sciences
UPDATE teachers
SET 
  degree = 'BA in Social Sciences',
  experience = 'Experienced in history, geography, and social studies, helping students connect lessons to real life.',
  major_id = 3  -- Social Sciences
WHERE teacher_id = 2;

-- Stéphanie Benoit – Humanities & Languages
UPDATE teachers
SET 
  degree = 'MA in French Language and Literature',
  experience = 'Specialized in French grammar and writing, guiding students to communicate clearly and confidently.',
  major_id = 2  -- Humanities & Languages
WHERE teacher_id = 3;

-- Ralph Joseph – Computer Science & ICT
UPDATE teachers
SET
  degree = 'BSc in Computer Science',
  experience = 'Teaches ICT and programming, introducing students to modern tools, coding, and digital skills.',
  major_id = 5  -- Computer Science & ICT
WHERE teacher_id = 17;

CREATE TABLE tutors(
tutor_id INT PRIMARY KEY AUTO_INCREMENT,
teacher_id INT,
major_id INT,
class_id INT,

FOREIGN KEY (teacher_id) REFERENCES teachers(teacher_id),
FOREIGN KEY (major_id) REFERENCES majors(major_id),
FOREIGN KEY (class_id) REFERENCES classes(class_id)

);
INSERT INTO courses (course_name, coefficient, description, class_id, teacher_id)
VALUES
('Biology',            3, 'Introduction to biological systems, cells, and ecosystems.',                                  4, 14),
('Chemistry',          3, 'Basic chemistry principles, reactions, and laboratory safety.',                               4, 15),
('Physics',            3, 'Motion, energy, waves, and fundamental physics concepts.',                                    4, 16),
('Geography',          2, 'World geography, maps, climates, and global regions.',                                        3, 17),
('History of Haiti',   2, 'Important events, figures, and cultural development of Haiti.',                               3, 18),
('World History',      3, 'Historical events from ancient to modern civilizations.',                                     3, 19),
('Algebra II',         4, 'Advanced algebraic expressions, equations, and graphs.',                                      4, 20),
('Geometry',           4, 'Shapes, proofs, angles, and spatial reasoning.',                                             4, 21),
('Statistics',         3, 'Data analysis, probability, interpretation, and real applications.',                          4, 22),
('Philosophy',         2, 'Introduction to logic, ethics, and philosophical thought.',                                   5, 23),
('Sociology',          2, 'Study of society, culture, and social behavior.',                                             5, 14),
('Economics',          3, 'Microeconomics and macroeconomics fundamentals.',                                             5, 15),
('Business Management',3, 'Leadership, entrepreneurship, and business operations.',                                      5, 16),
('Programming I',      4, 'Introduction to algorithms, logic, and basic programming.',                                   6, 17),
('Programming II',     4, 'Object-oriented programming and data structures concepts.',                                   6, 18),
('Computer Networking',3, 'Basics of computer networks, protocols, and configurations.',                                 6, 19),
('Database Systems',   3, 'SQL queries, database design, and relational models.',                                        6, 20),
('Web Development',    3, 'HTML, CSS, JavaScript basics, and website creation.',                                         6, 21),
('Digital Literacy',   1, 'Computer basics, typing, and safe internet usage.',                                           1, 22),
('Music Education',    1, 'Introduction to rhythm, instruments, and music theory.',                                      1, 23);

UPDATE courses
SET course_code = CONCAT(UPPER(SUBSTRING(course_name, 1, 3)), course_id)
WHERE course_code IS NULL OR course_code = '';



SELECT 
CONCAT(teachers.first_name,' ',teachers.last_name) AS teacher_fullname,
teachers.email,
teachers.degree,
teachers.phone,
teachers.experience,
classes.class_name,
major_name
FROM tutors
INNER JOIN teachers ON teachers.teacher_id = tutors.teacher_id
INNER JOIN majors ON majors.major_id = tutors.major_id
INNER JOIN classes ON classes.class_id = tutors.class_id;
 
ALTER TABLE students
    DROP COLUMN age;

ALTER TABLE students
    ADD COLUMN date_of_birth DATE AFTER class_id;

ALTER TABLE students
ADD COLUMN age INT AS (TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE())) VIRTUAL;
ALTER TABLE students
ADD COLUMN age INT AS (TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()));


ALTER TABLE students
ADD COLUMN date_of_birth DATE AFTER class_id;


ALTER TABLE students
ADD COLUMN age INT AFTER date_of_birth;

DELIMITER //

CREATE TRIGGER trg_students_before_insert
BEFORE INSERT ON students
FOR EACH ROW
BEGIN
  IF NEW.date_of_birth IS NOT NULL THEN
    SET NEW.age = TIMESTAMPDIFF(YEAR, NEW.date_of_birth, CURDATE());
  ELSE
    SET NEW.age = NULL;
  END IF;
END//

DELIMITER ;
DELIMITER //

CREATE TRIGGER trg_students_before_update
BEFORE UPDATE ON students
FOR EACH ROW
BEGIN
  IF NEW.date_of_birth IS NOT NULL THEN
    SET NEW.age = TIMESTAMPDIFF(YEAR, NEW.date_of_birth, CURDATE());
  ELSE
    SET NEW.age = NULL;
  END IF;
END//

DELIMITER ;


CREATE TABLE modern(
modern_id INT PRIMARY KEY AUTO_INCREMENT,
modern_course_name VARCHAR(200)
);

CREATE TABLE application (
  application_id INT PRIMARY KEY AUTO_INCREMENT,
  photo_passport VARCHAR(255) NOT NULL,
  last_name      VARCHAR(100) NOT NULL,
  first_name     VARCHAR(100) NOT NULL,
  date_of_birth  DATE NOT NULL,
  sex            CHAR(10) NOT NULL,
  birthplace     VARCHAR(100) NOT NULL,
  phone          VARCHAR(80) NOT NULL,
  email          VARCHAR(200) NOT NULL,
  address        VARCHAR(255) NOT NULL,
  last_class     CHAR(20) NOT NULL,
  modern_id      INT,
    FOREIGN KEY (modern_id) REFERENCES modern(modern_id)
);

CREATE TABLE quiz(
quiz_id INT AUTO_INCREMENT PRIMARY KEY,
application_id INT,
start_time DATETIME NOT NULL,
end_time DATETIME NOT NULL,
correct_questions INT NOT NULL,
incorrect_questions INT NOT NULL,
score INT NOT NULL
);

CREATE TABLE final_admission_decision(
final_admission_decision_id INT AUTO_INCREMENT PRIMARY KEY,
quiz_id INT NOT NULL,
application_id INT NOT NULL,

FOREIGN KEY (quiz_id) REFERENCES quiz(quiz_id),
FOREIGN KEY (application_id) REFERENCES application(application_id)

);

CREATE TABLE question_answers(
question_id INT PRIMARY KEY AUTO_INCREMENT,
question_category varchar(150) not null,
class_id INT,
question_text varchar(255),
optionA varchar(255),
optionB varchar(255),
optionC varchar(255),
optionD varchar(255),
correct_answer char(10)
);
SELECT DATABASE();
SHOW TABLES;


SELECT DATABASE();  

USE socrate_tech_institute;

ALTER TABLE application
  ADD COLUMN application_code VARCHAR(20) UNIQUE,
  ADD COLUMN photo_path       VARCHAR(255),
  ADD COLUMN birth_act_path   VARCHAR(255),
  ADD COLUMN transcripts_paths TEXT;


ALTER TABLE application
  ADD COLUMN IF NOT EXISTS last_school       VARCHAR(255) NULL,
  ADD COLUMN IF NOT EXISTS modern_courses    VARCHAR(255) NULL,
  ADD COLUMN IF NOT EXISTS birth_act_path    VARCHAR(255) NULL,
  ADD COLUMN IF NOT EXISTS transcripts_paths TEXT NULL,
  ADD COLUMN IF NOT EXISTS application_code  VARCHAR(50) NULL;

USE socrate_tech_institute;

ALTER TABLE application
  ADD COLUMN last_school     VARCHAR(255) AFTER address,
  ADD COLUMN modern_courses  VARCHAR(100) AFTER last_class;
ALTER TABLE application
  DROP COLUMN photo_passport;

USE socrate_tech_institute;

CREATE TABLE quiz_user_answers(
 quiz_user_answers_id INT AUTO_INCREMENT PRIMARY KEY,
 quiz_id INT NOT NULL,
 question_id INT NOT NULL,
 is_correct TINYINT, -- 0(INCORRECT) OR 1(CORRECT)
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 
 FOREIGN KEY (quiz_id) REFERENCES quiz(quiz_id),
 FOREIGN KEY (question_id) REFERENCES question_answers(question_id)
);

ALTER TABLE question_answers
DROP COLUMN question_category;

CREATE TABLE quiz_question_category(
category_id INT AUTO_INCREMENT PRIMARY KEY,
category_name VARCHAR(180) NOT NULL
);
ALTER TABLE question_answers
ADD category_id INT;

ALTER TABLE question_answers
ADD CONSTRAINT fk_question_category
FOREIGN KEY (category_id)
REFERENCES quiz_question_category(category_id);

ALTER TABLE question_answers
ADD category_id INT AFTER class_id;



SELECT DATABASE();

SELECT * FROM question_answers;

ALTER TABLE question_answers
ADD COLUMN category_id INT;

DROP TABLE question_answers;

ALTER TABLE question_answers
DROP class_id;


DROP TABLE question_answers;
ALTER TABLE question_answers
DROP category_id;
DROP TABLE question_answers;

ALTER TABLE question_answers
DROP question_id;

DROP TABLE quiz_user_answers;
DROP TABLE question_answers;

CREATE TABLE question_answers (
  question_id INT AUTO_INCREMENT PRIMARY KEY,
  class_id INT NOT NULL,
  category_id INT NOT NULL,
  question_text VARCHAR(255) NOT NULL,
  optionA VARCHAR(255) NOT NULL,
  optionB VARCHAR(255) NOT NULL,
  optionC VARCHAR(255) NOT NULL,
  optionD VARCHAR(255) NOT NULL,
  FOREIGN KEY (class_id) REFERENCES classes(class_id),
  FOREIGN KEY (category_id) REFERENCES quiz_question_category(category_id)
);

CREATE TABLE quiz_user_answers(
quiz_user_answers_id INT AUTO_INCREMENT PRIMARY KEY,
quiz_id INT NOT NULL,
question_id INT NOT NULL,
is_correct TINYINT NOT NULL,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

FOREIGN KEY (quiz_id) REFERENCES quiz(quiz_id),
FOREIGN KEY (question_id) REFERENCES question_answers(question_id)
);

INSERT INTO quiz_question_category (category_name)
VALUES
('Mathematics'),
('IT'),
('Science'),
('General Knowledge');

INSERT INTO question_answers (class_id, category_id, question_text, optionA, optionB, optionC, optionD)
VALUES
(7, 1, 'What is 6 × 7?', '42', '36', '48', '56'),
(7, 1, 'What is 15 + 9?', '20', '24', '30', '22'),
(7, 1, 'What is 81 ÷ 9?', '7', '8', '9', '10'),
(7, 1, 'Which number is prime?', '21', '15', '17', '25'),
(7, 1, 'What is 12 × 5?', '50', '55', '60', '65');

INSERT INTO question_answers (class_id, category_id, question_text, optionA, optionB, optionC, optionD)
VALUES
(7, 2, 'What does CPU stand for?', 'Central Process Unit', 'Central Processing Unit', 'Compute Power Utility', 'Control Processing User'),
(7, 2, 'Which device stores data permanently?', 'RAM', 'SSD or HDD', 'Cache', 'CPU'),
(7, 2, 'What is the role of an operating system?', 'Manage hardware and software', 'Print documents', 'Store electricity', 'Control WiFi'),
(7, 2, 'Which one is a programming language?', 'HTML', 'CSS', 'Python', 'USB'),
(7, 2, 'What does URL stand for?', 'User Random Link', 'Uniform Resource Locator', 'Universal Router Line', 'Unified Record Layer');

INSERT INTO question_answers (class_id, category_id, question_text, optionA, optionB, optionC, optionD)
VALUES
(7, 3, 'What is the boiling point of water?', '50°C', '80°C', '100°C', '120°C'),
(7, 3, 'Which planet is closest to the Sun?', 'Earth', 'Mars', 'Mercury', 'Venus'),
(7, 3, 'Which gas do plants release?', 'CO2', 'Nitrogen', 'Oxygen', 'Helium'),
(7, 3, 'Humans mainly breathe in which gas?', 'Hydrogen', 'Oxygen', 'Helium', 'Methane'),
(7, 3, 'What is H2O?', 'Salt', 'Water', 'Oxygen', 'Hydrogen');

INSERT INTO question_answers (class_id, category_id, question_text, optionA, optionB, optionC, optionD)
VALUES
(7, 4, 'Which country has the Eiffel Tower?', 'Italy', 'Germany', 'France', 'Spain'),
(7, 4, 'How many continents are there?', '5', '6', '7', '8'),
(7, 4, 'Which is the largest ocean?', 'Atlantic', 'Indian', 'Pacific', 'Arctic'),
(7, 4, 'What is the emergency number in the USA?', '411', '119', '911', '811'),
(7, 4, 'Which animal is called King of the Jungle?', 'Tiger', 'Lion', 'Elephant', 'Leopard');

INSERT INTO question_answers (class_id, category_id, question_text, optionA, optionB, optionC, optionD) VALUES
-- Math (cat 1)
(1, 1, 'What is 5 + 7?', '10', '11', '12', '13'),
(1, 1, 'What is 9 − 4?', '3', '4', '5', '6'),
(1, 1, 'What is 6 × 3?', '9', '12', '18', '21'),

-- IT (cat 2)
(1, 2, 'Which device is used to move the cursor?', 'Keyboard', 'Mouse', 'Speaker', 'Printer'),
(1, 2, 'Which of these is a computer?', 'Table', 'Laptop', 'Chair', 'Window'),
(1, 2, 'Which part shows the output?', 'Mouse', 'Monitor', 'Keyboard', 'USB'),

-- Science (cat 3)
(1, 3, 'Which one is a liquid at room temperature?', 'Ice', 'Water', 'Steam', 'Stone'),
(1, 3, 'Which sense organ helps us see?', 'Nose', 'Eyes', 'Ears', 'Tongue'),
(1, 3, 'Which animal can fly?', 'Dog', 'Cat', 'Bird', 'Fish'),

-- General Knowledge (cat 4)
(1, 4, 'What day comes after Monday?', 'Friday', 'Tuesday', 'Sunday', 'Thursday'),
(1, 4, 'Which color is the sky on a clear day?', 'Green', 'Blue', 'Red', 'Yellow'),
(1, 4, 'How many legs does a human have?', '1', '2', '3', '4');


INSERT INTO question_answers (class_id, category_id, question_text, optionA, optionB, optionC, optionD) VALUES
-- Math
(2, 1, 'What is 15 + 9?', '22', '23', '24', '25'),
(2, 1, 'What is 40 − 18?', '18', '20', '22', '24'),
(2, 1, 'What is 8 × 7?', '48', '54', '56', '64'),

-- IT
(2, 2, 'Which one is an input device?', 'Monitor', 'Mouse', 'Projector', 'Speaker'),
(2, 2, 'Which file extension is used for pictures?', '.txt', '.jpg', '.doc', '.pdf'),
(2, 2, 'Which key deletes the character on the left?', 'Enter', 'Shift', 'Backspace', 'Tab'),

-- Science
(2, 3, 'Water freezes at what temperature?', '-10°C', '0°C', '10°C', '100°C'),
(2, 3, 'Which gas do we breathe in mainly?', 'Carbon dioxide', 'Oxygen', 'Helium', 'Chlorine'),
(2, 3, 'Which part of the plant is usually green?', 'Root', 'Stem', 'Leaf', 'Fruit'),

-- General Knowledge
(2, 4, 'How many days are in a week?', '5', '6', '7', '8'),
(2, 4, 'Which of these is a continent?', 'Asia', 'Paris', 'Nile', 'Madrid'),
(2, 4, 'Which language is mainly spoken in Haiti?', 'Spanish', 'French', 'Creole', 'English');

INSERT INTO question_answers (class_id, category_id, question_text, optionA, optionB, optionC, optionD) VALUES
-- Math
(3, 1, 'What is 5²?', '5', '10', '20', '25'),
(3, 1, 'What is 9 × 6?', '45', '48', '52', '54'),
(3, 1, 'What is the value of 100 ÷ 4?', '20', '25', '30', '35'),

-- IT
(3, 2, 'Binary numbers use which digits?', '0 and 1', '1 and 2', '2 and 3', '8 and 9'),
(3, 2, 'Which one is NOT an input device?', 'Keyboard', 'Scanner', 'Monitor', 'Mouse'),
(3, 2, 'What does CPU stand for?', 'Central Process Unit', 'Central Processing Unit', 'Computer Personal Unit', 'Central Printed Unit'),

-- Science
(3, 3, 'Which part of the cell contains DNA?', 'Cell wall', 'Nucleus', 'Cytoplasm', 'Membrane'),
(3, 3, 'Which energy source is renewable?', 'Coal', 'Oil', 'Solar', 'Gas'),
(3, 3, 'What is the chemical symbol for water?', 'O₂', 'H₂', 'H₂O', 'CO₂'),

-- General Knowledge
(3, 4, 'Which ocean is the largest?', 'Atlantic', 'Indian', 'Pacific', 'Arctic'),
(3, 4, 'Which city is the capital of France?', 'Madrid', 'Rome', 'Paris', 'Berlin'),
(3, 4, 'Which instrument has black and white keys?', 'Guitar', 'Piano', 'Drum', 'Flute');

INSERT INTO question_answers (class_id, category_id, question_text, optionA, optionB, optionC, optionD) VALUES
-- Math
(4, 1, 'Solve: 2x + 5 = 15. What is x?', '3', '4', '5', '10'),
(4, 1, 'What is the value of 3(4 + 2)?', '12', '14', '16', '18'),
(4, 1, 'What is the slope of the line y = 2x + 3?', '1', '2', '3', '4'),
(4, 1, 'What is 30% of 200?', '40', '50', '60', '70'),

-- IT
(4, 2, 'Which language is used to structure web pages?', 'CSS', 'HTML', 'Python', 'SQL'),
(4, 2, 'Which storage is fastest?', 'Hard disk', 'SSD', 'DVD', 'Floppy disk'),
(4, 2, 'What does RAM stand for?', 'Random Access Memory', 'Read Any Memory', 'Ready Access Memory', 'Real Active Memory'),
(4, 2, 'Which protocol is used to browse web pages?', 'FTP', 'HTTP', 'SMTP', 'SSH'),

-- Science
(4, 3, 'Which particle has a negative charge?', 'Proton', 'Neutron', 'Electron', 'Photon'),
(4, 3, 'What is the main gas in Earth’s atmosphere?', 'Oxygen', 'Nitrogen', 'Carbon dioxide', 'Hydrogen'),
(4, 3, 'Which organ pumps blood in the human body?', 'Lungs', 'Kidney', 'Heart', 'Liver'),

-- General Knowledge
(4, 4, 'Which country is in the Caribbean?', 'Germany', 'Haiti', 'China', 'Italy'),
(4, 4, 'The Great Wall is in which country?', 'Japan', 'Korea', 'China', 'India'),
(4, 4, 'Which sport is played with a round ball and feet?', 'Basketball', 'Tennis', 'Football', 'Volleyball');

INSERT INTO question_answers (class_id, category_id, question_text, optionA, optionB, optionC, optionD) VALUES
-- Math
(5, 1, 'Solve: 4x − 8 = 0. What is x?', '1', '2', '4', '8'),
(5, 1, 'What is √169?', '11', '12', '13', '14'),
(5, 1, 'What is (2x)(3x)?', '5x', '5x²', '6x', '6x²'),
(5, 1, 'Convert 0.75 to a fraction.', '1/2', '3/4', '2/3', '4/5'),

-- IT
(5, 2, 'Which database language is most common?', 'CSS', 'HTML', 'SQL', 'C++'),
(5, 2, 'Which one is an operating system?', 'Chrome', 'Windows', 'Facebook', 'YouTube'),
(5, 2, 'Which device connects a network to the internet?', 'Switch', 'Mouse', 'Router', 'Speaker'),
(5, 2, 'What does URL stand for?', 'Uniform Resource Locator', 'Universal Record Link', 'User Route Line', 'Unified Reference Locator'),

-- Science
(5, 3, 'Which law explains action and reaction?', 'Newton’s first law', 'Newton’s second law', 'Newton’s third law', 'Law of gravity'),
(5, 3, 'What is the unit of electric current?', 'Volt', 'Watt', 'Ampere', 'Ohm'),
(5, 3, 'Which organ is responsible for filtering blood?', 'Heart', 'Kidney', 'Liver', 'Lungs'),

-- General Knowledge
(5, 4, 'Who wrote “Romeo and Juliet”?', 'Charles Dickens', 'William Shakespeare', 'Victor Hugo', 'Mark Twain'),
(5, 4, 'Which country is famous for the pyramids?', 'Greece', 'Egypt', 'Brazil', 'Canada'),
(5, 4, 'Which currency is used in the USA?', 'Euro', 'Pound', 'Dollar', 'Yen');

INSERT INTO question_answers (class_id, category_id, question_text, optionA, optionB, optionC, optionD) VALUES
-- Math
(6, 1, 'What is the solution of x² = 49?', '±5', '±6', '±7', '±8'),
(6, 1, 'Simplify: (x² · x³).', 'x⁵', 'x⁴', 'x³', 'x²'),
(6, 1, 'What is the value of sin(90°)?', '0', '1', '−1', '0.5'),
(6, 1, 'Solve: 3x + 2 = 14.', '2', '3', '4', '5'),

-- IT
(6, 2, 'Which language runs in the browser?', 'C', 'C++', 'JavaScript', 'Java'),
(6, 2, 'Which command is used to list files in Linux?', 'ls', 'cd', 'rm', 'mv'),
(6, 2, 'Which data structure uses FIFO?', 'Stack', 'Queue', 'Tree', 'Graph'),
(6, 2, 'Which protocol is secure for web?', 'HTTP', 'FTP', 'HTTPS', 'Telnet'),

-- Science
(6, 3, 'Which scientist proposed the theory of relativity?', 'Newton', 'Einstein', 'Darwin', 'Tesla'),
(6, 3, 'Which wave does not need a medium?', 'Sound wave', 'Water wave', 'Light wave', 'Seismic wave'),
(6, 3, 'What is the pH of neutral water?', '0', '5', '7', '10'),

-- General Knowledge
(6, 4, 'Which organization is abbreviated as UN?', 'United Nations', 'United Nations Bank', 'Union of Nations', 'Universal Network'),
(6, 4, 'Which city is called “Big Apple”?', 'Los Angeles', 'New York', 'Chicago', 'Miami'),
(6, 4, 'Which country hosted the 2016 Olympic Games?', 'China', 'Brazil', 'UK', 'Japan');

INSERT INTO question_answers (class_id, category_id, question_text, optionA, optionB, optionC, optionD) VALUES
-- Math
(7, 1, 'What are the roots of x² − 9 = 0?', '±2', '±3', '±4', '±5'),
(7, 1, 'Evaluate the determinant of [[1,2],[3,4]].', '−2', '−1', '1', '2'),
(7, 1, 'What is the derivative of x³?', 'x²', '2x²', '3x²', '3x'),
(7, 1, 'Compute: ∫ 2x dx.', 'x² + C', 'x²/2 + C', '2x² + C', 'x + C'),

-- IT
(7, 2, 'Which paradigm does Java support?', 'Functional only', 'Object-oriented', 'Procedural only', 'None'),
(7, 2, 'Which database type is MySQL?', 'NoSQL', 'Graph DB', 'Relational', 'In-memory only'),
(7, 2, 'Which HTTP method is commonly used to submit forms?', 'GET', 'POST', 'DELETE', 'PATCH'),
(7, 2, 'Which one is a version control system?', 'MySQL', 'Git', 'Apache', 'Nginx'),

-- Science
(7, 3, 'Which bond shares electron pairs?', 'Ionic bond', 'Covalent bond', 'Metallic bond', 'Hydrogen bond'),
(7, 3, 'Which organelle produces energy (ATP) in the cell?', 'Nucleus', 'Ribosome', 'Mitochondrion', 'Golgi body'),
(7, 3, 'Which law relates pressure and volume of a gas?', 'Ohm’s law', 'Boyle’s law', 'Hooke’s law', 'Kepler’s law'),

-- General Knowledge
(7, 4, 'Who is known as the “Father of Computers”?', 'Albert Einstein', 'Isaac Newton', 'Charles Babbage', 'Alan Turing'),
(7, 4, 'Which continent is the Sahara Desert in?', 'Asia', 'Africa', 'Australia', 'Europe'),
(7, 4, 'Which document begins with “We the People…”?', 'Universal Declaration of Human Rights', 'US Constitution', 'Magna Carta', 'UN Charter');

USE socrate_tech_institute;

ALTER TABLE question_answers 
ADD COLUMN correct_answer CHAR(1) NOT NULL DEFAULT 'A' 
AFTER optionD;


UPDATE question_answers SET correct_answer = 'A' WHERE question_id = 1;

UPDATE question_answers SET correct_answer = 'B' WHERE question_id = 2;

CREATE TABLE IF NOT EXISTS quiz_results (
  result_id INT(11) NOT NULL AUTO_INCREMENT,
  application_id INT(11) NOT NULL,
  score INT(11) NOT NULL CHECK (score BETWEEN 0 AND 100),
  status VARCHAR(50) NOT NULL,
  completed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (result_id),
  UNIQUE KEY unique_application_result (application_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



SELECT 
    question_id,
    CONCAT('Q', question_id, ': ', LEFT(question_text, 50), '...') as question,
    CONCAT('A: ', optionA) as optionA,
    CONCAT('B: ', optionB) as optionB,
    CONCAT('C: ', optionC) as optionC,
    CONCAT('D: ', optionD) as optionD,
    correct_answer as current_answer
FROM question_answers
WHERE class_id = 7  -- Change to your class
ORDER BY category_id, question_id;

UPDATE question_answers SET correct_answer = 'A' WHERE question_id = 1;  -- What is 6 x 7? = 42
UPDATE question_answers SET correct_answer = 'B' WHERE question_id = 2;  -- What is 15 + 9? = 24
UPDATE question_answers SET correct_answer = 'B' WHERE question_id = 3;  -- What is 81 ÷ 9? = 9
UPDATE question_answers SET correct_answer = 'B' WHERE question_id = 4;  -- Which number is prime? = 21


SELECT 
    question_id,
    LEFT(question_text, 40) as question,
    correct_answer,
    CASE 
        WHEN correct_answer = 'A' THEN optionA
        WHEN correct_answer = 'B' THEN optionB
        WHEN correct_answer = 'C' THEN optionC
        WHEN correct_answer = 'D' THEN optionD
    END as correct_option_text
FROM question_answers
WHERE class_id = 7
ORDER BY question_id;


SELECT COUNT(*) as questions_with_default_A
FROM question_answers
WHERE correct_answer = 'A' AND class_id = 7;




