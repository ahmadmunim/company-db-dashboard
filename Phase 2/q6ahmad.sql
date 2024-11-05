-- program that updates the most recent paystub of an employee
-- this will be used in the manager UI when they need to give an employee a raise or deduction
SET SERVEROUTPUT ON;

CREATE OR REPLACE PROCEDURE increase_salary (
    p_emp_ssn PAYSTUB.Essn%TYPE,
    p_percentage NUMBER
) AS
    v_current_salary PAYSTUB.Gross_pay%TYPE;
    v_new_salary PAYSTUB.Gross_pay%TYPE;
BEGIN
    -- Retrieve the most recent salary entry based on End_date
    SELECT Gross_pay
    INTO v_current_salary
    FROM PAYSTUB
    WHERE Essn = p_emp_ssn
    AND ROWNUM = 1
    ORDER BY End_date DESC;

    -- Calculate the new salary based on the percentage increase
    v_new_salary := v_current_salary * (1 + p_percentage / 100);

    -- Update the most recent paystub record for this employee
    UPDATE PAYSTUB
    SET Gross_pay = v_new_salary
    WHERE Essn = p_emp_ssn AND Gross_pay = v_current_salary;

    -- Display the updated salary
    dbms_output.put_line('Employee SSN: ' || p_emp_ssn);
    dbms_output.put_line('Old Salary: ' || TO_CHAR(v_current_salary, '999,999.99'));
    dbms_output.put_line('New Salary: ' || TO_CHAR(v_new_salary, '999,999.99'));

    -- Commit the transaction
    COMMIT;

EXCEPTION
    WHEN NO_DATA_FOUND THEN
        dbms_output.put_line('No paystub found for the specified employee SSN.');
    WHEN OTHERS THEN
        dbms_output.put_line('An unexpected error occurred: ' || SQLERRM);
END increase_salary;
/

DECLARE
    emp_ssn          PAYSTUB.Essn%TYPE := '&Enter_Employee_SSN';      -- Prompt for employee SSN
    percentage_incr  NUMBER := &Enter_Percentage_Increase;            -- Prompt for percentage increase
BEGIN
    -- Call the procedure
    increase_salary(p_emp_ssn => emp_ssn, p_percentage => percentage_incr);

    -- Confirmation message after procedure execution
    dbms_output.put_line('Most recent salary updated successfully for employee with SSN ' || emp_ssn);
END;
/