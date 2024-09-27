document.addEventListener('DOMContentLoaded', function() {
    var userInput = document.querySelector('[name="userid"]');
    var courseInput = document.querySelector('[name="courseid"]');
    var renewByDateRow = document.querySelector('#id_renewbydate'); // The renewbydate row in the form

    // Hide the renewbydate field initially
    renewByDateRow.style.display = 'none';

    // Fetch courses based on selected student
    userInput.addEventListener('change', function() {
        const userid = this.value;

        if (userid) {
            fetch(M.cfg.wwwroot + '/local/update_certificate/ajax.php?userid=' + userid)
            .then(response => response.json())
            .then(data => {
                let courseSelect = document.querySelector('[name="courseid"]');
                courseSelect.innerHTML = ''; // Clear existing options

                // Populate the course select dropdown
                data.courses.forEach(function(course) {
                    let option = new Option(course.fullname, course.id);
                    courseSelect.append(option);
                });

                // Check if only one course is returned and if its ID is 14
                if (data.courses.length === 1 && data.courses[0].id == 14) {
                    renewByDateRow.style.display = ''; // Show the renewbydate row
                } else {
                    renewByDateRow.style.display = 'none'; // Hide the renewbydate row
                }
            });
        }
    });

    // Add event listener for course selection to handle the second condition
    courseInput.addEventListener('change', function() {
        const courseId = this.value;

        // Show the renewbydate field if the selected course ID is 14
        if (courseId == 14) {
            renewByDateRow.style.display = ''; // Show the renewbydate row
        } else {
            renewByDateRow.style.display = 'none'; // Hide the renewbydate row
        }
    });
});
