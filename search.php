<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://fonts.googleapis.com/css?family=Righteous" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css.css">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	  <script src="https://getbootstrap.com/docs/4.0/assets/js/vendor/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script><script src="https://getbootstrap.com/docs/4.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/docsearch.js@2/dist/cdn/docsearch.min.js"></script><script src="https://getbootstrap.com/docs/4.0/assets/js/docs.min.js"></script>

    <title>Search</title>
</head>
<body>
  <?php
    require("nav.html");
    require("libraries.php");
    function list_of_books($service){
      if (isset($_GET["title"])) {
        $query = $_GET["title"];
        /*$optParams = [
          'filter' => 'free-ebooks',
        ];*/
        $results = $service->volumes->listVolumes($query);
        $data = $results->getItems();
        
        $i=0;
        while($i<=sizeof($data)) {
          echo '<div class="row row-cols-1 row-cols-xs-2 row-cols-sm-2 row-cols-lg-4 g-3">';
          for ($j=$i; $j<$i+4; $j++){
            if ($j >= sizeof($data)) {
              break;
            }
            else {
              $id = $data[$j]['id'];
              $title = $data[$j]['volumeInfo']['title'];
              //array to string, gli autori possono essere più di uno oppure nessuno
              if (empty($data[$j]['volumeInfo']['authors'])) {
                $author = "";
              }
              else {
                if (count($data[$j]['volumeInfo']['authors'])>1) {
                  $author = implode(", ", $data[$j]['volumeInfo']['authors']);
                }
                else {
                  $author = implode($data[$j]['volumeInfo']['authors']);
                }
              }
              $cover = $data[$j]['volumeInfo']['imageLinks']["thumbnail"];
              $publisher = $data[$j]['volumeInfo']['publisher'];
              $publishedDate = $data[$j]['volumeInfo']['publishedDate'];
              $desc = $data[$j]['volumeInfo']['description'];
              $pagenum = $data[$j]['volumeInfo']['pageCount'];

              echo  '<div class="col">';
              echo    '<div class="card h-100 shadow-sm">';
              echo      '<img src="'.$cover.'" class="card-img-top" alt="'.$title.'">';
              echo      '<div class="card-body">';
              echo        '<div class="clearfix mb-3">';
              echo            '<h5 class="card-title">'.$title.'</h5>';
              echo            '<p class="card-text">Author: '.$author.'</p>';
              echo            '<p class="card-text">Publisher: '.$publisher.'</p>';
              echo          '</div>';
              echo          '<div class="text-center my-4">';
              echo            '<button type="button" id="'.$id.'" class="btn btn-primary" data-toggle="modal" data-target="#'.$id.'">view more</button>';
              echo          '</div>';
              echo       '</div>';
              echo    '</div>';
              view_more($id,$title,$author,$cover,$desc,$publishedDate,$pagenum);
              echo  '</div>';
              
            }
          }
          echo  '</div>';

          $i=$i+4;
        }

      }
    }

    function view_more($id,$title,$author,$cover,$desc,$publishedDate,$pagenum){
      $modal = '<div class="modal fade" id="'.$id.'" tabindex="-1" role="dialog" aria-labelledby="'.$id.'" aria-hidden="true">';
      $modal .=   '<div class="modal-dialog modal-dialog-centered" role="document">';
      $modal .=     '<div class="modal-content">';
      $modal .=       '<div class="modal-header">';
      $modal .=         '<h5 class="modal-title" id="'.$title.'">'.$title.'</h5>';
      $modal .=         '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
      $modal .=           '<span aria-hidden="true">&times;</span>';
      $modal .=         '</button>';
      $modal .=       '</div>';
      $modal .=       '<div class="modal-body">';
      $modal .=         '<img src="'.$cover.'" class="card-img-top" alt="'.$title.'">';
      $modal .=         '<p class="card-text">'.$desc.'</p>';
      $modal .=       '</div>';
      $modal .=       '<div class="modal-footer">';
      $modal .=         '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>';
      $modal .=       '</div>';
      $modal .=     '</div>';
      $modal .=   '</div>';
      $modal .= '</div>';
      
      echo $modal;
    }
  ?>
  <div class="container">
    <div id="title" class="center">
      <h1 id="header" class="text-center mt-5">Search for a book</h1>
      <div class="row">
        <div id="input" class="input-group mx-auto col-lg-6 col-md-8 col-sm-12">
          <form action="" method="get" >
            <input id="search-box" type="text" class="form-control" name="title" placeholder="search...">
            <input type="submit" value="search" id="search" class="btn btn-primary" >
          </form>
          <h2 class="text-center">Search Result</h2>
        </div>
      </div>
    </div>
  </div>
  <div class="book-list">
    <div id="list-output" class="container-fluid bg-trasparent my-4 p-3">
      <?php
        list_of_books($service);
      ?>
    </div>
  </div>
  </body>
</html>
