<?php
    require("db.php");

    $sql = "SELECT * FROM boards WHERE id = ?";

    $q = $con->prepare($sql);

    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }else{
        echo "잘못된 접근입니다.";
        exit;
    }
    
    $q->execute([$id]);
    $data = $q->fetch(PDO::FETCH_OBJ);

    if(!$data){
        echo "존재하지 않는 글입니다.";
        exit;
    }
?>
<!DOCTYPE html>
<html lang="ko">
    
<?php require("head.php"); ?>

<body>
    <?php require("nav.php"); ?>
    <h1><?= $data->id ?> . <?= $data->title ?></h1>
    <div class="content">
    <?php if ($data->img != "") : ?>
        <img src="/<?= $data->img ?>" alt="첨부이미지">
    <?php endif; ?>
        <?= nl2br( htmlentities($data->content) ) ?>
    </div>
    
    <?php if ( $data->writer == $_SESSION['user']->email || $_SESSION['user']->email == "admin" ) : ?>
        <a class="btn btn-primary" href="/form.php?id=<?= $data->id ?>"> 수정하기</a>
        <a class="btn btn-warning" href="/delete.php?id=<?= $data->id ?>">삭제</a>
    <?php endif; ?>
    <a class="btn btn-success" href="/list.php">목록 보기</a>
</body>
</html>