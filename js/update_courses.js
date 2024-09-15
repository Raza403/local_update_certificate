document.addEventListener('DOMContentLoaded', function() {
    const studentSelect = document.querySelector('[name="userid"]');
    const courseSelect = document.querySelector('[name="courseid"]');

    studentSelect.addEventListener('change', function() {
        const userid = this.value;

        if (userid) {
            fetch(M.cfg.wwwroot + '/local/update_certificate/ajax.php?userid=' + userid)
            .then(response => response.json())
            .then(data => {
                // Clear existing options in course select
                courseSelect.innerHTML = '';

                // Add a placeholder option
                let placeholderOption = new Option('Select a course', '');
                courseSelect.append(placeholderOption);

                // Populate the courses
                data.courses.forEach(function(course) {
                    let option = new Option(course.fullname, course.id);
                    courseSelect.append(option);
                });
            })
            .catch(error => console.error('Error fetching courses:', error));
        } else {
            courseSelect.innerHTML = ''; // Clear if no student is selected
        }
    });
});
