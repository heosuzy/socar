<!DOCTYPE html>
<html>
<head> 
<meta charset="utf-8">
<title>PHP 프로그래밍</title>
<link rel="stylesheet" type="text/css" href="./css/common.css">
<link rel="stylesheet" type="text/css" href="./css/board.css">
</head>
<body> 
<header>
	<?php include "header.php";?>
</header>  
<section>
	<div id="main_img_bar">
		
	</div>
	<div id="board_box">
		<h3 class="title">
			게시판 > 내용보기
		</h3>
<?php
	//글 목록 페이지로부터 레코드 일련번호와 페이지 번호를 각각 전달받아 변수에 저장
	$num  = $_GET["num"];
	$page  = $_GET["page"];


	//DB에서 해당 글 검색하여 글 정보를 가져오기
	//해당 레코드 번호 $num을 가진 레코드를 검색하여 다시 $result에 저장
	$con = mysqli_connect("localhost", DBuser, DBpass, DBname);
	$sql = "select * from board where num=$num";
	$result = mysqli_query($con, $sql);

//$result에서 데이터 가져오기
	$row = mysqli_fetch_array($result);
	$id      = $row["id"]; 
	$name      = $row["name"]; 
	$regist_day = $row["regist_day"]; 
	$subject    = $row["subject"]; 
	$content    = $row["content"]; 
	$file_name    = $row["file_name"]; //첨부파일명
	$file_type    = $row["file_type"]; 
	$file_copied  = $row["file_copied"]; //서버에 저장된 첨부파일명
	$hit          = $row["hit"]; 

	//str_replace()함수는 공백을 HTML의 &nbsp;로 변경해주는 함수
	$content = str_replace(" ", "&nbsp;", $content);
	$content = str_replace("\n", "<br>", $content);


	//조회수 값 증가와 DB업데이트
	$new_hit = $hit + 1;
	$sql = "update board set hit=$new_hit where num=$num";   
	mysqli_query($con, $sql);



?>		
		<ul id="view_content">
			<li> <!-- 제목, 글쓴이 이름, 작성일자 -->
				<span class="col1"><b>제목 :</b> <?=$subject?></span> 
				<span class="col2"><?=$name?> | <?=$regist_day?></span> 
			</li>
			<li>
				<?php
					if($file_name) { /* 첨부파일 정보 출력 */
						$real_name = $file_copied;
						$file_path = "./data/".$real_name;
						$file_size = filesize($file_path);



						

						echo "▷ 첨부파일 : $file_name ($file_size Byte) &nbsp;&nbsp;&nbsp;&nbsp;
						<a href='download.php?num=$num&real_name=$real_name&file_name=$file_name&file_type=$file_type'>[저장]</a><br><br>";
					}
				?>
				<?=$content?> 
			</li>		
		</ul>
		<ul class="buttons"> <!-- 버튼삽입 -->
		<!-- 화면 하단 목록, 수정, 삭제, 글쓰기 -->
		
				<li><button onclick="location.href='board_list.php?page=<?=$page?>'">목록</button></li>
				<li><button onclick="location.href='board_modify_form.php?num=<?=$num?>&page=<?=$page?>'">수정</button></li>
				<li><button onclick="location.href='board_delete.php?num=<?=$num?>&page=<?=$page?>'">삭제</button></li>
				<li><button onclick="location.href='board_form.php'">글쓰기</button></li>
		</ul>
	</div> 
</section> 
<footer>
	<?php include "footer.php";?>
</footer>
</body>
</html>