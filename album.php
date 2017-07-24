<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <?php
        $db = new PDO('mysql:host=localhost;dbname=music','kiwi','banane');

        $req = $db->prepare('SELECT name FROM member WHERE id=:id'); 
        $req->bindValue('id',$_GET['id']);
        $req->execute();
        $data = $req->fetch();

        echo $data['name'];
        echo '<br><br>Ses Albums: <br>';

        $req = $db->prepare('SELECT album.name FROM member, album, album_member WHERE member.id = :id AND member.id = album_member.member_id AND album.id = album_member.album_id');
        $req->bindValue('id', $_GET['id']);
        $req->execute();
        $data = $req->fetch();
        if ($data != false) {
            echo $data['name'].'<br>';            
            while($data = $req->fetch()){
                echo $data['name'].'<br>';
            }
        } else {
            echo 'Cet artiste n\'a pas d\'albums enregistrés'; 
        }
    ?>
</body>
</html>