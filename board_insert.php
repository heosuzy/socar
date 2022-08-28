<meta charset="utf-8">
<?php
	include "define.php";


	session_start();

	//실습 사이트의 게시판에 글을 쓰려면 로그인되어 있어야함.
	if (isset($_SESSION["userid"])) $userid = $_SESSION["userid"];
	else $userid = "";
	if (isset($_SESSION["username"])) $username = $_SESSION["username"];
	else $username = "";



	if ( !$userid )
	{
		echo("
			<script>
			alert('게시판 글쓰기는 로그인 후 이용해 주세요!');
			history.go(-1)
			</script>
		");
		exit;
	}


	//글 제목과 글 내용 전달 받기.
	//사용자가 글쓰기 폼 양식에서 입력한 제목과 내용을
    $subject = $_POST["subject"];//전달받아 변수에 저장.
    $content = $_POST["content"];


	$subject = htmlspecialchars($subject, ENT_QUOTES);
	$content = htmlspecialchars($content, ENT_QUOTES);

	$regist_day = date("Y-m-d (H:i)");  //현재의 년-월-일-시-분을 저장


	//업로드 폴더를 설정.
	$upload_dir = './data/';

	$upfile_name	 = $_FILES["upfile"]["name"];//업로드 파일명	
	$upfile_tmp_name = $_FILES["upfile"]["tmp_name"];//실제 서버에 저장되는 임시파일명	
	$upfile_type     = $_FILES["upfile"]["type"];//업로드 파일 형식 
	$upfile_size     = $_FILES["upfile"]["size"];//업로드 파일의 크기		
	$upfile_error    = $_FILES["upfile"]["error"];//오류발생		



	if ($upfile_name && !$upfile_error)
	{
		//explode()함수를 이용하여 파일명과 확장자를 분리.
		$file = explode(".", $upfile_name); 
		$file_name = $file[0];//파일명
		$file_ext  = $file[1];//확장자


		//실제 업로드 파일명 구하기
		$new_file_name = date("Y_m_d_H_i_s");
		$new_file_name = $new_file_name;
		$copied_file_name = $new_file_name.".".$file_ext;      
		$uploaded_file = $upload_dir.$copied_file_name;


		//업로드 파일의 크기제한
		//업로드 파일의 크기가 약 1MB를 초과하면 경고메세지 출력
		if( $upfile_size  > 1000000 ) {
			echo("
				<script>
				alert('업로드 파일 크기가 지정된 용량(1MB)을 초과합니다!<br>파일 크기를 체크해주세요! ');
				history.go(-1)
				</script>
			");
			exit;
		}


		//move_uploaded_file()함수를 이용해 서버에 임시저장된 $upfile_tmp_name 파일을 $uploaded_file의 값인 경로/파일명 형태로 저장되도록.
		if (!move_uploaded_file($upfile_tmp_name, $uploaded_file) )
		{
			echo("
				<script>
				alert('파일을 지정한 디렉토리에 복사하는데 실패했습니다.');
				history.go(-1)
				</script>
			");
			exit;
		}
	}
	else 
	{
		$upfile_name      = "";
		$upfile_type      = "";
		$copied_file_name = "";
	}
	

	$con = mysqli_connect("localhost", DBuser, DBpass, DBname);
	//아이디, 사용자명,제목,내용,날짜,히트,파일이름,파일타입,실제 업로드 파일명
	$sql = "insert into board (id, name, subject, content, regist_day, hit,  file_name, file_type, file_copied) ";
	$sql .= "values('$userid', '$username', '$subject', '$content', '$regist_day', 0, ";
	$sql .= "'$upfile_name', '$upfile_type', '$copied_file_name')";
	mysqli_query($con, $sql);  // $sql 에 저장된 명령 실행


	//포인트 부여하기. 게시판에 글을 쓰면 회원에게 포인트 100점씩 부여됨.
	$point_up = 100;

	$sql = "select point from members where id='$userid'";
	$result = mysqli_query($con, $sql);
	$row = mysqli_fetch_array($result);
	$new_point = $row["point"] + $point_up;


	//DB에 포인트 업데이트
	$sql = "update members set point=$new_point where id='$userid'";
	mysqli_query($con, $sql);


	mysqli_close($con);  


	/* location.href에  board_list.php를 설정하여 목록페이지로 이동하도록*/
	echo "
		<script>
		location.href = 'board_list.php';
		</script>
	";
?>