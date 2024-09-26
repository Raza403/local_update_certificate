# Update course completion date

**Plugin name:** Update certificate (update course completion date)  
**Version:** 1.0.0  
**Moodle version:** 4.4 or later  
**Author:** Ahmed Raza

## Description

This Moodle plugin allows site administrators to update the course completion date and manage the "renew by" date for enrolled students. The plugin provides a simple interface where administrators can:

- Select a student.
- Choose a course the student is enrolled in (dynamically updated via AJAX).
- Pick a new completion date from a calendar.
- Apply the new date by updating the Moodle database (`mdl_course_completions` table).
- Manage the "renew by" date via the Moodle grading system by updating the `timemodified` field in `mdl_grade_grades` table.

The plugin is particularly useful for administrators who need to correct or modify course completion dates and ensure compliance with "renew by" requirements for certain activities.

### Background

This plugin was developed to address the need for backdating course completion dates and managing "renew by" dates in Moodle. In some cases, instructors conduct skills tests for students, complete paperwork, and then submit results a day or two later. Certificates must reflect the actual date the test was taken. Additionally, some courses require students to complete a "renew by" activity, which must be checked before updating the completion date.

## Features

- **Select student:** An auto-complete search field to select a student from the system.
- **Select course:** A dynamically updated dropdown list that displays all courses the selected student is enrolled in.
- **Completion date:** A calendar input for selecting the desired completion date (defaults to the current date).
- **"Renew by" check:** Before updating the course completion date, the plugin checks whether the student has completed the "renew by" activity (based on `mdl_grade_items` and `mdl_grade_grades` tables). If not completed, an error message is displayed, prompting the user to complete the activity first.
- **Success/failure messages:** Bootstrap-styled alert messages are displayed after submission, indicating whether the operation was successful or not.
- **Form reset:** The form is automatically reset after submission for further updates.

## Installation

1. Download or clone this repository into your Moodle installation's `local/` directory:
   ```bash
   git clone git@github.com:Raza403/update_certificate.git /path/to/moodle/local/update_certificate
    ```
2. Go to your Moodle site and navigate to Site administration > Notifications to complete the installation.
3. Once installed, the plugin will be accessible to administrators at the following URL:
    ```bash
    [your-moodle-site]/local/update_certificate/index.php
    ```

## Usage

1. Navigate to the "Update course completion date" page via the plugin's URL.
2. Select a student using the auto-complete search box.
3. Once a student is selected, the "Select course" dropdown will be dynamically populated with courses the student is enrolled in.
4. Choose the desired course from the dropdown list.
5. Verify "renew by" completion: The plugin will check if the student has completed the "renew by" activity. If not, an error message will prompt the administrator to ensure the student completes it before proceeding.
6. Select a new course completion date using the calendar.
7. Click "Set completion date" to apply the change.


A success message will be displayed if the operation is successful, and the form will reset for further entries. If an error occurs, an error message will appear.

### "Renew by" functionality

1. The plugin checks the `mdl_grade_items` table for an entry with `idnumber = 999` (representing the "renew by" activity) for the selected course.
2. If a corresponding entry is found, it retrieves the `itemid` and checks the `timemodified` field in the `mdl_grade_grades` table for the selected student.
3. If the `timemodified` field is `null`, the user is prompted to complete the "renew by" activity first.
4. If the activity has been completed, the `timemodified` field is updated to the new date provided by the administrator.

## Customization

### Language strings

To customize text displayed by the plugin, modify the strings in the language file:
```bash
/local/update_certificate/lang/en/local_update_certificate.php
```

### Example:
```php
$string['pluginname'] = 'Update course completion date';
$string['selectstudent'] = 'Select student';
$string['selectcourse'] = 'Select course';
$string['Issuedate'] = 'Select date';
$string['setcompletiondate'] = 'Set completion date';
$string['completiondateset'] = 'Completion date has been set.';
$string['error'] = 'An error occurred. Please try again.';
```

## Known issues


- The plugin relies on AJAX calls to dynamically update the course dropdown list based on the selected student. Ensure that JavaScript is enabled in your browser.
- If no courses are available for the selected student, the dropdown list will remain empty.
- The "renew by" check requires specific configuration in the Moodle grading system, with an activity labeled with `idnumber = 999` to identify the renew by activity.

## License

This plugin is licensed under the GNU General Public License, version 3 or later.