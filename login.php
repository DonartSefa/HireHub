<?php include_once 'header.php'; ?>

<style>
  body, html {
    height: 100%;
    margin: 0;
    font-family: 'Inter', sans-serif;
    background-color: #f6f6f3;
  }
  
  .login-section {
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px;
  }

  .card {
    border-radius: 25px;
    box-shadow: 0 8px 25px rgba(132,108,59,0.2);
    background-color: white;
    max-width: 900px;
    width: 100%;
    padding: 40px;
  }

  .login-title {
    font-weight: 700;
    color: #846c3b;
    font-size: 2.5rem;
    margin-bottom: 2rem;
    text-align: center;
  }

  form {
    max-width: 400px;
    margin: 0 auto;
  }

  .form-control {
    border: 2px solid #846c3b;
    border-radius: 8px;
    padding: 12px 15px;
    font-size: 1rem;
    transition: border-color 0.3s ease;
  }

  .form-control:focus {
    border-color: #6c552f;
    outline: none;
    box-shadow: 0 0 8px rgba(132,108,59,0.4);
  }

  label {
    color: #555;
    font-weight: 600;
  }

  .form-check-label a {
    color: #846c3b;
    text-decoration: none;
    font-weight: 600;
  }

  .form-check-label a:hover {
    text-decoration: underline;
  }

  .form-check {
    margin-bottom: 1.5rem;
  }

  .btn-primary {
    background-color: #846c3b;
    border: none;
    padding: 12px 30px;
    font-size: 1.1rem;
    font-weight: 700;
    border-radius: 8px;
    cursor: pointer;
    width: 100%;
    transition: background-color 0.3s ease;
  }

  .btn-primary:hover {
    background-color: #6c552f;
  }

  .signup-text {
    text-align: center;
    margin-top: 1rem;
    color: #555;
    font-weight: 600;
  }

  .signup-text a {
    color: #846c3b;
    font-weight: 700;
    text-decoration: none;
    margin-left: 5px;
  }

  .signup-text a:hover {
    text-decoration: underline;
  }

  /* Responsive */
  @media (max-width: 768px) {
    .card {
      padding: 30px 20px;
    }
    .login-title {
      font-size: 2rem;
    }
  }
</style>

<section class="login-section">
  <div class="card">
    <p class="login-title">Log in</p>
    <form action="loginLogic.php" method="POST" novalidate>

      <div class="mb-4">
        <label for="form3Example1c">Your Email</label>
        <input type="email" name="email" id="form3Example1c" class="form-control" required />
      </div>

      <div class="mb-4">
        <label for="form3Example4c">Password</label>
        <input type="password" name="password" id="form3Example4c" class="form-control" required />
      </div>

      <div class="form-check mb-4">
        <input class="form-check-input" type="checkbox" value="" id="form2Example3c" />
        <label class="form-check-label" for="form2Example3c">
          I agree all statements in <a href="#!">Terms of service</a>
        </label>
      </div>

      <button type="submit" name="submit" class="btn btn-primary">Log in</button>

      <p class="signup-text">Don't have an account! <a href="register.php">Sign Up</a></p>
    </form>
  </div>
</section>

<?php include_once 'footer.php'; ?>
