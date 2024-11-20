<html>

<head>
    <title>Company Login</title>
    <!-- Bootstrap for css styling -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .back {
            background: #e2e2e2;
            width: 100%;
            position: absolute;
            top: 0;
            bottom: 0;
        }

        .back h1 {
            padding-top: 20px;
            text-align: center;
        }

        .div-center {
            width: 400px;
            height: 400px;
            background-color: #fff;
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            margin: auto;
            max-width: 100%;
            max-height: 100%;
            overflow: auto;
            padding: 1em 2em;
            border-bottom: 2px solid #ccc;
            display: table;
        }

        div.content {
            display: table-cell;
            vertical-align: middle;
        }
    </style>
</head>

<body>
    <div class="back">
        <h1>Company Database</h1>
        <div class="div-center">
            <div class="content">
                <h3>Login</h3>
                <hr />
                <form method="post" action="<?= preg_replace('/\/[A-Za-z0-9]+(\.*\w*)(\?(.)*)*$/', '/', $_SERVER['REQUEST_URI']); ?>controller.php">
                    <?php if (isset($error_msg)) { ?>
                        <p style="color: red;"><?php echo htmlspecialchars($error_msg); ?></p>
                    <?php } ?>
                    <div class="form-group">
                        <label for="id">ID</label>
                        <input type="text" name="id" class="form-control" placeholder="Your ID">
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" name="email" class="form-control" placeholder="Email">
                    </div>
                    <br>
                    <button type="submit" name="login-manager" class="btn btn-primary">Login as Manager</button>
                    <br>
                    <br>
                    <button type="submit" name="login-employee" class="btn btn-primary">Login as Employee</button>
                    <br>
                    <br>
                    <button type="submit" name="login-client" class="btn btn-primary">Login as Client</button>
                    <br>
                    <br>
                </form>
            </div>
        </div>
    </div>  
</body>

</html>
