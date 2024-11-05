-- this trigger prevents you from giving an employee more than 3 projects
-- this will be used when a manager assigns projects to employees preventing them from giving one more than 3
CREATE OR REPLACE TRIGGER limit_employee_projects
BEFORE INSERT OR UPDATE OF Essn ON WORKS_ON
FOR EACH ROW
DECLARE
    v_project_count NUMBER;
BEGIN
    -- Count the current number of projects assigned to the employee
    SELECT COUNT(*)
    INTO v_project_count
    FROM WORKS_ON
    WHERE Essn = :NEW.Essn;

    -- Raise an exception if the employee is already assigned to five projects
    IF v_project_count >= 3 THEN
        RAISE_APPLICATION_ERROR(-20001, 'Error: An employee cannot be assigned to more than three projects.');
    END IF;
END limit_employee_projects;
/

-- Step 1: Insert sample records in WORKS_ON to assign an employee to five projects
INSERT INTO WORKS_ON (Essn, Pno, Hours) VALUES ('123456789', 101, 10);
INSERT INTO WORKS_ON (Essn, Pno, Hours) VALUES ('123456789', 102, 15);
INSERT INTO WORKS_ON (Essn, Pno, Hours) VALUES ('123456789', 103, 20);

-- Display the current assignments
SELECT * FROM WORKS_ON WHERE Essn = '123456789';

-- Step 2: Attempt to assign the employee to a sixth project (should trigger an error)
INSERT INTO WORKS_ON (Essn, Pno, Hours) VALUES ('123456789', 106, 35);