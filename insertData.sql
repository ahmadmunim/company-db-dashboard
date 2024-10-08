REM ******************************************************************
REM  file: insertCompany.sql
REM  description: used for loading company data
REM  created October 3, 2024
REM ******************************************************************

SET DEFINE OFF
SPOOL insertData.log

--Employee (Ssn, Fname, Lname,Rno, Bdate, Sex,Dno )
INSERT INTO EMPLOYEE VALUES (123456789,'John','Smith',1,TO_DATE('1965-01-09','YYYY-MM-DD'),'M',5);
INSERT INTO EMPLOYEE VALUES (333445555,'Franklin','Wong',6,TO_DATE('1955-12-08','YYYY-MM-DD'),'M',5);
INSERT INTO EMPLOYEE VALUES (999887777,'Alicia','Zelaya',9,TO_DATE('1968-01-19','YYYY-MM-DD'),'F',4);
INSERT INTO EMPLOYEE VALUES (987654321,'Jennifer','Wallace',2,TO_DATE('1941-06-20','YYYY-MM-DD'),'F',4);
INSERT INTO EMPLOYEE VALUES (666884444,'Ramesh','Narayan',10,TO_DATE('1962-09-15','YYYY-MM-DD'),'M',5);
INSERT INTO EMPLOYEE VALUES (453453453,'Joyce','English',2,TO_DATE('1972-07-31','YYYY-MM-DD'),'F',5);
INSERT INTO EMPLOYEE VALUES (987987987,'Ahmad','Jabbar',2,TO_DATE('1969-03-29','YYYY-MM-DD'),'M',4);
INSERT INTO EMPLOYEE VALUES (888665555,'James','Borg',3,TO_DATE('1937-11-10','YYYY-MM-DD'),'M',1);

--EMP_CONTACT:
-- Emp_Contact (Essn,Email,Phone_number,Address)
PROMPT Inserting values into 'EMP_CONTACT'
INSERT INTO EMP_CONTACT VALUES (123456789,'john@gmail.com','123-456-7890','731 Fondren, Houston,TX');
INSERT INTO EMP_CONTACT VALUES (333445555, 'franklin@gmail.com','456-123-9870','638 Voss Houston, TX');
INSERT INTO EMP_CONTACT VALUES (999887777,'alicia@gmail.com','789-465-1230','3321 Castle, Spring, TX');
INSERT INTO EMP_CONTACT VALUES (987654321,'jennifer@gmail.com','312-645-0789','291 Berry, Bellaire, TX');


/*DEPARTMENT*/
--Department(Dnumber,Dname,Mgr_ssn,Mgr_Start_Date)
PROMPT Inserting values into 'DEPARTMENT'
INSERT INTO DEPARTMENT VALUES(5,'Research',333445555,TO_DATE('1988-05-22','YYYY-MM-DD'));
INSERT INTO DEPARTMENT VALUES(4,'Administration',987654321,TO_DATE('1995-01-01','YYYY-MM-DD'));
INSERT INTO DEPARTMENT VALUES(1,'Headquarters',888665555,TO_DATE('1981-06-19','YYYY-MM-DD'));



/*DEPT_LOCATIONS*/
--Department_Location(Dnumber, Dlocation)
PROMPT Inserting values into 'DEPT_LOCATIONS'
INSERT INTO DEPT_LOCATIONS VALUES (1,'Houston');
INSERT INTO DEPT_LOCATIONS VALUES (4,'Stafford');
INSERT INTO DEPT_LOCATIONS VALUES (5,'Bellaire');
INSERT INTO DEPT_LOCATIONS VALUES (5,'Sugarland');
INSERT INTO DEPT_LOCATIONS VALUES (5,'Houston');

/*PROJECT*/
--Project(Pnumber,Pname,Dnum,Pstart_date)
PROMPT Inserting values into 'PROJECT'
INSERT INTO PROJECT VALUES(1,'ProductX',5,TO_DATE('2024-10-03','YYYY-MM-DD'));
INSERT INTO PROJECT VALUES(2,'ProductY',5,TO_DATE('2024-10-03','YYYY-MM-DD'));
INSERT INTO PROJECT VALUES(3,'ProductZ',5,TO_DATE('2024-10-03','YYYY-MM-DD'));
INSERT INTO PROJECT VALUES(10,'Computerization',4,TO_DATE('2024-10-03','YYYY-MM-DD'));
INSERT INTO PROJECT VALUES(20,'Reorganization',1,TO_DATE('2024-10-03','YYYY-MM-DD'));
INSERT INTO PROJECT VALUES(30,'Newbenefits',4,TO_DATE('2024-10-03','YYYY-MM-DD'));

/*WORKS_ON*/
--Works_On(Essn,Pno,Hours)
PROMPT Inserting values into 'WORKS_ON'
INSERT INTO WORKS_ON VALUES (123456789,1,32.5);
INSERT INTO WORKS_ON VALUES (123456789,2,7.5);
INSERT INTO WORKS_ON VALUES (666884444,3,40.0);
INSERT INTO WORKS_ON VALUES (453453453,1,20.0);
INSERT INTO WORKS_ON VALUES (453453453,2,20.0);
INSERT INTO WORKS_ON VALUES (333445555,2,10.0);
INSERT INTO WORKS_ON VALUES (333445555,3,10.0);
INSERT INTO WORKS_ON VALUES (333445555,10,10.0);
INSERT INTO WORKS_ON VALUES (333445555,20,10.0);
INSERT INTO WORKS_ON VALUES (999887777,30,30.0);
INSERT INTO WORKS_ON VALUES (999887777,10,10.0);
INSERT INTO WORKS_ON VALUES (987987987,10,35.0);
INSERT INTO WORKS_ON VALUES (987987987,30,5.0);
INSERT INTO WORKS_ON VALUES (987654321,30,20.0);
INSERT INTO WORKS_ON VALUES (987654321,20,15.0);
INSERT INTO WORKS_ON VALUES (888665555,20,NULL);

/*ROLES*/
--Roles(Rno,Rname)
PROMPT Inserting values into 'ROLES'
INSERT INTO ROLES VALUES (1,'Manager');
INSERT INTO ROLES VALUES (2,'Coordinator');
INSERT INTO ROLES VALUES (3,'Engineer');
INSERT INTO ROLES VALUES (6,'IT Technician');
INSERT INTO ROLES VALUES (9,'System Admin');
INSERT INTO ROLES VALUES (10,'HR');

/*DEPENDENT*/
--Dependent (Essn,Dependent_name,sex,bdate,relationship)
PROMPT Inserting values into 'DEPENDENT'
INSERT INTO DEPENDENT VALUES (333445555,'Alice','F',TO_DATE('1986-04-05','YYYY-MM-DD'),'Daughter');
INSERT INTO DEPENDENT VALUES (333445555,'Theodore','M',TO_DATE('1983-10-25','YYYY-MM-DD'),'Son');
INSERT INTO DEPENDENT VALUES (333445555,'Joy','F',TO_DATE('1958-05-03','YYYY-MM-DD'),'Spouse');
INSERT INTO DEPENDENT VALUES (987654321,'Abner','M',TO_DATE('1942-02-03','YYYY-MM-DD'),'Spouse');
INSERT INTO DEPENDENT VALUES (123456789,'Michael','M',TO_DATE('1988-01-04','YYYY-MM-DD'),'Son');
INSERT INTO DEPENDENT VALUES (123456789,'Alice','F',TO_DATE('1986-04-05','YYYY-MM-DD'),'Daughter');
INSERT INTO DEPENDENT VALUES (123456789,'Elizabeth','F',TO_DATE('1967-05-05','YYYY-MM-DD'),'Spouse');

/*CLIENT_PROJECT*/
--Client_Project(cid,gave_project)
PROMPT Inserting values into 'CLIENT_PROJECT'
INSERT INTO CLIENT_PROJECT VALUES (1,10);
INSERT INTO CLIENT_PROJECT VALUES (2,20);

/*CLIENT*/
--Client(cid,fname,lname,works_for,email,phone)
PROMPT Inserting values into 'CLIENT'
INSERT INTO CLIENT VALUES(1,'Toge','Inumaki','X','toge@gmail.com','123-456-7890');
INSERT INTO CLIENT VALUES(2,'Yuji','Itadori','Z','yuji@gmail.com','123-789-4560');





--PAYSTUB
--Paystub (recordID, Paystub_id, Essn, Start_date, End_date, Gross_pay, Deductions, Net_pay)
PROMPT Inserting values into 'PAYSTUB'
INSERT INTO PAYSTUB VALUES (1,123456789,TO_DATE('01-01-2024','MM-DD-YYYY'),TO_DATE('01-14-2024','MM-DD-YYYY'),2100.00,520.00,1580.00);
INSERT INTO PAYSTUB VALUES (2,123456789,TO_DATE('01-29-2024','MM-DD-YYYY'),TO_DATE('02-11-2024','MM-DD-YYYY'),2100.00,520.00,1580.00);
INSERT INTO PAYSTUB VALUES (3,123456789,TO_DATE('02-12-2024','MM-DD-YYYY'),TO_DATE('02-25-2024','MM-DD-YYYY'),2100.00,520.00,1580.00);

INSERT INTO PAYSTUB VALUES (4,333445555,TO_DATE('02-12-2024','MM-DD-YYYY'),TO_DATE('02-25-2024','MM-DD-YYYY'),2500.00,600.00,1900.00);
INSERT INTO PAYSTUB VALUES (5,333445555,TO_DATE('02-26-2024','MM-DD-YYYY'),TO_DATE('03-10-2024','MM-DD-YYYY'),2500.00,600.00,1900.00);

INSERT INTO PAYSTUB VALUES (6,999887777,TO_DATE('01-01-2024','MM-DD-YYYY'),TO_DATE('01-14-2024','MM-DD-YYYY'),3000.00,500.00,2500.00);
INSERT INTO PAYSTUB VALUES (7,999887777,TO_DATE('01-29-2024','MM-DD-YYYY'),TO_DATE('02-11-2024','MM-DD-YYYY'),3000.00,500.00,2500.00);
INSERT INTO PAYSTUB VALUES (8,999887777,TO_DATE('02-12-2024','MM-DD-YYYY'),TO_DATE('02-25-2024','MM-DD-YYYY'),3000.00,500.00,2500.00);
INSERT INTO PAYSTUB VALUES (9,999887777,TO_DATE('02-12-2024','MM-DD-YYYY'),TO_DATE('02-25-2024','MM-DD-YYYY'),3000.00,500.00,2500.00);
INSERT INTO PAYSTUB VALUES (10,999887777,TO_DATE('02-26-2024','MM-DD-YYYY'),TO_DATE('03-10-2024','MM-DD-YYYY'),3000.00,500.00,2500.00);


COMMIT;

SPOOL OFF