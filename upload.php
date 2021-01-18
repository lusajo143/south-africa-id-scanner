<?php

class sockets {

    public $socket;
    function send($ext) {
        $this->socket = socket_create(AF_INET, SOCK_STREAM, 0) or die ("Failed to create socket");
        $result = socket_connect($this->socket,"127.0.0.1",143) or die ("Failed to connect to Server");
        
        // Send message
        $message = "Done###".$ext;
        socket_write($this->socket,$message,strlen($message)) or die ("Failed to Send message to Server");

        $response = socket_read($this->socket,1024) or 
                die ("Failed to receive data");

        try {
          $data = json_decode($response);
          var_dump($data);
          return $data;
        } catch (Exception $th) {
          echo 'eee';
          return null;
        }

        
    }



}


$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    //echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;

    $target = "uploads/image.".$imageFileType;

    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target)) {
        
        $sock = new sockets();
        $data = $sock->send($imageFileType);
        echo 'eeeras'.$data->Surname;

    } else {
        echo "Sorry, there was an error uploading your file.";
    }
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}



?>

<html>
  <head>
    <title>Residence Book</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body class="body">
    <div class="parent">
      <div class="home">
        <h1>Results</h1>
        <table class="table">
          <tr >
            <td style="padding:0 15px 0 15px;" class="desc">Id:</td>
            <td style="padding:0 0 0 8em;" >
            <?php echo $data->id_ ?>
            </td>
          </tr>
          <tr >
            <td style="padding:0 15px 0 15px;" class="desc">Surname:</td>
            <td style="padding:0 0 0 8em;" >
            <?php echo $data->Surname; ?>
            </td>
          </tr>
          <tr>
            <td style="padding:0 15px 0 15px;" class="desc">Forenames:</td>
            <td style="padding:0 0 0 8em;" >
            <?php echo $data->Forenames; ?>
            </td>
          </tr>
          <tr>
            <td style="padding:0 15px 0 15px;" class="desc">Country:</td>
            <td style="padding:0 0 0 8em;" >
            <?php echo $data->Country; ?>
            </td>
          </tr>
          <tr>
            <td style="padding:0 15px 0 15px;" class="desc">Date of Birth:</td>
            <td style="padding:0 0 0 8em;" >
            <?php echo $data->DOB; ?>
            </td>
          </tr>
          <tr>
            <td style="padding:0 15px 0 15px;" class="desc">Date Issued:</td>
            <td style="padding:0 0 0 8em;" >
            <?php echo $data->DI; ?>
            </td>
          </tr>
        </table>
      </div>
    </div>
  </body>
</html>