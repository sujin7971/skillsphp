<style>
    .container{
        padding-top : 230px;
    }

    .jumbotron {
        box-shadow: 2px 2px 2px 2px rgba(0,0,0,0.43);
    }

    h1 > span {
        font-weight : bold;
    }
</style>

<?php require("db.php") ?>
<!DOCTYPE html>
<html lang="ko">

<?php require("head.php"); ?>

<body>
    <?php require("nav.php"); ?>

    <div class="container">
        <div class="row mt-4 d-flex justify-content-center">
            <div class="col-md-10 col-sm-12">
                <div class="jumbotron bg-white" >
                    <h1 class="display-4"><span>YY</span> 게시판</h1>
                    <p class="lead">양디고 게시판입니다. 아무나 말하시고 아무나 지우세요</p>
                    <hr class="my-4">
                    <p>뭐라 쓸 까요. 어서오세요~</p>
                    <a class="btn btn-outline-primary" href="/list.php" role="button">게시판 보기</a>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
<!-- 10.104.104.125:9090 -->