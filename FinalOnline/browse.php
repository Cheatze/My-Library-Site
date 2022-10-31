<?php
include_once 'resource/session.php';
include_once 'resource/Database.php';

if(!isset($_SESSION['username'])){
    header('location: index.php');
}


//number of entries shown on a page
$results_per_page = 5;

//maybe also set that one variable here if this is set?
if (isset ($_GET['page']) ) { 
    $page = $_GET['page'];  
} else {  
    $page = 1;   
}  

//determine the sql LIMIT starting number for the results on the displaying page  
$start_from = ($page-1) * $results_per_page;   

//variables here if(!isset($_SESSION['title'])){$_SESSION['title']=$title}
//$title = $_SESSION['title']; no title required while browsing
$owner = $_SESSION['username'];

//changed to only require owner
//$query = "SELECT * FROM books WHERE owner = '$owner' AND title LIKE '%$title%' LIMIT $start_from, $results_per_page"; 
$query = "SELECT * FROM books WHERE owner = '$owner' LIMIT $start_from, $results_per_page"; 

//retrieve results from query
$Rowresult = $db->query($query);

//get number of results
$number_of_result = $Rowresult->rowCount();

//determine the total number of pages available  
$number_of_page = ceil ($number_of_result / $results_per_page);  

?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <script src="https://kit.fontawesome.com/5b145bfb33.js" crossorigin="anonymous"></script>


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="stylesheet" href="Library.css">

    <link rel="stylesheet" href="style/searchStyle.css">

    <title>My Library</title>
  </head>

  <body>
    <!--Wil 'fixed-top' in navbar doen maar text valt er dan achter -->
    <nav id="mainNavbar" class="navbar navbar-dark bg-success navbar-expand-md">
      <a href="#" class="navbar-brand"><i class="fas fa-book pr-2"></i>My Library</a>
      <button class="navbar-toggler" data-toggle="collapse" data-target="#navLinks">
          <span class="navbar-toggler-icon"></span>
      </button>
      <div id="navLinks" class="collapse navbar-collapse">
          <ul class="navbar-nav">
              <li class="nav-item">
                  <a href="index.php" class="nav-link">HOME</a>
              </li>
              <li class="nav-item">
                  <a href="search.php" class="nav-link">Search</a>
              </li>
              <li class="nav-item">
                  <a href="Info.php" class="nav-link active">Info</a>
              </li>
              <li class="nav-item">
                  <a href="LibraryLogin.php" class="nav-link">Login</a>
              </li>
              <li class="nav-item">
                  <a href="SignUp.php" class="nav-link">Sign Up</a>
              </li>
          </ul>
      </div>
  </nav>

  <div class="container">
        <br>
        <div>
            <h1>Results</h1>
            <table class="table table-striped table-condensed table-bordered">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach  ($db->query($query) as $row) {
                    ?>
                    <tr><!--Turn the titles into links with $row["id"] & <a class = 'active' href='book.php?id="-->
                        <td><a href="book.php?id=<?php echo $row['id']?>"><?php echo $row['title'] ?></a></td>                        
                        <td><?php echo $row["author"] ?></td>
                    </tr>
                    <?php 
                        }
                    ?>
                </tbody>
            </table>

            <!--  -->
            <div class="pagination">
            <?php 
                //changed the sql here to ommit title as query, should owner be included?
                //WHERE owner = '$owner'
                $query = "select count(*) from books"; 
                $result = $db->query($query);
                $number_of_result = $result->rowCount();
                $total_records = count($row);

                echo "<br>";
                // Number of pages required.   
                $total_pages = ceil($total_records / $results_per_page);     
                $pagLink = "";     

                if($page>=2){   
                    echo "<a href='results.php?page=".($page-1)."'>  Prev </a>";   
                }  

                for($i=1; $i<=$total_pages; $i++){
                    if($i == $page){
                        $pagLink = "<a class = 'active' href='results.php?page="  
                        .$i."'>".$i." </a>";  
                    }else{
                        $pagLink .= "<a href='results.php?page=".$i."'>   
                        ".$i." </a>";  
                    }
                };
                echo $pagLink;

                if($page<$total_pages){
                    echo "<a href='results.php?page=".($page+1)."'>  Next </a>";  
                }

            ?>
            </div>

            <div class="inline">
                <input id="page" type="number" min="1" max="<?php echo $total_pages ?>"
                    placeholder="<?php echo $page.'/'.$total_pages; ?>" required>
                <button onClick="go2Page();">Go</button>
            </div>
        </div>
    </div>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script>
      $(function(){
          $(document).scroll(function(){
              var $nav = $("#mainNavbar");
              $nav.toggleClass("scrolled", $(this).scrollTop() > $nav.height());
          });
      });

      function go2Page(){
          var page = document.getElementById("page").value;
          page = ((page><?php echo $total_pages; ?>)?<?php echo $total_pages; ?>:((page<1)?1:page));   
        window.location.href = 'results.php?page='+page;  
      }
  </script>  
  </body>
</html>
