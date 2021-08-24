# Entities Error:

Having one table to store instructors, instructors degree, and faculties is an error

## Solution:

- Create instructor table
- Create degree table
- Create faculty table

# Attributes Error:

- Different attributes can't be joined togather with one attribute ( MS in Computer Science, 2018, AUB) ( degree type in field, date, university)
- Faculty can't have the faculty instructors names as their attributes
- Wrong naming conventions

## Solution:

- Add first_name, last_name attributes to instructor
- Add degree_type, date, and field attributes to degree table
- Add name, code attributes for the faculty table

#### Follow the naming conventions
