<?php
  session_start();

  $chatid = $_SESSION['userid'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Chat - KOFEE MANILA</title>
  <script src="libs/jquery.js"></script>
  <script src="libs/popper.js"></script>

  <script src="libs/bootstrap.min.js"></script>
  <link href="libs/bootstrap.min.css" rel="stylesheet" />
  <link
    href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap"
    rel="stylesheet"
  />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <link
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
    rel="stylesheet"
  />
  <title>Chat</title>

  <script type="module">
    import { initializeApp } from "https://www.gstatic.com/firebasejs/11.0.2/firebase-app.js";
    import { getDatabase, ref, set, get, child, query, onValue, orderByKey, startAfter, onChildAdded  } from "https://www.gstatic.com/firebasejs/11.0.2/firebase-database.js";

    const firebaseConfig = {
      apiKey: "AIzaSyDjWfyGpv_ECHnkHABYEss7J0unCrLH0ok",
      authDomain: "kofee-manila.firebaseapp.com",
      databaseURL: "https://kofee-manila-default-rtdb.asia-southeast1.firebasedatabase.app",
      projectId: "kofee-manila",
      storageBucket: "kofee-manila.firebasestorage.app",
      messagingSenderId: "296750304629",
      appId: "1:296750304629:web:39d6e2d377dfff5984d73c"
    };

    const app = initializeApp(firebaseConfig);
    const database = getDatabase(app);
    const chatid = <?php echo $chatid; ?>;

    function writeUserData(role, message) {
      const currenttime = new Date(Date.now()).toLocaleString();

      set(ref(database, 'chats/' + chatid + '/' + Date.now()), {
        role: role,
        message: message,
        timestamp: currenttime,
        seen: false
      });
    }

    const chatsRef = ref(database, `chats/${chatid}`);

    onChildAdded(chatsRef, (snapshot) => {
      const data = snapshot.val();

      if (data) {
        const { message, role, timestamp } = data;

        // Format the new message data
        const newMessage = {
          message,
          role,
          timestamp,
          currenttime: new Date(timestamp).toLocaleString(),
          seen: false
        };

        // Create HTML for the new message
        const messageHTML = `
          <div class='m-${newMessage.role}'>
            <div class='message-${newMessage.role}'>
              <p>${newMessage.message}</p>
            </div>
          </div>
        `;

        // Append the new message to the chat container
        $(".chat-container").append(messageHTML);

        $(".chat-container").scrollTop($(".chat-container")[0].scrollHeight);
      }
    });

    window.writeUserData = writeUserData;
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  
  <style>
    .m-admin {
      display: flex;
      flex-direction: row;
      justify-content: flex-start;
    }

    .message-admin {
      background-color: #F1F0F0;
      padding: 0.75rem;
      border-radius: 20px;
    }

    .message-admin > p {
      margin-bottom: 0;
      font-size: 16px;
      font-weight: 500;
    }

    .m-client {
      display: flex;
      flex-direction: row;
      justify-content: flex-end;
    }

    .m-client {
      display: flex;
      flex-direction: row;
      justify-content: flex-end;
    }

    .message-client {
      background-color: #0084FF;
      color: #fff;
      padding: 0.75rem;
      border-radius: 20px;
    }


    .message-client > p {
      margin-bottom: 0;
      font-size: 16px;
      font-weight: 500;
    }

    #clientform {
      margin-top: auto;
      display: flex;
      flex-direction: row;
      gap: 1rem;
    }

    .chat-container {
      overflow-y: scroll;
      display: flex;
      flex-direction: column;
      gap: 0.5rem;
    }

    .custom-container {
      gap: 1rem;
      max-width: 100%;
      display: flex;
      height: 100vh;
      flex-direction: column;
      padding: 0.5rem;
    }
  </style>
</head>

<body>
  <div class="custom-container">
    <h6 class="fw-semibold mt-2" style="font-size: 12px; text-align: center;">You are connected with our Customer Support...</h6>


    <main class="chat-container">

    </main>

    <form id="clientform">
      <input class="form-control" type="text" name="message" required />
      <button class="btn btn-primary" type="submit">Send</button>
    </form>
  </div>
  

  <script>

    $("#clientform").on("submit", function(event){
      event.preventDefault();

      let message = $("input[name='message']").val()
      $("input[name='message']").val("")

      writeUserData('client', message)
    })
  </script>
</body>
</html>