// $(document).ready(function() {
//     $('#uploadForm').submit(function(e) {
//         e.preventDefault();
        
//         var formData = new FormData(this);
        
//         $.ajax({
//             url: 'upload.php',
//             type: 'POST',
//             data: formData,
//             contentType: false,
//             processData: false,
//             success: function(response) {
//                 // Display the uploaded image
//                 $('#preview').html('<h2>Uploaded Image:</h2><img src="' + response.filePath + '" width="300">');
//             },
//             error: function(xhr, status, error) {
//                 alert('Error: ' + xhr.responseText);
//             }
//         });
//     });
// });
// In script.js (inside the submit handler)

$(document).ready(function() {
    $('#uploadForm').submit(function(e) {
        e.preventDefault();
        
        var formData = new FormData(this);
        
        $.ajax({
            url: 'upload.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json', // Ensure jQuery parses response as JSON
            success: function(response) {
                console.log("Server Response:", response); // Debug log
                
                // if (response.success && response.filePath) {
                //     // Use absolute URL if needed 
                //     var imageUrl = response.filePath.startsWith('http')
                //         ? response.filePath 
                //         : window.location.origin + response.filePath;
                    
                //     $('#preview').html(`
                //         <h2>Uploaded Image:</h2>
                //         <img src="${imageUrl}?t=${Date.now()}" width="300">
                //         <p>Path: ${imageUrl}</p>
                //     `);
                // } else {
                //     alert('Error: ' + (response.error || 'Invalid file path'));
                // }

//    1. Remove 'modal-open' from body
document.body.classList.remove("modal-open");


// 2. Add 'hide' back to all elements that originally had it
document.querySelectorAll('.hide').forEach(el => el.classList.add('hide'));

// 3. Show the scroll section by removing 'hide'
const scrollSection = document.getElementById("scroll");
scrollSection.classList.remove('hide');

            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", xhr.responseText);
                alert("Upload failed. Check console for details.");
            }
        });
    });
});
function openModal() {
  document.body.classList.add("modal-open");
  document.querySelectorAll('.hide').forEach(el => el.classList.remove('hide'));
  document.getElementById("scroll").classList.add('hide');
}

function closeModal() {
  document.body.classList.remove("modal-open");
  document.querySelectorAll('.hide').forEach(el => el.classList.add('hide'));
  document.getElementById("scroll").classList.remove('hide');
}
