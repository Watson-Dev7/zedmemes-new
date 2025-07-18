document.getElementById('auth-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const form = this;
    const formData = new FormData(form);
    const action = document.getElementById('addSign').textContent.trim() === 'Log in' ? 'login' : 'signup';
    
    // Client-side validation
    if (action === 'signup') {
        const password = formData.get('password');
        const confirmPassword = formData.get('confirm_password');
        
        if (password !== confirmPassword) {
            alert('Passwords do not match');
            return;
        }
    }
    
    // Remove unused fields
    if (action === 'login') {
        formData.delete('email');
        formData.delete('confirm_password');
    }
    
    formData.append('action', action);
    
    // Show loading state
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = 'Processing...';
    submitBtn.disabled = true;
    
    fetch('login.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        // First check if response is JSON
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            throw new Error('Invalid response from server');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Show success message
            alert(data.message || 'Operation successful');
            
            // Close the login/signup form
            if (typeof closeForm === 'function') {
                closeForm();
            }
            
            // Redirect if redirect URL is provided
            if (data.redirect) {
                // Small delay to show success message before redirect
                setTimeout(() => {
                    window.location.href = data.redirect;
                }, 500);
            } else {
                // If no redirect, reload the page to update the UI
                window.location.reload();
            }
        } else {
            alert(data.message || 'An error occurred');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        // Show more detailed error message if available
        const errorMessage = error.message || 'Request failed. Please check console for details.';
        alert(errorMessage);
    })
    .finally(() => {
        // Restore button state
        if (submitBtn && originalText) {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }
    });
});

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
