<?php
session_start();
include 'database/database.php';
include 'partials/functions.php';
include 'partials/header.php';
?>

<button class="new-course button" id="newCourseBtn">
  Add a New Course
  <i class="fa-solid fa-plus cross"></i>
</button>

<section class="modal-container" id="modalContainer">
  <div class="modal-form-container">
    <span class="close-x" id="closeBtn">
        <i class="fa-solid fa-xmark"></i>
    </span>

    <div class="modal-title">
      <h2>Add a New Course</h2>
    </div>

    <form action="" method="POST">
      <div class="input-group">
        <input type="hidden" name="course_code">

        <input type="text" name="course_name" placeholder="Course Name" required>
        <input type="text" name="assigned_teacher" placeholder="Assigned Teacher" required>
        <input type="text" name="coefficient" placeholder="Coefficient" required>

        <textarea name="description" placeholder="Course Description (optional)"></textarea>

        <button type="submit" name="save" class="button">Save</button>
      </div>
    </form>
  </div>
</section>

<!-- JS MUST be in the same folder as this file -->
<script src="script2.js"></script>
</body>
</html>
