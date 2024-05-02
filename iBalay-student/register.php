<!DOCTYPE html>
<html lang="en">
<head>
    <title>Tenant Sign Up</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="img js-fullheight" style="background-image: url(images/bg2.png); background-size: cover; background-attachment: fixed;">

    
<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="login-wrap p-0">
                    <h3 class="mb-4 text-center">Tenant - Sign up</h3>
<form action="register_process.php" method="POST" class="signin-form">
    <div class="form-group">
        <input type="text" class="form-control" placeholder="First Name" required name="FirstName">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" placeholder="Last Name" required name="LastName">
    </div>
    <div class="form-group">
        <input type="email" class="form-control" placeholder="Email" required name="Email">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" placeholder="Phone Number" required name="PhoneNumber">
    </div>
    <div class="form-group">
        <input id="password-field" type="password" class="form-control" placeholder="Password" required name="Password">
        <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
    </div>
    <div class="form-group">
        <input type="text" class="form-control" placeholder="Student ID Number" required name="student_id">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" placeholder="Address" required name="address">
    </div>
    <div class="form-group">
        <select class="form-control" required name="gender">
            <option value="">Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select>
    </div>
    <div class="form-group">
        <button type="submit" class="form-control btn btn-primary submit px-3">Sign Up</button>
    </div>
</form>
                    <br>
                    <br>

                    <div class="text-center">
                        <p style="color: #fff;">Already have an account? <a href="/iBalay.com/iBalay-student/login.php" style="color: #fff;">Sign in here!</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="js/jquery.min.js"></script>
<script src="js/popper.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/main.js"></script>

</body>
</html>
