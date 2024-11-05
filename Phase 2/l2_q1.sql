/*
The following PL/SQL code will get ESSN input from user to display their most 
recent paystub.

--15. Retrive paystub with format with time stamp:
PROMPT 15. Retrive paystub with format with time stamp:
SELECT e.fname, e.lname, e.Ssn, 
       TO_CHAR(SUM(p.Net_pay), '$999,999.99') AS Total_Net_Pay,
       TO_CHAR(SYSDATE, 'YYYY-MM-DD HH24:MI:SS') AS Current_Time
FROM EMPLOYEE e
JOIN PAYSTUB p ON e.Ssn = p.Essn
GROUP BY e.fname, e.lname, e.Ssn; 



This will correspond to view paystub button on the employee window in which it has a filter button that 
can be used to sort the paystub such as recent paystub.
Define the variables with the following types: CHAR, DATE, DECIMAL, INT
*/

SET SERVEROUTPUT ON;
DECLARE
    --declare variables that have the following data types
        --char,date,int,decimal: based on the paystub table
    --user inputs their essn
    v_essn_input CHAR(9) := &sv_essn_input;
    
    v_paystub_id INT;
    v_endD DATE;
    v_gross_pay DECIMAL(10,2);
    v_deductions DECIMAL (10,2);
    v_net_pay DECIMAL(10,2);
    v_current_time VARCHAR2(20);

    --Define where the cursor will start
    CURSOR c1 is 
        --Query to determine the given essn most recent paystub
        SELECT Paystub_id,Essn, End_date, Gross_pay, Deductions, Net_pay 
        FROM PAYSTUB p
        WHERE  p.Essn = v_essn_input
        AND
        End_date = 
            (
                SELECT MAX (End_date)
                FROM PAYSTUB p1
                WHERE p.Essn = p1.Essn
                AND  p1.Essn = v_essn_input
            );
BEGIN 
    --get the current time stamp to show when the user retrived this paystub:
    v_current_time := TO_CHAR(SYSDATE, 'YYYY-MM-DD HH24:MI:SS');

    OPEN c1;
    LOOP
        FETCH c1 INTO v_paystub_id, v_essn_input, v_endD, v_gross_pay, v_deductions, v_net_pay;
        EXIT WHEN c1%NOTFOUND;
        --output
        DBMS_OUTPUT.PUT_LINE('Essn: ' || v_essn_input);
        DBMS_OUTPUT.PUT_LINE('End Date: ' || v_endD);
        DBMS_OUTPUT.PUT_LINE('Gross Pay: ' || v_gross_pay);
        DBMS_OUTPUT.PUT_LINE('Deductions: ' || v_deductions);
        DBMS_OUTPUT.PUT_LINE('Net Pay: ' || v_net_pay);
        DBMS_OUTPUT.PUT_LINE('Current Time: ' || v_current_time);
        
        
    END LOOP;
    CLOSE c1;
END;
/