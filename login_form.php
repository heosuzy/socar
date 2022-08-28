<!DOCTYPE html>
<html>
<head> 
<meta charset="utf-8">
<title>PHP 프로그래밍</title>
<link rel="stylesheet" type="text/css" href="./css/common.css">
<link rel="stylesheet" type="text/css" href="./css/login.css">
<!-- 자신의 프로젝트에 포함시켜야할 파일 -->
<!-- 로그인 페이지의 아이디와 비밀번호 입력창에 데이터가 있는지 검사 후 경고 창 출력 -->
<!-- 데이터가 젲대로 입력되었다면 login.php로 이동 -->
<script type="text/javascript" src="./js/login.js"></script>


</head>
<body> 
	<header>
    	<?php include "header.php";?>
    </header>
	<section>
		<div id="main_img_bar">

        </div>
        <div id="main_content">
      		<div id="login_box">
	    		<div id="login_title">
		    		<span>로그인</span>
	    		</div>
	    		<div id="login_form">
          		<form  name="login_form" method="post" action="login.php"> 	       	
                  	<ul>
                    <li><input type="text" name="id" placeholder="아이디" value=""></li>
                    <li><input type="password" id="pass" name="pass" placeholder="비밀번호" value=""></li> <!-- pass -->
                  	</ul>
                  	<div id="login_btn">
                      	<a href="#"><img src="./img/loginBT.png" width="429" onclick="check_input()"></a> 
						<!-- 로그인 페이지 입력창에 아이디와 비번을 입력하여 버튼을 클릭하면 함수 실행.  아이디 입력창에 데이터가 비어있으면 경고창 띄움.-->
                      
                  	</div>		    	
           		</form>
        		</div>
    		</div>
        </div> 
	</section> 
	<footer>
    	<?php include "footer.php";?>
    </footer>
</body>
</html>
