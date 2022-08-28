<?php header("Content-Type:text/html;charset=utf-8"); ?>
<?php
  include "define.php"; 

  $id   = $_POST["id"]; 
  $pass = $_POST["pass"];  
  $name = $_POST["name"];
  $email1  = $_POST["email1"];
  $email2  = $_POST["email2"];

  $email = $email1."@".$email2; 

  $regist_day = date("Y-m-d (H:i)"); 



  $con = mysqli_connect("localhost", DBuser, DBpass, DBname); 
  

  $sql = "insert into members(id, pass, name, email, regist_day, level, point) ";

  /*추가*/
  $checkid = "select * from members where id='$id'"; 
  $result =  mysqli_query($con, $checkid); 
  $num_record = mysqli_num_rows($result); 
  /*추가끝*/

  $sql .= "values('$id', '$pass', '$name', '$email', '$regist_day', 10, 0)"; 
  

/*추가*/
  if($num_record){  //
      echo("
          <script>
              window.alert('아이디가 중복되었습니다! 다른 아이디를 사용해주세요.');
              history.go(-1); /*이전페이지로이동*/
          </script>
      ");
  } else {
      mysqli_query($con, $sql); //$sql에 저장된 명령을 실행
  } 

  mysqli_close($con); //서버와 연결 끊기
 /*추가끝*/




  echo "
      <script>
          // location.href = 'index2.php';
          location.href = 'login_form.php';  /*회원가입 후 로그인 페이지로 이동*/
      </script>
  ";

?>