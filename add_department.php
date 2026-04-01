<?php
include('../config/db_connect.php');

// ✅ ADD / UPDATE DEPARTMENT
if(isset($_POST['save_dept'])){

    $name = trim($_POST['dept_name']);

    if(!empty($name)){

        // 🔥 CHECK DUPLICATE
        $check = mysqli_query($conn,"SELECT * FROM departments WHERE name='$name'");
        
        if(mysqli_num_rows($check) > 0 && empty($_POST['edit_id'])){
            $error = "Department already exists!";
        } else {

            // UPDATE
            if(isset($_POST['edit_id']) && $_POST['edit_id'] != ""){
                $id = $_POST['edit_id'];

                mysqli_query($conn,"
                UPDATE departments 
                SET name='$name' 
                WHERE id='$id'
                ");

                $success = "Department updated successfully!";
            } 
            // INSERT
            else {
                mysqli_query($conn,"
                INSERT INTO departments (name) 
                VALUES ('$name')
                ");

                $success = "Department added successfully!";
            }
        }

    } else {
        $error = "Department name cannot be empty!";
    }
}

// ✅ DELETE
if(isset($_GET['delete'])){
    $id = $_GET['delete'];

    mysqli_query($conn,"DELETE FROM departments WHERE id='$id'");
    header("Location: add_department.php");
    exit();
}

// ✅ EDIT FETCH
$edit_data = null;

if(isset($_GET['edit'])){
    $id = $_GET['edit'];

    $result = mysqli_query($conn,"
    SELECT * FROM departments WHERE id='$id'
    ");

    $edit_data = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin - Department Management</title>

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

input{
padding:12px;
width:280px;
border-radius:6px;
border:none;
}

button{
padding:12px 20px;
background:#2563eb;
color:white;
border:none;
border-radius:6px;
cursor:pointer;
margin-top:10px;
}

button:hover{
background:#1e40af;
}

.success{
color:#4ade80;
margin-top:10px;
}

.error{
color:#ef4444;
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

.delete-btn:hover{
background:#dc2626;
}

.edit-btn:hover{
background:#d97706;
}
</style>

</head>

<body>

<div class="container">

<h1>Department Management</h1>

<?php 
if(isset($success)) echo "<p class='success'>$success</p>"; 
if(isset($error)) echo "<p class='error'>$error</p>"; 
?>

<!-- FORM -->
<form method="POST">

<input type="hidden" name="edit_id" value="<?php echo $edit_data['id'] ?? ''; ?>">

<input type="text" name="dept_name" 
value="<?php echo $edit_data['name'] ?? ''; ?>" 
placeholder="Enter Department Name" required><br>

<button name="save_dept">
<?php echo $edit_data ? "Update Department" : "Add Department"; ?>
</button>

</form>

<!-- TABLE -->
<h2>All Departments</h2>

<table>
<tr>
<th>ID</th>
<th>Department Name</th>
<th>Actions</th>
</tr>

<?php
$result = mysqli_query($conn,"SELECT * FROM departments ORDER BY id DESC");

while($row = mysqli_fetch_assoc($result)){
?>

<tr>
<td><?php echo $row['id']; ?></td>
<td><?php echo $row['name']; ?></td>
<td>
<a class="edit-btn" href="add_department.php?edit=<?php echo $row['id']; ?>">Edit</a>

<a class="delete-btn" 
href="add_department.php?delete=<?php echo $row['id']; ?>" 
onclick="return confirm('Are you sure?')">Delete</a>
</td>
</tr>

<?php } ?>

</table>

</div>

</body>
</html>