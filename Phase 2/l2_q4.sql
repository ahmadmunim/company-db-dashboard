/*
Write a PL/SQL code that includes EXCEPTION section and handles an exception 
using a variable declared in the code.

Classifying the projects into different categories, HIGH, MEDIUM, LOW effort in terms of works on hours:

Previous query:
PROMPT 11.Total number of hours worked on project #10 
SELECT SUM (HOURS) AS Total_Hours
FROM WORKS_ON
WHERE Pno = 10;


Query to determine how many hours in total is worked on each project:
SELECT SUM(hours) AS total_hours
        FROM works_on
        WHERE pno = v_pNumber
        GROUP BY pno ;

This will be implemented in Management window of Assigned Projects button to determine 
which project requires the most hours and if needed assign more employees or decrease the number of employees working 
on that project.
Same as Question 3 but modified with exception handling. 
*/

SET SERVEROUTPUT ON;
DECLARE
    --get user input for project number
    v_pNumber VARCHAR2(2) := '&sv_pNumber';
    v_pNumberN NUMBER;

    v_total_hours NUMBER;


    --use cursor to "search" through the table to get the given project
    CURSOR c1 is
        SELECT SUM(hours) AS total_hours
        FROM works_on
        WHERE pno = v_pNumberN
        GROUP BY pno ;
BEGIN

    --Convert user input from varchar2 to number in order to raise the value_error exception
    --value_error exception will occurr if there is a conversion mismatch error S#76 
    v_pNumberN := TO_NUMBER(v_pNumber);
    
    OPEN c1;
    --store the hours into v_total_hours 
    FETCH c1 INTO v_total_hours;
    CLOSE c1;

    --total hours is not null
    IF v_total_hours IS NOT NULL THEN
        
        --less than 10 hours: LOW
        IF v_total_hours <=10 THEN
            DBMS_OUTPUT.PUT_LINE('Project Effort Category:  LOW');
        
        --less than 30 hours but greater than 10: MEDIUM
        ELSIF v_total_hours >10 AND v_total_hours <= 30 THEN
            DBMS_OUTPUT.PUT_LINE('Project Effort Category:  MEDIUM');

        --total hours of project worked on has more than 30 hours: HIGH
        ELSE 
            DBMS_OUTPUT.PUT_LINE('Project Effort Category:  HIGH');
        END IF;     
    
        ELSE
            DBMS_OUTPUT.PUT_LINE('Total hours is NULL');
            --'call' the no data found exception
            RAISE NO_DATA_FOUND;
    END IF;

--Q4: ADD EXCEPTION HANDLING:
EXCEPTION
    --use NO DATA FOUND when it does not return any valid project (no rows)
    WHEN NO_DATA_FOUND THEN 
        DBMS_OUTPUT.PUT_LINE('Project does not exists');
        --use VALUE ERROR when the given project number is not a number
    WHEN VALUE_ERROR THEN
         DBMS_OUTPUT.PUT_LINE('Enter a numeric value for project number');
END;
/