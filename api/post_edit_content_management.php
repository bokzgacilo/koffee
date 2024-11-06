<?php
  include("connection.php");

  $c = $conn -> query("SELECT * FROM content_management WHERE id=1");
  $content = $c -> fetch_assoc();

  $phone = trim(filter_var($_POST['phone'], FILTER_SANITIZE_STRING));
  $email = trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
  $address = trim(filter_var($_POST['address'], FILTER_SANITIZE_STRING));
  $quill = $_POST['quill'];


  $banners = json_decode($content['banner'], true);
  $descriptions = json_decode($content['description'], true);
  $abouts = json_decode($content['about'], true);

  $bannerInputs = ['bannerImage1', 'bannerImage2', 'bannerImage3'];
  

  foreach ($bannerInputs as $index => $input) {
    $title = "bannerTitle" . ($index + 1);
    $description = "bannerDescription" . ($index + 1);

    if (isset($_FILES[$input]) && $_FILES[$input]['error'] == 0) {
      $target_dir = "../uploads/banner/";
      $fileExtension = pathinfo($_FILES[$input]['name'], PATHINFO_EXTENSION);
      $customFileName = 'banner' . ($index + 1) . '.' . $fileExtension;
      $targetFilePath = $target_dir . $customFileName;

      if (move_uploaded_file($_FILES[$input]["tmp_name"], $targetFilePath)) {
        $banners[$index]['image'] = 'uploads/banner/' . $customFileName;
      }
    }

    $banners[$index]['title'] = $_POST[$title];
    $banners[$index]['description'] = $_POST[$description];
  }

  foreach($descriptions as $index => $desc){
    if (isset($_FILES['descImage1']) && $_FILES['descImage1']['error'] == 0) {
      $target_dir = "../uploads/banner/";
      $fileExtension = pathinfo($_FILES['descImage1']['name'], PATHINFO_EXTENSION);
      $customFileName = 'description' . ($index + 1) . '.' . $fileExtension;
      $targetFilePath = $target_dir . $customFileName;

      if (move_uploaded_file($_FILES['descImage1']["tmp_name"], $targetFilePath)) {
        $descriptions[$index]['image'] = 'uploads/banner/' . $customFileName;
      }
    }

    $descriptions[$index]['title'] = $_POST['descTitle1'];
    $descriptions[$index]['description'] = $_POST['descDescription1'];
  }

  foreach($abouts as $index => $about){
    if (isset($_FILES['aboutImage']) && $_FILES['aboutImage']['error'] == 0) {
      $target_dir = "../uploads/";
      $fileExtension = pathinfo($_FILES['aboutImage']['name'], PATHINFO_EXTENSION);
      $customFileName = 'about' . ($index + 1) . '.' . $fileExtension;
      $targetFilePath = $target_dir . $customFileName;

      if (move_uploaded_file($_FILES['aboutImage']["tmp_name"], $targetFilePath)) {
        $abouts[$index]['image'] = 'uploads/' . $customFileName;
      }
    }

    $abouts[$index]['title'] = $_POST['aboutTitle'];
    $abouts[$index]['description'] = $_POST['aboutDescription'];
  }

  if (isset($_FILES['gcashImage']) && $_FILES['gcashImage']['error'] == 0) {
    $target_dir = "../uploads/";
    $fileExtension = pathinfo($_FILES['gcashImage']['name'], PATHINFO_EXTENSION);
    $customFileName = 'gcash' . '.' . $fileExtension;
    $targetFilePath = $target_dir . $customFileName;
    $dbpath = 'uploads/' . $customFileName;
 
    if (move_uploaded_file($_FILES['gcashImage']["tmp_name"], $targetFilePath)) {
      $conn -> query("UPDATE content_management SET gcash='$dbpath' WHERE id=1");
    }
  }

  $updatedBannerJson = json_encode($banners, JSON_UNESCAPED_SLASHES);
  $updatedDescriptionJson = json_encode($descriptions, JSON_UNESCAPED_SLASHES);
  $updatedAboutJson = json_encode($abouts, JSON_UNESCAPED_SLASHES);

  $updateBanner = $conn -> query("UPDATE content_management SET banner='$updatedBannerJson' WHERE id=1");
  $updateDescription = $conn -> query("UPDATE content_management SET description='$updatedDescriptionJson' WHERE id=1");
  $updateAbout = $conn -> query("UPDATE content_management SET about='$updatedAboutJson' WHERE id=1");

  $updateContact = $conn -> query("UPDATE content_management SET terms_and_condition='$quill', phone='$phone', email='$email', address='$address' WHERE id=1");

  if($updateBanner && $updateDescription && $updateAbout && $updateContact){
    echo "ok";
  }

  $conn -> close();
?>