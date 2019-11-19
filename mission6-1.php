<!DOCTYPE html>
<html lang = "ja">
  <head>
    <meta charset = "UTF-8">
    <title>投稿フォーム編集・削除機能付き</title>
    <style>
      form{
	margin-bottom: 20px;
      }
    </style>
  </head>
  <body>
<?php
$dsn = 'データベース名'; //データベース
$user = 'ユーザー名';  //ユーザ名
$password = 'パスワード';  //パスワード
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

 
      //投稿機能

if(!empty($_POST["name"]) && !empty($_POST["comment"]) && empty($_POST["ID"]) && $_POST["pass1"] == 'pass'){
	$name = $_POST["name"];
      	$comment = $_POST["comment"];
      	$time = date("Y-m-d H:i:s");
      
      	$sql = $pdo -> prepare("INSERT INTO mission5 (name, comment, time) VALUES (:name, :comment, :time)");
      	$sql -> bindParam(':name', $name, PDO::PARAM_STR);
      	$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
      	$sql -> bindParam(':time', $time, PDO::PARAM_STR);
	$sql->execute();

      	$sql = 'SELECT * FROM mission5';
      	$stmt = $pdo->query($sql);
      	$results = $stmt->fetchAll();
      	foreach ($results as $row){
	//$rowの中にはテーブルのカラム名が入る
	echo $row['id'].',';
	echo $row['name'].',';
	echo $row['comment'].',';
	echo $row['time'].'<br>';
	echo "<hr>";
      	} 
}
elseif(!empty($_POST["dnum"]) && !empty($_POST["pass2"]) && $_POST["pass2"] == 'pass'){
	$delete = $_POST["dnum"];
	$id = $delete;
	$sql = 'delete from mission5 where id=:id';
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
	$stmt->execute();

	$sql = 'SELECT * FROM mission5';
      	$stmt = $pdo->query($sql);
      	$results = $stmt->fetchAll();
      	foreach ($results as $row){
	//$rowの中にはテーブルのカラム名が入る
	echo $row['id'].',';
	echo $row['name'].',';
	echo $row['comment'].',';
	echo $row['time'].'<br>';
	echo "<hr>";
      	} 
}
elseif(!empty($_POST["edit"]) && !empty($_POST["pass3"]) && $_POST["pass3"] = 'pass'){
	$sql = 'SELECT * FROM mission5';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
	foreach ($results as $row){
		if($_POST["edit"] == $row['id']){
			$ID = $_POST["edit"];
			$name = $row['name'];
			$comment = $row['comment'];
		}
	}
}
elseif(!empty($_POST["name"]) && !empty($_POST["comment"]) && !empty($_POST["ID"])){
	$id = $_POST["ID"];
	$name = $_POST["name"];
	$comment = $_POST["comment"];
	$time = date("Y-m-d H:i:s");

	$sql = 'update mission5 set name=:name, comment=:comment, time=:time where id=:id';
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':name', $name, PDO::PARAM_STR);
	$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
	$stmt -> bindParam(':time', $time, PDO::PARAM_STR);
	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
	$stmt->execute();
	$sql = 'SELECT * FROM mission5';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
	foreach ($results as $row){
	//$rowの中にはテーブルのカラム名が入る
	echo $row['id'].',';
	echo $row['name'].',';
	echo $row['comment'].',';
	echo $row['time'].'<br>';
	}
}
?>

  <form action = "mission_5-1.php" method = "post">
    <h3>【投稿フォーム】</h3>
    名前：　　　　
    <input type = "text" name = "name" placeholder = "名前" value = "<?php if(isset($name)) {echo $name;} ?>"><br>
    コメント：　　
    <input type = "text" name = "comment" placeholder = "コメント" value = "<?php if(isset($comment)) {echo $comment;} ?>"><br>
    <input type = "hidden" name = "ID" value = "<?php if(isset($ID)) {echo $ID;} ?>">
    パスワード：　
    <input type = "password" name = "pass1" placeholder = "パスワード">
    <input type= "submit" name = "submit" value = "送信">
  </form>

  <form action = "mission_5-1.php" method = "post"> 
    <h3>【削除フォーム】</h3>
    編集対象番号:
    <input type = "text" name = "dnum" placeholder = "削除対象番号"><br>
    パスワード:　
    <input type = "password" name = "pass2" placeholder = "パスワード">
    <input type = "submit" name = "delete" value = "削除">
 
  </form>

  <form action = "mission_5-1.php" method = "post">
    <h3>【編集フォーム】</h3>
    編集対象番号:
    <input type = "text" name = "edit" placeholder = "編集対象番号"><br>
    パスワード:
    <input type = "password" name = "pass3" placeholder = "パスワード">
    <input type = "submit" value = "編集">
  </form>
  </body>
</html>
