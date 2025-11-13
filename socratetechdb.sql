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


