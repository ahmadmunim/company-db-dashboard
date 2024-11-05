-- this program allows users to input a project number and outputs said project's information
-- this program will be used by in the manager and client UI to filter for a specific project that they're tasked with
SET SERVEROUTPUT ON;

DECLARE
    -- Anchored type variables based on the database columns
    proj_number    PROJECT.Pnumber%TYPE;
    proj_name      PROJECT.Pname%TYPE;
    proj_start     PROJECT.Pstart_date%TYPE;
    dept_name      DEPARTMENT.Dname%TYPE;
    dept_mgr_ssn   DEPARTMENT.Mgr_ssn%TYPE;

BEGIN
    -- Read data from the user (using substitution variables in SQL*Plus)
    proj_number := '&proj_number';
    
    -- Retrieve project and department information based on the provided project number
    SELECT P.Pname, P.Pstart_date, D.Dname, D.Mgr_ssn
    INTO proj_name, proj_start, dept_name, dept_mgr_ssn
    FROM PROJECT P
    JOIN DEPARTMENT D ON P.Dnum = D.Dnumber
    WHERE P.Pnumber = proj_number;

    -- Print retrieved information
    dbms_output.put_line('Project Information:');
    dbms_output.put_line('-------------------------');
    dbms_output.put_line('Project Number: ' || proj_number);
    dbms_output.put_line('Project Name: ' || proj_name);
    dbms_output.put_line('Project Start Date: ' || TO_CHAR(proj_start, 'DD-MON-YYYY'));
    dbms_output.put_line('Department: ' || dept_name);
    dbms_output.put_line('Department Manager SSN: ' || dept_mgr_ssn);
    
EXCEPTION
    WHEN NO_DATA_FOUND THEN
        dbms_output.put_line('No project found with the specified project number.');
    WHEN OTHERS THEN
        dbms_output.put_line('An unexpected error occurred: ' || SQLERRM);
END;
/