// File: /local/update_certificate/js/autocomplete.js

document.addEventListener('DOMContentLoaded', function() {
    var userInput = document.querySelector('[name="userid"]');
    var courseInput = document.querySelector('[name="courseid"]');

    // Function to fetch user suggestions
    function fetchUserSuggestions(query) {
        return fetch(M.cfg.wwwroot + '/local/update_certificate/ajax.php?query=' + encodeURIComponent(query))
            .then(response => response.json())
            .then(data => data.suggestions);
    }

    // Initialize autocomplete for user input
    new Autocomplete(userInput, {
        source: function(query, response) {
            fetchUserSuggestions(query).then(response);
        }
    });

    // Fetch courses based on selected student
    userInput.addEventListener('change', function() {
        const userid = this.value;

        if (userid) {
            fetch(M.cfg.wwwroot + '/local/update_certificate/ajax.php?userid=' + userid)
            .then(response => response.json())
            .then(data => {
                let courseSelect = document.querySelector('[name="courseid"]');
                courseSelect.innerHTML = ''; // Clear existing options
                data.courses.forEach(function(course) {
                    let option = new Option(course.fullname, course.id);
                    courseSelect.append(option);
                });
            });
        }
    });
});
