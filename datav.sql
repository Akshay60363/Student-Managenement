CREATE DATABASE IF NOT EXISTS ruas3;
USE ruas3;

-- Branches Table
DROP TABLE IF EXISTS Branches;
CREATE TABLE Branches (
    BranchID INT PRIMARY KEY,
    BranchName VARCHAR(100) NOT NULL,
    Location VARCHAR(255),
    ContactNumber VARCHAR(15)
);

-- Students Table
DROP TABLE IF EXISTS Students;
CREATE TABLE Students (
    StudentID INT PRIMARY KEY AUTO_INCREMENT,
    FirstName VARCHAR(50) NOT NULL,
    LastName VARCHAR(50) NOT NULL,
    Address VARCHAR(255),
    ContactNumber VARCHAR(15),
    BranchID INT,
    Password VARCHAR(255) NOT NULL,
    CONSTRAINT fk_students_branch FOREIGN KEY (BranchID) REFERENCES Branches(BranchID)
);

-- FeePayments Table
DROP TABLE IF EXISTS FeePayments;
CREATE TABLE FeePayments (
    PaymentID INT PRIMARY KEY,
    StudentID INT,
    Amount DECIMAL(10, 2) NOT NULL,
    PaymentDate DATE NOT NULL,
    CONSTRAINT fk_feepayments_student FOREIGN KEY (StudentID) REFERENCES Students(StudentID)
);

-- ExamResults Table
DROP TABLE IF EXISTS ExamResults;
CREATE TABLE ExamResults (
    ResultID INT PRIMARY KEY,
    StudentID INT,
    Subject VARCHAR(50) NOT NULL,
    Marks INT,
    Grade VARCHAR(2),
    CONSTRAINT fk_examresults_student FOREIGN KEY (StudentID) REFERENCES Students(StudentID)
);

-- Courses Table
DROP TABLE IF EXISTS Courses;
CREATE TABLE Courses (
    CourseID INT PRIMARY KEY,
    CourseName VARCHAR(100) NOT NULL,
    Department VARCHAR(100),
    Duration INT,
    facultyname VARCHAR(100),
    Credits INT
);

-- Enrollments Table
DROP TABLE IF EXISTS Enrollments;
CREATE TABLE Enrollments (
    EnrollmentID INT PRIMARY KEY  AUTO_INCREMENT,
    StudentID INT,
    CourseID INT,
    EnrollmentDate DATE NOT NULL,
    CONSTRAINT fk_enrollments_student FOREIGN KEY (StudentID) REFERENCES Students(StudentID),
    CONSTRAINT fk_enrollments_course FOREIGN KEY (CourseID) REFERENCES Courses(CourseID)
);

-- CourseFeedback Table
DROP TABLE IF EXISTS CourseFeedback;
CREATE TABLE CourseFeedback (
    FeedbackID INT PRIMARY KEY,
    EnrollmentID INT,
    FeedbackText TEXT,
    Rating INT,
    CONSTRAINT fk_coursefeedback_enrollment FOREIGN KEY (EnrollmentID) REFERENCES Enrollments(EnrollmentID)
);

-- CourseAttendance Table
DROP TABLE IF EXISTS CourseAttendance;
CREATE TABLE CourseAttendance (
    AttendanceID INT PRIMARY KEY,
    EnrollmentID INT,
    Date DATE NOT NULL,
    Status VARCHAR(10) NOT NULL,
    CONSTRAINT fk_attendance_enrollment FOREIGN KEY (EnrollmentID) REFERENCES Enrollments(EnrollmentID)
);



-- Insert values into Branches Table
INSERT INTO Branches (BranchID, BranchName, Location, ContactNumber)
VALUES
(1, 'Computer Science', 'Main Campus', '123-456-7890'),
(2, 'Electrical Engineering', 'Main Campus', '987-654-3210'),
(3, 'Mechanical Engineering', 'Main Campus', '456-789-0123');

ALTER TABLE Students
ADD COLUMN Semester INT,
ADD COLUMN AcademicYear VARCHAR(10);

-- Insert values into Students Table (Remember to hash the passwords before inserting)
INSERT INTO Students (StudentID, FirstName, LastName, Address, ContactNumber, BranchID, Password,Semester, AcademicYear)
VALUES
(1, 'John', 'Doe', '123 Main St', '987-654-3211', 1, 'hashed_password_here',4,'2ndyear'),
(2, 'Jane', 'Smith', '456 Oak St', '789-012-3456', 2, 'another_hashed_password',3,'2ndyear');

-- Insert values into Courses Table
INSERT INTO Courses (CourseID, CourseName, Department, Duration, facultyname, Credits)
VALUES
(201, 'Introduction to Programming', 'Computer Science', 12, 'george', 3),
(202, 'Circuit Analysis', 'Electrical Engineering', 14, 'tom', 4),
(203, 'Thermodynamics', 'Mechanical Engineering', 16, 'walter white', 4);

-- Insert values into Enrollments Table
INSERT INTO Enrollments (EnrollmentID, StudentID, CourseID, EnrollmentDate)
VALUES
(301, 1, 201, '2023-01-15'),
(302, 2, 202, '2023-01-16');

-- Insert values into FeePayments Table
INSERT INTO FeePayments (PaymentID, StudentID, Amount, PaymentDate)
VALUES
(401, 1, 1000.00, '2023-01-15'),
(402, 2, 1200.00, '2023-01-16');

-- Insert values into ExamResults Table
INSERT INTO ExamResults (ResultID, StudentID, Subject, Marks, Grade)
VALUES
(501, 1, 'Programming Fundamentals', 85, 'A'),
(502, 2, 'Circuit Theory', 78, 'B');

-- Insert values into CourseFeedback Table
INSERT INTO CourseFeedback (FeedbackID, EnrollmentID, FeedbackText, Rating)
VALUES
(601, 301, 'Great course, loved the content!', 5),
(602, 302, 'Good instructor, clear explanations.', 4);

-- Insert values into CourseAttendance Table
INSERT INTO CourseAttendance (AttendanceID, EnrollmentID, Date, Status)
VALUES
(701, 301, '2023-02-01', 'Present'),
(702, 302, '2023-02-01', 'Present');
