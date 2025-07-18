<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Foundation | Welcome</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/foundation-sites@6.7.5/dist/css/foundation.min.css" crossorigin="anonymous">
   
     <link rel="stylesheet" href="zedmem.css">
      <link rel="stylesheet" href="reaction.css">
    <link rel="stylesheet" href="foundatiob\css\foundation.css">
   
     <link rel="stylesheet" href="responsive.css">
    
      
</head>
  <body>
    <div class="grid-container">
      <main id="stack">
        <!-- Start Top Bar -->
        <div class="title-bar" data-responsive-toggle="responsive-menu" data-hide-for="medium">
          <button class="menu-icon" type="button" data-toggle="responsive-menu"></button>
          <div class="title-bar-title">            <span class="loading-logo">
        <span class="boarder-spinner"></span> <!--avoiding to spin the entire logo-->
        ZedMemes
    </span> </div>
        </div>

        <div class="top-bar" id="responsive-menu">
          <div class="top-bar-left">
            <h1 class="menu-text">            <span class="loading-logo">
        <span class="boarder-spinner"></span> <!--avoiding to spin the entire logo-->
        ZedMemes
    </span> </h1>
          </div>
          <div class="top-bar-right">
            <ul class="menu">
               <!-- Profile Button -->
<button id="profile-btn"  ><svg class="icons" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512l388.6 0c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304l-91.4 0z"/></svg>
    </button>
         <!-- <button class="click" onclick="openForm('login')">Log In</button> -->
<!-- <button class="click" onclick="openForm('signup')">Sign Up</button> -->
<!-- Overlay + Pop-up -->
<div id="profile-overlay" class="overlay hidden">
  <div class="popup">
    <img src="zedmems.jpg" alt="Profile Picture" class="profile-pic">
    <h3>@josephine</h3>
    <p class="description">Meme queen of ZedMemes. Loves cats, coding, and comedy.</p>
    <div class="popup-actions">
      <button class="cta-button" onclick="logout()">Log Out</button>
      <button onclick="closeProfile()">Close</button>
    </div>
  </div>
</div>
              <li><button class="button" id="openUploadButton" onclick="triggerThrobber()">Create Meme</button></li>
              <li><button class="button" onclick="triggerThrobber()">Remove Meme</button></li>
              <li><button class="button" onclick="triggerThrobber()">Filter</button></li>
            </ul>
          </div>
        </div>
        <!-- End Top Bar -->
      </main>

      <div id="showUpload">
       
      <div class="upload hide"  >
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
    <input type="email" name="email" placeholder="Email" >
    <input type="password" name="confirm_password" placeholder="Confirm Password" >
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
   <div  id="center">
  <span id="show"></span>
      </div>      
         
        </div>
      </section>

      <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/foundation-sites@6.7.5/dist/js/foundation.min.js"></script>
      <script>
        $(document).foundation();
      </script>
      <script src="script.js"></script>
     
      <script src="login.js"></script>
        
         <script src="spin.js"></script>
      <script src="pages/uploadMeme.js"></script>
       
         <!-- <script src="finalReceiveData.js"></script> -->
         <script src="test.Response.js"></script>
        
         <script src="start.js"></script>
         <!-- <script src="reaction.js"></script> -->

          <script>
       document.querySelectorAll('.cta-button').forEach(button => {
  button.addEventListener('click', () => {
    const icon = button.querySelector('.icons');

    // Trigger pop animation
    icon.classList.add('animate');

    icon.addEventListener('animationend', () => {
      icon.classList.remove('animate');
    }, { once: true });

    // Disable further clicks
    //button.disabled = true;
    //button.style.cursor = 'default';
  });
});


const profileBtn = document.getElementById('profile-btn');
const profileOverlay = document.getElementById('profile-overlay');

profileBtn.addEventListener('click', () => {
  profileOverlay.classList.remove('hidden');
});

function closeProfile() {
  profileOverlay.classList.add('hidden');
}

function logout() {
  alert("Logging out...");
  // Add logout logic here
  closeProfile();
}





      </script>

      
<script>
    function openForm(type) {
  const overlay = document.getElementById('form-overlay');
  const title = document.getElementById('form-title');
  const value = document.getElementById('addSign');
  const extraFields = document.getElementById('extra-fields');

  const hidBut = document.getElementById('hideMe');

  overlay.classList.remove('hidden');

  if (type === 'signup') {
    title.textContent = 'Sign Up';
    extraFields.classList.remove('hidden');
    
    value.textContent = 'Sign Up';
    hidBut.textContent=" ";
  } else {
    title.textContent = 'Log In';
    extraFields.classList.add('hidden');
  }
}

function closeForm() {
  document.getElementById('form-overlay').classList.add('hidden');
}

// Login form will be shown when user clicks the login button
</script>
<style>

    
        /* Overlay */
.overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.884);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

/* Hide by default */
.hidden {
  display: none;
}

/* Pop-up form */
.form-popup {
  background: #fff;
  padding: 20px;
  width: 300px;
  border-radius: 10px;
  box-shadow: 0 0 15px rgba(221, 215, 215, 0.3);
  text-align: center;
}

.form-popup input {
  width: 90%;
  padding: 8px;
  margin: 8px 0;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.form-popup button {
  margin: 5px;
  padding: 8px 12px;
  border: none;
  background-color: #0077cc;
  color: white;
  border-radius: 5px;
  cursor: pointer;
}

.form-popup button:hover {
  background-color: #005fa3;
}
h1{
    text-decoration: solid;
    text-align: center;
    
    
    font-family: Arial, Helvetica, sans-serif;
    color: #0077cc;
}
.welcome
{
    box-shadow: #050505;
    border: none;
    justify-content: center;
    align-items: center;
    margin: 100px;

}
.click
{
    width: 150px;
    padding: 15px;
    font-size: large;
    color: #005fa3;
    background-color: #ccc;
    border-radius: 20px;
    margin: 10px;
    font-weight: bold;
    text-align: center;
    
}
.click:hover{
    background-color: #353f7e;
    color: #ccc;
    cursor: pointer;
}



</style>
    </div>
  </body>
</html>