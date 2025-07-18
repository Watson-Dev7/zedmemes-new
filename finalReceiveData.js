let reconnectAttempts = 0;
const maxReconnectAttempts = 5;
const baseReconnectDelay = 1000; // 1 second

function setupSSE() {
    const eventSource = new EventSource('finalSendData.php');

    eventSource.onopen = () => {
        console.log("SSE connection established");
        reconnectAttempts = 0; // Reset on successful connection
    };

    eventSource.onmessage = (e) => {
        // Ignore heartbeat comments
        if (e.data.trim() === ': heartbeat') return;

        if (e.data.includes("Connection closed")) {
            console.log("SSE closed by server. Reconnecting...");
            eventSource.close();
            scheduleReconnect();
            return;
        }

        // try {
        //     const data = JSON.parse(e.data);
        //     console.log("Data:", data.data);
            
        //     // document.getElementById("show").innerHTML = `
        //     //     <p>${data.data[0].id}</p>
        //     //     <img src="${data.data[0].name}?t=${Date.now()}" width="300">
        //     // `;
        //     for(i=0;i <data.data.length;i++)
        //     {
        //     document.getElementById("getData").innerHTML = `<div class="cell small-12 medium-6 large-4">
        //     <div class="card">
        //       <div class="card-divider">
        //         Meme Title 1
        //       </div>
        //       <div></div>
        //       <img src="${data.data[i].name}?t=${Date.now()}" class="meme-image">
        //       <div class="card-section">
        //         <p>Meme description or controls</p>
        //       </div>
        //     </div>
        //   </div>
        //     `;

        //     }
          

            
        // } catch (error) {
        //     console.error("Error parsing SSE data:", error);
        // }
        try {
        const data = JSON.parse(e.data);
        console.log("Received", data.data.length, "items");
        
        // Get container safely
        const container = document.getElementById("getData");
        if (!container) {
            console.error("Error: #getData container not found");
            return;
        }
        
        // Clear container properly
        container.innerHTML = '';
        
        // Build all cards at once (more efficient)
        let htmlContent = '';
        data.data.forEach((meme) => {
            htmlContent += `
            <div class="cell small-12 medium-6 large-4">
                <div class="card">
                    <div class="card-divider">Meme ${meme.id}</div>
                    <img src="${meme.name}?t=${Date.now()}" 
                         class="meme-image"
                         onerror="this.src='placeholder.jpg'">
                    <div class="card-section">
                        <p>ID: ${meme.id}</p>
                    </div>
                </div>
            </div>`;
        });
        
        // Insert all content at once
        container.innerHTML = htmlContent;
        
        // Reinitialize Foundation if needed
        if (typeof Foundation !== 'undefined') {
            $(document).foundation('reflow');
        }
        
    } catch (error) {
        console.error("Processing error:", error);
    }
    };

    eventSource.onerror = (e) => {
        console.error("SSE Error:", e);
        
        // Only reconnect if the connection was closed unexpectedly
        if (eventSource.readyState === EventSource.CLOSED) {
            eventSource.close();
            scheduleReconnect();
        }
    };
}

function scheduleReconnect() {
    if (reconnectAttempts >= maxReconnectAttempts) {
        console.error("Max reconnect attempts reached");
        return;
    }

    const delay = baseReconnectDelay * Math.pow(2, reconnectAttempts);
    reconnectAttempts++;
    
    console.log(`Attempting reconnect in ${delay}ms (attempt ${reconnectAttempts})`);
    
    setTimeout(setupSSE, delay);
}

// Start the initial connection
setupSSE();