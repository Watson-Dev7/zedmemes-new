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





    