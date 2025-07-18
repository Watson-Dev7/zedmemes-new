<?php include './components/Header.php'; ?>
<?php include './components/NavBar.php'; ?>

<div class="grid-container">
  <div id="showUpload">
    <div class="upload hide">
      <h1>Upload Meme</h1>
      <div id="preview" class="memeBorder"></div>
      <form id="uploadForm" enctype="multipart/form-data">
        <input type="file" name="image" id="image" accept="image/*" required>
        <button id="post" type="submit" class="button" onclick="triggerThrobber() ">Post</button>
      </form>
    </div>

  </div>

  <div id="form-errors" class="error-message"></div>
  <!-- Overlay Container -->
  <div id="form-overlay" class="overlay hidden">
    <div class="form-popup" id="form-content">
      <h2 id="form-title">Log In</h2>
      <form id="auth-form">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <div id="extra-fields" class="hidden">
          <input type="email" name="email" placeholder="Email">
          <input type="password" name="confirm_password" placeholder="Confirm Password">
        </div>
        <button type="submit" id="login">
          <p id="addSign">Log in</p>
        </button>
        <div id="hideMe">
          <button type="button" onclick="openForm('signup')">
            <p>Sign up</p>
          </button>
        </div>
      </form>
    </div>
  </div>

  <section id="scroll">
    <div class="grid-x grid-margin-x">



      <!-- Add this where you want memes to appear -->
      <!-- <div id="getData" class="grid-x grid-margin-x"></div> -->
      <div id="center">
        <span id="show"></span>
      </div>

    </div>
  </section>
</div>

<?php include './components/Footer.php'; ?>