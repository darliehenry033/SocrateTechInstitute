<?php
session_start();
require_once 'database/database.php';
require_once 'partials/functions.php';
require_once 'partials/header.php';

$courseEdited = false;
$courseError  = '';

$course = [
    'course_id'    => '',
    'course_name'  => '',
    'coefficient'  => '',
    'description'  => '',
    'class_id'     => '',
    'teacher_id'   => ''
];

if (isset($_GET['course_id'])) {
    $id = (int)$_GET['course_id'];
    if ($id > 0) {
        $stmt = mysqli_prepare($connect, "
            SELECT course_id, course_name, coefficient, description, class_id, teacher_id
            FROM courses
            WHERE course_id = ?
        ");
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($res)) {
            $course = $row;
        } else {
            $courseError = "Course not found.";
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_course'])) {
    $course['course_id']   = (int)$_POST['course_id'];
    $course['course_name'] = trim($_POST['course_name']);
    $course['coefficient'] = (int)$_POST['coefficient'];
    $course['description'] = trim($_POST['description']);
    $course['class_id']    = (int)$_POST['class_id'];
    $course['teacher_id']  = (int)$_POST['teacher_id'];

    if (
        $course['course_name'] === '' ||
        $course['coefficient'] <= 0 ||
        $course['class_id'] <= 0 ||
        $course['teacher_id'] <= 0
    ) {
        $courseError = "Please fill all fields correctly.";
    } else {
        $sql = "UPDATE courses
                SET course_name = ?, coefficient = ?, description = ?, class_id = ?, teacher_id = ?
                WHERE course_id = ?";
        $stmt = mysqli_prepare($connect, $sql);
        mysqli_stmt_bind_param(
            $stmt,
            'sisiii',
            $course['course_name'],
            $course['coefficient'],
            $course['description'],
            $course['class_id'],
            $course['teacher_id'],
            $course['course_id']
        );

        if (mysqli_stmt_execute($stmt)) {
            $courseEdited = true;

            $course_code = strtoupper(substr($course['course_name'], 0, 3)) . $course['course_id'];
            $stmt2 = mysqli_prepare($connect, "UPDATE courses SET course_code = ? WHERE course_id = ?");
            mysqli_stmt_bind_param($stmt2, 'si', $course_code, $course['course_id']);
            mysqli_stmt_execute($stmt2);
        } else {
            $courseError = "Database error.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Course</title>
    <link rel="stylesheet" href="design.css">

    <style>
      .success-toast {
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        background-color: #16a34a;
        color: #fff;
        padding: 12px 24px;
        border-radius: 6px;
        font-size: 0.95rem;
        box-shadow: 0 8px 20px rgba(0,0,0,0.25);
        z-index: 1000;
        animation: toastInOut 3.5s ease-in-out forwards;
      }
      @keyframes toastInOut {
        0%   { opacity: 0; transform: translate(-50%, -20px); }
        10%,80% { opacity: 1; transform: translate(-50%, 0); }
        100% { opacity: 0; transform: translate(-50%, -20px); }
      }
    </style>
</head>
<body>

<?php if ($courseEdited): ?>
  <div class="success-toast">
    The course has been updated successfully.
  </div>
<?php endif; ?>

<section class="modal-container" id="courseModal" style="display:flex;">
  <div class="modal-form-container">
    <span class="close-x" id="closeCourseModal"><i class="fa-solid fa-xmark"></i></span>
    <div class="modal-title"><h2>Edit Course</h2></div>

    <?php if ($courseError !== ''): ?>
      <p style="color:red; text-align:center; margin-bottom:10px;">
        <?= htmlspecialchars($courseError, ENT_QUOTES, 'UTF-8'); ?>
      </p>
    <?php endif; ?>

    <form action="" method="POST">
      <div class="input-group">
        <input type="hidden" name="course_id" value="<?= htmlspecialchars($course['course_id']); ?>">
        <input type="hidden" name="class_id" value="<?= htmlspecialchars($course['class_id']); ?>">

        <input
          type="text"
          name="course_name"
          placeholder="Course Name"
          value="<?= htmlspecialchars($course['course_name']); ?>"
          required
        >

        <select name="teacher_id" required>
          <option value="">Select a teacher</option>
          <?php
          $teacherResult = mysqli_query($connect, "SELECT teacher_id, last_name, first_name FROM teachers ORDER BY last_name");
          while ($t = mysqli_fetch_assoc($teacherResult)) {
              $tid  = $t['teacher_id'];
              $name = $t['last_name'] . ' ' . $t['first_name'];
              $selected = ($tid == $course['teacher_id']) ? 'selected' : '';
              echo "<option value=\"$tid\" $selected>$name</option>";
          }
          ?>
        </select>

        <input
          type="number"
          name="coefficient"
          placeholder="Coefficient"
          value="<?= htmlspecialchars($course['coefficient']); ?>"
          required
        >

        <textarea name="description" placeholder="Course Description (optional)"><?= htmlspecialchars($course['description']); ?></textarea>

        <button type="submit" name="edit_course" class="button">Save</button>
      </div>
    </form>
  </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const courseModal = document.getElementById('courseModal');
  const closeCourseModal = document.getElementById('closeCourseModal');

  if (closeCourseModal) {
    closeCourseModal.addEventListener('click', () => {
      window.history.back();
    });
  }
});
</script>
</body>
</html>
