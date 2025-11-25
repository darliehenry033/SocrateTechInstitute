<?php
session_start();
require_once 'database.php';
require_once 'partials/functions.php';
require_once 'partials/header.php';

$courseAdded = false;
$courseError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_course'])) {
    $course_name = trim($_POST['course_name']);
    $coefficient = (int)$_POST['coefficient'];
    $description = trim($_POST['description']);
    $class_id    = (int)$_POST['class_id'];
    $teacher_id  = (int)$_POST['teacher_id'];

    if ($course_name === '' || $coefficient <= 0 || $class_id <= 0 || $teacher_id <= 0) {
        $courseError = "Please fill all fields correctly.";
    } else {
        $sql = "INSERT INTO courses (course_name, coefficient, description, class_id, teacher_id)
                VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($connect, $sql);
        mysqli_stmt_bind_param($stmt,'sisii', $course_name,$coefficient,$description,$class_id,$teacher_id);

        if (mysqli_stmt_execute($stmt)) {
            $course_id   = mysqli_insert_id($connect);
            $course_code = strtoupper(substr($course_name, 0, 3)) . $course_id;

            $sql2  = "UPDATE courses SET course_code = ? WHERE course_id = ?";
            $stmt2 = mysqli_prepare($connect, $sql2);
            mysqli_stmt_bind_param($stmt2,'si',$course_code,$course_id);
            mysqli_stmt_execute($stmt2);

            $courseAdded = true;
        } else {
            $courseError = "Database error";
        }
    }
}
?>

</head>
<body>

<section class="modal-container" id="courseModal">
  <div class="modal-form-container">
    <span class="close-x" id="closeCourseModal"><i class="fa-solid fa-xmark"></i></span>
    <div class="modal-title"><h2>Add a New Course</h2></div>

    <form action="" method="POST">
      <div class="input-group">
        <input type="hidden" name="class_id" value="1">
        <input type="text" name="course_name" placeholder="Course Name" required>
        <select name="teacher_id" required>
          <option value="">Select a teacher</option>
          <?php
          $teacherResult = mysqli_query($connect, "SELECT teacher_id, last_name, first_name FROM teachers ORDER BY last_name");
          while ($t = mysqli_fetch_assoc($teacherResult)) {
              $tid = $t['teacher_id'];
              $name = $t['last_name'] . ' ' . $t['first_name'];
              echo "<option value=\"$tid\">$name</option>";
          }
          ?>
        </select>
        <input type="number" name="coefficient" placeholder="Coefficient" required>
        <textarea name="description" placeholder="Course Description (optional)"></textarea>
        <button type="submit" name="add_course" class="button">Save</button>
      </div>
    </form>
  </div>
</section>

<?php if ($courseAdded): ?>
  <div class="success-toast">
    The course has been added successfully.
  </div>
<?php endif; ?>



<script>
const courseModal = document.getElementById('courseModal');
  const successModal = document.getElementById('successModal');
  const newCourseBtn = document.getElementById('newCourseBtn');
  const closeCourseModal = document.getElementById('closeCourseModal');
  const closeSuccessModal = document.getElementById('closeSuccessModal');
  const successOkBtn = document.getElementById('successOkBtn');

  if (newCourseBtn) {
    newCourseBtn.addEventListener('click', () => {
      courseModal.style.display = 'flex';
    });
  }
  if (closeCourseModal) {
    closeCourseModal.addEventListener('click', () => {
      courseModal.style.display = 'none';
    });
  }

  const hideSuccess = () => {
    successModal.style.display = 'none';
  };
  if (closeSuccessModal) closeSuccessModal.addEventListener('click', hideSuccess);
  if (successOkBtn) successOkBtn.addEventListener('click', hideSuccess);

  <?php if ($courseAdded): ?>
    successModal.style.display = 'flex';
  <?php endif; ?>
  
</script>
</body>
</html>

