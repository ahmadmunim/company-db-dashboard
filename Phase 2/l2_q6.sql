/*
Write a PL/SQL procedure with parameters to perform appropriate action. Also write 
the anonymous block that calls this procedure. 

The following procedure get employee contact information from the manager window through the 
get employee contact information button 

From Lab1 :
PROMPT 3. List the contact information of an employee who is female 
SELECT * 
FROM contact
WHERE contact.ssn IN
    (
        SELECT employee.ssn
        FROM employee
        WHERE sex = 'F'
    );

But modified to (PL/SQL):
        SELECT *
		FROM EMP_CONTACT
		WHERE Essn = essnIN;

where essnIN is the input essn from user such as manager to find an employee contact info for business purposes

*/

--https://www.oracletutorial.com/plsql-tutorial/plsql-procedure/ 

CREATE OR REPLACE
	PROCEDURE display_emp_contact( essnIN IN NUMBER)
	IS
    employee_contact EMP_CONTACT%ROWTYPE;

    --get the employee contact information based on essn 
	BEGIN
		SELECT *
		INTO employee_contact
		FROM EMP_CONTACT
		WHERE Essn = essnIN;

        --display the contact information:
        DBMS_OUTPUT.PUT_LINE(employee_contact.Essn  || ' ' || employee_contact.phone || ' ' || employee_contact.email );
    EXCEPTION
		WHEN NO_DATA_FOUND THEN
        DBMS_OUTPUT.PUT_LINE ('Contact info for Essn of ' || essnIN || ' does not exist');
END;
/

--Anonymous pl/sql block
SET SERVEROUTPUT ON;

DECLARE 
    --variable to hold the user input of employee id
    v_enterEssn NUMBER := &essn;
BEGIN 
    --call the procdure and pass in the user input
    display_emp_contact(v_enterEssn);
END;
/
