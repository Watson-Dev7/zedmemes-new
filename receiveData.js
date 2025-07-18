
fetch('sendData.php', {
    cache: 'no-store', // Prevent caching
    headers: {
        'Cache-Control': 'no-cache, no-store, must-revalidate',
        'Pragma': 'no-cache',
        'Expires': '0'
    }
})
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            alert("Error: " + data.message); // Show error message
            return;
        }
        console.log("Data:", data.data); // Process data
        document.getElementById("show").innerHTML=
        `<p>${data.data[0]["id"]} } </p>
        
        <h2>Recived Image from the Server:</h2>
                        <img src="${data.data[0]["name"]}?t=${Date.now()}" width="300">
                        <p>Path: ${data.data[0]["name"].startsWith('http')
                        ? response.data[0]["name"]
                        : window.location.origin +  data.data[0]["name"]}`
    });