<?php
// Controller action for both Post action and getting list. Can be made into a class for more complex actions
require "model.php";
$data = [];
$db = new SimpleDB();

if (isset($_POST['login-manager'])) {

    $id = $_POST['id'];
    $email = $_POST['email'];
    
    $conditions = [];

    $sql = "SELECT ec.Essn, ec.Email FROM emp_contact ec, employee e WHERE Essn = '$id' AND ec.Essn = e.Ssn AND e.Rno = 1";

    $result = $db->query($sql, $conditions);
    print_r($result);
    
    if($result) {
        if ($result[0]['Email'] == $email) {
            session_start();
            $_SESSION["user"] = $id;
            header("Location: app/manager/main.php");
            die();
        }
        else {
            header("Location: login.php");     
            echo "wrong credentials";       
        }
    } else {
        header("Location: login.php");
        echo "wrong credentials";
    }

}

if (isset($_POST['login-employee'])) {

    $id = $_POST['id'];
    $email = $_POST['email'];
    
    $conditions = [];

    $sql = "SELECT ec.Essn, ec.Email FROM emp_contact ec, employee e WHERE Essn = '$id' AND ec.Essn = e.Ssn AND e.Rno != 1";

    $result = $db->query($sql, $conditions);
    print_r($result[0]);
    
    if($result) {
        if ($result[0]['Email'] == $email) {
            session_start();
            $_SESSION["user"] = $id;        
            header("Location: app/employee/main.php");
            die();
        }
        else {
            $error_msg = "Invalid credentials";
            include 'login.php';
            header("Location: login.php");         
        }
    } else {
        $error_msg = "Invalid credentials";
        include 'login.php';
        header("Location: login.php");
    }

}

if (isset($_POST['login-client'])) {

    $id = $_POST['id'];
    $email = $_POST['email'];
    
    $conditions = [];

    $sql = "SELECT c.Cid, c.Email FROM client c WHERE Cid = '$id'";

    $result = $db->query($sql, $conditions);
    print_r($result);
    
    if($result) {
        if ($result[0]['Email'] == $email) {
            session_start();
            $_SESSION["user"] = $id;            
            header("Location: app/client/main.php");
            die();
        }
        else {
            header("Location: login.php");     
            echo "wrong credentials";       
        }
    } else {
        header("Location: login.php");
        echo "wrong credentials";
    }

}

if (isset($_POST['submit-emp'])) { // Check if post action
    $conditions = [
        ":Bdate" => date("Y-m-d")
    ];
    $message = "Success";
    $errors = [];
    $attributes = [ // array of name fields in the create employee form
        "Ssn",
        "Fname",
        "Lname",
        "Rno",
        "Bdate",
        "Sex",
        "Dno"
    ];

    print_r($attributes);

    // Create conditions for query and where statement
    foreach ($attributes as $attribute) {
        $value = $_POST[$attribute]; // gets inputted value in each form entry and assigns it
        if ($value) {
            $conditions[":$attribute"] = $value; // adds inputted value in conditions array
        } else {
            $errors[] = $attribute;
        }
    }

    if ($errors) {
        $message = "Could not add employee - Empty attributes " . implode(", ", $errors);
    } else {
        // Insert Sql statment with interpolated variables `:variable`
        $sql = "INSERT INTO employee (Ssn, Fname, Lname, Rno, Bdate, Sex, Dno) VALUES (:Ssn, :Fname, :Lname, :Rno, :Bdate, :Sex, :Dno)";
        // Insert data from post action
        $result = $db->insert_employee($sql, $conditions); // goes to insert_employee function in model.php

        if (is_string($result)) {
            $message = "Could not add employee - " . $result;
        } else {
            $data['employee'] = $result;
        }
    }

    // Return calls
    $data['message'] = $message;
} elseif (isset($_GET['submit-emp'])) {
    $conditions = [];
    $where = "";
    $ssn = $_GET['ssn'] ?? null;
    
    if ($ssn) {
        $conditions[':Ssn'] = $ssn;
        $where = "Ssn = :Ssn";
    }
    
    $sql = "SELECT Ssn, Fname, Lname, Rno, Bdate, Sex, Dno FROM employee";
    $sql .= $where ? " WHERE $where" : "";
    
    // Execute query to fetch the matching employee
    $result = $db->query($sql, $conditions);
    $data = [
        'message' => $result ? '' : 'No Employee Found',
        'employee' => $result[0] ?? null // Get the first result if there's a match
    ];

    $relativePath = preg_replace('/\/[A-Za-z0-9]+(\.*\w*)(\?(.)*)*$/', '/', $_SERVER['REQUEST_URI']);
    header("Location:" . $relativePath . "app/employee.php?" . http_build_query($data));
    
} elseif (isset($_POST['submit-client'])) {
    $conditions = [];
    $message = "Success";
    $errors = [];
    $attributes = [
        "Cid",
        "Fname",
        "Lname",
        "Works_for",
        "Email",
        "Phone"
    ];

    // Create conditions for query and where statement
    foreach ($attributes as $attribute) {
        $value = $_POST[$attribute];
        if ($value) {
            $conditions[":$attribute"] = $value;
        } else {
            $errors[] = $attribute;
        }
    }

    if ($errors) {
        $message = "Could not add client - Empty attributes " . implode(", ", $errors);
    } else {
        // Insert Sql statment with interpolated variables `:variable`
        $sql = "INSERT INTO client (Cid, Fname, Lname, Works_for, Email, Phone) VALUES (:Cid, :Fname, :Lname, :Works_for, :Email, :Phone)";
        // Insert data from post action
        $result = $db->insert_client($sql, $conditions);

        if (is_string($result)) {
            $message = "Could not add client - " . $result;
        } else {
            $data['client'] = $result;
        }
    }

    // Return calls
    $data['message'] = $message;
} elseif (isset($_GET['submit-client'])) {
    $conditions = [];
    $where = "";
    $cid = $_GET['cid'] ?? null;
    
    if ($cid) {
        $conditions[':Cid'] = $cid;
        $where = "Cid = :Cid";
    }
    
    $sql = "SELECT Cid, Fname, Lname, Works_for, Email, Phone FROM client";
    $sql .= $where ? " WHERE $where" : "";
    
    // Execute query to fetch the matching employee
    $result = $db->query($sql, $conditions);
    $data = [
        'message' => $result ? '' : 'No Client Found',
        'client' => $result[0] ?? null // Get the first result if there's a match
    ];

    $relativePath = preg_replace('/\/[A-Za-z0-9]+(\.*\w*)(\?(.)*)*$/', '/', $_SERVER['REQUEST_URI']);
    header("Location:" . $relativePath . "app/client.php?" . http_build_query($data));
    
} elseif (isset($_POST['submit-project'])) {
    $conditions = [];
    $message = "Success";
    $errors = [];
    $attributes = [
        "Pnumber",
        "Pname",
        "Dnum",
        "Pstart_date"
    ];

    // Create conditions for query and where statement
    foreach ($attributes as $attribute) {
        $value = $_POST[$attribute];
        if ($value) {
            $conditions[":$attribute"] = $value;
        } else {
            $errors[] = $attribute;
        }
    }

    if ($errors) {
        $message = "Could not add project - Empty attributes " . implode(", ", $errors);
    } else {
        // Insert Sql statment with interpolated variables `:variable`
        $sql = "INSERT INTO project (Pnumber, Pname, Dnum, Pstart_date) VALUES (:Pnumber, :Pname, :Dnum, :Pstart_date)";
        // Insert data from post action
        $result = $db->insert_project($sql, $conditions);

        if (is_string($result)) {
            $message = "Could not add project - " . $result;
        } else {
            $data['project'] = $result;
        }
    }

    // Return calls
    $data['message'] = $message;

} elseif (isset($_GET['submit-project'])) {
    $conditions = [];
    $where = "";
    $pnumber = $_GET['pnumber'] ?? null;
    
    if ($pnumber) {
        $conditions[':Pnumber'] = $pnumber;
        $where = "Pnumber = :Pnumber";
    }
    
    $sql = "SELECT Pnumber, Pname, Dnum, Pstart_date FROM project";
    $sql .= $where ? " WHERE $where" : "";
    
    // Execute query to fetch the matching employee
    $result = $db->query($sql, $conditions);
    $data = [
        'message' => $result ? '' : 'No Project Found',
        'project' => $result[0] ?? null // Get the first result if there's a match
    ];

    $relativePath = preg_replace('/\/[A-Za-z0-9]+(\.*\w*)(\?(.)*)*$/', '/', $_SERVER['REQUEST_URI']);
    header("Location:" . $relativePath . "app/project.php?" . http_build_query($data));
    
} elseif (isset($_GET['submit-employee-projects'])) {
    $ssn = $_GET['ssn'] ?? null;
    $conditions = [];
    
    if ($ssn) {
        $conditions[':ssn'] = $ssn;
        
        // SQL query to get employee's projects
        $sql = "SELECT E.Fname, E.Lname, P.Pname
                FROM employee E
                JOIN works_on W ON E.Ssn = W.Essn
                JOIN project P ON W.Pno = P.Pnumber
                WHERE E.Ssn = :ssn";
        
        // Execute query
        $result = $db->query($sql, $conditions);

        // Check if there are results and prepare data
        $data = [
            'message' => $result ? '' : 'No Projects Found for this Employee',
            'employeeProject' => $result
        ];
    } else {
        $data['message'] = 'No SSN provided';
    }

    // Redirect to a specific HTML page to display results
    $relativePath = preg_replace('/\/[A-Za-z0-9]+(\.*\w*)(\?(.)*)*$/', '/', $_SERVER['REQUEST_URI']);
    header("Location:" . $relativePath . "app/employeeProject.php?" . http_build_query($data));

} elseif (isset($_GET['submit-employee-netpay'])) {
    
    // Handle GET request to retrieve net pay for a specific employee

    $ssn = $_GET['ssn'] ?? null;
    $conditions = [];
    
    if ($ssn) {
        $conditions[':ssn'] = $ssn;
        
        // SQL query to get employee's net pay details
        $sql = "SELECT E.Fname, E.Lname, P.Net_pay, P.Start_date, P.End_date
                FROM employee E
                JOIN paystub P ON E.Ssn = P.Essn
                WHERE E.Ssn = :ssn";
        
        // Execute query
        $result = $db->query($sql, $conditions);

        // Check if there are results and prepare data
        $data = [
            'message' => $result ? '' : 'No Paystub Found for this Employee',
            'employeeNetpay' => $result
        ];
    } else {
        $data['message'] = 'No SSN provided';
    }

    // Redirect to a specific HTML page to display results
    $relativePath = preg_replace('/\/[A-Za-z0-9]+(\.*\w*)(\?(.)*)*$/', '/', $_SERVER['REQUEST_URI']);
    header("Location:" . $relativePath . "app/employeeNetpay.php?" . http_build_query($data));
    exit;
} elseif (isset($_POST['submit-employee-paystub'])) {
    $conditions = [];
    $message = "Success";
    $errors = [];
    $attributes = [
        "Paystub_id",
        "Essn",
        "Start_date",
        "End_date",
        "Gross_pay",
        "Deductions",
        "Net_pay"
    ];

    // Create conditions for query and where statement
    foreach ($attributes as $attribute) {
        $value = $_POST[$attribute];
        if ($value) {
            $conditions[":$attribute"] = $value;
        } else {
            $errors[] = $attribute;
        }
    }

    if ($errors) {
        $message = "Could not add paystubs - Empty attributes " . implode(", ", $errors);
    } else {
        // Insert Sql statment with interpolated variables `:variable`
        $sql = "INSERT INTO paystub (Paystub_id, Essn, Start_date, End_date, Gross_pay, Deductions, Net_pay) VALUES (:Paystub_id, :Essn, :Start_date, :End_date, :Gross_pay, :Deductions, :Net_pay)";
        // Insert data from post action
        $result = $db->insert_paystub($sql, $conditions);

        if (is_string($result)) {
            $message = "Could not add paystub - " . $result;
        } else {
            $data['paystub'] = $result;
        }
    }

    // Return calls
    $data['message'] = $message;

//Project Button Selected from Client folder --> Main.php
}elseif(isset($_POST['projectBtn'])) {
    //view projects
    $projectData = $db ->query("SELECT Pname,Pstart_date,d.Dname AS Dept_Name FROM project JOIN department d ON d.Dnumber = Dnum;");
    session_start();
    $_SESSION['projectData'] = $projectData;
    //Redirect from the main client page to projects.php
    header("Location:http://localhost/xampp/company-db-dashboard/Phase3/app/client/projects.php");
    exit;

//Exit button selected from projects.php
}elseif(isset($_POST['exitBtn'])){
    //redirects from projects.php to main.php
    header("Location:http://localhost/xampp/company-db-dashboard/Phase3/app/client/main.php");
    exit;

//Edit button selected from projects.php
}elseif(isset($_POST['editBtn'])){
    //redirects from projects.php to editProjects.php
    header("Location:http://localhost/xampp/company-db-dashboard/Phase3/app/client/editProjects.php");
    exit;


//Save button selected from editProjects.php
}elseif(isset($_POST['saveBtn'])){
    //Get old project name from client
    $oldProject = $_POST['oldProjectName'];

    //Get the new project name from client
    $newProject = $_POST['newProjectName'];
    //Update the name of the project from Project table
    $updateProjName = $db -> query("UPDATE project SET Pname = '$newProject' WHERE Pname = '$oldProject'");

    //get updated table:
    $projectData = $db ->query("SELECT Pname,Pstart_date,d.Dname AS Dept_Name FROM project JOIN department d ON d.Dnumber = Dnum;");
    session_start();
    $_SESSION['projectData'] = $projectData;

    header("Location:http://localhost/xampp/company-db-dashboard/Phase3/app/client/projects.php");
    exit;
}
//view emplpoyee information button selected from projects.php
elseif(isset($_POST['viewEmpBtn'])){
    //get employee contact information
    $viewEmp = $db -> query(
        "  SELECT p.Pname, e.Ssn, ec.Email, ec.Address, ec.Phone 
                FROM project p 
                JOIN employee e ON p.Dnum = e.Dno 
                JOIN emp_contact ec ON e.Ssn = ec.Essn");
    //create a session 
    session_start();
    $_SESSION['viewEmp']= $viewEmp;

    //redirect to view employee information page
    header("Location:http://localhost/xampp/company-db-dashboard/Phase3/app/client/viewEmp.php");
    exit();
}
//view manager information button selected from projects.php
elseif(isset($_POST['viewManagerBtn'])){
    //get manager info 
    $viewManager = $db ->query(
        "  SELECT d.Mgr_ssn, p.Pname, ec.Email, ec.Phone, ec.Address
                FROM works_on wo
                JOIN department d ON d.Mgr_ssn = wo.Essn
                JOIN project p ON wo.Pno = p.Pnumber
                JOIN emp_contact ec ON d.Mgr_ssn = ec.Essn;"
    );

    //create a session
    session_start();
    $_SESSION['viewManager'] = $viewManager;

    //redirect to view manager info page:
    header("Location:http://localhost/xampp/company-db-dashboard/Phase3/app/client/viewManager.php");
    exit();
}


