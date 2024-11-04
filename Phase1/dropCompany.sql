REM ******************************************************************
REM   file: dropCompany.sql
REM  description: used for droping company schema objects. Note that
REM                 this script only drops the objects created for
REM                 the SQL book and for the beginning of the
REM                 PL/SQL book.
REM  created October 3, 2024
REM ******************************************************************

PROMPT ** ******************************************************** **
PROMPT ** Continuing will cause all of your company schema objects **
PROMPT **   and data to be dropped. This may be desirable if you   **
PROMPT **   are attempting to rebuild the objects.                 **
PROMPT ** Press CTRL-C now to cancel or <RETURN> to continue.      **
PROMPT ** ******************************************************** **
PAUSE

PROMPT
PROMPT Dropping Company schema objects

REM === Drop Indexes ===

DROP INDEX EMP_FNAME_LNAME_FK_I
/
DROP INDEX CLIENT_FNAME_LNAME_FK_I
/

REM === Drop Tables ===

DROP TABLE EMPLOYEE CASCADE CONSTRAINTS;
DROP TABLE EMP_CONTACT CASCADE CONSTRAINTS;
DROP TABLE DEPARTMENT CASCADE CONSTRAINTS;
DROP TABLE DEPT_LOCATIONS CASCADE CONSTRAINTS;
DROP TABLE PROJECT CASCADE CONSTRAINTS;
DROP TABLE WORKS_ON CASCADE CONSTRAINTS;
DROP TABLE DEPENDENT CASCADE CONSTRAINTS;
DROP TABLE ROLES CASCADE CONSTRAINTS;
DROP TABLE CLIENT CASCADE CONSTRAINTS;
DROP TABLE CLIENT_PROJECT CASCADE CONSTRAINTS;
DROP TABLE PAYSTUB CASCADE CONSTRAINTS;
