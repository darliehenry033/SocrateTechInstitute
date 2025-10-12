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



