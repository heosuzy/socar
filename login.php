<meta charset="utf-8">
<?php
   include "define.php";
   
   /* 사용자가 입력한 아이디 패스워드가 members테이블에 존재하는지 검사하여 로그인 판단여부를 판단하고 처리함. */
   $id   = $_POST["id"]; 
   $pass = $_POST["pass"];

   $con = mysqli_connect("localhost", DBuser, DBpass, DBname); 


   $sql = "select * from members where id='$id'";

   $result = mysqli_query($con, $sql); 
   

   $num_match = mysqli_num_rows($result); //저장된 레코드 개수를 세어 저장.


   if(!$num_match) //존재여부 판단
   {
     echo("
           <script>
             window.alert('등록되지 않은 아이디입니다!')  /*아이디가 존재하지 않는 경우*/
             history.go(-1)
           </script>
         ");
    }
    else 
    {
        $row = mysqli_fetch_array($result); 
       
        $db_pass = $row["pass"];


        mysqli_close($con);

        if($pass != $db_pass) 
        {
            
           echo(" 
              <script>
                window.alert('비밀번호가 틀립니다!')
                history.go(-1)
              </script>
           ");
           exit;
        }
        else
        {
            session_start(); //비밀번호 같은 경우 세션 시작
            $_SESSION["userid"] = $row["id"]; 
            
            $_SESSION["username"] = $row["name"]; 
           
            $_SESSION["userlevel"] = $row["level"];
            $_SESSION["userpoint"] = $row["point"]; 
           

            echo("
              <script>
                location.href = 'index.php';
              </script>
            ");
        }
     }        
?>