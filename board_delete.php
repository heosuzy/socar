<?php
    include "define.php";

    session_start();
    if (isset($_SESSION["userlevel"])) $userlevel = $_SESSION["userlevel"];
    else $userlevel = "";

    if ( $userlevel != 1 )
    {
        echo("
            <script>
            alert('관리자가 아닙니다! 삭제는 관리자만 가능합니다!');
            history.go(-1)
            </script>
        ");
                exit;
    }

    //글 내용 보기 페이지 board_view.php 파일에서 하단 삭제를 클릭하면 글삭제 board_delete.php 페이지로이동

    //레코드 번호와 페이지 번호 전달받기
    $num   = $_GET["num"];
    $page   = $_GET["page"];


    //삭제할 첨부 파일명 가져오기
    //mysqli_fetch_array()는 첨부파일명인  $row["file_copied"]를 변수  $copied_name 에 저장하기 위함.
    $con = mysqli_connect("localhost", DBuser, DBpass, DBname);
    $sql = "select * from board where num = $num";
    $result = mysqli_query($con, $sql); 
    $row = mysqli_fetch_array($result); 

    $copied_name = $row["file_copied"]; 



    //첨부파일 삭제
    //unlink()함수로 서버에 저장된 첨부파일을 삭제
	if ($copied_name)
	{
		$file_path = "./data/".$copied_name;
		unlink($file_path); 
    }

    //db에서 해당 레코드 삭제
    $sql = "delete from board where num = $num";
    mysqli_query($con, $sql);
    mysqli_close($con);

    echo "
        <script>
        //페이지 이동
            location.href = 'board_list.php?page=$page';
        </script>
    ";
?>