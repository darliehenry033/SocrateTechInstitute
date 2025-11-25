<?php
session_start();
require_once 'database.php';
require_once 'partials/functions.php';
require_once 'partials/header.php';

/* --------------------------FLAGS & MESSAGES--------------------------------*/
$courseAdded     = false;
$courseEdited    = false;
$courseDeleted   = false;
$courseError     = '';

$studentAdded    = false;
$studentEdited   = false;
$studentDeleted  = false;
$studentError    = '';

$userEdited      = false;
$userDeleted     = false;
$userError       = '';

$successMessage  = '';

if (!function_exists('h')) {
    function h($v){
        return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('getAllRows')) {
    function getAllRows($connect, $sql){
        $res = mysqli_query($connect, $sql);
        return $res ? mysqli_fetch_all($res, MYSQLI_ASSOC) : [];
    }
}

function renderCoursesRows(mysqli $connect, int $classId): void {
    $sql = "
        SELECT 
            c.course_id,
            c.course_code,
            c.course_name,
            c.coefficient,
            c.description,
            c.class_id,
            CONCAT(t.last_name, ' ', t.first_name) AS teacher_fullname
        FROM courses c
        INNER JOIN teachers t ON c.teacher_id = t.teacher_id
        WHERE c.class_id = ?
        ORDER BY c.course_id ASC
    ";
    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $classId);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);

    if (!$res || mysqli_num_rows($res) === 0) {
        echo '<tr><td colspan="6">No courses for this class yet.</td></tr>';
        return;
    }

    while ($row = mysqli_fetch_assoc($res)) {
        ?>
        <tr>
            <td><?= h($row['course_code']) ?></td>
            <td><?= h($row['course_name']) ?></td>
            <td><?= h($row['teacher_fullname']) ?></td>
            <td><?= h($row['coefficient']) ?></td>
            <td><?= h($row['description']) ?></td>
            <td>
                <div class="button-container">
                    <button 
                        class="edit edit-course-btn"
                        data-course-id="<?= (int)$row['course_id'] ?>"
                        data-course-name="<?= h($row['course_name']) ?>"
                        data-course-coef="<?= (int)$row['coefficient'] ?>"
                        data-course-desc="<?= h($row['description']) ?>"
                        data-class-id="<?= (int)$row['class_id'] ?>"
                    >
                        <i class="fa-solid fa-pen"></i>
                    </button>
                    <button 
                        class="delete delete-course-btn"
                        data-course-id="<?= (int)$row['course_id'] ?>"
                        data-course-name="<?= h($row['course_name']) ?>"
                    >
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </div>
            </td>
        </tr>
        <?php
    }
}

function renderScheduleTable(mysqli $connect, string $className): void {
    $sql = "
        SELECT 
            d.day        AS day_name,
            t.time_id    AS time_id,
            t.start_time AS start_time,
            t.end_time   AS end_time,
            c.course_name AS course_name
        FROM days d
        CROSS JOIN time_slots t
        LEFT JOIN schedule s
            ON s.day_id  = d.day_id
            AND s.time_id = t.time_id
        LEFT JOIN classes cl
            ON cl.class_id = s.class_id
            AND cl.class_name = ?
        LEFT JOIN courses c
            ON c.course_id = s.course_id
        ORDER BY t.start_time, d.day_id
    ";
    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, 's', $className);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $days       = [];
    $timeLabels = [];
    $timeMeta   = [];
    $map        = [];

    if ($result) {
        while ($r = mysqli_fetch_assoc($result)) {
            $day    = $r['day_name'];
            $timeId = $r['time_id'];

            $startShort = substr($r['start_time'], 0, 5);
            $endShort   = substr($r['end_time'],   0, 5);
            $label      = $startShort . ' - ' . $endShort;

            if (!in_array($day, $days, true)) {
                $days[] = $day;
            }

            if (!isset($timeLabels[$timeId])) {
                $timeLabels[$timeId] = $label;
                $timeMeta[$timeId]   = [
                    'start' => $startShort,
                    'end'   => $endShort,
                ];
            }

            if (!empty($r['course_name'])) {
                $map[$timeId][$day] = $r['course_name'];
            }
        }
    }
    ?>
    <table>
        <thead>
            <tr>
                <th>Time</th>
                <?php foreach ($days as $dayName): ?>
                    <th><?= h($dayName) ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
        <?php if (empty($timeLabels)): ?>
            <tr>
                <td colspan="<?= count($days) + 1 ?>">No schedule data</td>
            </tr>
        <?php else: ?>
            <?php foreach ($timeLabels as $timeId => $label): ?>
                <tr>
                    <td><?= h($label) ?></td>
                    <?php
                        $start = $timeMeta[$timeId]['start'];
                        $end   = $timeMeta[$timeId]['end'];
                    ?>
                    <?php foreach ($days as $dayName): ?>
                        <?php
                            $value     = $map[$timeId][$dayName] ?? '';
                            $cellClass = '';

                            if ($value === '') {
                                if ($start === '08:00' && $end === '10:00') {
                                    $value     = 'Flag / Exercises';
                                    $cellClass = 'schedule-flag';
                                } elseif ($start === '12:00' && $end === '13:00') {
                                    $value     = 'Break';
                                    $cellClass = 'schedule-break';
                                } elseif ($start === '15:00' && $end === '15:30') {
                                    $value     = 'Break';
                                    $cellClass = 'schedule-break';
                                }
                            }
                        ?>
                        <td class="<?= h($cellClass) ?>"><?= h($value) ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
    <?php
}

function renderStudentsTable(mysqli $connect, int $classId): void {
  $sql = "
      SELECT
          s.student_id,
          s.first_name,
          s.last_name,
          s.class_id,
          s.gender_id,
          c.class_name AS grade_level,
          s.date_of_birth,
          g.gender_name,
          s.phone,
          s.email,
          s.place_of_birth,
          s.address,
          TIMESTAMPDIFF(YEAR, s.date_of_birth, CURDATE()) AS age
      FROM students s
      INNER JOIN classes c 
          ON c.class_id = s.class_id
      INNER JOIN gender g 
          ON g.gender_id = s.gender_id
      WHERE s.class_id = ?
      ORDER BY s.student_id
  ";

  $stmt = mysqli_prepare($connect, $sql);
  mysqli_stmt_bind_param($stmt, 'i', $classId);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  if (!$result || mysqli_num_rows($result) === 0) {
      echo '<p>No students registered yet for this class.</p>';
      return;
  }

  echo '<table class="courses-table students-table">';
  echo '<thead>
          <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Grade</th>
            <th>Age</th>
            <th>Gender</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Place of Birth</th>
            <th>Address</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>';

  while ($row = mysqli_fetch_assoc($result)) {
      $fullName = $row['first_name'] . ' ' . $row['last_name'];
      $age      = $row['age'] ?? '';
      $dob      = $row['date_of_birth'] ?? '';

      echo '<tr>';
      echo '<td>' . (int)$row['student_id'] . '</td>';
      echo '<td>' . h($fullName) . '</td>';
      echo '<td>' . h($row['grade_level']) . '</td>';
      echo '<td>' . h($age) . '</td>';
      echo '<td>' . h($row['gender_name']) . '</td>';
      echo '<td>' . h($row['phone']) . '</td>';
      echo '<td>' . h($row['email']) . '</td>';
      echo '<td>' . h($row['place_of_birth']) . '</td>';
      echo '<td>' . h($row['address']) . '</td>';

      echo '<td>
              <div class="button-container">
                <button
                  class="edit edit-student-btn"
                  data-student-id="' . (int)$row['student_id'] . '"
                  data-student-fname="' . h($row['first_name']) . '"
                  data-student-lname="' . h($row['last_name']) . '"
                  data-student-email="' . h($row['email']) . '"
                  data-student-phone="' . h($row['phone']) . '"
                  data-student-class-id="' . (int)$row['class_id'] . '"
                  data-student-gender-id="' . (int)$row['gender_id'] . '"
                  data-student-dob="' . h($dob) . '"
                  data-student-place="' . h($row['place_of_birth']) . '"
                  data-student-address="' . h($row['address']) . '"
                  data-student-age="' . h($age) . '"
                >
                  <i class="fa-solid fa-pen"></i>
                </button>

                <button
                  class="delete delete-student-btn"
                  data-student-id="' . (int)$row['student_id'] . '"
                  data-student-name="' . h($fullName) . '"
                >
                  <i class="fa-solid fa-trash"></i>
                </button>
              </div>
            </td>';

      echo '</tr>';
  }

  echo '</tbody></table>';
}



function renderGenericClassBasicInfo(mysqli $connect, int $classId): void {
    $sql = "
        SELECT class_name, classroom, start_academic_year, end_academic_year, capacity
        FROM classes
        WHERE class_id = ?
        LIMIT 1
    ";
    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $classId);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $row = $res ? mysqli_fetch_assoc($res) : null;

    if (!$row) {
        echo "<p>No information for this class yet.</p>";
        return;
    }

    $className = $row['class_name'];
    $room      = $row['classroom'] ?: 'TBD';
    $startY    = $row['start_academic_year'] ?: 'TBD';
    $endY      = $row['end_academic_year'] ?: 'TBD';
    $capacity  = $row['capacity'] ?: 'TBD';

    $classIdValue = $classId;

    $sqlCount = "
        SELECT
          (SELECT COUNT(*) FROM students WHERE class_id = ?) AS nb_students,
          (SELECT COUNT(DISTINCT teacher_id) FROM courses WHERE class_id = ?) AS nb_teachers,
          (SELECT COUNT(*) FROM courses WHERE class_id = ?) AS nb_courses
    ";
    $stmt2 = mysqli_prepare($connect, $sqlCount);
    mysqli_stmt_bind_param($stmt2, 'iii', $classIdValue, $classIdValue, $classIdValue);
    mysqli_stmt_execute($stmt2);
    $counts = mysqli_stmt_get_result($stmt2);
    $countsRow = $counts ? mysqli_fetch_assoc($counts) : ['nb_students'=>0,'nb_teachers'=>0,'nb_courses'=>0];

    ?>
    <div class="basic-info-container">
      <div class="basic-info">
        <span><?= h($className) ?></span>
        <h2>Academic Year: <?= h($startY) ?> - <?= h($endY) ?></h2>
        <h2>Classroom #: <?= h($room) ?></h2>
        <h2>Capacity: <?= h($capacity) ?></h2>
        <h2>Number of Students: <?= (int)$countsRow['nb_students'] ?></h2>
        <h2>Number of Teachers: <?= (int)$countsRow['nb_teachers'] ?></h2>
        <h2>Number of Courses: <?= (int)$countsRow['nb_courses'] ?></h2>
      </div>
      <div class="tutor-info">
        <div class="tutor-info-left">
          <img src="images/default-tutor.png" alt="">
        </div>
        <div class="tutor-info-right">
          <h2>Class Tutor</h2>
          <h4>To be assigned</h4>
          <p><strong>Email:</strong> <a href="#">tutor@sti.edu.ht</a></p>
          <p><strong>Phone:</strong> <a href="#">+509 0000 0000</a></p>
          <p>This placeholder uses your database for class information. Once you configure the
          <code>tutors</code> table you can replace it with a dynamic tutor card.</p>
        </div>
      </div>
    </div>
    <?php
}

/* ---------------------POST ACTIONS---------------------------------- */

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_course'])) {
    $course_name = trim($_POST['course_name'] ?? '');
    $coefficient = (int)($_POST['coefficient'] ?? 0);
    $description = trim($_POST['description'] ?? '');
    $class_id    = (int)($_POST['class_id'] ?? 0);
    $teacher_id  = (int)($_POST['teacher_id'] ?? 0);

    if ($course_name === '' || $coefficient <= 0 || $class_id <= 0 || $teacher_id <= 0) {
        $courseError = "Please fill all course fields correctly.";
    } else {
        $sql = "INSERT INTO courses (course_name, coefficient, description, class_id, teacher_id)
                VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($connect, $sql);
        mysqli_stmt_bind_param($stmt, 'sisii', $course_name, $coefficient, $description, $class_id, $teacher_id);

        if (mysqli_stmt_execute($stmt)) {
            $course_id   = mysqli_insert_id($connect);
            $course_code = strtoupper(substr($course_name, 0, 3)) . $course_id;

            $sql2  = "UPDATE courses SET course_code = ? WHERE course_id = ?";
            $stmt2 = mysqli_prepare($connect, $sql2);
            mysqli_stmt_bind_param($stmt2, 'si', $course_code, $course_id);
            mysqli_stmt_execute($stmt2);

            $courseAdded     = true;
            $successMessage  = "The course has been added successfully.";
        } else {
            $courseError = "Database error while adding course.";
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_course'])) {
    $course_id   = (int)($_POST['course_id'] ?? 0);
    $course_name = trim($_POST['course_name'] ?? '');
    $coefficient = (int)($_POST['coefficient'] ?? 0);
    $description = trim($_POST['description'] ?? '');
    $class_id    = (int)($_POST['class_id'] ?? 0);
    $teacher_id  = (int)($_POST['teacher_id'] ?? 0);

    if ($course_id <= 0 || $course_name === '' || $coefficient <= 0 || $class_id <= 0 || $teacher_id <= 0) {
        $courseError = "Please fill all course fields correctly.";
    } else {
        $sql = "UPDATE courses
                SET course_name = ?, coefficient = ?, description = ?, class_id = ?, teacher_id = ?
                WHERE course_id = ?";
        $stmt = mysqli_prepare($connect, $sql);
        mysqli_stmt_bind_param(
            $stmt,
            'sisiii',
            $course_name,
            $coefficient,
            $description,
            $class_id,
            $teacher_id,
            $course_id
        );

        if (mysqli_stmt_execute($stmt)) {
            $courseEdited    = true;
            $successMessage  = "The course has been updated successfully.";

            $course_code = strtoupper(substr($course_name, 0, 3)) . $course_id;
            $stmt2 = mysqli_prepare($connect, "UPDATE courses SET course_code = ? WHERE course_id = ?");
            mysqli_stmt_bind_param($stmt2, 'si', $course_code, $course_id);
            mysqli_stmt_execute($stmt2);
        } else {
            $courseError = "Database error while updating course.";
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_course'])) {
    $course_id = (int)($_POST['course_id'] ?? 0);
    if ($course_id > 0) {
        $stmt = mysqli_prepare($connect, "DELETE FROM courses WHERE course_id = ?");
        mysqli_stmt_bind_param($stmt, 'i', $course_id);
        if (mysqli_stmt_execute($stmt)) {
            $courseDeleted   = true;
            $successMessage  = "The course has been deleted successfully.";
        } else {
            $courseError = "Database error while deleting course.";
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_student'])) {

  $first_name        = trim($_POST['first_name'] ?? '');
  $last_name         = trim($_POST['last_name'] ?? '');
  $class_id          = (int)($_POST['class_id'] ?? 0);
  $gender_id         = (int)($_POST['gender_id'] ?? 0);
  $phone             = trim($_POST['phone'] ?? '');
  $email             = trim($_POST['email'] ?? '');
  $place_of_birth    = trim($_POST['place_of_birth'] ?? '');
  $address           = trim($_POST['address'] ?? '');
  $date_of_birth_raw = trim($_POST['date_of_birth'] ?? '');

  if ($date_of_birth_raw === '' || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date_of_birth_raw)) {
      $date_of_birth = null;
  } else {
      $date_of_birth = $date_of_birth_raw;
  }

  if ($first_name === '' || $last_name === '' || $class_id <= 0 || $gender_id <= 0) {
      $studentError = "Please fill all required fields for the student.";
  } else {

      $sql = "
          INSERT INTO students 
              (first_name, last_name, class_id, date_of_birth, gender_id, phone, email, place_of_birth, address)
          VALUES 
              (?, ?, ?, ?, ?, ?, ?, ?, ?)
      ";
      $stmt = mysqli_prepare($connect, $sql);
      mysqli_stmt_bind_param(
          $stmt,
          'ssisissss',
          $first_name,
          $last_name,
          $class_id,
          $date_of_birth,
          $gender_id,
          $phone,
          $email,
          $place_of_birth,
          $address
      );

      if (mysqli_stmt_execute($stmt)) {
          $studentAdded   = true;
          $successMessage = "The student has been added successfully.";
      } else {
          $studentError   = "Database error while adding student: " . mysqli_error($connect);
      }
  }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_student'])) {

  $student_id        = (int)($_POST['student_id'] ?? 0);
  $first_name        = trim($_POST['first_name'] ?? '');
  $last_name         = trim($_POST['last_name'] ?? '');
  $class_id          = (int)($_POST['class_id'] ?? 0);
  $gender_id         = (int)($_POST['gender_id'] ?? 0);
  $phone             = trim($_POST['phone'] ?? '');
  $email             = trim($_POST['email'] ?? '');
  $place_of_birth    = trim($_POST['place_of_birth'] ?? '');
  $address           = trim($_POST['address'] ?? '');
  $date_of_birth_raw = trim($_POST['date_of_birth'] ?? '');

  if ($date_of_birth_raw === '' || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date_of_birth_raw)) {
      $date_of_birth = null;
  } else {
      $date_of_birth = $date_of_birth_raw;
  }

  if ($student_id <= 0 || $first_name === '' || $last_name === '' || $class_id <= 0 || $gender_id <= 0) {
      $studentError = "Please fill all required fields for the student.";
  } else {

      $sql = "
          UPDATE students
             SET first_name     = ?,
                 last_name      = ?,
                 class_id       = ?,
                 date_of_birth  = ?,
                 gender_id      = ?,
                 phone          = ?,
                 email          = ?,
                 place_of_birth = ?,
                 address        = ?
           WHERE student_id     = ?
      ";
      $stmt = mysqli_prepare($connect, $sql);
      mysqli_stmt_bind_param(
          $stmt,
          'ssisissssi',
          $first_name,
          $last_name,
          $class_id,
          $date_of_birth,
          $gender_id,
          $phone,
          $email,
          $place_of_birth,
          $address,
          $student_id
      );

      if (mysqli_stmt_execute($stmt)) {
          $studentEdited   = true;
          $successMessage  = "The student has been updated successfully.";
      } else {
          $studentError = "Database error while updating student: " . mysqli_error($connect);
      }
  }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_student'])) {

    $student_id = (int)($_POST['student_id'] ?? 0);

    if ($student_id <= 0) {
        $studentError = "Invalid student selected for deletion.";
    } else {
        $sql = "DELETE FROM students WHERE student_id = ?";
        $stmt = mysqli_prepare($connect, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $student_id);

        if (mysqli_stmt_execute($stmt)) {
            $studentDeleted   = true;
            $successMessage   = "The student has been deleted successfully.";
        } else {
            $studentError = "Database error while deleting student: " . mysqli_error($connect);
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_user'])) {
    $userType = $_POST['user_type'] ?? '';
    $userId   = (int)($_POST['user_id'] ?? 0);
    $email    = trim($_POST['email'] ?? '');

    if ($userId <= 0 || $userType === '' || $email === '') {
        $userError = "User type, id and email are required.";
    } else {
        switch ($userType) {
            case 'admins':
                $sql = "UPDATE admin SET email = ? WHERE admin_id = ?";
                break;
            case 'teachers':
                $sql = "UPDATE teachers SET email = ? WHERE teacher_id = ?";
                break;
            case 'parents':
                $sql = "UPDATE parents SET email = ? WHERE parent_id = ?";
                break;
            case 'students':
                $sql = "UPDATE students SET email = ? WHERE student_id = ?";
                break;
            default:
                $sql = '';
        }

        if ($sql !== '') {
            $stmt = mysqli_prepare($connect, $sql);
            mysqli_stmt_bind_param($stmt, 'si', $email, $userId);
            if (mysqli_stmt_execute($stmt)) {
                $userEdited     = true;
                $successMessage = "The user email has been updated.";
            } else {
                $userError = "Database error while updating user.";
            }
        } else {
            $userError = "Unknown user type.";
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user'])) {
    $userType = $_POST['user_type'] ?? '';
    $userId   = (int)($_POST['user_id'] ?? 0);

    if ($userId <= 0 || $userType === '') {
        $userError = "User type and id are required.";
    } else {
        switch ($userType) {
            case 'admins':
                $sql = "DELETE FROM admin WHERE admin_id = ?";
                break;
            case 'teachers':
                $sql = "DELETE FROM teachers WHERE teacher_id = ?";
                break;
            case 'parents':
                $sql = "DELETE FROM parents WHERE parent_id = ?";
                break;
            case 'students':
                $sql = "DELETE FROM students WHERE student_id = ?";
                break;
            default:
                $sql = '';
        }

        if ($sql !== '') {
            $stmt = mysqli_prepare($connect, $sql);
            mysqli_stmt_bind_param($stmt, 'i', $userId);
            if (mysqli_stmt_execute($stmt)) {
                $userDeleted    = true;
                $successMessage = "The user has been deleted.";
            } else {
                $userError = "Database error while deleting user.";
            }
        } else {
            $userError = "Unknown user type.";
        }
    }
}

$sqlCounts = "
  SELECT
    (SELECT COUNT(*) FROM teachers) AS teachers,
    (SELECT COUNT(*) FROM admin)    AS admins,
    (SELECT COUNT(*) FROM students) AS students,
    (SELECT COUNT(*) FROM parents)  AS parents
";
$counts = mysqli_fetch_assoc(mysqli_query($connect, $sqlCounts));

$cards = [
  ['key' => 'teachers', 'title' => 'Teachers',   'img' => 'images/dashboardImage/teachers.png'],
  ['key' => 'admins',   'title' => 'S. Members', 'img' => 'images/dashboardImage/staff.png'],
  ['key' => 'students', 'title' => 'Students',   'img' => 'images/dashboardImage/students.png'],
  ['key' => 'parents',  'title' => 'Parents',    'img' => 'images/dashboardImage/family.png'],
];

$userTabs = [
  'admins' => [
    'title' => 'Admins',
    'primary_key' => 'admin_id',
    'columns' => [
      'Admin ID'    => 'admin_id',
      'Last Name'   => 'admin_lastname',
      'First Name'  => 'admin_firstname',
      'Age'         => 'admin_age',
      'Email'       => 'email',
      'Description' => 'admin_function',
    ],
    'sql' => "SELECT admin_id, admin_lastname, admin_firstname, admin_age, email, admin_function
              FROM admin ORDER BY admin_id",
  ],
  'teachers' => [
    'title' => 'Teachers',
    'primary_key' => 'teacher_id',
    'columns' => [
      'Teacher ID'  => 'teacher_id',
      'Last Name'   => 'last_name',
      'First Name'  => 'first_name',
      'Email'       => 'email',
      'Department'  => 'department_id',
    ],
    'sql' => "SELECT teacher_id, last_name, first_name, email, department_id
              FROM teachers ORDER BY teacher_id",
  ],
  'students' => [
    'title' => 'Students',
    'primary_key' => 'student_id',
    'columns' => [
      'Student ID'   => 'student_id',
      'Last Name'    => 'last_name',
      'First Name'   => 'first_name',
      'Grade'        => 'class_name',
      'Parent Email' => 'parent_email',
      'Student Email'=> 'email',
    ],
    'sql' => "SELECT 
                s.student_id,
                s.last_name,
                s.first_name,
                cl.class_name AS class_name,
                GROUP_CONCAT(DISTINCT p.email SEPARATOR ', ') AS parent_email,
                s.email AS email
              FROM students s
              INNER JOIN classes cl
                ON cl.class_id = s.class_id
              LEFT JOIN student_parents sp
                ON sp.student_id = s.student_id
              LEFT JOIN parents p
                ON p.parent_id = sp.parent_id
              GROUP BY s.student_id, s.last_name, s.first_name, cl.class_name, s.email
              ORDER BY s.student_id",
  ],
  'parents' => [
    'title' => 'Parents',
    'primary_key' => 'parent_id',
    'columns' => [
      'Parent ID'   => 'parent_id',
      'Last Name'   => 'last_name',
      'First Name'  => 'first_name',
      'Email'       => 'email',
    ],
    'sql' => "SELECT parent_id, last_name, first_name, email
              FROM parents ORDER BY parent_id",
  ],
];

$tablesData = [];
foreach ($userTabs as $key => $def) {
  $tablesData[$key] = getAllRows($connect, $def['sql']);
}

$classesList  = getAllRows($connect, "SELECT class_id, class_name FROM classes ORDER BY class_id");
$genderList   = getAllRows($connect, "SELECT gender_id, gender_name FROM gender ORDER BY gender_id");
$parentsList  = getAllRows($connect, "
    SELECT parent_id, first_name, last_name 
    FROM parents 
    ORDER BY last_name, first_name
");
$teachersList = getAllRows($connect, "
    SELECT teacher_id, last_name, first_name
    FROM teachers
    ORDER BY last_name, first_name
");
?>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</head>
<body>

<?php if ($successMessage !== ''): ?>
  <div class="success-toast">
    <?= h($successMessage); ?>
  </div>
<?php endif; ?>

<section class="dashboard-container">
  <aside id="sidebar">
    <div class="dashboard-logo-container">
      <a href="index.html"><img src="images/logowhite.png" alt=""></a>
    </div>

    <button class="dashboard-tab-button" data-tab="1">Overview/Analytics</button>
    <button class="dashboard-tab-button" data-tab="2">User Management</button>
    <button class="dashboard-tab-button" data-tab="3">Classes & Courses</button>
    <button class="dashboard-tab-button" data-tab="4">Documents & Admissions</button>
    <button class="dashboard-tab-button" data-tab="5">Announcements / Notifications</button>
    <button class="dashboard-tab-button" data-tab="6">System Settings</button>
  </aside>

  <main id="main-content">
    <div class="dashboards-header-outer-container">
      <div class="dashboards-header">
        <div class="dashboards-header-left">
          <h1>Welcome to STI</h1>
        </div>
        <div class="dashboard-middle-header">
          <form action="" class="search-form">
            <input type="search" placeholder="Search students, teachers, classes...">
            <button type="submit"><i class="fa-brands fa-searchengin"></i></button>
          </form>
        </div>
        <div class="dashboards-header-right">
          <span>Academic Year: 2025-2026</span>
          <div class="dashboard-icons-container">
            <i class="fa-solid fa-user"></i>
            <i class="fa-solid fa-bell"></i>
            <i class="fa-solid fa-gear"></i>
            <i class="fa-solid fa-question"></i>
          </div>
        </div>
      </div>
    </div>

    <div class="dashboard-tabs-content dashboards-content-active" data-tab="1">
      <div class="dashboard-card-outer-container">
        <div class="dashboard-card-container">
          <?php foreach ($cards as $c): ?>
            <div class="card-child">
              <div class="card-child-left">
                <img src="<?= h($c['img']) ?>" alt="">
              </div>
              <div class="card-child-right">
                <span><?= (int)($counts[$c['key']] ?? 0) ?></span>
                <h2><?= h($c['title']) ?></h2>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="socratetech-statistic">
        <div class="socratetech-statistic-left">
          <h1>Attendance Rate</h1>
          <div id="chart"></div>
        </div>
        <div class="socratetech-statistic-right">
          <h1>Performance Statistics</h1>
          <div id="performanceChart"></div>
        </div>
      </div>
    </div>

    <div class="dashboard-tabs-content" data-tab="2">
      <div class="user-management-tab-container">
        <?php if ($userError !== ''): ?>
          <div class="flash-error"><?= h($userError) ?></div>
        <?php endif; ?>

        <div class="user-management-button-container">
          <?php $umIndex=1; foreach ($userTabs as $key=>$def): ?>
            <button class="user-management-tab-button" data-tab="<?= $umIndex ?>"><?= h($def['title']) ?></button>
          <?php $umIndex++; endforeach; ?>
        </div>

        <?php $umIndex=1; foreach ($userTabs as $key=>$def): ?>
          <div class="user-management-content-container<?= $umIndex===1 ? ' userManagementActiveContentContainer' : '' ?>" data-tab="<?= $umIndex ?>">
            <div class="admin-table-container">
              <table class="table-container">
                <thead>
                  <tr>
                    <?php foreach ($def['columns'] as $label => $field): ?>
                      <th><?= h($label) ?></th>
                    <?php endforeach; ?>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($tablesData[$key])): ?>
                    <?php foreach ($tablesData[$key] as $row): ?>
                      <tr>
                        <?php foreach ($def['columns'] as $fieldLabel => $fieldName): ?>
                          <td><?= h($row[$fieldName] ?? '') ?></td>
                        <?php endforeach; ?>
                        <td>
                          <div class="button-container">
                            <button 
                                class="edit edit-user-btn"
                                data-user-type="<?= h($key) ?>"
                                data-user-id="<?= (int)$row[$def['primary_key']] ?>"
                                data-user-email="<?= h($row['email'] ?? '') ?>"
                            >
                              <i class="fa-solid fa-pen"></i>
                            </button>
                            <button 
                                class="delete delete-user-btn"
                                data-user-type="<?= h($key) ?>"
                                data-user-id="<?= (int)$row[$def['primary_key']] ?>"
                            >
                              <i class="fa-solid fa-trash"></i>
                            </button>
                          </div>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr><td colspan="<?= count($def['columns']) + 1 ?>">No data available</td></tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        <?php $umIndex++; endforeach; ?>
      </div>
    </div>

    <div class="dashboard-tabs-content" data-tab="3">
      <div class="classes-main-container">
        <div class="classes-buttons-tab-container">
          <button class="class-button-tab button" data-tab="1">7e</button>
          <button class="class-button-tab button" data-tab="2">8e</button>
          <button class="class-button-tab button" data-tab="3">9e</button>
          <button class="class-button-tab button" data-tab="4">NS1</button>
          <button class="class-button-tab button" data-tab="5">NS2</button>
          <button class="class-button-tab button" data-tab="6">NS3</button>
          <button class="class-button-tab button" data-tab="7">NS4</button>
        </div>

        <div class="classes-content-container classesContentContainerActive" data-tab="1">
          <div class="classes-buttons-info-container">
            <button class="class-button-tab-info button" data-tab="1">Basic Info</button>
            <button class="class-button-tab-info button" data-tab="2">Courses</button>
            <button class="class-button-tab-info button" data-tab="3">Schedule</button>
            <button class="class-button-tab-info button" data-tab="4">Students</button>
          </div>

          <div class="classes-content-info-container classInfoActiveContent" data-tab="1">
            <div class="basic-info-container">
              <div class="basic-info">
                <span>7e Année Fondamentale</span>
                <h2>Academic Year: 2025-2026</h2>
                <h2>Classroom #: 0245</h2>
                <h2>Capacity: 45</h2>
                <h2>Number of Students: 56</h2>
                <h2>Number of Teachers: 14</h2>
                <h2>Number of courses: 14</h2>
              </div>
              <div class="tutor-info">
                <div class="tutor-info-left">
                  <img src="images/0016_3.JPG" alt="">
                </div>
                <div class="tutor-info-right">
                  <h2>Prof. JEAN W. LEYDER</h2>
                  <h4>Sciences & Mathematics</h4>
                  <p><strong>Email:</strong> <a href="#">leyder.jean@sti.edu.ht</a></p>
                  <p><strong>Phone:</strong> <a href="#">+509 42 36 89 15</a></p>
                  <p><strong>Degree:</strong> Bachelor in Informatics</p>
                  <p><strong>Experience:</strong> 7 years of teaching experience</p>
                  <p>Dedicated to making science clear and exciting for students through logic and daily examples.</p>
                  <p><strong>Courses handled in 7e:</strong> Mathematics, Physics, General Science</p>
                </div>
              </div>
            </div>
          </div>
          
          <div class="classes-content-info-container" data-tab="2">
            <button class="new-course button js-new-course">
              Add a New Course <i class="fa-solid fa-plus cross"></i>
            </button>

            <?php if ($courseError !== ''): ?>
              <div class="flash-error">
                <?= h($courseError) ?>
              </div>
            <?php endif; ?>

            <?php if ($studentError !== ''): ?>
              <div class="flash-error">
                <?= h($studentError) ?>
              </div>
            <?php endif; ?>

            <div class="courses-container">
              <table class="courses-table">
                <thead>
                  <tr>
                    <th>Course Code</th>
                    <th>Course Name</th>
                    <th>Teacher</th>
                    <th>Coefficient</th>
                    <th>Description</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php renderCoursesRows($connect, 1); ?>
                </tbody>
              </table>
            </div>
          </div>

          <div class="classes-content-info-container schedule-container" data-tab="3">
            <?php renderScheduleTable($connect, '7e'); ?>
          </div>

          <div class="classes-content-info-container" data-tab="4">
            <button class="new-course button js-new-student" data-class-id="1">
              Add a New Student<i class="fa-solid fa-plus cross"></i>
            </button>   
            <div class="student-container">
              <?php renderStudentsTable($connect, 1); ?>
            </div>
          </div>
        </div>

        <div class="classes-content-container" data-tab="2">
          <div class="classes-buttons-info-container">
            <button class="class-button-tab-info button" data-tab="1">Basic Info</button>
            <button class="class-button-tab-info button" data-tab="2">Courses</button>
            <button class="class-button-tab-info button" data-tab="3">Schedule</button>
            <button class="class-button-tab-info button" data-tab="4">Students</button>
          </div>

          <div class="classes-content-info-container classInfoActiveContent" data-tab="1">
            <?php renderGenericClassBasicInfo($connect, 2); ?>
          </div>

          <div class="classes-content-info-container" data-tab="2">
            <button class="new-course button js-new-course">
              Add a New Course <i class="fa-solid fa-plus cross"></i>
            </button>
            <div class="courses-container">
              <table class="courses-table">
                <thead>
                  <tr>
                    <th>Course Code</th>
                    <th>Course Name</th>
                    <th>Teacher</th>
                    <th>Coefficient</th>
                    <th>Description</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php renderCoursesRows($connect, 2); ?>
                </tbody>
              </table>
            </div>
          </div>

          <div class="classes-content-info-container schedule-container" data-tab="3">
            <?php renderScheduleTable($connect, '8e'); ?>
          </div>

          <div class="classes-content-info-container" data-tab="4">
            <button class="new-course button js-new-student" data-class-id="2">
              Add a New Student<i class="fa-solid fa-plus cross"></i>
            </button>
            <div class="student-container">
              <?php renderStudentsTable($connect, 2); ?>
            </div>
          </div>
        </div>

        <div class="classes-content-container" data-tab="3">
          <div class="classes-buttons-info-container">
            <button class="class-button-tab-info button" data-tab="1">Basic Info</button>
            <button class="class-button-tab-info button" data-tab="2">Courses</button>
            <button class="class-button-tab-info button" data-tab="3">Schedule</button>
            <button class="class-button-tab-info button" data-tab="4">Students</button>
          </div>

          <div class="classes-content-info-container classInfoActiveContent" data-tab="1">
            <?php renderGenericClassBasicInfo($connect, 3); ?>
          </div>
          <div class="classes-content-info-container" data-tab="2">
            <button class="new-course button js-new-course">
              Add a New Course <i class="fa-solid fa-plus cross"></i>
            </button>
            <div class="courses-container">
              <table class="courses-table">
                <thead>
                  <tr>
                    <th>Course Code</th>
                    <th>Course Name</th>
                    <th>Teacher</th>
                    <th>Coefficient</th>
                    <th>Description</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php renderCoursesRows($connect, 3); ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="classes-content-info-container schedule-container" data-tab="3">
            <?php renderScheduleTable($connect, '9e'); ?>
          </div>
          <div class="classes-content-info-container" data-tab="4">
            <button class="new-course button js-new-student" data-class-id="3">
              Add a New Student<i class="fa-solid fa-plus cross"></i>
            </button>
             <div class="student-container">
             <?php renderStudentsTable($connect, 1); ?>
             </div>
             </div>
             </div>

        <div class="classes-content-container" data-tab="4">
          <div class="classes-buttons-info-container">
            <button class="class-button-tab-info button" data-tab="1">Basic Info</button>
            <button class="class-button-tab-info button" data-tab="2">Courses</button>
            <button class="class-button-tab-info button" data-tab="3">Schedule</button>
            <button class="class-button-tab-info button" data-tab="4">Students</button>
          </div>
          <div class="classes-content-info-container classInfoActiveContent" data-tab="1">
            <?php renderGenericClassBasicInfo($connect, 4); ?>
          </div>
          <div class="classes-content-info-container" data-tab="2">
            <button class="new-course button js-new-course">
              Add a New Course <i class="fa-solid fa-plus cross"></i>
            </button>
            <div class="courses-container">
              <table class="courses-table">
                <thead>
                  <tr>
                    <th>Course Code</th>
                    <th>Course Name</th>
                    <th>Teacher</th>
                    <th>Coefficient</th>
                    <th>Description</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php renderCoursesRows($connect, 4); ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="classes-content-info-container schedule-container" data-tab="3">
            <?php renderScheduleTable($connect, 'NS1'); ?>
          </div>
          <div class="classes-content-info-container" data-tab="4">
            <button class="new-course button js-new-student" data-class-id="4">
              Add a New Student<i class="fa-solid fa-plus cross"></i>
            </button>
            <div class="student-container">
              <?php renderStudentsTable($connect, 4); ?>
            </div>
          </div>
        </div>

        <div class="classes-content-container" data-tab="5">
          <div class="classes-buttons-info-container">
            <button class="class-button-tab-info button" data-tab="1">Basic Info</button>
            <button class="class-button-tab-info button" data-tab="2">Courses</button>
            <button class="class-button-tab-info button" data-tab="3">Schedule</button>
            <button class="class-button-tab-info button" data-tab="4">Students</button>
          </div>
          <div class="classes-content-info-container classInfoActiveContent" data-tab="1">
            <?php renderGenericClassBasicInfo($connect, 5); ?>
          </div>
          <div class="classes-content-info-container" data-tab="2">
            <button class="new-course button js-new-course">
              Add a New Course <i class="fa-solid fa-plus cross"></i>
            </button>
            <div class="courses-container">
              <table class="courses-table">
                <thead>
                  <tr>
                    <th>Course Code</th>
                    <th>Course Name</th>
                    <th>Teacher</th>
                    <th>Coefficient</th>
                    <th>Description</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php renderCoursesRows($connect, 5); ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="classes-content-info-container schedule-container" data-tab="3">
            <?php renderScheduleTable($connect, 'NS2'); ?>
          </div>
          <div class="classes-content-info-container" data-tab="4">
            <button class="new-course button js-new-student" data-class-id="5">
              Add a New Student<i class="fa-solid fa-plus cross"></i>
            </button>
            <div class="student-container">
              <?php renderStudentsTable($connect, 5); ?>
            </div>
          </div>
        </div>

        <div class="classes-content-container" data-tab="6">
          <div class="classes-buttons-info-container">
            <button class="class-button-tab-info button" data-tab="1">Basic Info</button>
            <button class="class-button-tab-info button" data-tab="2">Courses</button>
            <button class="class-button-tab-info button" data-tab="3">Schedule</button>
            <button class="class-button-tab-info button" data-tab="4">Students</button>
          </div>
          <div class="classes-content-info-container classInfoActiveContent" data-tab="1">
            <?php renderGenericClassBasicInfo($connect, 6); ?>
          </div>
          <div class="classes-content-info-container" data-tab="2">
            <button class="new-course button js-new-course">
              Add a New Course <i class="fa-solid fa-plus cross"></i>
            </button>
            <div class="courses-container">
              <table class="courses-table">
                <thead>
                  <tr>
                    <th>Course Code</th>
                    <th>Course Name</th>
                    <th>Teacher</th>
                    <th>Coefficient</th>
                    <th>Description</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php renderCoursesRows($connect, 6); ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="classes-content-info-container schedule-container" data-tab="3">
            <?php renderScheduleTable($connect, 'NS3'); ?>
          </div>
          <div class="classes-content-info-container" data-tab="4">
            <button class="new-course button js-new-student" data-class-id="6">
              Add a New Student<i class="fa-solid fa-plus cross"></i>
            </button>
            <div class="student-container">
              <?php renderStudentsTable($connect, 6); ?>
            </div>
          </div>
        </div>

        <div class="classes-content-container" data-tab="7">
          <div class="classes-buttons-info-container">
            <button class="class-button-tab-info button" data-tab="1">Basic Info</button>
            <button class="class-button-tab-info button" data-tab="2">Courses</button>
            <button class="class-button-tab-info button" data-tab="3">Schedule</button>
            <button class="class-button-tab-info button" data-tab="4">Students</button>
          </div>
          <div class="classes-content-info-container classInfoActiveContent" data-tab="1">
            <?php renderGenericClassBasicInfo($connect, 7); ?>
          </div>
          <div class="classes-content-info-container" data-tab="2">
            <button class="new-course button js-new-course">
              Add a New Course <i class="fa-solid fa-plus cross"></i>
            </button>
            <div class="courses-container">
              <table class="courses-table">
                <thead>
                  <tr>
                    <th>Course Code</th>
                    <th>Course Name</th>
                    <th>Teacher</th>
                    <th>Coefficient</th>
                    <th>Description</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php renderCoursesRows($connect, 7); ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="classes-content-info-container schedule-container" data-tab="3">
            <?php renderScheduleTable($connect, 'NS4'); ?>
          </div>
          <div class="classes-content-info-container" data-tab="4">
            <button class="new-course button js-new-student" data-class-id="7">
              Add a New Student<i class="fa-solid fa-plus cross"></i>
            </button>
            <div class="student-container">
              <?php renderStudentsTable($connect, 7); ?>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="dashboard-tabs-content" data-tab="4">Documents & Admissions…</div>
    <div class="dashboard-tabs-content" data-tab="5">Announcements / Notifications…</div>
    <div class="dashboard-tabs-content" data-tab="6">System Settings…</div>

  </main>
</section>

<section class="modal-container" id="addCourseModal">
  <div class="modal-form-container">
    <span class="close-x" id="closeAddCourseModal"><i class="fa-solid fa-xmark"></i></span>
    <div class="modal-title"><h2>Add a New Course</h2></div>

    <form action="" method="POST">
      <div class="input-group">
        <select name="class_id" required>
          <option value="">Select a class</option>
          <?php foreach ($classesList as $cls): ?>
            <option value="<?= (int)$cls['class_id']; ?>"><?= h($cls['class_name']); ?></option>
          <?php endforeach; ?>
        </select>

        <input type="text" name="course_name" placeholder="Course Name" required>

        <select name="teacher_id" required>
          <option value="">Select a teacher</option>
          <?php foreach ($teachersList as $t): ?>
            <option value="<?= (int)$t['teacher_id']; ?>">
              <?= h($t['last_name'] . ' ' . $t['first_name']); ?>
            </option>
          <?php endforeach; ?>
        </select>

        <input type="number" name="coefficient" placeholder="Coefficient" required>
        <textarea name="description" placeholder="Course Description (optional)"></textarea>
        <button type="submit" name="add_course" class="button">Save</button>
      </div>
    </form>
  </div>
</section>

<section class="modal-container" id="editCourseModal">
  <div class="modal-form-container">
    <span class="close-x" id="closeEditCourseModal"><i class="fa-solid fa-xmark"></i></span>
    <div class="modal-title"><h2>Edit Course</h2></div>

    <form action="" method="POST" id="editCourseForm">
      <div class="input-group">
        <input type="hidden" name="course_id" id="editCourseId">

        <select name="class_id" id="editClassId" required>
          <option value="">Select a class</option>
          <?php foreach ($classesList as $cls): ?>
            <option value="<?= (int)$cls['class_id']; ?>"><?= h($cls['class_name']); ?></option>
          <?php endforeach; ?>
        </select>

        <input
          type="text"
          name="course_name"
          id="editCourseName"
          placeholder="Course Name"
          required
        >

        <select name="teacher_id" id="editTeacherId" required>
          <option value="">Select a teacher</option>
          <?php foreach ($teachersList as $t): ?>
            <option value="<?= (int)$t['teacher_id']; ?>">
              <?= h($t['last_name'] . ' ' . $t['first_name']); ?>
            </option>
          <?php endforeach; ?>
        </select>

        <input
          type="number"
          name="coefficient"
          id="editCoefficient"
          placeholder="Coefficient"
          required
        >

        <textarea name="description" id="editDescription" placeholder="Course Description (optional)"></textarea>

        <button type="submit" name="edit_course" class="button">Save</button>
      </div>
    </form>
  </div>
</section>

<section class="modal-container" id="deleteCourseModal">
  <div class="modal-form-container">
    <span class="close-x" id="closeDeleteCourseModal"><i class="fa-solid fa-xmark"></i></span>
    <div class="modal-title"><h2>Delete Course</h2></div>
    <p id="deleteCourseText">Are you sure you want to delete this course?</p>
    <form action="" method="POST">
      <input type="hidden" name="course_id" id="deleteCourseId">
      <button type="submit" name="delete_course" class="button">Yes, delete</button>
    </form>
  </div>
</section>

<section class="modal-container" id="addStudentModal">
  <div class="modal-form-container">
    <span class="close-x" id="closeAddStudentModal"><i class="fa-solid fa-xmark"></i></span>
    <div class="modal-title"><h2>Add a New Student</h2></div>

    <form action="" method="POST">
      <div class="input-group">
        <input type="text" name="first_name" placeholder="First Name" required>
        <input type="text" name="last_name" placeholder="Last Name" required>

        <select name="class_id" id="addStudentClassId" required>
          <option value="">Select Class</option>
          <?php foreach ($classesList as $cls): ?>
            <option value="<?= (int)$cls['class_id']; ?>"><?= h($cls['class_name']); ?></option>
          <?php endforeach; ?>
        </select>

        <select name="gender_id" required>
          <option value="">Select Gender</option>
          <?php foreach ($genderList as $g): ?>
            <option value="<?= (int)$g['gender_id']; ?>"><?= h($g['gender_name']); ?></option>
          <?php endforeach; ?>
        </select>

        <input type="date" name="date_of_birth" placeholder="Date of Birth">
        <input type="text" name="phone" placeholder="Phone">
        <input type="email" name="email" placeholder="Email">
        <input type="text" name="place_of_birth" placeholder="Place of Birth">
        <input type="text" name="address" placeholder="Address">
        <input type="number" name="age" placeholder="Age">

        <button type="submit" name="add_student" class="button">Save</button>
      </div>
    </form>
  </div>
</section>


<section class="modal-container" id="editStudentModal">
  <div class="modal-form-container">
    <span class="close-x" id="closeEditStudentModal"><i class="fa-solid fa-xmark"></i></span>
    <div class="modal-title"><h2>Edit Student</h2></div>

    <form action="" method="POST">
      <div class="input-group">
        <input type="hidden" name="student_id" id="editStudentId">

        <input type="text" name="first_name" id="editStudentFname" placeholder="First Name">
        <input type="text" name="last_name"  id="editStudentLname" placeholder="Last Name">

        <select name="class_id" id="editStudentClassId" required>
          <option value="">Select Class</option>
          <?php foreach ($classesList as $cls): ?>
            <option value="<?= (int)$cls['class_id']; ?>"><?= h($cls['class_name']); ?></option>
          <?php endforeach; ?>
        </select>

        <select name="gender_id" id="editStudentGenderId" required>
          <option value="">Select Gender</option>
          <?php foreach ($genderList as $g): ?>
            <option value="<?= (int)$g['gender_id']; ?>"><?= h($g['gender_name']); ?></option>
          <?php endforeach; ?>
        </select>

        <input type="date" name="date_of_birth" id="editStudentDob" placeholder="Date of Birth">
        <input type="text" name="phone" id="editStudentPhone" placeholder="Phone">
        <input type="email" name="email" id="editStudentEmail" placeholder="Email">
        <input type="text" name="place_of_birth" id="editStudentPlace" placeholder="Place of Birth">
        <input type="text" name="address" id="editStudentAddress" placeholder="Address">
        <input type="number" name="age" id="editStudentAge" placeholder="Age">

        <button type="submit" name="edit_student" class="button">Save</button>
      </div>
    </form>
  </div>
</section>


<section class="modal-container" id="deleteStudentModal">
  <div class="modal-form-container">
    <span class="close-x" id="closeDeleteStudentModal"><i class="fa-solid fa-xmark"></i></span>
    <div class="modal-title"><h2>Delete Student</h2></div>
    <p id="deleteStudentText">Are you sure you want to delete this student?</p>
    <form action="" method="POST" class="input-group">
      <input type="hidden" name="student_id" id="deleteStudentId">
      <button type="submit" name="delete_student" class="button">Yes, delete</button>
    </form>
  </div>
</section>

<section class="modal-container" id="editUserModal">
  <div class="modal-form-container">
    <span class="close-x" id="closeEditUserModal"><i class="fa-solid fa-xmark"></i></span>
    <div class="modal-title"><h2>Edit User</h2></div>
    <form action="" method="POST">
      <div class="input-group">
        <input type="hidden" name="user_id" id="editUserId">
        <input type="hidden" name="user_type" id="editUserType">
        <input type="email" name="email" id="editUserEmail" placeholder="Email" required>
        <button type="submit" name="edit_user" class="button">Save</button>
      </div>
    </form>
  </div>
</section>

<section class="modal-container" id="deleteUserModal">
  <div class="modal-form-container">
    <span class="close-x" id="closeDeleteUserModal"><i class="fa-solid fa-xmark"></i></span>
    <div class="modal-title"><h2>Delete User</h2></div>
    <p id="deleteUserText">Are you sure you want to delete this user?</p>
    <form action="" method="POST" class="input-group">
      <input type="hidden" name="user_id" id="deleteUserId">
      <input type="hidden" name="user_type" id="deleteUserType">
      <button type="submit" name="delete_user" class="button">Yes, delete</button>
    </form>
  </div>
</section>






<script src="script2.js"></script>

<script src="script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
</body>
</html>
