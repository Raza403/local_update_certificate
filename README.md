# Update course completion date

**Plugin name:** Update certificate (update course completion date)  
**Version:** 1.0.0  
**Moodle version:** 4.4 or later  
**Author:** Ahmed Raza

## Description

This Moodle plugin allows site administrators to update the course completion date for any enrolled student. The plugin provides a simple interface where administrators can:

- Select a student.
- Choose a course the student is enrolled in (dynamically updated via AJAX).
- Pick a new completion date from a calendar.
- Apply the new date by updating the Moodle database (`mdl_course_completions` table).

The plugin is particularly useful for administrators who need to correct or modify course completion dates without directly accessing the database.

### Background

This plugin was developed to address the need for backdating course completion dates. In our case, instructors conduct skills tests for students, complete paperwork, and then submit results a day or two later. Certificates must reflect the actual date the test was taken, but Moodle only allows course completion and certificate issuance on the current date. This plugin solves that issue by allowing administrators to update the course completion date to match the actual date of the skills test.

## Features

- **Select student**: An auto-complete search field to select a student from the system.
- **Select course**: A dynamically updated dropdown list that displays all courses the selected student is enrolled in.
- **Completion date**: A calendar input for selecting the desired completion date (defaults to the current date).
- **Success/failure messages**: Bootstrap-styled alert messages are displayed after submission, indicating whether the operation was successful or not.
- **Form reset**: The form is automatically reset after submission for further updates.

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
5. Select a new course completion date using the calendar.
6. Click "Set completion date" to apply the change.

A success message will be displayed if the operation is successful, and the form will reset for further entries. If an error occurs, an error message will appear.

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
$string['selectdate'] = 'Select date';
$string['setcompletiondate'] = 'Set completion date';
$string['completiondateset'] = 'Completion date has been set.';
$string['error'] = 'An error occurred. Please try again.';
```

## Known issues

- The plugin relies on AJAX calls to dynamically update the course dropdown list based on the selected student. Ensure that JavaScript is enabled in your browser.
- If no courses are available for the selected student, the dropdown list will remain empty.

## License

This plugin is licensed under the GNU General Public License, version 3 or later.