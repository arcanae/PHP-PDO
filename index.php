<?php

try {
$db = new PDO('mysql:host=localhost;dbname=music','kiwi','banane');

        echo 'Groups :<br>';
        $sql = 'SELECT * FROM `group`'; 
        
        $req = $db->query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error()); 
        while($data = $req->fetch()) 
        { 
            echo '<b>'.$data['name'].'</b>('.$data['start'].')'; 
            echo ' <i>origine : '.$data['origin'].'</i><br>'; 
        } 

        echo '<br>Members :<br>';

        $sql = 'SELECT member.name,member.role,member.birth,group.name as groupname  FROM member, `group` WHERE group.id = member.group_id'; 

        $req = $db->query($sql); 
        while($data = $req->fetch()) 
        { 
            echo '<b>'.$data['name'].'</b>('.$data['role'].')'; 
            echo ' <i>Naissance : '.$data['birth'].'</i> - '; 
            echo 'Appartient au groupe : <b>'.$data['groupname'].'</b><br>';
        } 
        
        echo '<br>Albums : <br>';

        $sql = 'SELECT * FROM album GROUP BY album.name'; 

        $req = $db->query($sql); 
        while($data = $req->fetch()) 
        { 
            echo '<b>'.$data['name'].'</b>('.$data['date'].')'; 
            echo ' <i>Genre : '.$data['genre'].'</i> - '; 
            echo 'Produit par : <b>'.$data['label'].'</b> - Participants : ';
            albumMember($data['name'], $db);
            echo '<br>';
        } 
        

} catch (PDOException $exception) {
    echo $exception->getMessage();
}

function albumMember($name, $db) {
    $sql = 'SELECT member.name FROM album, member, album_member WHERE album.name =\''.$name.'\' AND album_member.member_id = member.id AND album_member.album_id = album.id; '; 
        $req = $db->query($sql); 
        $i=0;
        while($data = $req->fetch()){
        if( $i == 1){
            echo ', <b>'.$data['name'].'</b>';
        }else{
            echo '<b>'.$data['name'].'</b>';
            $i++;
        }
    }
    echo '.';
}
