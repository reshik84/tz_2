<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
include_once 'db.php';
if ($_SERVER['REQUEST_URI'] != '/'){
    $sql = $pdo->prepare('SELECT * FROM urls WHERE short=?');
    $sql->execute([substr($_SERVER['REQUEST_URI'], 1)]);
    $url = $sql->fetch();
    if(!empty($url)) {
        header('Location: ' . $url['url']);
        exit;
    }
}

function generateRandomString($length = 6) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


    if(!empty($_POST)){
        $url = $_POST['url'];
        $hash = generateRandomString();
        $sql = $pdo->prepare("INSERT INTO `urls` (`url`, `short`) VALUES (?, ?)");
        $sql->execute([$url, $hash]);

        $protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']), 'https') === FALSE ? 'http' : 'https';

        $url = $protocol . '://' . $_SERVER['HTTP_HOST'] . '/' . $hash;
    }

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Тест - короткие ссылки</title>
    </head>
    <body>
        <div class="wrap">
            <form action="" method="post">
                <label>Ссылка</label>
                <input type="text" name="url" />
                <br>
                <input type="submit" value="получить ссылку">
            </form>
        </div>
    <?php
        if (isset($url)):
    ?>
        <a href="<?php echo $url ?>"><?php echo $url ?></a>
    <?php endif; ?>
    </body>
</html>