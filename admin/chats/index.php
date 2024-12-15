<?php
  $chatid = "";
  $listofids = [];

  if(!isset($_GET['cid']) || $_GET['cid'] == ""){
    $chatid = 0;
  }else {
    $chatid = $_GET['cid'];
  }
?>


<script>
  const currentUrl = window.location.href;

  // Parse the URL to get the query parameters
  const url = new URL(currentUrl);

  // Dynamically retrieve the 'cid' parameter
  const cid = url.searchParams.get('cid');

  // console.log(cid); // Outputs the dynamic value of 'cid', e.g., 29
  // $(`.customer-list`).css('background-color', '#e7e7e7');
</script>

<script type="module">
  import { initializeApp } from "https://www.gstatic.com/firebasejs/11.0.2/firebase-app.js";
  import { getDatabase, ref, set, get, child, onChildAdded, remove, onValue } from "https://www.gstatic.com/firebasejs/11.0.2/firebase-database.js";

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
  const chatsRef = ref(database, `chats/${chatid}`);
  const customerRef = ref(database, "chats/");

  function writeUserData(role, message) {
    const currenttime = new Date(Date.now()).toLocaleString();

    set(ref(database, 'chats/' + chatid + '/' + Date.now()), {
      role: role,
      message: message,
      timestamp: currenttime
    });
  }

  function clearChat() {
    remove(chatsRef);
  }

  onValue(customerRef, (snapshot) => {
    const data = snapshot.val();

    if (data) {
      const keys = Object.keys(data);

      $(document).ready(function(){
        $.ajax({
          url: 'chats/get_customer.php',
          type: 'post',
          data: {
            ids: keys,
            selected: <?php echo $chatid; ?>
          },
          success: response => {
            $('.customer-list').html(response)
          }
        })
      })

      let count = 0;

      Object.keys(data).forEach((key) => {
        const message = data[key];
        Object.keys(message).forEach((index) => {

          if (message[index].seen === false) {
            count++;
          }


        })

        $(`.client-${key}`).append(count)
      });
    } else {
      console.log("No data found in 'chats/'");
    }
  });

  onChildAdded(chatsRef, (snapshot) => {
    const data = snapshot.val();

    if (data) {
      const { message, role, timestamp } = data;
      

      const newMessage = {
        message,
        role,
        timestamp,
        currenttime: new Date(timestamp).toLocaleString(),
      };

      const messageHTML = `
          <div class='m-${newMessage.role}'>
            <div class='message-${newMessage.role}'>
              <p>${newMessage.message}</p>
            </div>
          </div>
        `;

      $(".chat-container > .chats").append(messageHTML);
      $(".chat-container > .chats").scrollTop($(".chat-container > .chats")[0].scrollHeight);
    }
  });


  window.writeUserData = writeUserData;
  window.clearChat = clearChat;
</script>


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

  .is-selected {
    background-color: #F1F0F0;
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

  .container-fluid {
    background-color: #fff;
    padding: 1rem;
    display: flex;
    flex-direction: column;
    gap: 1rem;
  }

  .customer-list {
    display: flex;
    flex-direction: column;
    height: 100%;
    overflow-y: auto;
    gap: 0.5rem;
  }

  .customer-list > a {
    padding: 0.5rem 1rem;
    font-size: 18px;
    color: #000;
    font-weight: 500;
    text-decoration: none;
    display: flex;
    flex-direction: row;
    gap: 1rem;
    align-items: center;
    border-bottom: 1px solid #e7e7e7;
  }

  .customer-list > a > img {
    border-radius: 50px;
    width: 40px;
    height: 40px;
  }

  .chat-container {
    height: 600px;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    border-left: 1px solid #e7e7e7;
    border-right: 1px solid #e7e7e7;
  }

  .chats {
    display: flex;
    flex-direction: column;
    overflow: auto;
    gap: 0.25rem;

  }

  #chatform {
    display: flex;
    flex-direction: row;
    gap: 1rem;
    margin-top: auto;
  }
</style>

<div class="container-fluid">
  <h4 class="fw-bold">CHATS</h4>
  <div class="row">
    <div class="col-3">
      <h5>Customers</h5>
      <div class="customer-list">
      </div>
    </div>
    <div class="col-5 chat-container" >
      <div class="chat-control">
        <button class="btn btn-primary btn-sm" id="clear-chat-btn">Clear Chat</button>
      </div>
      <div class="chats">

      </div>
      <form id="chatform">
        <input class="form-control" type="text" name="message" required/>
        <button type="submit" class="btn btn-primary">Send</button>
      </form>
    </div>
    <div class="col-4"></div>
  </div>
</div>

<script>
  $("#chatform").on("submit", function(e){
    e.preventDefault();
    let message = $("input[name='message']").val()
    $("input[name='message']").val("")

    writeUserData('admin', message)
  })

  $("#clear-chat-btn").on("click", function(){
    clearChat()
    location.reload();
  })
</script>
