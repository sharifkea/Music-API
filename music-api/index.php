<?php
  require_once('src/functions.php');

  header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-Methods: *");

  define('POS_ENTITY', 1);
  define('POS_ID', 2);
  
  define('MAX_PIECES', 3);

  define('ENTITY_ADMIN', 'admin');
  define('ENTITY_ARTIST', 'artist');
  define('ENTITY_ALBUM', 'album');
  define('ENTITY_TRACK', 'track');
  define('ENTITY_INVOICE', 'invoice');
  define('ENTITY_CUSTOMER', 'customer');

  $url = strtok($_SERVER['REQUEST_URI'], "?"); 
  if (substr($url, strlen($url) - 1) == '/') {
    $url = substr($url, 0, strlen($url) - 1);
  }
  $url = substr($url, strpos($url, basename(__DIR__)));
  $urlPieces = explode('/', urldecode($url));

  header('Content-Type: application/json');
  header('Accept-version: v1');

  $pieces = count($urlPieces);
  $entity='';
  $verb='';
  if ($pieces == 1) {
    echo API_description();
  } else {
    if ($pieces > MAX_PIECES) {
        echo formatError();
    } else {

      $entity = $urlPieces[POS_ENTITY];
    
      switch ($entity) {

        case ENTITY_ADMIN:

          require_once('src/admin.php');
          $admin = new Admin();

            $verb = $_SERVER['REQUEST_METHOD'];

            switch ($verb) {
              case 'GET':                             // Get Admin Password
                
                echo add_HATEOAS($admin-> fetch_pass(), ENTITY_ADMIN);
                
                break;
            }
          $admin = null;
          break;

        case ENTITY_ARTIST:
          
          require_once('src/artist.php');
          $artist = new Artist();

          $verb = $_SERVER['REQUEST_METHOD'];

          switch ($verb) {
            case 'GET':                             // Search artist
              if (!isset($_GET['name'])) {
                  echo format_error();
              } else {
                  echo add_HATEOAS($artist->search($_GET['name']), ENTITY_ARTIST);
              }
              break;
          }
          $artist = null;
          break;

        case ENTITY_ALBUM:
          require_once('src/album.php');
          $album = new Album();

          $verb = $_SERVER['REQUEST_METHOD'];

          switch ($verb) {
            case 'GET':                             // Search album
              if (!isset($_GET['title'])) {
                if(!isset($_GET['artistId'])){
                  echo format_error();
                }else {
                  echo add_HATEOAS($album->with_art_id($_GET['artistId']), ENTITY_ALBUM);
              }    
              } else {
                  echo add_HATEOAS($album->search($_GET['title']), ENTITY_ALBUM);
              }
              break;
          }
          $album = null;
          break;
        
        case ENTITY_TRACK:

          require_once('src/track.php');
          $track = new Track();

          $verb = $_SERVER['REQUEST_METHOD'];
          //$_POST=json_decode($_POST,true);

          switch ($verb) {
            case 'GET':                             // Search track
              if (!isset($_GET['name'])) {
                if(!isset($_GET['albumId'])){
                  if(!isset($_GET['trackId'])){
                    echo format_error();
                  }else {
                    echo add_HATEOAS($track->with_id($_GET['trackId']), ENTITY_TRACK);
                  }
                }else {
                  echo add_HATEOAS($track->with_alb_id($_GET['albumId']), ENTITY_TRACK);
                }    
              }else {
                echo add_HATEOAS($track->search($_GET['name']), ENTITY_TRACK);
              }
              break;

            case 'POST':                                    // Add and update track
              if($pieces==MAX_PIECES){
                if (!isset($_POST['Name'])) {
                  echo format_error();
              } else {
                  echo add_HATEOAS($track->add($_POST), ENTITY_TRACK);
                }
              }
              else if($pieces<MAX_PIECES){
                if (!isset($_POST['TrackId'])) {
                  echo format_error();
                } else {
                    echo add_HATEOAS($track->update($_POST), ENTITY_TRACK);
                }
              }
              break;

            case 'DELETE':                          // Delete track
              if ($pieces < MAX_PIECES) {
                  echo format_error();
              } else {
                  echo add_HATEOAS($track->delete($urlPieces[POS_ID]), ENTITY_TRACK);
              }
              break;        
          }
          $track = null;
          break;
        
        case ENTITY_INVOICE:
          require_once('src/invoice.php');
          $invoice = new Invoice();

          $verb = $_SERVER['REQUEST_METHOD'];

          switch ($verb) {
            case 'GET':                             // Search invoice
              if ($pieces < MAX_PIECES){
                if (!isset($_GET['customerId'])) {
                  echo format_error();
                } else {
                  echo add_HATEOAS($invoice->with_cus_id($_GET['customerId']), ENTITY_INVOICE);
                }
              }else{
                echo add_HATEOAS($invoice->get($urlPieces[POS_ID]), ENTITY_INVOICE);
              }
              break;
              
            case 'POST':                                    // Add invoice
              if($pieces<MAX_PIECES){
                if (!isset($_POST)) {
                  echo format_error();
              } else {
                  echo add_HATEOAS($invoice->add($_POST), ENTITY_INVOICE);
                }
                
              }
              
              break;
          }
          $invoice = null;
          break;
          
        case ENTITY_CUSTOMER:
          require_once('src/customer.php');
          $customer = new Customer();

          $verb = $_SERVER['REQUEST_METHOD'];

          switch ($verb) {
            case 'GET':                             // Search customer
              echo add_HATEOAS($customer->get($urlPieces[POS_ID]), ENTITY_CUSTOMER);
              break;

            case 'POST':                                    // Add and update customer
              if($pieces==MAX_PIECES){

                if (!isset($_POST['Password'])) {
                  echo $_POST['LastName'];
                  echo format_error();
              } else {
                  //echo $_POST['LastName'];
                  echo add_HATEOAS($customer->add($_POST), ENTITY_CUSTOMER);
                }
              }
              else if($pieces<MAX_PIECES){
                if (!isset($_POST['Password'])) {
                  echo format_error();
                } else {
                    echo add_HATEOAS($customer->update($_POST), ENTITY_CUSTOMER);
                }
              }
              break;
          }
          $customer = null;
          break;

        default:
          echo "error.\n";
        

      }
    }
  }
 
?>
  