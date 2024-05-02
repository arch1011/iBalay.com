<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/img/evsu.png" rel="icon">
    <style>
     @import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap');
*{
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Poppins', sans-serif;
}
html,body{
  display: grid;
  height: 100%;
  width: 100%;
  place-items: center;
  background: -webkit-linear-gradient(left, #003366,#004080,#0059b3
, #0073e6);
}
::selection{
  background: #1a75ff;
  color: #fff;
}
.wrapper{
  overflow: hidden;
  max-width: 390px;
  background: #fff;
  padding: 30px;
  border-radius: 15px;
  box-shadow: 0px 15px 20px rgba(0,0,0,0.1);

}
.wrapper .title-text{
  display: flex;
  width: 200%;
}
.wrapper .title{
  width: 50%;
  font-size: 30px;
  font-weight: 600;
  text-align: center;
  transition: all 0.6s cubic-bezier(0.68,-0.55,0.265,1.55);
}
.wrapper .slide-controls{
  position: relative;
  display: flex;
  height: 50px;
  width: 100%;
  overflow: hidden;
  margin: 30px 0 10px 0;
  justify-content: space-between;
  border: 1px solid lightgrey;
  border-radius: 15px;
}
.slide-controls .slide{
  height: 100%;
  width: 100%;
  color: #fff;
  font-size: 18px;
  font-weight: 500;
  text-align: center;
  line-height: 48px;
  cursor: pointer;
  z-index: 1;
  transition: all 0.6s ease;
}
.slide-controls label.signup{
  color: #000;
}
.slide-controls .slider-tab{
  position: absolute;
  height: 100%;
  width: 50%;
  left: 0;
  z-index: 0;
  border-radius: 15px;
  background: -webkit-linear-gradient(left,#003366,#004080,#0059b3
, #0073e6);
  transition: all 0.6s cubic-bezier(0.68,-0.55,0.265,1.55);
}
input[type="radio"]{
  display: none;
}
#signup:checked ~ .slider-tab{
  left: 50%;
}
#signup:checked ~ label.signup{
  color: #fff;
  cursor: default;
  user-select: none;
}
#signup:checked ~ label.login{
  color: #000;
}
#login:checked ~ label.signup{
  color: #000;
}
#login:checked ~ label.login{
  cursor: default;
  user-select: none;
}
.wrapper .form-container{
  width: 100%;
  overflow: hidden;
}
.form-container .form-inner{
  display: flex;
  width: 200%;
}
.form-container .form-inner form{
  width: 50%;
  transition: all 0.6s cubic-bezier(0.68,-0.55,0.265,1.55);
}
.form-inner form .field{
  height: 50px;
  width: 100%;
  margin-top: 20px;
}
.form-inner form .field input{
  height: 100%;
  width: 100%;
  outline: none;
  padding-left: 15px;
  border-radius: 15px;
  border: 1px solid lightgrey;
  border-bottom-width: 2px;
  font-size: 17px;
  transition: all 0.3s ease;
}
.form-inner form .field input:focus{
  border-color: #1a75ff;
}
.form-inner form .field input::placeholder{
  color: #999;
  transition: all 0.3s ease;
}
form .field input:focus::placeholder{
  color: #1a75ff;
}
.form-inner form .pass-link{
  margin-top: 5px;
}
.form-inner form .signup-link{
  text-align: center;
  margin-top: 30px;
}
.form-inner form .pass-link a,
.form-inner form .signup-link a{
  color: #1a75ff;
  text-decoration: none;
}
.form-inner form .pass-link a:hover,
.form-inner form .signup-link a:hover{
  text-decoration: underline;
}
form .btn{
  height: 50px;
  width: 100%;
  border-radius: 15px;
  position: relative;
  overflow: hidden;
}
form .btn .btn-layer{
  height: 100%;
  width: 300%;
  position: absolute;
  left: -100%;
  
  background: -webkit-linear-gradient(right,#003366,#004080,#0059b3
, #0073e6);
  border-radius: 15px;
  transition: all 0.4s ease;;
}
form .btn:hover .btn-layer{
  left: 0;
}
form .btn input[type="submit"]{
  height: 100%;
  width: 100%;
  z-index: 1;
  position: relative;
  background: none;
  border: none;
  color: #fff;
  padding-left: 0;
  border-radius: 15px;
  font-size: 20px;
  font-weight: 500;
  cursor: pointer;
}

.form-inner form .field.file-input {
  position: relative;
  overflow: hidden;
  margin-left: 10px;
}

.field.file-input {
    position: relative;
    overflow: hidden;
    width: 95%;
    margin-left: 10px; /* Adjust margin as needed */
}

.field.file-input input[type="file"] {
    position: absolute;
    left: 0;
    top: 0;
    opacity: 0;
    width: 80%;
    height: 100%;
    cursor: pointer;
}

.field.file-input .file-upload-label {
    position: absolute;
    top: 0;
    left: 0;
    width: 95%;
    height: 100%;
    padding: 10px; /* Adjust padding as needed */
    background: -webkit-linear-gradient(right,#003366,#004080,#0059b3
, #0073e6);
    color: #fff; /* Button text color */
    border-radius: 15px;
    cursor: pointer;
    box-sizing: border-box;
    text-align: center;
    line-height: 30px; /* Adjust line height to vertically center text */
}

.field.file-input:hover .file-upload-label {
    background-color: #0059b3; /* Button background color on hover */
}

.form-inner form .field select {
  height: 50px;
  width: 100%;
  outline: none;
  padding-left: 15px;
  border-radius: 15px;
  border: 1px solid lightgrey;
  border-bottom-width: 2px;
  font-size: 17px;
  transition: all 0.3s ease;
  appearance: none; /* Remove default arrow */
  background: transparent; /* Set transparent background */
  background-image: url('data:image/svg+xml;utf8,<svg fill="#000000" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/><path d="M0 0h24v24H0z" fill="none"/></svg>'); /* Add custom arrow */
  background-repeat: no-repeat;
  background-position: right 10px center;
}

.form-inner form .field select:focus {
  border-color: #1a75ff;
}

.form-inner form .field select option {
  color: #000; /* Set text color */
  background: #fff; /* Set background color */
}

</style>
</head>

<body>
<div class="wrapper">
      <div class="title-text">
        <div class="title login">Welcome Back!</div>
        <div class="title signup">Signup Form</div>
      </div>
      <div class="form-container">
        <div class="slide-controls">
          <input type="radio" name="slide" id="login" checked>
          <input type="radio" name="slide" id="signup">
          <label for="login" class="slide login">Login</label>
          <label for="signup" class="slide signup">Signup</label>
          <div class="slider-tab"></div>
        </div>
        <div class="form-inner">
          <form action="login_process.php" method="POST" class="login">
            <div class="field">
              <input type="text" placeholder="Email Address" required name="email">
            </div>
            <div class="field">
              <input type="password" placeholder="Password" required name="password">
            </div>
            <div class="pass-link"><a href="#">Forgot password?</a></div>
            <div class="field btn">
              <div class="btn-layer"></div>
              <input type="submit" value="Login">
            </div>
            <div class="signup-link">Not a member? <a href="#signup">Signup now</a></div>
          </form>
          <form action="register_process.php" method="POST" class="signup">
              <div class="field">
                  <input type="text" name="FirstName" placeholder="First Name" required>
              </div>
              <div class="field">
                  <input type="text" name="LastName" placeholder="Last Name" required>
              </div>
              <div class="field">
                  <input type="email" name="Email" placeholder="Email Address" required>
              </div>
              <div class="field">
                  <input type="text" name="PhoneNumber" placeholder="Phone Number" required>
              </div>
              <div class="field">
                  <input type="password" name="Password" placeholder="Password" required>
              </div>
              <div class="field">
                  <input type="text" name="student_id" placeholder="Student ID Number" required>
              </div>
              <div class="field">
                  <input type="text" name="address" placeholder="Address" required>
              </div>
              <div class="field">
                  <select name="gender" required>
                      <option value="">Select Gender</option>
                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                  </select>
              </div>
              <div class="field btn">
                  <div class="btn-layer"></div>
                  <input type="submit" value="Signup">
              </div>
          </form>
        </div>
      </div>
    </div>

</body>

<script>
     const loginText = document.querySelector(".title-text .login");
      const loginForm = document.querySelector("form.login");
      const loginBtn = document.querySelector("label.login");
      const signupBtn = document.querySelector("label.signup");
      const signupLink = document.querySelector("form .signup-link a");
      signupBtn.onclick = (()=>{
        loginForm.style.marginLeft = "-50%";
        loginText.style.marginLeft = "-50%";
      });
      loginBtn.onclick = (()=>{
        loginForm.style.marginLeft = "0%";
        loginText.style.marginLeft = "0%";
      });
      signupLink.onclick = (()=>{
        signupBtn.click();
        return false;
      });

</script>

</html> 
