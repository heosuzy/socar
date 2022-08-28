<?php
    include "define.php";

    session_start();
    if (isset($_SESSION["userlevel"])) $userlevel = $_SESSION["userlevel"];
    else $userlevel = "";

    if ( $userlevel != 1 )
    {
        echo("
                    <script>
                    alert('관리자가 아닙니다! 회원 삭제는 관리자만 가능합니다!');
                    history.go(-1)
                    </script>
        ");
                exit;
    }

    //체크박스 선택여부 판단 : $_POST["item"]값을 확인하면 체크박스 선택여부를 알수있음.
    //count()에 의해 체크박스가 선택된 항목의 수를 구해서 변수에 저장.
    if (isset($_POST["item"]))
        $num_item = count($_POST["item"]);
    else
        echo("
                    <script>
                    alert('삭제할 게시글을 선택해주세요!');
                    history.go(-1)
                    </script>
        ");

    $con = mysqli_connect("localhost", DBuser, DBpass, DBname);

    for($i=0; $i<count($_POST["item"]); $i++){

        //count($_POST["item"])에 의해 체크박스가 선택된 항목의 수를 구해  $num_item에 저장
        $num = $_POST["item"][$i];

        //업로드된 첨부 파일명 가져오기: 
        $sql = "select * from board where num = $num";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($result);

        $copied_name = $row["file_copied"];

        //첨부파일 삭제: $copied_name에 값이 있다면 첨부파일을 unlink()함수로 해당 파일들을 삭제
        if ($copied_name)
        {
            $file_path = "./data/".$copied_name;
            unlink($file_path);
        }

         
        $sql = "delete from board where num = $num";
        mysqli_query($con, $sql);
    }

    mysqli_close($con);

    echo "
	     <script>
	         location.href = 'admin.php';
	     </script>
	   ";
?>

