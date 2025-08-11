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

<body>

    <?php

        $user_email = $no['email'];
        $sql = "SELECT `category` FROM fresh_fare_signup WHERE email = '$user_email'";
        $result = mysqli_query($login_db, $sql);
        $user = mysqli_fetch_assoc($result);

        if (!$user || $user['category'] !== 'sup_admin') {
            echo "<h3>Access Denied. Only Super Admin can view this page.</h3>";
            exit();
        }

        // Fetch enrolled companies
        $companies = mysqli_query($login_db, "SELECT * FROM fresh_fare_signup WHERE category = 'company' ORDER BY id DESC");
    ?>    
    <div class="container mt-5">
        <h2 class="mb-4">Registered Companies</h2>

        <?php if (mysqli_num_rows($companies) > 0): ?>
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Company Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Registered On</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $count = 1; while ($row = mysqli_fetch_assoc($companies)): ?>
                        <tr>
                            <td><?= $count++ ?></td>
                            <td><?= htmlspecialchars($row['username']) ?></td>
                            <td><?= htmlspecialchars($row['email']) ?></td>
                            <td><?= htmlspecialchars($row['mob_num']) ?></td>
                            <td><?= date("d M Y", strtotime($row['created_at'] ?? $row['reg_date'] ?? 'now')) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No companies found.</p>
        <?php endif; ?>
    </div>
</body>

<?php 
    include("./footer.php");
  }}
}else
  { 
  header("Location:./index"); 
  }
?>