<?php
  include("connection.php");

  $c = $conn -> query("SELECT * FROM content_management WHERE id=1");
  $content = $c -> fetch_assoc();

  $banners = json_decode($content['banner'], true);
  $descriptions = json_decode($content['description'], true);

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

  $updatedBannerJson = json_encode($banners, JSON_UNESCAPED_SLASHES);

  $updatedDescriptionJson = json_encode($descriptions, JSON_UNESCAPED_SLASHES);

  $updateBanner = $conn -> query("UPDATE content_management SET banner='$updatedBannerJson' WHERE id=1");

  $updateDescription = $conn -> query("UPDATE content_management SET description='$updatedDescriptionJson' WHERE id=1");

  if($updateBanner && $updateDescription){
    echo "ok";
  }

  $conn -> close();
?>