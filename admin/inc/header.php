

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>
    <?php echo $_settings->info('title') != false ? $_settings->info('title') . ' | ' : '' ?><?php echo $_settings->info('name') ?>
  </title>
  <script src="script.js" defer></script>

  <link rel="icon" href="<?php echo validate_image($_settings->info('logo')) ?>" />
  <!-- Google Font: Source Sans Pro -->
  <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&amp;display=fallback"> -->
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url ?>plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <!-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> -->
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet"
    href="<?php echo base_url ?>plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url ?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url ?>plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url ?>plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?php echo base_url ?>plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="<?php echo base_url ?>plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url ?>dist/css/adminlte.css">
  <link rel="stylesheet" href="<?php echo base_url ?>dist/css/custom.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?php echo base_url ?>plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url ?>plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="<?php echo base_url ?>plugins/summernote/summernote-bs4.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="<?php echo base_url ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- <style type="text/css">
    /* Chart.js */
    @keyframes chartjs-render-animation {
      from {
        opacity: .99
      }

      to {
        opacity: 1
      }
    }

    .chartjs-render-monitor {
      animation: chartjs-render-animation 1ms
    }

    .chartjs-size-monitor,
    .chartjs-size-monitor-expand,
    .chartjs-size-monitor-shrink {
      position: absolute;
      direction: ltr;
      left: 0;
      top: 0;
      right: 0;
      bottom: 0;
      overflow: hidden;
      pointer-events: none;
      visibility: hidden;
      z-index: -1
    }

    .chartjs-size-monitor-expand>div {
      position: absolute;
      width: 1000000px;
      height: 1000000px;
      left: 0;
      top: 0
    }

    .chartjs-size-monitor-shrink>div {
      position: absolute;
      width: 200%;
      height: 200%;
      left: 0;
      top: 0
    }
  </style> -->

  <!-- jQuery -->
  <script src="<?php echo base_url ?>plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="<?php echo base_url ?>plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- SweetAlert2 -->
  <script src="<?php echo base_url ?>plugins/sweetalert2/sweetalert2.min.js"></script>
  <!-- Toastr -->
  <script src="<?php echo base_url ?>plugins/toastr/toastr.min.js"></script>
  <script>
    var _base_url_ = '<?php echo base_url ?>';
  </script>
  <script src="<?php echo base_url ?>dist/js/script.js"></script>

  <!-- Firebase SDK -->
  <script type="module">
    import { initializeApp } from "https://www.gstatic.com/firebasejs/10.14.1/firebase-app.js";
    import { getFirestore, collection, addDoc, onSnapshot } from "https://www.gstatic.com/firebasejs/10.14.1/firebase-firestore.js";

    // Firebase configuration
    const firebaseConfig = {
      apiKey: "AIzaSyDjWfyGpv_ECHnkHABYEss7J0unCrLH0ok",
      authDomain: "kofee-manila.firebaseapp.com",
      databaseURL: "https://kofee-manila-default-rtdb.asia-southeast1.firebasedatabase.app",
      projectId: "kofee-manila",
      storageBucket: "kofee-manila.appspot.com",
      messagingSenderId: "296750304629",
      appId: "1:296750304629:web:39d6e2d377dfff5984d73c"
    };

    // Initialize Firebase
    const app = initializeApp(firebaseConfig);
    const db = getFirestore(app);

    // Add a new document to the logs collection
    const logDocs = collection(db, "user_updates");

    // Listen for real-time updates on the logs collection
    onSnapshot(logDocs, (snapshot) => {
      let newEntryFound = false; // Flag to track if there is a new entry

      snapshot.docChanges().forEach((change) => {
        if(change.doc.data().message === "entry"){
          $('.custom-toast').css('display', 'grid').animate(
            { right: '15%', opacity: 1 }, 
            200
          );

          setTimeout(function() {
            $('.custom-toast').animate(
              { right: '-100%', opacity: 0 }, 
              500,
              function() {
                $(this).css('display', 'none'); // Hide element after the animation completes
              }
            );
          }, 5000);
        }
      });

      // Check if no new entries were found
      if (!newEntryFound) {
        console.log("No new entries were added.");
        // Perform any action if no new entry is detected, if needed.
      }
    });

    export function updateDocument(orderid, newmessage) {
      const docRef = db.collection("user_updates").doc(orderid); // Reference to the document with ID "20"

      // New data to update
      const updatedData = {
        message: newmessage, // Replace with actual field names and values
      };

      // Update the document
      docRef.update(updatedData)
        .then(() => {

        })
        .catch((error) => {
          console.error("Error updating document: ", error);
        });
    }
  </script>
</head>