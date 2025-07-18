<?php include '../components/Header.php'?>

  <div class="login-wrapper">
    <form class="login-form">
      <h2>ZedMemes Login</h2>

      <div class="input-group">
        <label for="username">Username</label>
        <input type="text" id="username" placeholder="Enter your username" required />
      </div>

      <div class="input-group">
        <label for="password">Password</label>
        <input type="password" id="password" placeholder="Enter your password" required />
      </div>

      <div class="options">
        <label>
          <input type="checkbox" />
          Remember me
        </label>
        <a href="#">Forgot password?</a>
      </div>

      <button type="submit" class="login-btn">Login</button>

      <p class="signup-text">Don't have an account? <a href="#">Sign up</a></p>
    </form>
  </div>


  <?php include'../components/Footer.php'?>
