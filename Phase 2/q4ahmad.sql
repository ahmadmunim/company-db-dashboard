-- this program filters client information by their id
-- this will be used in the manager ui where the manager can filter clients
SET SERVEROUTPUT ON;

DECLARE
    -- Variables for client information
    client_id       CLIENT.Cid%TYPE := '&Enter_Client_ID';        -- Prompt for client ID
    client_name     VARCHAR2(100);                                -- Variable to hold full client name
    project_given   CLIENT_PROJECT.Gave_project%TYPE;             -- Project name or ID given by the client
    error_message   VARCHAR2(200);                                -- Variable to hold error message

BEGIN
    -- Attempt to retrieve client information based on the provided client ID
    SELECT Fname || ' ' || Lname, Gave_project
    INTO client_name, project_given
    FROM CLIENT C
    JOIN CLIENT_PROJECT CP ON C.Cid = CP.Cid
    WHERE C.Cid = client_id;

    -- Display client information
    dbms_output.put_line('Client Name: ' || client_name);
    dbms_output.put_line('Project Assigned: ' || project_given);

EXCEPTION
    -- Handle case where no data is found for the specified client ID
    WHEN NO_DATA_FOUND THEN
        error_message := 'Error: No client found with the specified Client ID ' || client_id;
        dbms_output.put_line(error_message);

    -- Handle any other unexpected exceptions
    WHEN OTHERS THEN
        error_message := 'An unexpected error occurred: ' || SQLERRM;
        dbms_output.put_line(error_message);
END;
/
