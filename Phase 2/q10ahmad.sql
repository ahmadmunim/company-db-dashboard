-- This program counts the total number of hours an employee is working and outputs if they're working overtime (> 40 hours)
-- This will be used by the manager when checking the work their employees are doing in the manager window

SET SERVEROUTPUT ON;

DECLARE
    emp_ssn CHAR(9) := '&emp_ssn'; -- asks user to input employee ssn
    total_hours DECIMAL(3,1);
BEGIN
    -- sums all of the hours employees are putting into all projects they're assigned
    SELECT SUM(HOURS) INTO total_hours FROM WORKS_ON 
    WHERE Essn = emp_ssn;

    -- checks if total hours is greater than 40 and outputs if the employee is working overtime
    IF total_hours > 40 THEN
        dbms_output.put_line('Employee working ' || total_hours - 40 || ' overtime');
    ELSE
        dbms_output.put_line('Employee not working overtime');
    END IF;
EXCEPTION
    WHEN NO_DATA_FOUND THEN
        dbms_output.put_line('No paystub found for the specified employee SSN.');
    WHEN OTHERS THEN
        dbms_output.put_line('An unexpected error occurred: ' || SQLERRM);
END;
/