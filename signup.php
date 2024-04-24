<?php
$showAlart = false;
$showError = false;
$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'partials/_dbconnect.php';
    $username = $_POST["username"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];
    $exists = false;
    // https://youtu.be/PnqppM2t_hk?list=PLu0W_9lII9aikXkRE0WxDt1vozo3hnmtR&t=349
    // use of exixst
    // for ensuring the primary key 
    $exist = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $exist);
    $numRows = mysqli_num_rows($result);
    if ($numRows > 0) {
        $showError = true;
        $error = "Username alredy Exist !!!";
    } else {
        if ($password == $cpassword) {
            // when you use hash must take varchar 255 for the password 
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (username, password) VALUES ('$username', '$hash')";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $showAlart  = true;
            } else {
                $showError = true;
                $error = "Failed to insert record!";
            }
        } else {
            $showError = true;
            $error = "Passwords do not match!";
        }
    }
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>signup</title>
    <link rel="shortcut icon" href="./images/add-user.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
</head>

<body>
    <?php
    require 'partials/_nav.php';
    ?>
    <div class="container p-5">
        <?php
        if ($showAlart) {
            echo '
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success erzlich willkommen!</strong> Your account is now created and you can login
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        ';
        }
        if ($showError) {
            echo '
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Entschuldigung!!!  </strong>' . $error . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        ';
        }
        ?>
        <h2 class="text-center mb-5">SignUp To Bark</h2>
        <div class="row justify-content-center text-center">
            <div class="border border-success rounded-4 col-md-6">
                <form class="p-3" action="./signup.php" method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" maxlength="100" class="form-control" id="username" name="username" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">First Name</label>
                        <input type="text" maxlength="100" class="form-control" id="username" name="f-name" aria-describedby="emailHelp" require>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Last Name</label>
                        <input type="text" maxlength="100" class="form-control" id="username" name="l-name" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Gmail</label>
                        <input type="text" maxlength="100" class="form-control" id="username" name="gmail" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Gsuit</label>
                        <input type="text" maxlength="100" class="form-control" id="username" name="gsuit" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="dob" class="form-label">Date of Birth</label>
                        <input type="text" maxlength="100" class="form-control" id="dob" name="dob" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="h-town" class="form-label">Home Town</label>
                        <select class="form-select" aria-label="Default select example">
                            <option selected>Select Your Home Town</option>
                            <option value="1">Dhaka</option>
                            <option value="2">Chittagong</option>
                            <option value="3">Khulna</option>
                            <option value="4">Maymensingh</option>
                            <option value="5">Rajshahi</option>
                            <option value="6">Rangpur</option>
                            <option value="7">Sylhet</option>
                            <option value="8">Barisal</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="mb-3">
                        <label for="cpassword" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="cpassword" name="cpassword">
                        <small id="cpassword" class="form-text text-muted">make sure you type the same password</small>
                    </div>
                    <button type="submit" class="btn btn-primary col-12">SignUp</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script>
        $(function() {
            $("#dob").datepicker({
                dateFormat: 'yy-mm-dd', // Format date as 'yyyy-mm-dd'
                changeMonth: true, // Allow changing month
                changeYear: true, // Allow changing year
                yearRange: "-100:+0", // Set year range from 100 years ago to present
                maxDate: '0' // Set max date to today's date
            });
        });
    </script>

</body>

</html>