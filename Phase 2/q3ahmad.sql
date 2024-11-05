-- This program filters projects based on what department they're assigned to.
-- This will be used in the manager UI where managers can only view projects that are assigned to the department they're supervising
SET SERVEROUTPUT ON;

DECLARE
    dept_number    PROJECT.Dnum%TYPE := &Enter_Department_Number;  -- Prompt for department number
    proj_name      PROJECT.Pname%TYPE;
    error_message  VARCHAR2(200);

BEGIN
    -- Cursor to retrieve projects filtered by department number
    FOR proj_rec IN (SELECT Pname, Dnum 
                     FROM PROJECT 
                     WHERE Dnum = dept_number) LOOP
        -- Display each project's details
        dbms_output.put_line('Project Name: ' || proj_rec.Pname || ', Department: ' || proj_rec.Dnum);
    END LOOP;

    -- Check if no projects were found for the given department number
    IF SQL%ROWCOUNT = 0 THEN
        error_message := 'No projects found for Department Number ' || dept_number;
        dbms_output.put_line(error_message);
    END IF;

EXCEPTION
    WHEN OTHERS THEN
        error_message := 'An unexpected error occurred: ' || SQLERRM;
        dbms_output.put_line(error_message);
END;
/