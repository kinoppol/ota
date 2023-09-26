<div class="login-box">
        <div class="logo">
            <a href="javascript:void(0);"><?php print $systemName?></a>
        </div>
        <div class="card">
            <div class="body">
                <form id="sign_in" action="<?php print site_url('public/user/checkLogin'); ?>" method="POST">
                    <?php
                        if(isset($_SESSION['message'])&&$_SESSION['message']!=''){
                            print '<div class="msg" style="color:red;">'.$_SESSION['message'].'</div>';
                            $_SESSION['message']='';
                        }else{
                            print '<div class="msg">โปรดระบุข้อมูลของคุณเพื่อเข้าสู่ระบบ</div>';
                        }
                    ?>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                        <div class="form-line">
                            <input type="text" class="form-control" name="username" placeholder="Username" required autofocus>
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8 p-t-5">
                            <input type="checkbox" name="rememberme" id="rememberme" class="filled-in chk-col-pink" value="yes">
                            <label for="rememberme">ลงชื่อเข้าใช้ค้างไว้</label>
                        </div>
                        <div class="col-xs-4">
                            <button class="btn btn-block bg-pink waves-effect" type="submit">SIGN IN</button>
                        </div>
                    </div>
                    <div class="row m-t-15 m-b--20">
                        <div class="col-xs-6">
                            <a href="sign-up.html">Register Now!</a>
                        </div>
                        <div class="col-xs-6 align-right">
                            <a href="forgot-password.html">Forgot Password?</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>