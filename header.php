<link rel="stylesheet" type="text/css" href="./css/common.css">
<!-- 헤더변경시 해당 스타일시트 추가 -->
<?php
    include "define.php"; 
    
    session_start();//섹션의 시작. 세션을 저장하거나 저장된 세션을 사용할때 미리 선언해야함.

    if (isset($_SESSION["userid"])) $userid = $_SESSION["userid"];//isset()함수는 이 섹션에 "userid"값이 있는지 검사(값이 있으면 참, 없으면 거짓)


    else $userid = ""; //값을 null로 설정.

    if (isset($_SESSION["username"])) $username = $_SESSION["username"];
    
    else $username = ""; 

    if (isset($_SESSION["userlevel"])) $userlevel = $_SESSION["userlevel"];
    else $userlevel = "";

    if (isset($_SESSION["userpoint"])) $userpoint = $_SESSION["userpoint"];
    else $userpoint = "";

?>		
        <div id="top">
            <h1>
                <a href="index.php"><img src="./img/fix_logo.gif"></a>
            </h1>
            <ul id="top_menu">  

<?php
    if(!$userid) { //로그인되지 않은 상태. 사용자 이름, 아이디, 레벨, 포인트가 출력됨.
       
?>           

                <li><a href="member_form.php">회원 가입</a> </li>
                <li> | </li>
                <li><a href="login_form.php">로그인</a></li>

<?php
    } else { 
       

        $logged = $username."님 [Level:".$userlevel.", Point:".$userpoint."]";
        

?>
                <li><?=$logged?> </li>
                <li> | </li>
                <li><a href="logout.php">로그아웃</a> </li>
                <li> | </li>
                <li><a href="member_modify_form.php">마이페이지</a></li>
<?php
    }
?>


<?php
    if($userlevel==1) { //관리자 모드 버튼, 로그인한 사용자가 관리자인지 확인
                        //하여 관리자라면 관리자 페이지 접속할 메뉴가 생성됨.
   
?>
                <li> | </li>
                <li><a href="admin.php">관리자 모드</a></li>
<?php
    }
?>
            </ul>
        </div>
        <div id="menu_bar">
            <ul>  
                <li><a href="#">회사소개</a></li>
                <li><a href="#">제품소개</a></li>                                
                <li><a href="board_list.php">Notice</a></li>
                <li><a href="login_form.php">마이페이지</a></li>
            </ul>
        </div>
