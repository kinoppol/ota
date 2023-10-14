<?php
    $bgColor=array(
        'board'=>'#FFAAAA',
        'boc'=>'#FFFFAA',
        'committee'=>'#AAFFFF',
        'admin'=>'#FFAAFF',
        'school'=>'#AAFFAA',
    );
    //define('GOOGLE_APPID','863569354219-2aal7nslu6i3s8bm5v5797k1cbjuriqo.apps.googleusercontent.com');
    
    define('GOOGLE_APPID','620231865129-q7kvp1260ccavm43knd4603ectdqgvtb.apps.googleusercontent.com');
    
?>

<meta name="google-signin-scope" content="profile email">
		<meta name="google-signin-client_id" content="<?php print GOOGLE_APPID; ?>">
        <script src="https://apis.google.com/js/platform.js" async defer></script>
        <body class="login-page" style="font-family: 'Kanit', sans-serif; background-color: <?php print $bgColor[$userType]; ?>;">
               <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                    <div class="header" style="text-align:center">
                            <h2>
                                ลงชื่อเข้าใช้<?php print SYSTEMNAME; ?>   
                            </h2>
                            </div>
                            
                        <div class="body">
                        <!--
                        <?php
                        if(isset($onlyMail)){
                            print "หากท่านลืมรหัสผ่านท่านสามารถลงชื่อเข้าใช้ระบบผ่าน Gmail หรือติดต่อผู้ดูแลระบบ";
                        }else{
                        ?>
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
                            <input type="checkbox" name="rememberme" id="rememberme" class="filled-in chk-col-orange" value="yes">
                            <label for="rememberme">ลงชื่อเข้าใช้ค้างไว้</label>
                        </div>
                        <div class="col-xs-4">
                            <button class="btn btn-block bg-orange waves-effect" type="submit">เข้าสู่ระบบ</button>
                        </div>
                    </div>
                    <div class="row m-t-15 m-b--20">
                        <div class="col-xs-6">
                            <a href="<?php print site_url('public/user/registerNewUser'); ?>">ลงทะเบียนผู้ใช้งาน</a>
                        </div>
                        <div class="col-xs-6 align-right">
                            <a href="<?php print site_url('public/user/forgetPassword'); ?>">ลืมรหัสผ่าน?</a>
                        </div>
                    </div>
                </form>
                <div class="text" style="text-align:center">หรือเข้าสู่ระบบด้วย Gmail</div> -->
                        <?php
                        }
                        ?>
        <div class="row">
                    <div class="col-md-12 p-t-5" style="text-align:right;">
                        <div class="g-signin2" data-onsuccess="onSignIn" data-theme="dark"></div>
                        </div>
                    </div>
                    <div id="ggResponse">
                    </div></div>
                    </div></div>
                    </div>
                    <body>
    <script>
        
			function onSignIn(userInfo) {
				var result = '';
				var profile = userInfo.getBasicProfile();
                $.post( "<?php print site_url('public/user/checkGoogle'); ?>",{email:profile.getEmail(),token:userInfo.getAuthResponse().id_token}, function( data ) {
                    var result=$.parseJSON(data);
                    if(result.status=='ok'){                 
                        signOut();
                        window.location.replace("<?php print site_url('public/home/dashboard'); ?>");
                    }else{
                        alert(result.text);
                    }
                });
			}
    function signOut() {
				var auth2 = gapi.auth2.getAuthInstance();
				auth2.signOut().then(function () { 
						console.log("User signed out.");
				});
			}
    </script>