<?php
    include "define.php";


    $num = $_GET["num"]; 
    $page = $_GET["page"]; 

    $subject = $_POST["subject"]; //수정된 글 제목 전달받음
    $content = $_POST["content"]; //수정된 글 내용 전달받음

    $con = mysqli_connect("localhost", DBuser, DBpass, DBname);


    $sql = "update board set subject='$subject', content='$content' ";
    $sql .= " where num=$num";
    mysqli_query($con, $sql);

    mysqli_close($con);     

    echo "
        <script>/* 글목록 보기 페이지로 이동 */
        // 글 목록 보기 페이지 board_list.php로 이동. 
        // GET방식으로 전달하여 글 목록 보기 페이지에서 수정된 글 제목을 볼 수 있음.
            location.href = 'board_list.php?page=$page';
        </script>
    ";
?>