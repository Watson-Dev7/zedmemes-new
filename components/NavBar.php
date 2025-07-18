<main id="stack">
    <!-- Start Top Bar -->
    <div class="title-bar" data-responsive-toggle="responsive-menu" data-hide-for="medium">
      <button class="menu-icon" type="button" data-toggle="responsive-menu"></button>
      <div class="title-bar-title"> <span class="loading-logo">
          <span class="boarder-spinner"></span> <!--avoiding to spin the entire logo-->
          ZedMemes
        </span> </div>
    </div>

    <div class="top-bar" id="responsive-menu">
      <div class="top-bar-left">
        <h1 class="menu-text"> <span class="loading-logo">
            <span class="boarder-spinner"></span> <!--avoiding to spin the entire logo-->
            ZedMemes
          </span> </h1>
      </div>
      <div class="top-bar-right">
        <ul class="menu">
          <!-- Profile Button -->
          <button id="profile-btn"><svg class="icons" xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
              <path
                d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512l388.6 0c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304l-91.4 0z" />
            </svg>
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