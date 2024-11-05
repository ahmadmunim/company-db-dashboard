-- Package Specification
CREATE OR REPLACE 
PACKAGE assign_emp_pkg AS
    -- Procedure to assign an employee to a project
    PROCEDURE assign_emp_to_project(p_Essn VARCHAR2, p_Pnumber NUMBER, p_Hours NUMBER);
END assign_emp_pkg;
/

-- Package Body
CREATE OR REPLACE PACKAGE BODY assign_emp_pkg AS
    -- Procedure: to assign an employee to a project
    PROCEDURE assign_emp_to_project(p_Essn VARCHAR2, p_Pnumber NUMBER, p_Hours NUMBER) IS
    BEGIN 
        INSERT INTO WORKS_ON (Essn, Pno, HOURS)
        VALUES (p_Essn, p_Pnumber, p_Hours);
        COMMIT;

    EXCEPTION
        WHEN DUP_VAL_ON_INDEX THEN  
            DBMS_OUTPUT.PUT_LINE('Employee with ' || p_Essn || ' is already assigned to project number ' || p_Pnumber);
    
    END assign_emp_to_project;

END assign_emp_pkg;
/

-- Anonymous Block to Call the Procedure
SET SERVEROUTPUT ON;

DECLARE
    v_Essn VARCHAR2(9) := '&sv_Essn'; -- Enter employee SSN
    v_Pnumber NUMBER := &sv_Pnumber; -- Enter project number
    v_Hours NUMBER := &sv_Hours; -- Enter number of hours worked on the project
BEGIN
    -- Call the procedure to assign an employee to a project
    assign_emp_pkg.assign_emp_to_project(v_Essn, v_Pnumber, v_Hours);
    DBMS_OUTPUT.PUT_LINE('Employee ' || v_Essn || ' assigned to project number ' || v_Pnumber || ' for ' || v_Hours || ' hours.');
END;
/
