<?php
require ("db.php");

$file = null;

if(isset($_FILES['upload']) && $_FILES['upload']['name'] != ""){
    $file = $_FILES['upload'];
}


if($file != null){
    if(strncmp("image/", $file['type'], 6) != 0){
        msgAndBack("이미지 파일만 업로드 할 수 있습니다.");
        exit;
    }
}

if(!isset($_SESSION['user'])){
    msgAndGo("로그인한 유저만 말을 쓸 수 있습니다.", "/login.php");
    exit;
}

$title = $_POST['title'];
$writer = $_POST['writer'];
$content = $_POST['content'];
$_writer = $_SESSION['user']->email;

if(trim($title) == "" || trim($writer) == "" || trim($content) == ""){
    msgAndBack("필수 값이 비어있습니다.");
    exit;
}

$id = $_POST['id'];
$params = [$title, $writer, $content];

if($id == 0){
    $sql = "INSERT INTO boards 
            (`title`, `writer`, `content`, `wdate`";

    // $sql .= $file != null ? ", img)" : ")";

    if($file != null){
        $sql .= ", img)  VALUES (?, ?, ?, NOW(), ?)";
        move_uploaded_file($file['tmp_name'], "upload/" . $file['name']);
        $params[] = "upload/" . $file['name'];
    }else {
        $sql .= ")  VALUES (?, ?, ?, NOW())";
    }

    move_uploaded_file($_FILES['upload']['tmp_name'], "upload/" . $_FILES['upload']['name']);
}else {
    //수정일 경우에는 해당 글에 수정 권한이 있는지 체크해야한다.
    $sql = "SELECT * FROM boards WHERE id = ?";

    $result = fetch($con, $sql, [$id]);
    if($result->writer != $_SESSION['user']->email){
        msgAndBack("권한이 없습니다.");
        exit;
    }

    $sql = "UPDATE boards SET `title` = ? ,
                 `writer` = ?, `content` = ?
            WHERE id = ?";
    if($file != null){
        $sql = "UPDATE boards SET `title` = ? ,
                 `writer` = ?, `content` = ? , `img` = ?
            WHERE id = ?";
            move_uploaded_file($file['tmp_name'], "upload/" . $file['name']);
            $params[] = "upload/" . $file['name'];
    }
    $params[] = $id;
}

$cnt = query($con, $sql, $params);

if($cnt == 1){
    msgAndGo("정상적으로 처리되었습니다.", "list.php");
}else{
    msgAndBack("오류가 발생했습니다");
}
