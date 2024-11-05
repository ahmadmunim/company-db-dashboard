/*
Write a PL/SQL package specification and body to perform appropriate action. Also 
write a code that calls this procedure

Structure of package: https://www.geeksforgeeks.org/plsql-packages/ 


Query:
PROMPT 10.List the Male employees that worked on product Z.
SELECT e.*
FROM EMPLOYEE e 
JOIN WORKS_ON wo  ON e.Ssn = wo.ESsn
JOIN PROJECT p  ON wo.Pno = p.Pnumber
WHERE e.Sex = 'M' AND p.Pname = 'ProductZ'

*****change to manager ****

Modified Program:
This package will be used by the client to create projects in the client window --> project button
then manager can use this to determine how many projects are there in the manager window -->assign project 
    -manager knows how many projects are there currently instead of filtering it by gender
*/

CREATE OR REPLACE 
PACKAGE project_info AS
    --Procedure to add new projects 
    PROCEDURE create_project(p_Pnumber NUMBER, p_Pname VARCHAR2, p_Dnum NUMBER, p_Pstart_date DATE);

    --Function to determine the total number of projects:
    FUNCTION num_projects  RETURN NUMBER;

END project_info;
/
--Package Body:
CREATE OR REPLACE PACKAGE BODY project_info AS
    --Procedure: to create projects
    PROCEDURE create_project(p_Pnumber NUMBER, p_Pname VARCHAR2, p_Dnum NUMBER, p_Pstart_date DATE) IS
    BEGIN
        INSERT INTO PROJECT (Pnumber, Pname, Dnum, Pstart_date)
        VALUES (p_Pnumber, p_Pname, p_Dnum, p_Pstart_date);
        
        -- Save updated table with new insert values
        COMMIT;
    
    EXCEPTION
        WHEN DUP_VAL_ON_INDEX THEN
            DBMS_OUTPUT.PUT_LINE('Project Number ' || p_Pnumber || ' already exists');
    END create_project;

    --Function: determine total num of projects
    FUNCTION num_projects RETURN NUMBER IS
        total_projects NUMBER;
    BEGIN
        SELECT COUNT(*)
        INTO total_projects
        FROM PROJECT;

        RETURN total_projects;
    EXCEPTION
        WHEN OTHERS THEN
            DBMS_OUTPUT.PUT_LINE(SQLERRM);
            RETURN NULL;
    END num_projects;

END project_info;
/

--Call the package by using an anonymous block
SET SERVEROUTPUT ON;

DECLARE
    -- Enter project number
    v_Pnumber NUMBER := &sv_Pnumber;
    -- Enter project name (note: ensure to provide a proper string value)
    v_Pname VARCHAR2(15) := '&sv_Pname';
    -- Enter department number: MUST BE AN EXISTING DEPARTMENT
    v_Dnum NUMBER := &sv_Dnum;
    -- Enter project start date
    v_Pstart_date DATE := TO_DATE('&sv_Pstart_date','YYYY-MM-DD');
    -- Variable to hold the total number of projects
    total_num NUMBER;

BEGIN
    -- Call the procedure in the package to create a project
    project_info.create_project(v_Pnumber, v_Pname, v_Dnum, v_Pstart_date);

    -- Call the function in the package to determine the total number of projects in each department 
    total_num := project_info.num_projects;
    DBMS_OUTPUT.PUT_LINE('Total projects  '||  total_num);

END;
/





