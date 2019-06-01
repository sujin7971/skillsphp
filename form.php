<?php
//숙제 안해온 사람 : 재성 X 2, 나영 X 1, 다민 X 2
    require ("db.php");

    if(!isset($_SESSION['user'])){
        $_SESSION['nextPage'] = "form.php";
        msgAndGo("글을 쓰기 위해서는 로그인을 해야합니다.", "/login.php");
        exit;
    }

    $mod = 0; // 글 작성모드
    if(isset($_GET['id'])){
        //글 수정 모드
        $mod = $_GET['id'];
        $sql = "SELECT * FROM boards WHERE id = ?";
        $q = $con->prepare($sql);
        $q->execute([ $_GET['id'] ]);
        $data = $q->fetch(PDO::FETCH_OBJ);

        if(!$data){
            echo "존재하지 않는 글입니다.";
            exit;
        }

        if($data->writer != $_SESSION['user']->email){
            msgAndBack("권한이 없습니다.");
            exit;
        }
    }
?>
<!DOCTYPE html>
<html lang="ko">
    
<?php require("head.php"); ?>

<body>
    <?php require("nav.php"); ?>
    
    <?php if ($mod == 0) : ?>
        <h1>글쓰기</h1>
    <?php else : ?>
        <h1>글 수정</h1>
    <?php endif ?>

    <form action="/process.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $mod ?>">
        제목 :
        <input type="text" name="title" 
                value="<?= $mod != 0 ? $data->title : "" ?>" >
        <br>
        글쓴이 : <input type="text" name="writer" value="<?= $mod != 0 ? $data->writer : $_SESSION['user']->email ?>" readonly><br>
        내용 : <br>
        <textarea name="content" cols="30" rows="10"><?= $mod != 0 ? $data->content : "" ?></textarea>
        <br>
        <input type="file" name="upload"> <br>
        <input type="submit" value="전송">
    </form>
</body>
</html>