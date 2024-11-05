-- this program sums the total pay an employee has gotten
-- this will be used in the manager ui and the employee ui to check the total pay for something like the annual income or to see if there's still any payment left to give
CREATE OR REPLACE FUNCTION calculate_total_gross_pay (
    p_emp_ssn PAYSTUB.Essn%TYPE
) RETURN NUMBER AS
    v_total_gross_pay NUMBER;
BEGIN
    -- Calculate the total gross pay for the given employee SSN
    SELECT SUM(Gross_pay)
    INTO v_total_gross_pay
    FROM PAYSTUB
    WHERE Essn = p_emp_ssn;

    -- Return the total gross pay
    RETURN NVL(v_total_gross_pay, 0);  -- Return 0 if no paystubs found
EXCEPTION
    WHEN NO_DATA_FOUND THEN
        RETURN 0;  -- Return 0 if no paystub records are found for the employee
    WHEN OTHERS THEN
        dbms_output.put_line('An unexpected error occurred: ' || SQLERRM);
        RETURN -1;  -- Return -1 to indicate an error occurred
END calculate_total_gross_pay;
/

DECLARE
    emp_ssn            PAYSTUB.Essn%TYPE := '&Enter_Employee_SSN';   -- Prompt for employee SSN
    total_gross_pay    NUMBER;
BEGIN
    -- Call the function and store the result in total_gross_pay
    total_gross_pay := calculate_total_gross_pay(emp_ssn);

    -- Display the result
    IF total_gross_pay = -1 THEN
        dbms_output.put_line('An error occurred while calculating the total gross pay.');
    ELSE
        dbms_output.put_line('Total Gross Pay for Employee with SSN ' || emp_ssn || ': $' || TO_CHAR(total_gross_pay, '999,999.99'));
    END IF;
END;
/