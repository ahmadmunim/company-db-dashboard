/*
Write a PL/SQL package specification and body to perform appropriate action. Also 
write a code that calls this procedure.

-The packackage will include procedure, IF conditions,vairables, exception handling

This package will be used by management to remove employee from their company.  
Manager window --> Employee Button --> view employee table --> delete button 

*/

CREATE OR REPLACE 
PACKAGE delete_employee AS
    --Procedure to remove an employee 
    PROCEDURE remove_employee(r_ssn NUMBER);
END delete_employee;
/
CREATE OR REPLACE PACKAGE BODY delete_employee AS
    PROCEDURE remove_employee(r_ssn NUMBER) IS
        --var to deterime if the given essn exists must be greater than 0 if true
        v_exist NUMBER;
    BEGIN
        --checks if the employee ssn exists:
        --Count the number of occurences the given SSN appears in EMPLOYEE table
        SELECT COUNT(*)
        INTO v_exist
        FROM Employee
        WHERE Ssn = r_ssn;

        IF v_exist > 0 THEN
            --Use EXCEUTE IMMEDIATE since DDL such as ALTER TABLE does not work in procedure in PL/SQL
            --Disable the constraint in the works_on table to prevent deleting the project in project table 
            EXECUTE IMMEDIATE 'ALTER TABLE WORKS_ON DISABLE CONSTRAINT WORKS_ON_PNO_FK';
            COMMIT;
            --Delete the employee ssn:
            --on cascade delete - to remove child 
            DELETE FROM EMPLOYEE WHERE Ssn = r_ssn;
            COMMIT;
            --Enable the constraint 
            --EXECUTE IMMEDIATE 'ALTER TABLE WORKS_ON ENABLE CONSTRAINT WORKS_ON_PNO_FK';
            --COMMIT;

            DBMS_OUTPUT.PUT_LINE('Employee SSN Number ' || r_ssn || ' has been removed');
        ELSE
            --'call' the NO_DATA_FOUND exception
           RAISE NO_DATA_FOUND;
        END IF;
    
    EXCEPTION
        WHEN NO_DATA_FOUND THEN
            DBMS_OUTPUT.PUT_LINE('Employee SSN Number ' || r_ssn || ' does not exist');
        WHEN OTHERS THEN
            DBMS_OUTPUT.PUT_LINE('An error occurred: ' || SQLERRM);
    END remove_employee;

END delete_employee;
/

--anonymous block
SET SERVEROUTPUT ON;

DECLARE
    --get employee essn to remove
    v_Ssn NUMBER := &sv_Ssn;
BEGIN
    --call the delete employee package and user provide the essn of the employee they want to remove
    delete_employee.remove_employee(v_Ssn);
END;
/
