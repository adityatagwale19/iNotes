<?php

$insert = false;
$edit = false;
$delete = false;
// make a connection
$servername = 'localhost';
$username = 'root';
$password = 'root';
$database = 'dbfirst';

$conn = mysqli_connect($servername, $username, $password, $database) or die("Connection unsuccesfull!");


//echo $_SERVER['REQUEST_METHOD'];   => debug method
// delete the data Sno wise
if (isset($_GET['delete'])) {
    $sno = $_GET['delete'];
    $delete = true;

    // SQL query to be submited
    $sql = "DELETE FROM `notes`
            WHERE `Sno` = $sno";
    $result = mysqli_query($conn, $sql);
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['snoEdit'])) {
        // update the note 
        $Sno = $_POST['snoEdit'];
        $Title = $_POST['TitleEdit'];
        $Description = $_POST['DescriptionEdit'];

        // SQL query to be submited
        $sql = "UPDATE `notes` SET
                `Title` = '$Title',
                `Description` = '$Description'
                WHERE `Sno` = '$Sno';";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $edit = true;
        } else {
            echo "record could't updated succesfully beacuse of =>" . mysqli_error($conn);
        }
    } else {
        // insert data from form to table
        $Title = $_POST['Title'];
        $Description = $_POST['Description'];

        // SQL query to be submited
        $sql = "INSERT INTO `notes` (`Title`, `Description`)
            VALUES ('$Title', '$Description');";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $insert = true;
        } else {
            echo "Record could't submitted succesfully because of => " . mysqli_error($conn);
        }
        //exit(); => debug method
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
    <title>iNotes - crud operations</title>
</head>

<body>
    <!-- modal for edit data -->
    <!-- Button trigger modal -->
    <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal">
        Launch demo modal
    </button> -->

    <!-- Modal(popup message) for edit the note-->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Note</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/php/iNotes_crud/index.php" method="post">
                    <div class="modal-body">
                        <input type="hidden" name="snoEdit" id="snoEdit">
                        <div class="form-group">
                            <label for="Title">Title</label>
                            <input type="text" class="form-control" id="TitleEdit" name="TitleEdit" aria-describedby="emailHelp">
                        </div>
                        <div class="form-group">
                            <label for="Description">Description</label>
                            <textarea class="form-control" id="DescriptionEdit" rows="3" name="DescriptionEdit"></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
            </div>
            </form>
        </div>
    </div>

    <!-- navbar starts -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">iNotes</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact us</a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>

    <!-- confirmation msg to show data inserted succesfully -->
    <?php
    if ($insert) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
            <strong>Success!</strong> Your note has been submitted succesfully.
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
             </button>
        </div>";
    }
    ?>

    <!-- confirmation msg to show data updated succesfully -->
    <?php
    if ($edit) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
            <strong>Success!</strong> Your note has been updated succesfully.
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
             </button>
        </div>";
    }
    ?>

    <!-- confirmation msg to show data deleted succesfully -->
    <?php
    if ($delete) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
            <strong>Success!</strong> Your note has been deleted succesfully.
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
             </button>
        </div>";
    }
    ?>

    <!-- create a form to add a notes -->
    <div class="container my-4">
        <h2>Add a note</h2>
        <form action="/php/iNotes_crud/index.php" method="post">
            <div class="form-group">
                <label for="Title">Title</label>
                <input type="text" class="form-control" id="Title" name="Title" aria-describedby="emailHelp">
            </div>
            <div class="form-group">
                <label for="Description">Description</label>
                <textarea class="form-control" id="Description" rows="3" name="Description"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Add Note</button>
        </form>
    </div>

    <!-- create a table to show notes -->
    <div class="container my-4">

        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Select data from database and fetch in column -->
                <?php
                $sql = "SELECT * from notes";
                $result = mysqli_query($conn, $sql);
                $sno = 0;
                while ($row = mysqli_fetch_assoc($result)) {
                    $sno = $sno + 1;
                    echo "<tr>
                        <th scope='row'>" . $sno . "</th>
                        <td>" . $row['Title'] . "</td>
                        <td>" . $row['Description'] . "</td>
                        <td><button type='button' class='btn btn-primary edit' id=" . $row['Sno'] . ">Edit</button> <button type='button' class='btn btn-danger delete' id=d" . $row['Sno'] . ">Delete</button></td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>

    -->

    <!-- Add a data table  -->
    <script src="//cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    <script>
        // data table for pagination, search etc.
        let table = new DataTable('#myTable'); //(line - 200)
    </script>
    <script>
        // for edit the note
        edits = document.getElementsByClassName('edit');
        Array.from(edits).forEach((element) => {
            element.addEventListener("click", (e) => {
                console.log("edit ", );
                tr = e.target.parentNode.parentNode; // select the title and discreption
                Title = tr.getElementsByTagName("td")[0].innerText;
                Description = tr.getElementsByTagName("td")[1].innerText;
                console.log(Title, Description);
                // edit the note by using modal
                TitleEdit.value = Title;
                DescriptionEdit.value = Description;
                snoEdit.value = e.target.id;
                console.log(e.target.id);
                $('#editModal').modal('toggle'); //(line - 87)
            })
        })

        // for delete the note
        deletes = document.getElementsByClassName('delete');
        Array.from(deletes).forEach((element) => {
            element.addEventListener("click", (e) => {
                console.log("delete ", );
                sno = e.target.id.substr(1, );
                console.log(sno);
                if (confirm("Are you sure to delete this item!")) {
                    window.location = `/php/iNotes_crud/index.php?delete=${sno}`;
                } else {
                    console.log("no");
                }
            })
        })
    </script>
</body>

</html>