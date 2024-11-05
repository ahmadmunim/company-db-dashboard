/*
Write a PL/SQL function to perform appropriate action. Also write a block that calls 
this procedure.

This function will calculate the total current net pay of an employee. This can be used 
by the employee when they view their paystub. 
Employee window --> view paystub button

Query:
--20. Show the most recent paystub of each employee
PROMPT 20.Show the most recent paystub of each employee
SELECT essn, MAX(end_date) AS latest_end_date
FROM paystub
GROUP BY essn;


Modified (PL/SQL) to:
SELECT SUM(Net_pay) AS total_netPay
		INTO employee_netPay
		FROM PAYSTUB
		WHERE Essn = essnIN;

*/
CREATE OR REPLACE
	FUNCTION current_total_netPay( essnIN IN NUMBER)
	RETURN NUMBER IS
    employee_netPay NUMBER;

    --get the employee contact information based on essn 
	BEGIN
		SELECT SUM(Net_pay) AS total_netPay
		INTO employee_netPay
		FROM PAYSTUB
		WHERE Essn = essnIN;

        --return 
        RETURN employee_netPay;
EXCEPTION
		WHEN OTHERS THEN
        DBMS_OUTPUT.PUT_LINE (SQLERRM);
END;
/

--Anonymous pl/sql block
SET SERVEROUTPUT ON;

DECLARE 
    --variable to hold the user input of employee id
    v_essn NUMBER := &essn;
    --store the total 
    v_current_total_netPay NUMBER;
BEGIN 
    --call the procdure and pass in the user input
   v_current_total_netPay :=  current_total_netPay(v_essn);

   --display the value:
     DBMS_OUTPUT.PUT_LINE ('Current total netpay: ' || v_current_total_netPay);
END;
/
