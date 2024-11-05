-- this program gets the salary of the employee and outputs whether the employee is earning more than average
-- this program will be used in the employee UI when an employee views their paystubs and compares it to the avg earning of all employees
SET SERVEROUTPUT ON;

DECLARE
    -- Variable declarations
    emp_ssn        CHAR(9) := '&emp_ssn';     -- CHAR type, for employee SSN
    emp_fname        VARCHAR2(15);                                   -- VARCHAR2 type, for employee full name
    emp_lname        VARCHAR2(15);
    emp_net_pay      DECIMAL (10,2);                           -- NUMBER type, for employee's net pay
    avg_net_pay      DECIMAL (10,2);                                 -- NUMBER type, for the average net pay of all employees
    is_above_average BOOLEAN := FALSE;                               -- BOOLEAN type, to check if above average

BEGIN
    -- Retrieve the employee's name and most recent net pay from PAYSTUB
    SELECT E.Fname, E.Lname, P.Net_pay
    INTO emp_fname, emp_lname, emp_net_pay
    FROM EMPLOYEE E
    JOIN PAYSTUB P ON E.Ssn = P.Essn
    WHERE E.Ssn = emp_ssn
    AND P.End_date = (SELECT MAX(End_date) FROM PAYSTUB WHERE Essn = emp_ssn)
    AND ROWNUM = 1;

    -- Calculate the average net pay across all employees' latest paystubs
    SELECT AVG(Net_pay)
    INTO avg_net_pay
    FROM PAYSTUB
    WHERE (Essn, End_date) IN (
        SELECT Essn, MAX(End_date)
        FROM PAYSTUB
        GROUP BY Essn
    );

    -- Determine if the employee's net pay is above the average
    IF emp_net_pay > avg_net_pay THEN
        is_above_average := TRUE;
    END IF;

    -- Display the employee's net pay details
    dbms_output.put_line('Employee Name: ' || emp_fname || ' ' || emp_lname);
    dbms_output.put_line('Your Net Pay: $' || TO_CHAR(emp_net_pay, '999,999.99'));
    dbms_output.put_line('Average Net Pay: $' || TO_CHAR(avg_net_pay, '999,999.99'));

    -- Display if the employee earns above or below the average
    IF is_above_average THEN
        dbms_output.put_line('Status: You earn above the company average.');
    ELSE
        dbms_output.put_line('Status: You earn below the company average.');
    END IF;

EXCEPTION
    WHEN NO_DATA_FOUND THEN
        dbms_output.put_line('Error: No paystub found for employee with SSN ' || emp_ssn);
    WHEN OTHERS THEN
        dbms_output.put_line('An unexpected error occurred: ' || SQLERRM);
END;
/
