# Lecture Scheduling Module  

This project is a Lecture Scheduling System designed for managing courses, lectures, and instructors efficiently. The system includes an Admin Panel for managing schedules and an Instructor Panel for instructors to view their assigned lectures.  

## Features  

1) Admin Panel  
- Login: Secure login for admin access.  
- View Instructors: Display a list of all registered instructors in Dropdown.  
- Add Courses:
  - Add course details, including:  
    - Name  
    - Level  
    - Description  
    - Image  
  - Ability to manage multiple batches for each course by using Batch Number.  
- Add Lectures: 
  - Assign lectures to specific instructors and batches.  
  - Ensure no scheduling conflicts:  
    - Prevent assigning multiple lectures to the same instructor on the same date.  
- Dashboard Overview:
  - Summary of courses, lectures, and instructor data.  

2) Instructor Panel  
- Login: Secure login for instructors.  
- View Assigned Lectures: 
  - List of lectures with details such as course name, date, and batch number.  

3) Registration  
- User Registration: Admins and instructors can register.  
- Password Validation: 
  - Minimum 8 characters.  
  - At least one uppercase letter.  
  - At least one number.  
  - At least one special character.  

4) Logout  
-  logout functionality for both admin and instructors.  

## Steps to Run the project


1. Download the Project  
   - Download the project from Google Drive, extract it, and place it in `C:\xampp\htdocs\`.

2. Set Up the Database
   - Open (http://localhost/phpmyadmin) in your browser.  
   - Create a database (e.g., `lecturesschedule`).  
   - Import the `database.sql` file from the project folder.

3. Update Database Configuration
   - Open `db.php` and ensure the connection settings match your setup:  
     ```php
     $conn = mysqli_connect("localhost", "root", "", "lecturesschedule");
     ```

4. Run the Project 
   - Open your browser and navigate to:  
     ```
     http://localhost/LecturesSchedule
     ```
   - Use the login or register page to access the system. 



