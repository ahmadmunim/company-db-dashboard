REM ******************************************************************
REM   file: createTest.sql
REM  description: used for creating the objects and loading data
REM                 into the company schema
REM  created September 28 2024
REM ******************************************************************

SET ECHO OFF

@@company.tab
@@company.ind
@@insertData.sql
@@company.con
SET ECHO OFF