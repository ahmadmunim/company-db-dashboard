/*
 Write a PL/SQL code to create a trigger to perform appropriate action as well as the 
code to show the effect of this trigger  

The program will be used when employee or manager changes their contact 
information through the Manager window --> employee button --> edit button


--14. Rename project name
PROMPT 14. Replace the project name
SELECT REPLACE (pname,'ProductX','ProductA') AS updated_pname, pnumber 
FROM project;

*/

--Trigger when employee changes their phone number:
CREATE OR REPLACE TRIGGER project_update
BEFORE UPDATE ON PROJECT
FOR EACH ROW
WHEN (NVL(NEW.Pname, ' ') <> OLD.Pname)
BEGIN
    DBMS_OUTPUT.PUT_LINE('Project name has been changed from ' || :OLD.Pname || ' to ' || :NEW.Pname);
END;
/

--Test the trigger:
SET SERVEROUTPUT ON;

DECLARE 

    --get updated phone number
    v_updated_project_name VARCHAR2(12) := '&sv_updated_project_name';
    v_project_name VARCHAR2(12) := '&sv_project_name';

BEGIN 


    --update the phone number
    UPDATE PROJECT
    SET Pname = v_updated_project_name
    WHERE Pname = v_project_name;

    COMMIT;

    DBMS_OUTPUT.PUT_LINE('Project name has been changed');

EXCEPTION
    WHEN NO_DATA_FOUND THEN
        DBMS_OUTPUT.PUT_LINE('No project with that name ' || v_project_name);

END;
/




