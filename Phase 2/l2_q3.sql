/*
Write a PL/SQL code that uses nested conditional statement(s) to implement 
appropriate actions printing some output.

Classifying the projects into different categories, HIGH, MEDIUM, LOW effort in terms of works on hours:

Query to determine how many hours in total is worked on each project:
SELECT SUM(hours) AS total_hours
        FROM works_on
        WHERE pno = v_pNumber
        GROUP BY pno ;

This will be implemented in Management window of Assigned Projects button to determine 
which project requires the most hours and if needed assign more employees or decrease the number of employees working 
on that project
*/


/*
select pno, SUM(hours) as total_hours
from works_on
group by pno
*/
SET SERVEROUTPUT ON;
DECLARE
    --get user input for project number
    v_pNumber NUMBER := &sv_pNumber;

    v_total_hours NUMBER;


    --use cursor to "search" through the table to get the given project
    CURSOR c1 is
        SELECT SUM(hours) AS total_hours
        FROM works_on
        WHERE pno = v_pNumber
        GROUP BY pno ;
BEGIN
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
    --project number DNE - does not exists
    ELSE
        DBMS_OUTPUT.PUT_LINE('Project Does not exists');

    END IF;

END;
/




