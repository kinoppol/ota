<body class="login-page" style="font-family: 'Kanit', sans-serif; background-color: grey;">
<div class="login-box">
        <div class="logo">
        <h1>
            <a href="javascript:void(0);">ลงทะเบียนผู้ใช้งาน</a>
            </h1>
        </div>
        <div class="card">
        <div class="header" style="text-align:center">
                            <h2>
                                <?php print SYSTEMNAME; ?>   
                            </h2>
                            </div>
            <div class="body">
                <form id="sign_in" action="<?php print site_url('public/user/checkSignUp'); ?>" method="POST">
                    <?php
                        if(isset($_SESSION['message'])&&$_SESSION['message']!=''){
                            print '<div class="msg" style="color:red;">'.$_SESSION['message'].'</div>';
                            $_SESSION['message']='';
                        }else{
                            print '<div class="msg">โปรดระบุข้อมูลของคุณเพื่อเข้าลงทะเบียนสมาชิกใหม่</div>';
                        }
                    ?>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                        <div class="form-line">
                            <input type="text" class="form-control" name="username" placeholder="Username"  minlength="4" onkeypress="return /[a-z,A-Z,0-9_\-.]/i.test(event.key)" pattern="[a-z,A-Z,0-9_\-.]" autocomplete="off" required autofocus>
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input type="password" class="form-control" name="password" placeholder="รหัสผ่าน" minlength="8" required>
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input type="password" class="form-control" name="confirmPassword" placeholder="ยืนยันรหัสผ่าน" minlength="8" required>
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">people</i>
                        </span>
                        <div class="form-line">
                            <input type="text" class="form-control" name="name" placeholder="ชื่อ" minlength="3" required>
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">people</i>
                        </span>
                        <div class="form-line">
                            <input type="text" class="form-control" name="surname" placeholder="สกุล" minlength="3" required>
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">mail</i>
                        </span>
                        <div class="form-line">
                            <input type="email" class="form-control" name="email" placeholder="อีเมล" required>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-xs-8 p-t-5">
                        </div>
                        <div class="col-xs-4">
                            <button class="btn btn-block bg-pink waves-effect" type="submit">ลงทะเบียน</button>
                        </div>
                    </div>
                    <div class="row m-t-15 m-b--20">
                        <div class="col-xs-6">
                        </div>
                        <div class="col-xs-6 align-right">
                            <a href="<?php print site_url('public/user/loginSelector'); ?>">เข้าสู่ระบบ</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
                    </body>