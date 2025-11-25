document.addEventListener("DOMContentLoaded", () => {
  const dashBtns = document.querySelectorAll(".dashboard-tab-button");
  const dashPanes = document.querySelectorAll(".dashboard-tabs-content");

  if (dashBtns.length && dashPanes.length) {
    dashBtns.forEach((btn) => {
      btn.addEventListener("click", () => {
        const tab = btn.dataset.tab;

        dashBtns.forEach((b) => b.classList.remove("dashboards-btn-active"));
        dashPanes.forEach((p) =>
          p.classList.remove("dashboards-content-active")
        );

        btn.classList.add("dashboards-btn-active");
        const pane = document.querySelector(
          `.dashboard-tabs-content[data-tab="${tab}"]`
        );
        if (pane) pane.classList.add("dashboards-content-active");

        if (tab === "1") {
          initChart();
          initPerformanceChart();
        }
      });
    });

    dashBtns[0].classList.add("dashboards-btn-active");
    dashPanes[0].classList.add("dashboards-content-active");
  }

  const umBtns = document.querySelectorAll(".user-management-tab-button");
  const umPanes = document.querySelectorAll(
    ".user-management-content-container"
  );

  if (umBtns.length && umPanes.length) {
    umBtns.forEach((btn) => {
      btn.addEventListener("click", () => {
        const tab = btn.dataset.tab;

        umBtns.forEach((b) =>
          b.classList.remove("userManagementActiveButton")
        );
        umPanes.forEach((p) =>
          p.classList.remove("userManagementActiveContentContainer")
        );

        btn.classList.add("userManagementActiveButton");
        const pane = document.querySelector(
          `.user-management-content-container[data-tab="${tab}"]`
        );
        if (pane) pane.classList.add("userManagementActiveContentContainer");
      });
    });

    umBtns[0].classList.add("userManagementActiveButton");
    umPanes[0].classList.add("userManagementActiveContentContainer");
  }

  const classBtns = document.querySelectorAll(".class-button-tab");
  const classPanes = document.querySelectorAll(".classes-content-container");

  if (classBtns.length && classPanes.length) {
    classBtns.forEach((btn) => {
      btn.addEventListener("click", () => {
        const tab = btn.dataset.tab;

        classBtns.forEach((b) =>
          b.classList.remove("classesButtonsActive")
        );
        classPanes.forEach((p) =>
          p.classList.remove("classesContentContainerActive")
        );

        btn.classList.add("classesButtonsActive");
        const pane = document.querySelector(
          `.classes-content-container[data-tab="${tab}"]`
        );
        if (pane) {
          pane.classList.add("classesContentContainerActive");

          const infoButtons = pane.querySelectorAll(".class-button-tab-info");
          const infoContents = pane.querySelectorAll(
            ".classes-content-info-container"
          );

          infoButtons.forEach((b, idx) => {
            b.classList.toggle("classInfoActiveButton", idx === 0);
          });
          infoContents.forEach((c, idx) => {
            c.classList.toggle("classInfoActiveContent", idx === 0);
          });
        }
      });
    });

    classBtns[0].classList.add("classesButtonsActive");
    classPanes[0].classList.add("classesContentContainerActive");
  }

  const classInfoButtons = document.querySelectorAll(".class-button-tab-info");

  classInfoButtons.forEach((button) => {
    button.addEventListener("click", () => {
      const parentContainer = button.closest(".classes-content-container");
      const tab = button.dataset.tab;

      const siblingButtons = parentContainer.querySelectorAll(
        ".class-button-tab-info"
      );
      const siblingContents = parentContainer.querySelectorAll(
        ".classes-content-info-container"
      );

      siblingButtons.forEach((btn) =>
        btn.classList.remove("classInfoActiveButton")
      );
      siblingContents.forEach((content) =>
        content.classList.remove("classInfoActiveContent")
      );

      button.classList.add("classInfoActiveButton");
      const pane = parentContainer.querySelector(
        `.classes-content-info-container[data-tab="${tab}"]`
      );
      if (pane) pane.classList.add("classInfoActiveContent");
    });
  });

  const addCourseModal = document.getElementById("addCourseModal");
  const editCourseModal = document.getElementById("editCourseModal");
  const deleteCourseModal = document.getElementById("deleteCourseModal");

  const newCourseBtns = document.querySelectorAll(".js-new-course");
  const closeAddCourseModal = document.getElementById("closeAddCourseModal");
  const closeEditCourseModal = document.getElementById("closeEditCourseModal");
  const closeDeleteCourseModal = document.getElementById(
    "closeDeleteCourseModal"
  );

  newCourseBtns.forEach((btn) => {
    btn.addEventListener("click", () => {
      if (addCourseModal) addCourseModal.style.display = "flex";
    });
  });

  if (closeAddCourseModal && addCourseModal) {
    closeAddCourseModal.addEventListener("click", () => {
      addCourseModal.style.display = "none";
    });
  }
  if (closeEditCourseModal && editCourseModal) {
    closeEditCourseModal.addEventListener("click", () => {
      editCourseModal.style.display = "none";
    });
  }
  if (closeDeleteCourseModal && deleteCourseModal) {
    closeDeleteCourseModal.addEventListener("click", () => {
      deleteCourseModal.style.display = "none";
    });
  }

  const editCourseBtns = document.querySelectorAll(".edit-course-btn");
  const editCourseId = document.getElementById("editCourseId");
  const editClassId = document.getElementById("editClassId");
  const editTeacherId = document.getElementById("editTeacherId");
  const editCourseName = document.getElementById("editCourseName");
  const editCoefficient = document.getElementById("editCoefficient");
  const editDescription = document.getElementById("editDescription");

  editCourseBtns.forEach((btn) => {
    btn.addEventListener("click", () => {
      if (!editCourseModal) return;

      if (editCourseId) editCourseId.value = btn.dataset.courseId || "";
      if (editCourseName) editCourseName.value = btn.dataset.courseName || "";
      if (editCoefficient) editCoefficient.value = btn.dataset.courseCoef || "";
      if (editDescription)
        editDescription.value = btn.dataset.courseDesc || "";
      if (editClassId) editClassId.value = btn.dataset.classId || "";
      if (editTeacherId) editTeacherId.value = btn.dataset.teacherId || "";

      editCourseModal.style.display = "flex";
    });
  });

  const deleteCourseBtns = document.querySelectorAll(".delete-course-btn");
  const deleteCourseId = document.getElementById("deleteCourseId");
  const deleteCourseText = document.getElementById("deleteCourseText");

  deleteCourseBtns.forEach((btn) => {
    btn.addEventListener("click", () => {
      if (!deleteCourseModal) return;
      const courseName = btn.dataset.courseName || "this course";
      if (deleteCourseId) deleteCourseId.value = btn.dataset.courseId || "";
      if (deleteCourseText)
        deleteCourseText.textContent = `Are you sure you want to delete the course "${courseName}"?`;
      deleteCourseModal.style.display = "flex";
    });
  });

  const addStudentModal = document.getElementById("addStudentModal");
  const editStudentModal = document.getElementById("editStudentModal");
  const deleteStudentModal = document.getElementById("deleteStudentModal");

  const closeAddStudentModal = document.getElementById("closeAddStudentModal");
  const closeEditStudentModal = document.getElementById("closeEditStudentModal");
  const closeDeleteStudentModal = document.getElementById(
    "closeDeleteStudentModal"
  );

  const newStudentBtns = document.querySelectorAll(".js-new-student");
  const addStudentClassSelect = document.getElementById("addStudentClassId");

  newStudentBtns.forEach((btn) => {
    btn.addEventListener("click", () => {
      const classId = btn.dataset.classId || "";
      if (addStudentClassSelect) addStudentClassSelect.value = classId;
      if (addStudentModal) addStudentModal.style.display = "flex";
    });
  });

  if (closeAddStudentModal && addStudentModal) {
    closeAddStudentModal.addEventListener("click", () => {
      addStudentModal.style.display = "none";
    });
  }
  if (closeEditStudentModal && editStudentModal) {
    closeEditStudentModal.addEventListener("click", () => {
      editStudentModal.style.display = "none";
    });
  }
  if (closeDeleteStudentModal && deleteStudentModal) {
    closeDeleteStudentModal.addEventListener("click", () => {
      deleteStudentModal.style.display = "none";
    });
  }

  const editStudentBtns = document.querySelectorAll(".edit-student-btn");
  const editStudentId = document.getElementById("editStudentId");
  const editStudentFname = document.getElementById("editStudentFname");
  const editStudentLname = document.getElementById("editStudentLname");
  const editStudentEmail = document.getElementById("editStudentEmail");
  const editStudentPhone = document.getElementById("editStudentPhone");
  const editStudentClassId = document.getElementById("editStudentClassId");
  const editStudentGenderId = document.getElementById("editStudentGenderId");
  const editStudentDob = document.getElementById("editStudentDob");
  const editStudentPlace = document.getElementById("editStudentPlace");
  const editStudentAddress = document.getElementById("editStudentAddress");
  const editStudentAge = document.getElementById("editStudentAge");

  editStudentBtns.forEach((btn) => {
    btn.addEventListener("click", () => {
      if (!editStudentModal) return;

      if (editStudentId) editStudentId.value = btn.dataset.studentId || "";
      if (editStudentFname)
        editStudentFname.value = btn.dataset.studentFname || "";
      if (editStudentLname)
        editStudentLname.value = btn.dataset.studentLname || "";
      if (editStudentEmail)
        editStudentEmail.value = btn.dataset.studentEmail || "";
      if (editStudentPhone)
        editStudentPhone.value = btn.dataset.studentPhone || "";
      if (editStudentClassId)
        editStudentClassId.value = btn.dataset.studentClassId || "";
      if (editStudentGenderId)
        editStudentGenderId.value = btn.dataset.studentGenderId || "";
      if (editStudentDob) editStudentDob.value = btn.dataset.studentDob || "";
      if (editStudentPlace)
        editStudentPlace.value = btn.dataset.studentPlace || "";
      if (editStudentAddress)
        editStudentAddress.value = btn.dataset.studentAddress || "";
      if (editStudentAge) editStudentAge.value = btn.dataset.studentAge || "";

      editStudentModal.style.display = "flex";
    });
  });

  const deleteStudentBtns = document.querySelectorAll(".delete-student-btn");
  const deleteStudentText = document.getElementById("deleteStudentText");
  const deleteStudentId = document.getElementById("deleteStudentId");

  deleteStudentBtns.forEach((btn) => {
    btn.addEventListener("click", () => {
      if (!deleteStudentModal) return;

      const name = btn.dataset.studentName || "this student";
      if (deleteStudentText)
        deleteStudentText.textContent = `Are you sure you want to delete ${name}?`;
      if (deleteStudentId) deleteStudentId.value = btn.dataset.studentId || "";
      deleteStudentModal.style.display = "flex";
    });
  });

  const editUserModal = document.getElementById("editUserModal");
  const deleteUserModal = document.getElementById("deleteUserModal");
  const closeEditUserModal = document.getElementById("closeEditUserModal");
  const closeDeleteUserModal = document.getElementById("closeDeleteUserModal");
  const editUserId = document.getElementById("editUserId");
  const editUserType = document.getElementById("editUserType");
  const editUserEmail = document.getElementById("editUserEmail");
  const deleteUserText = document.getElementById("deleteUserText");
  const deleteUserId = document.getElementById("deleteUserId");
  const deleteUserType = document.getElementById("deleteUserType");

  if (closeEditUserModal && editUserModal) {
    closeEditUserModal.addEventListener("click", () => {
      editUserModal.style.display = "none";
    });
  }
  if (closeDeleteUserModal && deleteUserModal) {
    closeDeleteUserModal.addEventListener("click", () => {
      deleteUserModal.style.display = "none";
    });
  }

  const editUserBtns = document.querySelectorAll(".edit-user-btn");
  editUserBtns.forEach((btn) => {
    btn.addEventListener("click", () => {
      if (!editUserModal) return;

      if (editUserId) editUserId.value = btn.dataset.userId || "";
      if (editUserType) editUserType.value = btn.dataset.userType || "";
      if (editUserEmail) editUserEmail.value = btn.dataset.userEmail || "";

      editUserModal.style.display = "flex";
    });
  });

  const deleteUserBtns = document.querySelectorAll(".delete-user-btn");
  deleteUserBtns.forEach((btn) => {
    btn.addEventListener("click", () => {
      if (!deleteUserModal) return;

      const userId = btn.dataset.userId || "";
      const userType = btn.dataset.userType || "user";
      if (deleteUserId) deleteUserId.value = userId;
      if (deleteUserType) deleteUserType.value = userType;
      if (deleteUserText)
        deleteUserText.textContent = `Are you sure you want to delete ${userType} #${userId}?`;

      deleteUserModal.style.display = "flex";
    });
  });

  window.addEventListener("click", (e) => {
    const modals = document.querySelectorAll(".modal-container");
    modals.forEach((modal) => {
      if (e.target === modal) {
        modal.style.display = "none";
      }
    });
  });

  initChart();
  initPerformanceChart();
});

function initChart() {
  const el = document.querySelector("#chart");
  if (!el || el.dataset.rendered || typeof ApexCharts === "undefined") return;

  el.dataset.rendered = "1";

  const options = {
    series: [
      {
        name: "Inflation",
        data: [2.3, 3.1, 4.0, 10.1, 4.0, 3.6, 3.2, 2.3, 1.4, 0.8, 0.5, 0.2],
      },
    ],
    chart: { height: 350, type: "bar" },
    plotOptions: {
      bar: { borderRadius: 10, dataLabels: { position: "top" } },
    },
    dataLabels: {
      enabled: true,
      formatter: (v) => v + "%",
      offsetY: -20,
      style: { fontSize: "12px", colors: ["#304758"] },
    },
    xaxis: {
      categories: [
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "May",
        "Jun",
        "Jul",
        "Aug",
        "Sep",
        "Oct",
        "Nov",
        "Dec",
      ],
      position: "top",
      axisBorder: { show: false },
      axisTicks: { show: false },
      crosshairs: {
        fill: {
          type: "gradient",
          gradient: {
            colorFrom: "#D8E3F0",
            colorTo: "#BED1E6",
            stops: [0, 100],
            opacityFrom: 0.4,
            opacityTo: 0.5,
          },
        },
      },
      tooltip: { enabled: true },
    },
    yaxis: {
      axisBorder: { show: false },
      axisTicks: { show: false },
      labels: { show: false, formatter: (v) => v + "%" },
    },
    title: {
      text: "Monthly Inflation in Argentina, 2002",
      floating: true,
      offsetY: 330,
      align: "center",
      style: { color: "#444" },
    },
  };

  new ApexCharts(el, options).render();
}

function initPerformanceChart() {
  const el = document.querySelector("#performanceChart");
  if (!el || el.dataset.rendered || typeof ApexCharts === "undefined") return;

  el.dataset.rendered = "1";

  const options = {
    series: [44, 55, 41, 17, 15],
    chart: { type: "donut", height: 350 },
    labels: ["Excellent", "Good", "Average", "Below Avg", "Poor"],
    responsive: [
      {
        breakpoint: 480,
        options: {
          chart: { width: 200 },
          legend: { position: "bottom" },
        },
      },
    ],
    legend: { position: "right", offsetY: 0, height: 230 },
  };

  new ApexCharts(el, options).render();
}
