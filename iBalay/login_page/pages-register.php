<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Pages / Register</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <link href="./.././assets/img/evsu.png" rel="icon">
  <link href="./.././assets/img/evsu.png" rel="apple-touch-icon">

  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <link href="./.././assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="./.././assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="./.././assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="./.././assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="./.././assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="./.././assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="./.././assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <link href="./.././assets/css/style.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body>

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="card mb-3">

                <div id="thankYouMessage" class="text-center" style="display: none;">
                  <h5 class="card-title pb-2 fs-4">Thank you for registering!</h5>
                  <p class="text-center small">
                    Your account is pending approval. You will be notified once it is approved.
                    You can also <a href="pages-login.php">log in</a> to check the condition of your account. Thank you!
                  </p>
                </div>

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Create iBalay Account</h5>
                    <p class="text-center small">Enter your personal details to create account</p>
                  </div>

                    <form class="row g-3 needs-validation" novalidate enctype="multipart/form-data">
                    <div class="col-12">
                      <label for="ownerName" class="form-label">Your Name</label>
                      <input type="text" name="name" class="form-control" id="ownerName" required>
                      <div class="invalid-feedback">Please, enter your name!</div>
                    </div>

                    <div class="col-12">
                      <label for="ownerEmail" class="form-label">Your Email</label>
                      <input type="email" name="email" class="form-control" id="ownerEmail" required>
                      <div class="invalid-feedback">Please enter a valid Email address!</div>
                    </div>

                    <div class="col-12">
                      <label for="ownerUsername" class="form-label">Username</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="text" name="username" class="form-control" id="ownerUsername" required>
                        <div class="invalid-feedback">Please choose a username.</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="ownerPassword" class="form-label">Password</label>
                      <input type="password" name="password" class="form-control" id="ownerPassword" required>
                      <div class="invalid-feedback">Please enter your password!</div>
                    </div>

                    <div class="col-12">
                      <label for="ownerLocation" class="form-label">Location</label>
                      <input type="text" name="location" class="form-control" id="ownerLocation" required>
                    </div>

                    <div class="col-12">
                      <label for="ownerContactNumber" class="form-label">Contact Number</label>
                      <input type="text" name="contact_number" class="form-control" id="ownerContactNumber" required>
                    </div>

                      <div class="col-12">
                        <label for="ownerPhoto" class="form-label">Upload Profile Photo</label>
                        <input type="file" name="ownerPhoto[]" class="form-control" id="ownerPhoto" multiple required>
                      </div>

                      <div class="col-12 mb-3">
                        <label for="ownerDocuments1" class="form-label">
                          Required Documents 
                          <span data-bs-toggle="tooltip" data-bs-placement="top" title="Boarding House Permit, Tax Permit, Safety Permit, PDF, PNG, JPEG ONLY!!">
                            <i class="bi bi-question-circle"></i>
                          </span>
                        </label>
                        <input type="file" name="ownerDocuments1[]" class="form-control" id="ownerDocuments1" multiple required>
                      </div>
                      <div class="col-12 mb-3">
                        <input type="file" name="ownerDocuments2[]" class="form-control" id="ownerDocuments2" multiple required>
                      </div>

                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" name="terms" type="checkbox" value="" id="acceptTerms" required>
                                <label class="form-check-label" for="acceptTerms">
                                    I agree and accept the <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">terms and conditions</a>
                                </label>
                                <div class="invalid-feedback">You must agree before submitting.</div>
                            </div>
                        </div>

                          <input type="hidden" name="approval_status" id="approvalStatus" value="pending">

                          <div class="col-12">
                            <button class="btn btn-primary w-100" type="button" id="submitBtn">Create Account</button>
                          </div>

                          <div id="errorMessage" class="alert alert-danger" style="display: none;"></div>

                          <div class="col-12">
                            <p class="small mb-0">Already have an account? <a href="pages-login.php">Log in</a></p>
                          </div>
                        </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>

            <!-- Modal for Terms and Condition (kailangan pa ada ig edit)-->
            <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="termsModalLabel">Terms and Conditions</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <h2>Welcome to iBalay!</h2>
                            <p>These terms and conditions outline the rules and regulations for the use of iBalay's website.</p>
                            <p>By accessing this website, we assume you accept these terms and conditions. Do not continue to use iBalay if you do not agree to all of the terms and conditions stated on this page.</p>
                            <h3>1. Definitions</h3>
                            <p>The following terminology applies to these Terms and Conditions, Privacy Statement, and Disclaimer Notice and all agreements:</p>
                            <h3>2. Cookies</h3>
                            <p>We employ the use of cookies. By accessing iBalay, you agree to use cookies in agreement with iBalay's Privacy Policy.</p>
                            <h3>3. License</h3>
                            <p>Unless otherwise stated, iBalay and/or its licensors own the intellectual property rights for all material on iBalay. All intellectual property rights are reserved.</p>
                            <h3>4. Comments</h3>
                            <p>Parts of this website offer an opportunity for users to post and exchange opinions and information in certain areas of the website.</p>
                            <h3>5. Hyperlinking</h3>
                            <p>The following organizations may link to our Website without prior written approval:</p>
                            <h3>6. iFrames</h3>
                            <p>Without prior approval and written permission, you may not create frames around our Webpages that alter the visual presentation or appearance of our Website.</p>
                            <h3>7. Content Liability</h3>
                            <p>We shall not be held responsible for any content that appears on your Website.</p>
                            <h3>8. Your Privacy</h3>
                            <p>Please read our Privacy Policy for information on how we handle your privacy.</p>
                            <h3>9. Disclaimer</h3>
                            <p>To the maximum extent permitted by applicable law, we exclude all representations, warranties, and conditions relating to our website and the use of this website.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

      <input type="hidden" name="approval_status" id="approvalStatus" value="pending">

  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

   <!-- Vendor JS Files -->
  <script src="./.././assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="./.././assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="./.././assets/vendor/chart.js/chart.umd.js"></script>
  <script src="./.././assets/vendor/echarts/echarts.min.js"></script>
  <script src="./.././assets/vendor/quill/quill.min.js"></script>
  <script src="./.././assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="./.././assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="./.././assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="./.././assets/js/main.js"></script>

  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>



      <script>
        $(document).ready(function () {
          $('#submitBtn').on('click', function () {
            var form = $('form')[0];
            if (form.checkValidity()) {
              $(this).prop('disabled', true);
              $('#errorMessage').hide();

              var formData = new FormData(form);

              $.ajax({
                type: 'POST',
                url: 'process_registration.php',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                  if (response === 'pending') {
                    showThankYouMessage();
                  } else {
                    $('#errorMessage').text(response.error || 'Account registration failed. Please try again.');
                    $('#errorMessage').show();
                    $('#submitBtn').prop('disabled', false);
                  }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                  console.error('AJAX error:', textStatus, errorThrown);
                  $('#errorMessage').text('An error occurred. Please try again.');
                  $('#errorMessage').show();
                  $('#submitBtn').prop('disabled', false);
                },
                complete: function () {
                }
              });
            } else {
              $('#errorMessage').text('Please fill in all required fields.');
              $('#errorMessage').show();
              $(form).find(':input').each(function () {
                if (!this.checkValidity()) {
                  $(this).addClass('is-invalid');
                } else {
                  $(this).removeClass('is-invalid');
                }
              });
            }
          });

          $('#thankYouMessage a').on('click', function (event) {
            event.preventDefault();
            window.location.href = $(this).attr('href');
          });

          function showThankYouMessage() {
            $('.card-body').hide();
            $('#errorMessage').hide();
            $('#thankYouMessage').show();
          }
        });
      </script>

</body>
</html>