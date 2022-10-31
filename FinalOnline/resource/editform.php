

<div class="container">
<h5>If you do not give an imput for the series or image they will stay the same in the database.</h5>

    <form name="boeker"  method="post" onsubmit="return validateForm()" enctype="multipart/form-data">

    <div class="form-group ml-20px">
        <label for="exampleInputEmail1">Title</label>
        <?php
        echo "<input type='text' name='title' class='form-control' aria-describedby='emailHelp' value='$title'>";
        ?>
    </div>
    <!--required-->
    <div class="form-group">
        <label for="exampleInputUsername1">Author</label>
        <?php
           echo "<input type='text' name='author' class='form-control' value='$author'>";
        ?>
    </div>

    <label for="exampleInputUsername1">Series (optional)</label>
    <div class="form-group">
        <input type="text" name="series" class="form-control" placeholder="Series">
    </div>
        
    <div class="form-group">
        <label for="exampleInputPassword1">Select image to upload: (optional)</label>
        <input type="file" name="fileToUpload" class="form-control" id="fileToUpload" placeholder="">
    </div>

    <button type="submit" name="editbtn" value="insertBtn"  class="btn btn-primary">Submit</button>
    </form>
</div>

<hr>

<div class="container">
    <h3>Delete</h3>
    <form name="delete" method="post" action="">
    <button type="submit" name="deletebtn" value="del" lass="btn btn-primary" onclick="return confirm('Are you sure you want to delete?')">Delete entry</button>
    </form>
</div>