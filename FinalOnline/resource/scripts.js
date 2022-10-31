function ValidateSize(file) {//2.. or 4 mib
  var FileSize = file.files[0].size / 1024 / 1024; // in MiB
  if (FileSize > 4) {
      alert('File size exceeds 4 MiB');
     // $(file).val(''); //for clearing with Jquery
     return false;
  } else {

  }
}


function validateForm(){
    var title = document.forms["boeker"]["title"].value;
    var author = document.forms["boeker"]["author"].value;
    var series = document.forms["boeker"]["series"].value;
    var image = document.forms["boeker"]["fileToUpload"].value;
    var file = document.forms["boeker"]["fileToUpload"];

    //alert(image); tests
    //alert("Does this still works?");

    //document.boeker.title.value
    if (title == "") {
      alert("Title must be filled out");
      return false;
    }

    if(title.length >= 100){
      alert("Title too long must be under 100 characters");
      return false;
    }

    //document.boeker.author.value
    if(author == "") {
        alert("Author must be filled out");
        return false;
    }

    if(author.length >= 100){
      alert("Author name too long, must be under 100 characters");
      return false;
    }

    if(series.length >= 100){
      alert("Series name too long must be under 100 characters");
      return false;
    }

    ValidateSize(file);


    var re = /(\.jpg|\.jpeg|\.bmp|\.gif|\.png)$/i;
    if (!re.exec(image)) {
      alert("File extension not supported!");
      return false;
    }

    //var validExt = [ 'gif', 'jpg', 'png' ];
    //var ext = image.value.split('.').pop();
    //validExt.indexOf(ext.toLowerCase()) == -1
    /*if(true){
        alert("Not allowed file type");
        return false;
    }*/
  }
