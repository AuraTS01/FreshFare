<?php
include('./header.php');

if (isset($_SESSION['user'])) 
{

  // echo "pass";
  if((time() - $_SESSION['last_login_timestamp']) > 600) // 900 = 15 * 60  
  {  
    header("Location:logout.php");  
  }  
  else  
  {  
    $_SESSION['last_login_timestamp'] = time();  
    $sql = "SELECT * FROM `fresh_fare_signup` WHERE `email`='" . $_SESSION["email"] . "'";
    $result = mysqli_query($login_db,$sql);
    $no = mysqli_fetch_array($result);
    if($no!=0) 
    {

?>



    <?php

         $user_email = $no['email'];
        $sql = "SELECT `category` FROM fresh_fare_signup WHERE email = '$user_email'";
        $result = mysqli_query($login_db, $sql);
        $user = mysqli_fetch_assoc($result);

        if (!$user || $user['category'] !== 'sup_admin') {
            echo "<h3>Access Denied. Only Super Admin can view this page.</h3>";
            exit();
        }

        // Fetch all users except sup_admin
        $users = mysqli_query($login_db, "SELECT * FROM fresh_fare_signup WHERE category != 'sup_admin' ORDER BY id DESC");
    ?>    
     <?php 
        if(isset($_GET['msg']) || isset($_GET['err'])){
          $msg = isset($_GET['msg'])? $_GET['msg']:$_GET['err'];
          showAlert($msg);
        }
        
    ?>

    <div class="container mt-5">
        <h2 class="mb-4">Registered Users</h2>


        <?php if (mysqli_num_rows($users) > 0): ?>
            <table id="usersTable" class="table table-bordered table-striped dt-responsive nowrap" style="width:100%">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Category</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $count = 1; while ($row = mysqli_fetch_assoc($users)): ?>
                        <tr>
                            <td><?= $count++ ?></td>
                            <td><?= htmlspecialchars($row['username']) ?></td>
                            <td><?= htmlspecialchars($row['email']) ?></td>
                            <td><?= htmlspecialchars($row['mob_num']) ?></td>
                            <td><?= htmlspecialchars($row['category']) ?></td>
                            <td>
                                <button class="btn btn-sm btn-primary change-category-btn" 
                                    data-email="<?= $row['email'] ?>" 
                                    data-name="<?= htmlspecialchars($row['username']) ?>" 
                                    data-phone="<?= htmlspecialchars($row['mob_num']) ?>" 
                                    data-category="<?= $row['category'] ?>"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#changeCategoryModal">
                                    Change Category
                                </button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

        <?php else: ?>
            <p>No users found.</p>
        <?php endif; ?>
    </div>

    <!-- Change Category Modal -->
    <div class="modal fade" id="changeCategoryModal" tabindex="-1" aria-labelledby="changeCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" id="changeCategoryForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Update User Info</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="email" id="modalEmail"> <!-- primary key -->
                        
                        <div class="mb-3">
                            <label for="modalName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="modalName" name="username" required>
                        </div>

                        <div class="mb-3">
                            <label for="modalPhone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="modalPhone" name="mob_num" required>
                        </div>

                        <div class="mb-3">
                            <label for="modalCategory" class="form-label">Category</label>
                            <select class="form-select form-select-sm" id="modalCategory" name="category" required>
                                <option value="company">Company</option>
                                <option value="customer">Customer</option>
                                <option value="delivery_agent">Delivery Agent</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" name="updateCategory" class="btn btn-success">Save</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

<?php 
    include("./footer.php");
  }}
}else
  { 
  header("Location:./index"); 
  }
?>