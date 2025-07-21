    </main>

    <footer>
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> ZedMemes. All rights reserved.</p>
        </div>
    </footer>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Foundation JS -->
    <script src="https://cdn.jsdelivr.net/npm/foundation-sites@6.7.5/dist/js/foundation.min.js"></script>
    
    <!-- Main Application JavaScript -->
    <script src="/js/main.js"></script>
    
    <!-- Initialize Foundation -->
    <script>
        $(document).foundation();
        
        // Logout function
        function logout() {
            // You can add any client-side logout logic here
            // For example, redirecting to logout.php
            window.location.href = '/logout.php';
        }
    </script>

    <script>
        // Form handling functions
        function openForm(type) {
            const overlay = document.getElementById('form-overlay');
            if (!overlay) return;
            
            const title = document.getElementById('form-title');
            const value = document.getElementById('addSign');
            const extraFields = document.getElementById('extra-fields');
            const hidBut = document.getElementById('hideMe');

            overlay.classList.remove('hidden');

            if (type === 'signup') {
                if (title) title.textContent = 'Sign Up';
                if (extraFields) extraFields.classList.remove('hidden');
                if (value) value.textContent = 'Sign Up';
                if (hidBut) hidBut.textContent = " ";
            } else {
                if (title) title.textContent = 'Log In';
                if (extraFields) extraFields.classList.add('hidden');
            }
        }

        function closeForm() {
            const overlay = document.getElementById('form-overlay');
            if (overlay) {
                overlay.classList.add('hidden');
            }
        }
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