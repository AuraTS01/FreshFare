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
        if(isset($_GET['msg']) || isset($_GET['err'])){
          $msg = isset($_GET['msg'])? $_GET['msg']:$_GET['err'];
          showAlert($msg);
        }
        
    ?>
   
    <div class="form-wrapper">
        <div class="form-container">
            <h2 class="mb-4 text-center">Enroll New Company</h2>
            <form action="enroll_company" method="POST" autosave="off" autocomplete="off">
                <div class="mb-3">
                    <label for="companyName" class="form-label">Company Name</label>
                    <input type="text" class="form-control" id="companyName" name="company_name" required>
                </div>

                <div class="mb-3">
                    <label for="companyAddress" class="form-label">Company Address</label>
                    <textarea class="form-control" id="companyAddress" name="company_address" rows="3" required></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Company Sells:</label><br>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="selling[]" value="Chicken" id="chkChicken">
                        <label class="form-check-label" for="chkChicken">Chicken</label>
                    </div>
                    <div id="chickenOptions" class="nested-options">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="chicken_options[]" value="With Skin" id="chickenSkin">
                            <label class="form-check-label" for="chickenSkin">Chicken with Skin</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="chicken_options[]" value="Without Skin" id="chickenNoSkin">
                            <label class="form-check-label" for="chickenNoSkin">Chicken without Skin</label>
                        </div>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="selling[]" value="Mutton" id="chkMutton">
                        <label class="form-check-label" for="chkMutton">Mutton</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="selling[]" value="Fish" id="chkFish">
                        <label class="form-check-label" for="chkFish">Fish</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="selling[]" value="Prawn" id="chkPrawn">
                        <label class="form-check-label" for="chkPrawn">Prawn</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="selling[]" value="Kadai" id="chkKadai">
                        <label class="form-check-label" for="chkKadai">Kadai</label>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Email</label>
                    <div class="input-group">
                        <input type="email" class="form-control" id="email" name="email" required>
                        
                    </div>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Mobile Number</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="mob_num" name="mob_num" required>

                    </div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="password" name="password" required>
                        <button type="button" class="btn btn-outline-secondary" onclick="generateDefaultPassword()">Generate Default Password</button>
                    </div>
                </div>

                <button type="submit" name="enroll_company" class="btn btn-primary">Enroll Company</button>
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