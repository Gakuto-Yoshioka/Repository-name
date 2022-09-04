<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>mission_5-1</title>
  </head>
  
<?php
 $dsn = ʼデータベース名ʼ;
    $user =ʼユーザー名ʼ ;
    $password = ʼパスワードʼ;
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
   $sql = "CREATE TABLE IF NOT EXISTS tb52"
            ." ("
            . "id INT AUTO_INCREMENT PRIMARY KEY,"
            . "name TEXT,"
            . "str TEXT,"
            . "date DATETIME,"
            . "pass char(12)"
            .");";
            $stmt = $pdo->query($sql);

    
    //新規投稿
      if(empty($_POST["editNo"]) && !empty($_POST["name"]) && !empty($_POST["str"]) && !empty($_POST["pass"]) ){
                
                //insert文；データレコードの挿入
                $sql = $pdo -> prepare("INSERT INTO keijiban (name, str, date, pass) VALUES (:name, :str, now(), :pass)");
                $sql -> bindParam(':name', $name, PDO::PARAM_STR);
                $sql -> bindParam(':str', $str, PDO::PARAM_STR);
                $sql -> bindParam(':pass', $pass, PDO::PARAM_STR);
                
                $name = $_POST["name"];
                $str = $_POST["str"];
                $date = date("Y/m/d H:i:s");
                $pass = $_POST["pass"];
                
                $sql -> execute();
      }
      
      if( !empty($_POST["name"]) && !empty($_POST["str"]) && !empty($_POST["pass"])&&!empty($_POST["editnum"])){
           $editnum = $_POST["editnum"];
            $id = $editnum; 
                 $name = $_POST["name"];
                 $str = $_POST["str"]; 
                 $date = date("Y/m/d H:i:s");
                 $sql = 'UPDATE tb52 SET name=:name, str=:str, date=:date, pass=:pass WHERE id=:id';
                 $stmt = $pdo->prepare($sql);
                 $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                 $stmt->bindParam(':str', $str, PDO::PARAM_STR);
                 $stmt->bindParam(':date', $date, PDO::PARAM_STR);
                 $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
                 $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                 $stmt->execute();
      }
        if(!empty($_POST["editnum"]) && !empty($_POST["editpass"]) ){
              
                 $editnum = $_POST["editnum"];
                 $editpass = $_POST["editpass"];
                 
                 $id = $editnum;
                 $sql = "SELECT * FROM tb52 WHERE id=:id AND pass=:pass";
                 $stmt = $pdo->prepare($sql);
                 $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                 $stmt->bindParam(':pass', $editpass, PDO::PARAM_STR);
                 $stmt->execute();
                 $results = $stmt->fetchAll();
                 foreach ($results as $row){
                     
                     $editname = $row["name"];
                     $editstr = $row["str"];
                 }
        }
        
        if( !empty($_POST["delnum"]) && !empty($_POST["delpass"]) ){
                 $delnum = $_POST["delnum"];
                 $delpass = $_POST["delpass"];
                 
                 $id = $delnum;
                 $sql = "delete from tb52 where id=:id AND pass=:pass";
                 $stmt = $pdo->prepare($sql);
                 $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                 $stmt->bindParam(':pass', $delpass, PDO::PARAM_STR);
                 $stmt->execute();
                 
             }
             ?>
             
              <form action="" method="post">
      <input type="text" name="name" placeholder="名前" value="<?php if(isset($editname)) {echo $editname;} ?>"><br>
      <input type="text" name="str" placeholder="コメント" value="<?php if(isset($editstr)) {echo $editstr;} ?>"><br>
       <input type="password" name="pass" placeholder="パスワード">
      <input type="hidden" name="editnum" value="<?php if(isset($editnum)) {echo $editnum;} ?>">
      <input type="submit" name="submit">
    </form>

    <form action="" method="post">
      <input type="text" name="delnum" placeholder="削除対象番号">
       <input type="password" name="delpass" placeholder="パスワード">
      <input type="submit"  value="削除">
    </form>

    <form action="" method="post">
      <input type="text" name="editnum" placeholder="編集対象番号">
       <input type="password" name="editpass" placeholder="パスワード">
      <input type="submit" value="編集">
    </form>
    
    <?php
            
             //表示機能
              $sql = 'SELECT * FROM tb52';
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();
            foreach ($results as $row){
                
                echo $row['id'].',';
                echo $row['name'].',';
                echo $row['str'].',';
                echo $row['date'].'<br>';
                echo "<hr>";
            }
         ?>        
              </body>
      </html>
      