-- this combines the functions and procedures defined in 6 and 7 into one package
CREATE OR REPLACE PACKAGE pay_management_pkg AS
    PROCEDURE increase_salary(p_emp_ssn PAYSTUB.Essn%TYPE, p_percentage NUMBER);

    FUNCTION calculate_total_gross_pay(p_emp_ssn PAYSTUB.Essn%TYPE) RETURN NUMBER;
END pay_management_pkg;
/

CREATE OR REPLACE PACKAGE BODY pay_management_pkg AS

    -- Implementation of increase_gross_pay procedure
    PROCEDURE increase_salary (
        p_emp_ssn PAYSTUB.Essn%TYPE,
        p_percentage NUMBER
    ) IS
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

    -- Implementation of calculate_total_gross_pay function
    FUNCTION calculate_total_gross_pay (
        p_emp_ssn PAYSTUB.Essn%TYPE
    ) RETURN NUMBER IS
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

END pay_management_pkg;
/

SHOW ERRORS

SET SERVEROUTPUT ON;

DECLARE
    emp_ssn         PAYSTUB.Essn%TYPE := '&Enter_Employee_SSN';   -- Prompt for employee SSN
    percentage_incr NUMBER := &Enter_Percentage_Increase;          -- Prompt for percentage increase
    total_gross_pay NUMBER;
BEGIN
    -- Call the increase_gross_pay procedure to update the gross pay
    pay_management_pkg.increase_salary(p_emp_ssn => emp_ssn, p_percentage => percentage_incr);

    -- Call the calculate_total_gross_pay function to get the updated total gross pay
    total_gross_pay := pay_management_pkg.calculate_total_gross_pay(p_emp_ssn => emp_ssn);

    -- Display the updated total gross pay
    dbms_output.put_line('Total Gross Pay for Employee with SSN ' || emp_ssn || ': $' || TO_CHAR(total_gross_pay, '999,999.99'));
END;
/