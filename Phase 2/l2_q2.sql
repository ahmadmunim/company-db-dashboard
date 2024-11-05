/*
Write a PL/SQL code to declare variables of anchored type belonging to type of at 
least one or two columns of your database. Your code should also read data from the 
keyboard and include appropriate executable section instructions to print some values. 

Prompt the user to enter the name of employee to determine the role:

--19.Display the roles of each employee 
PROMPT 19 .Display the roles of each employee 
SELECT e.fname, e.lname , r.rname
FROM employee e
JOIN roles r on e.rno = r.rno;

This will be implemented in employee button in the manager's window to show what role each employee 
is assigned as. Can be used to modify the roles later.
*/

SET SERVEROUTPUT ON;
DECLARE
    --use %TYPE to get the same data type as the attribute in the table
	v_fname EMPLOYEE.fname % TYPE := '&sv_fname';
    v_lname EMPLOYEE.lname % TYPE := '&sv_lname';
    
    --the result of the query will be stored into this variable
    v_result_info VARCHAR2(500);
BEGIN

    SELECT CONCAT(CONCAT(fname, ' '), CONCAT(CONCAT(lname, '''s role is the '),r.rname)) 
    INTO v_result_info
    FROM EMPLOYEE e
    JOIN ROLES r ON e.rno = r.rno
    WHERE e.fname = v_fname AND e.lname = v_lname;

    DBMS_OUTPUT.PUT_LINE (v_result_info);
END;
/
