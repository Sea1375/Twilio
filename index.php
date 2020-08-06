<?php

    require __DIR__ . '/vendor/autoload.php';
    use Twilio\Rest\Client;

    class AsyncOperation extends Thread {

        public function __construct($arg) {
            $this->arg = $arg;
        }
    
        public function run() {
            
            $account_sid = 'Axxxxx';
            $auth_token = '1xxxxxx';
            $twilio_number = "+448181241923";
            
            if ($this->arg) {
                $client = new Client($account_sid, $auth_token);
                $client->account->calls->create(
                    $to_number,
                    $twilio_number,
                    array(
                        "url" => "http://demo.twilio.com/docs/voice.xml"
                    )
                );
            }
        }
    }
    
    if($_SERVER['REQUEST_METHOD']=='POST'){

        if(isset($_FILES["fileToUpload"])) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);

            $myfile = fopen($target_file, "r");
            $stack = array();

            while(!feof($myfile)) {

                $to_number ="+". fgets($myfile);
                $stack[] = new AsyncOperation($to_number);
            }

            foreach ( $stack as $t ) {
                $t->start();
            }

            fclose($myfile);
        }
    }
?>

<!DOCTYPE html>
<html>
<body>

<form method="post" enctype="multipart/form-data">
  Select text to upload:
  <input type="file" name="fileToUpload" id="fileToUpload">
  <input type="submit" value="Upload Text" name="submit">
</form>

</body>
</html>