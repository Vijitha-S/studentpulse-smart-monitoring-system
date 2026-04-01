<?php
include('../config/db_connect.php');

// ✅ ADD / UPDATE
if(isset($_POST['save_year'])){
    $year_name = $_POST['year_name'];
    $type = $_POST['type'];

    if(isset($_POST['edit_id']) && $_POST['edit_id'] != ""){
        $id = $_POST['edit_id'];
        mysqli_query($conn, "UPDATE years SET year_name='$year_name', type='$type' WHERE id='$id'");
        $success = "Year updated successfully!";
    } else {
        mysqli_query($conn, "INSERT INTO years (year_name, type) VALUES ('$year_name', '$type')");
        $success = "Year added successfully!";
    }
}

// ✅ DELETE
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM years WHERE id='$id'");
    header("Location: add_year.php");
    exit();
}

// ✅ EDIT FETCH
$edit_data = null;
if(isset($_GET['edit'])){
    $id = $_GET['edit'];
    $result = mysqli_query($conn, "SELECT * FROM years WHERE id='$id'");
    $edit_data = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Year Management</title>

<style>
body{
background:#020617;
color:white;
font-family:"Book Antiqua";
text-align:center;
}

.container{
margin-top:50px;
}

select, input{
padding:12px;
width:280px;
border-radius:6px;
border:none;
margin:5px;
}

button{
padding:12px 20px;
background:#22c55e;
color:white;
border:none;
border-radius:6px;
cursor:pointer;
}

button:hover{
background:#16a34a;
}

.success{
color:#4ade80;
margin-top:10px;
}

table{
margin:30px auto;
width:70%;
border-collapse:collapse;
}

th,td{
padding:12px;
border:1px solid #ccc;
text-align:center;
}

th{
background:#1e293b;
}

tr:nth-child(even){
background:#0f172a;
}

.delete-btn{
background:#ef4444;
padding:6px 12px;
color:white;
border-radius:5px;
text-decoration:none;
}

.edit-btn{
background:#f59e0b;
padding:6px 12px;
color:white;
border-radius:5px;
text-decoration:none;
margin-right:5px;
}
</style>

<script>
// 🔥 Dynamic Year Dropdown
function updateYears(){
    var type = document.getElementById("type").value;
    var yearSelect = document.getElementById("year_name");

    yearSelect.innerHTML = "<option value=''>Select Year</option>";

    if(type === "UG"){
        yearSelect.innerHTML += "<option>1st Year</option>";
        yearSelect.innerHTML += "<option>2nd Year</option>";
        yearSelect.innerHTML += "<option>3rd Year</option>";
    } else if(type === "PG"){
        yearSelect.innerHTML += "<option>1st Year</option>";
        yearSelect.innerHTML += "<option>2nd Year</option>";
    }
}
</script>

</head>

<body>

<div class="container">

<h1>Year Management</h1>

<?php if(isset($success)) echo "<p class='success'>$success</p>"; ?>

<form method="POST">

<input type="hidden" name="edit_id" value="<?php echo $edit_data['id'] ?? ''; ?>">

<!-- TYPE -->
<select name="type" id="type" onchange="updateYears()" required>
<option value="">Select Type</option>
<option value="UG" <?php if(($edit_data['type'] ?? '')=="UG") echo "selected"; ?>>UG</option>
<option value="PG" <?php if(($edit_data['type'] ?? '')=="PG") echo "selected"; ?>>PG</option>
</select>

<!-- YEAR -->
<select name="year_name" id="year_name" required>
<option value=""><?php echo $edit_data['year_name'] ?? 'Select Year'; ?></option>
</select>

<br>

<button name="save_year">
<?php echo isset($edit_data) ? "Update Year" : "Add Year"; ?>
</button>

</form>

<h2>All Years</h2>

<table>
<tr>
<th>ID</th>
<th>Type</th>
<th>Year</th>
<th>Actions</th>
</tr>

<?php
$result = mysqli_query($conn, "SELECT * FROM years");

while($row = mysqli_fetch_assoc($result)){
    echo "<tr>
            <td>".$row['id']."</td>
            <td>".$row['type']."</td>
            <td>".$row['year_name']."</td>
            <td>
                <a class='edit-btn' href='add_year.php?edit=".$row['id']."'>Edit</a>
                <a class='delete-btn' href='add_year.php?delete=".$row['id']."' onclick=\"return confirm('Delete?')\">Delete</a>
            </td>
          </tr>";
}
?>

</table>

</div>

</body>
</html>