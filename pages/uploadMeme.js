document.getElementById("openUploadButton").addEventListener("click", function() {
    
  document.body.classList.add("modal-open");
  document.querySelectorAll('.hide').forEach(el => el.classList.remove('hide'));



//   const element = document.getElementById("scroll");
// element.id = ""; // Also removes the ID
// element.id.add('hideMeme')

// const element = document.querySelector("scroll");
// element.id = "hideMeme"; // Adds or updates the ID

 // Hide the scroll section by adding a 'hide' class
  const scrollSection = document.getElementById("scroll");
  scrollSection.classList.add('hide');

//   const postButton = document.getElementById("scroll");
//   postButton.classList.add('hide');
  
    
  
});


 const imageInput = document.getElementById('image');
  const previewDiv = document.getElementById('preview');

  imageInput.addEventListener('change', function(e) {
    // Clear previous preview
    previewDiv.innerHTML = '';
    
    if (this.files && this.files[0]) {
      const reader = new FileReader();
      
      reader.onload = function(e) {
        // Create and display the image preview
        const img = document.createElement('img');
        img.src = e.target.result;
        img.style.maxWidth = '100%';
        img.style.maxHeight = '300px';
        previewDiv.appendChild(img);
      }
      
      reader.readAsDataURL(this.files[0]);
    }
  });
  


// document.getElementById("uploadForm").addEventListener("submit", function(e) {
//   e.preventDefault(); // Prevent actual form submission for demo
//   document.body.classList.remove("modal-open");
//   alert("Meme uploaded!"); // Example feedback
// });