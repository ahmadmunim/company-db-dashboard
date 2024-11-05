/*
 Write a PL/SQL code that declares a cursor and utilizes this cursor in a loop instruction 
to implement appropriate action. 

This will determine what clients have assigned what projects and under what department which is implemeted in 
the project button under client window.


--21. Client that assigned the most projects
PROMPT 21.Client that assigned the most projects
SELECT cid, pNum
FROM (
    SELECT cid, COUNT(gave_project) AS pNum
    FROM client_project
    GROUP BY cid
    ORDER BY pNum DESC
)
WHERE ROWNUM = 1;


Query:
select c.fname, c.lname, p.pname
from client c
join client_project cp on c.cid = cp.cid
join project p on cp.gave_project = p.pnumber
join department d ON p.dNum = d.Dnumber;
*/

SET SERVEROUTPUT ON;
DECLARE
    v_client_assign_project VARCHAR2(500);
    v_fname VARCHAR2(15);
    v_lname VARCHAR2(15);
    v_pName VARCHAR2(15);
    v_dName VARCHAR2(15);

    --cursor 
    CURSOR c1 is
        --query for finding the name of the client that assigned a project and determine the department that it got assigned
        SELECT c.fname, c.lname, p.pname, d.dName
        FROM client c
        JOIN client_project cp ON c.cid = cp.cid
        JOIN project p ON cp.gave_project = p.pnumber
        JOIN department d ON p.Dnum = d.Dnumber;
BEGIN 
    OPEN c1;
    LOOP
        FETCH c1 INTO v_fname, v_lname, v_pName, v_dName;
        EXIT WHEN c1%NOTFOUND;
        --output
        DBMS_OUTPUT.PUT_LINE('The Client ' || v_fname || ' ' || v_lname || ' has assigned a project named: ' || v_pName || ' under the department : '|| v_dName);
    END LOOP;
    CLOSE c1;
    
END;
/
