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
<!-- <script src="test.Response.js"></script> -->

<script src="start.js"></script>
<script src="foundation/js/main.js"></script>

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
            hidBut.textContent = " ";
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

    h1 {
        text-decoration: solid;
        text-align: center;


        font-family: Arial, Helvetica, sans-serif;
        color: #0077cc;
    }

    .welcome {
        box-shadow: #050505;
        border: none;
        justify-content: center;
        align-items: center;
        margin: 100px;

    }

    .click {
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

    .click:hover {
        background-color: #353f7e;
        color: #ccc;
        cursor: pointer;
    }
</style>
</body>

</html>