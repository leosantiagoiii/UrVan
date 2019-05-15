<?php require "header.php"; ?>
<body class="login-member-bg">
    <main>
        <div class="container text-center fandra">
            <div class="fandrabelow">
                <h1>Rider Login</h1>
                <form action="includes/login.inc.php" method="post">
                    <input name="mail-and-uname" type="text" style="width:100%; margin-bottom:20px;" class="form-control form-control form-control-lg
                    <?php
                    $var = NULL;
                    if(isset($_GET['error'])){
                        echo 'red';
                    } 
                    else {
                        echo NULL;
                    }
                    ?>" placeholder="Email/Username" value="<?php
                    $var = NULL;
                    if(isset($_GET['error'])=='emptyfields' || isset($_GET['error'])=='wrongpassword'){
                        echo $_GET['mail-and-uname'];
                    } 
                    elseif(isset($_GET['error'])=='nouserindatabase'){
                        echo NULL;
                    } 
                    else {
                        echo NULL;
                    }
                    ?>">
                    <input name="password" type="password" style="width:100%; margin-bottom:20px;" class="form-control form-control form-control-lg
                    <?php
                    $var = NULL;
                    if(isset($_GET['error'])){
                        echo 'red';
                    } 
                    else {
                        echo NULL;
                    }
                    ?>" id="inputPassword" placeholder="Password">
                    <button type="submit" name="login-button" class="btn btn-outline-primary btn-block btn-lg" style="width:100%">Login</button>
                </form>
            </div>
        </div>
    </main>
    <?php
    if(isset($_GET['error'])){
        if($_GET['error']=='emptyfields'){
            echo '<div class="errormsg-sign">empty fields</div>';
        }
        elseif($_GET['error']=='wrongpassword'){
            echo '<div class="errormsg-sign">wrong password</div>';
        }
        else {
            echo "";
        }
    } 
    else {
        echo NULL;
    } ?>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
</body>
<?php require "footer.php"; ?>