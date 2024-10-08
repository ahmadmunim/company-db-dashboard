REM ******************************************************************
REM   file: quries5.sql
REM  description: using the built in functions to create queries
REM               from moddifeid company table
REM  created Oct.7.2024
REM ******************************************************************

SET ECHO OFF

--1. Gets projects that started after 2024-10-03
PROMPT 1. Gets projects that started after 2024-10-03
SELECT * FROM PROJECT WHERE Pstart_date > TO_DATE('2024-10-03' , 'YYYY-MM-DD');


--2. Gets the employees and what project they're working on
PROMPT 2. Gets the employees and what project theyre working on
SELECT E.Fname, E.Lname, P.Pname
    FROM EMPLOYEE E
JOIN WORKS_ON W ON E.Ssn = W.Essn
JOIN PROJECT P ON W.Pno = P.Pnumber;


--3. Gets the managers, the project they're supervising and what client gave the project 
PROMPT3. Gets the managers, the project theyre supervising and what client gave the project 
SELECT M.Fname AS ManagerFname, M.Lname AS ManagerLname, P.Pname AS Project, C.Fname AS ClientFname, C.Lname AS ClientLname
FROM DEPARTMENT D
JOIN EMPLOYEE M ON D.Mgr_ssn = M.Ssn
JOIN PROJECT P ON D.Dnumber = P.Dnum
JOIN CLIENT_PROJECT CP ON P.Pnumber = CP.Gave_project
JOIN CLIENT C ON CP.Cid = C.Cid
WHERE P.Pnumber IN (SELECT W.Pno FROM WORKS_ON W WHERE W.Essn = M.Ssn);


--4. Gets departments that have more than 3 employees
PROMPT 4. Gets departments that have more than 3 employees
SELECT D.Dname
FROM DEPARTMENT D
WHERE D.Dnumber IN (
    SELECT E.Dno
    FROM EMPLOYEE E
    GROUP BY E.Dno
    HAVING COUNT(*) > 3
);

--5. Gets the clients that have assigned exactly 2 projects
PROMPT 5. Gets the clients that have assigned exactly 2 projects
SELECT Fname, Lname
FROM CLIENT
WHERE Cid IN (
    SELECT Cid
    FROM CLIENT_PROJECT
    GROUP BY Cid
    HAVING COUNT(*) = 2
);

--6. Gets employees that work in the same department as John Smith
PROMPT 6. Gets average salary of all employees
SELECT Fname, Lname
FROM EMPLOYEE
WHERE Dno = (SELECT Dno FROM EMPLOYEE WHERE Fname = 'John' AND Lname = 'Smith');

--7. Gets employees whose salary is higher than the average salary
PROMPT 7. Gets average salary of all employees
SELECT E.Fname, E.Lname
FROM EMPLOYEE E
JOIN PAYSTUB P ON E.Ssn = P.Essn
WHERE P.Net_pay > (SELECT AVG(Net_pay) FROM PAYSTUB);

--8. Gets average salary of all employees
PROMPT 8. Gets average salary of all employees
SELECT AVG(Net_pay) AS Average_Salary FROM PAYSTUB ;


--9. Gets the max, min and avg salaries of each department
PROMPT 9. Gets the max, min and avg salaries of each department
SELECT Dno, 
       MAX(Salary) AS Max_Salary, 
       MIN(Salary) AS Min_Salary, 
       AVG(Salary) AS Avg_Salary
FROM EMPLOYEE
GROUP BY Dno;

-- 10. Gets the number of employees in each role
PROMPT 10. List the department managers of each department
SELECT R.Rname, COUNT(E.Rno) AS Number_Of_Employees
FROM ROLES R
JOIN EMPLOYEE E ON R.Rno = E.Rno
GROUP BY R.Rname;

--11. Display the name of each department manager
PROMPT 11. List the department managers of each department
SELECT CONCAT(CONCAT(fname, ' '),
CONCAT( CONCAT (lname, ' is the department manager of '),d.Dname)) AS Dept_Manager_Info FROM employee e
JOIN DEPARTMENT d ON e.Ssn = d.Mgr_ssn;

--12. Display the formatted total net pay
PROMPT 12.Display formatted total net pay
SELECT e.fname, e.lname, e.Ssn, TO_CHAR(SUM(p.Net_pay),'$999,999.99') As Total_Net_Pay FROM EMPLOYEE e
JOIN PAYSTUB p ON e.Ssn = p.Essn
GROUP BY e.fname,e.lname,e.Ssn

/*
13. Change the format of the phone number from ###-###-####
to ### ### #### where the employee is female.
*/
PROMPT 13. format the phone number for employess that are female
SELECT c.essn, c.address,c.phone,TRANSLATE(c.phone,
'###-###-####', '### ### ####') AS formatted_phone_number, c.email FROM EMP_CONTACT c WHERE c.essn IN (
SELECT e.ssn FROM employee e WHERE e.sex = 'F' );

--14. Rename project name
PROMPT 14. Replace the project name
SELECT REPLACE (pname,'ProductX','ProductA') AS updated_pname, pnumber 
FROM project;

--15. Retrive paystub with format with time stamp:
PROMPT 15. Retrive paystub with format with time stamp:
SELECT e.fname, e.lname, e.Ssn, 
       TO_CHAR(SUM(p.Net_pay), '$999,999.99') AS Total_Net_Pay,
       TO_CHAR(SYSDATE, 'YYYY-MM-DD HH24:MI:SS') AS Current_Time
FROM EMPLOYEE e
JOIN PAYSTUB p ON e.Ssn = p.Essn
GROUP BY e.fname, e.lname, e.Ssn; 


--16.Determine the total number of client projects
PROMPT 16. Determine the total number of client projects
SELECT COUNT(*) AS TOTAL_NUM_PROJECTS
FROM client_project;


--17.Average net pay of employee that has a role of manager
PROMPT 17. Average net pay of employee that has a role of manager
SELECT e.fname, e.lname , r.rname, avg (p.net_pay) AS AVG_NET_PAY
FROM employee e 
JOIN roles r ON e.rno = r.rno 
JOIN paystub p on e.ssn = p.essn 
WHERE r.rname = 'Manager' 
GROUP BY e.fname, e.lname, r.rname;

--18.Display the name of the employee with the highest net pay
PROMPT 18. Display the name of the employee with the highest net pay
SELECT DISTINCT INITCAP(e.fname) AS FIRST_NAME, LOWER( e.lname) AS LAST_NAME,p.Net_pay 
FROM EMPLOYEE E 
JOIN PAYSTUB p ON e.Ssn = p.Essn 
WHERE p.Net_pay = 
    ( SELECT
        MAX(Net_pay) 
        FROM PAYSTUB 
    );


--19.Display the roles of each employee 
PROMPT 19 .Display the roles of each employee 
SELECT e.fname, e.lname , r.rname
FROM employee e
JOIN roles r on e.rno = r.rno;

--20. Show the most recent paystub of each employee
PROMPT 20.Show the most recent paystub of each employee
SELECT essn, MAX(end_date) AS latest_end_date
FROM paystub
GROUP BY essn;

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


--22. Displays the name of the project name with department name
PROMPT 22.Displays the name of the project name with department name
SELECT p.pname, d.dname 
FROM PROJECT p 
JOIN DEPARTMENT d ON  p.Dnum = d.Dnumber;


SET ECHO OFF
CLEAR SCREEN