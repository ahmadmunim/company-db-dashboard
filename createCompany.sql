REM ******************************************************************
REM   file: createCompany.sql
REM  description: used for creating the objects and loading data
REM                 into the company schema
REM  
REM ******************************************************************

SET ECHO OFF

@@createSchema.tab
@@company.ind
@@company.con
@@insertData.sql
SET ECHO OFF
CLEAR SCREEN


