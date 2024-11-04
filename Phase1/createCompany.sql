REM ******************************************************************
REM   file: createCompany.sql
REM  description: used for creating the objects and loading data
REM                 into the company schema
REM  created October 3, 2024
REM ******************************************************************

SET ECHO OFF

@@company.tab
@@company.ind
@@insertData.sql
@@company.con
SET ECHO OFF