<?php
    $real_name = $_GET["real_name"];
    $file_name = $_GET["file_name"];
    $file_type = $_GET["file_type"];
    $file_path = "./data/".$real_name;

   //브라우저가 인터넷 익스플로러인지 판단
    $ie = preg_match('~MSIE|Internet Explorer~i', $_SERVER['HTTP_USER_AGENT']) || 
        (strpos($_SERVER['HTTP_USER_AGENT'], 'Trident/7.0') !== false && 
            strpos($_SERVER['HTTP_USER_AGENT'], 'rv:11.0') !== false);

    //IE인경우 한글 파일명이 깨지는 경우를 방지하기위한 코드
    if( $ie ){
        $file_name = iconv('utf-8', 'euc-kr', $file_name);
    }

   //다운로드 파일의 존재확인
    if( file_exists($file_path) )
    {
        //fopen()는 경로를 포함한 파일을 열어
        //rb는 파일을 읽고 쓸 수 있는 모드로 열어
        $fp = fopen($file_path,"rb"); 
        //Header()함수로 다운로드할 파일의 정보를 클라이언트 브라우저에게 알려줌.
        Header("Content-type: application/x-msdownload"); 
        Header("Content-Length: ".filesize($file_path));     
        Header("Content-Disposition: attachment; filename=".$file_name);   
        Header("Content-Transfer-Encoding: binary"); 
        Header("Content-Description: File Transfer"); 
        Header("Expires: 0");       
    } 
	
    //파일 전송 및 파일 포인터 닫기
    if(!fpassthru($fp)) 
        fclose($fp); 
?>