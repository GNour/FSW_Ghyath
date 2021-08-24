# 1 . Select all the degrees of all the instructors in this university

SELECT *
FROM degree;

# 2 . Select the first name of the instructors who earned an MS degree in Computer Science

SELECT i.first_name
FROM instructor as i,degree as d
WHERE degree_type = "MS" AND field = "Computer Science" AND i.instructor_id = d.instructor_instructor_id; 

# 3 . Delete all instructors

DELETE FROM instructor;

# 4 . Add instructor

INSERT INTO `instructor`(`instructor_id`, `first_name`, `last_name`, `faculty_faculty_id`) VALUES (NULL,'NEW','Instructor',1)


