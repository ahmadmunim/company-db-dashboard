-- This program lists how many dependents each employee has
-- The manager will be able to see how many dependents an employee has when they view the employee table
SET SERVEROUTPUT ON;

DECLARE
    -- Cursor to select each employee's SSN, first name, and last name
    CURSOR emp_cursor IS
        SELECT Ssn, Fname, Lname
        FROM EMPLOYEE;

    -- Variables to store data from the cursor
    emp_ssn        EMPLOYEE.Ssn%TYPE;
    emp_fname      EMPLOYEE.Fname%TYPE;
    emp_lname      EMPLOYEE.Lname%TYPE;

    -- Variable to store the dependent count for each employee
    dependent_count NUMBER;

BEGIN
    -- Open the cursor and loop through each employee
    OPEN emp_cursor;
    LOOP
        -- Fetch each employee's details
        FETCH emp_cursor INTO emp_ssn, emp_fname, emp_lname;
        EXIT WHEN emp_cursor%NOTFOUND;  -- Exit loop when no more employees

        -- Count the number of dependents for the current employee
        SELECT COUNT(*)
        INTO dependent_count
        FROM DEPENDENT
        WHERE Essn = emp_ssn;

        -- Print the result for each employee
        dbms_output.put_line('Employee: ' || emp_fname || ' ' || emp_lname);
        dbms_output.put_line('Dependent Count: ' || dependent_count);
        dbms_output.put_line('-----------------------------');
    END LOOP;

    -- Close the cursor
    CLOSE emp_cursor;
    
EXCEPTION
    WHEN OTHERS THEN
        dbms_output.put_line('An unexpected error occurred: ' || SQLERRM);
END;
/