<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>POSTED</title>
    </head>
    <body>
    <center>
    <h1>みんなの掲示板</h1>
        
        <?php
//4-1
$dsn = 'データベース名';
	$user = 'ユーザー名';
	$password = 'パスワード名';
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

//4-2
$sql ="CREATE TABLE IF NOT EXISTS tbtest"
."("
."id INT AUTO_INCREMENT PRIMARY KEY,"
."name char(32),"
."comment TEXT"
.");";
$stmt = $pdo->query($sql);

//echo "succeeded";
//4-3
$sql = 'SHOW TABLES';
$result =$pdo->query($sql);
foreach($result as $row){
    echo $row[0];
    echo '<br>';
}
echo "<hr>";

//echo "succeeded";

//4-4
$sql ='SHOW CREATE TABLE tbtest';
$result=$pdo -> query($sql);
foreach($result as $row){
    echo $row[1];
}

echo "<hr>";

//4-5
/*$sql=$pdo ->prepare("INSERT INTO tbtest (name, comment) VALUES (:name, :comment)");
$sql -> bindParam(':name',$name,PDO::PARAM_STR);
$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
$name='nakanobu';
$comment='succeed';
$sql->execute();

//*2
$sql=$pdo ->prepare("INSERT INTO tbtest (name, comment) VALUES (:name, :comment)");
$sql -> bindParam(':name',$name,PDO::PARAM_STR);
$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
$name='marisa';
$comment='you know alice always makes browny so well.';
$sql->execute();

//4-6
$sql ='SELECT*FROM tbtest';
$stmt=$pdo->query($sql);
$results=$stmt->fetchAll();
foreach($results as $row){
    echo $row['id'].',';
    echo $row['name'].',';
    echo $row['comment'].'<br>';

    echo"<hr>";

}
    //4-7
    $id=1;
    $name="reimu";
    $comment="Today is also good weather";
    $sql='update tbtest set name=:name,comment=:comment where id=:id';
    $stmt=$pdo->prepare($sql);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':comment',$comment,PDO::PARAM_STR);
    $stmt->bindParam(':id',$id,PDO::PARAM_INT);
    $stmt->execute();

    $sql ='SELECT*FROM tbtest';
$stmt=$pdo->query($sql);
$results=$stmt->fetchAll();
foreach($results as $row){
    echo $row['id'].',';
    echo $row['name'].',';
    echo $row['comment'].'<br>';

    echo"<hr>";
}

//4-8
$id=1;
$sql ='delete from tbtest where id=:id';
$stmt =$pdo->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();

$sql ='SELECT*FROM tbtest';
$stmt=$pdo->query($sql);
$results=$stmt->fetchAll();
foreach($results as $row){
    echo $row['id'].',';
    echo $row['name'].',';
    echo $row['comment'].'<br>';

    echo"<hr>";

}
*/

?>
        
        <?php
        
        $timestamp =time();
       $contents=@$_POST["contents"];
        $names=@$_POST["name"];
        $fixname="名前";
        $fixcomment="コメント";
        $fixnum="null";
         $putpass=@$_POST["putpass"];
 
        $psfile="psfile.txt";
    
        $filename = "mission_5-1.txt";

        //名前、コメント受信
        if(isset($_POST["name"],$_POST["contents"])){
        $names=$_POST["name"];
        $contents=$_POST["contents"];
        $time=date('Y')."年".date("m月d日 H:i:s");
        $hideno=$_POST["hiddenno"];
        $putpass=@$_POST["putpass"];
  
        if($names==''|| $contents==''||$putpass==''){
            echo "入力されていない箇所があります<br>";
        }else{
       // if($putpass=="edit"){
        if(file_exists($filename)){

            $countplus=(count(file($filename))+1);
      
            $countplus=1;

        }
       $newdata=$countplus."<>".$names."<>".$contents."<>".$time."<br>";
       $newtext=$countplus."<>".$names."<>".$contents."<>".$time."<>".$putpass."<>"."<br>";

        if($contents==''){
        echo '何も入力されていません<br />';

        }
 if($hideno=="null"){


    try{
        $pdo->beginTransaction();
        $sql = "INSERT INTO thread1(name, contents) VALUES(:_name, :_contents)";
        $stmh=$pdo->prepare($sql);
        $stmh->bindValue(":_name", $_POST["name"], PDO::PARAM_STR);
        $stmh->bindValue(":_contents", $_POST["contents"], PDO::PARAM_STR);

        $stmh->execute();

        $pdo->commit();



    }
    catch(PDOException $Exception){
      $pdo->rollBack;
      print "エラー".$Exception->getMessage();
        
   

/* ステートメントハンドラを取得 */
try{
  // トランザクション開始
  $pdo->beginTransaction();
  // SQL文を発行
  $sql = "SELECT * FROM thread1";
  // ステートメントハンドラを取得
  $stmh = $pdo->prepare($sql);
  // 実行
  $stmh->execute();
  // 書き込み件数を取得
  $count = $stmh->rowCount();
  // トランザクション終了
  $pdo->commit();

}catch(PDOException $Exception){
  print "エラー：".$Exception->getMessage();
}

/* 書き込み件数を表示 */
if($count == 0){
  // 書き込みがないとき
  print "書き込みがありません。<br>";
}else{
  // 書き込み件数を表示
  print "書き込み件数は".$count."件です。<br><br><br>";
}

/* 書き込みを表示する */
while($row = $stmh->fetch(PDO::FETCH_ASSOC)){


 print $row['number']; 
 print $row['name']; 
 print $row['time']; 
 print $row['content']; 
}



    /*$fp = fopen($filename ,"a");
        fwrite( $fp ,  $newdata."\r\n");
        fclose( $fp );

        $fp=fopen($psfile, "a");
        fwrite($fp, $newtext."\r\n");
        fclose($fp);
        */
    

       //編集機能
        }
          
           $fixfile=file("mission_5-1.txt");         
           
           $psfile=file("psfile.txt");
          $edipass=$_POST["putpass"];
       for ($g = 0; $g < count($psfile) ; $g++){ 

                    $psData = explode("<>", $psfile[$g]);

                    if ($psData[0] == $edipass) { 

                        $fp=fopen("mission_5-1.txt",'r+');
                        ftruncate($fp,0);
                        fseek($fp,0); 
                        fclose($fp);
 

                   
                     
            for ($j = 0; $j < count($fixfile) ; $j++){ 

                
                    $fixData = explode("<>", $fixfile[$j]);

                    if ($fixData[0] == $hideno) { //番号が同じか判別


                        $fp = fopen("mission_5-1.txt" ,"a");  
                        fwrite( $fp ,  $fixData[0]."<>".$names."<>".$contents."<>".$time."<br>");
                        fclose($fp);
                    
                     }
                     
                     /*else{ 

                        
                         $fp=fopen("mission_5-1.txt", "a");                 
                    fwrite( $fp ,  $fixfile[$j]."\r\n");
                    fclose( $fp );
                     }      
                     */           
                    } 
                }
        }

}
        

        }
    }

//削除
        if(isset($_POST["deletenumber"])){

           

           $delete=$_POST["deletenumber"];
            $delpass=$_POST["delpass"];

          
           $file=file("mission_5-1.txt");
           $psfile=file("psfile.txt");

            $pcnt=0;
            foreach($psfile as $value){
                $pfilecontent=explode('<>',$value);
                if($pfilecontent[4]==$delpass){
                    unset($psfile[$pcnt]);
                    file_put_contents('psfile.txt',$psfile);
         

            $cnt=0;
            foreach($file as $value){
                $filecontent=explode('<>',$value);
                if($filecontent[0]==$delete){
                    unset($file[$cnt]);
                    file_put_contents('mission_5-1.txt',$file);

                    
                   // print "削除しました<br>";
                    break;
                }
                $cnt++;
            }
            //print "削除しました<br>";
        
        }
         $pcnt++;
         }
               
            }
       

//編集機能

             if(isset($_POST["fixno"])){


          
          
                $fixno=$_POST["fixno"];
                $edipass=$_POST["edipass"];

               // if($edipass=="edit"){
                    
           $fixfile=file("mission_5-1.txt");

            for ($j = 0; $j < count($fixfile) ; $j++){ 

                    $fixData = explode("<>", $fixfile[$j]);



                    if ($fixData[0] == $fixno) { 

                        $fixnum=$fixData[0];
                        $fixname=$fixData[1];
                        $fixcomment=$fixData[2];
                       
                       
                    }
           


            
             }
          //  }else{
         //       echo "パスワードが正しくありません<br>";
            }
            


            //書き込み

             $ret_array=file_get_contents($filename);
             

       $ret_array=explode("<>", $ret_array);
       


            foreach($ret_array as $superword){
   
                
            echo $superword." ";
            }
    
        

        ?>

           
         <form method="POST" action="mission_5-1.php">
       
            <label for="name">名前</label>
       <input type="text" name="name" value="<?php echo $fixname;?>" />
       <label for="contents">コメント</label>
       <input type="text" name="contents" value="<?php echo $fixcomment;?>" />
     <input type="password" name="putpass" value="" />
       <input type="submit" value="送信" />
       <input type="hidden" name="hiddenno" value="<?php echo $fixnum;?>" />
        
        </form>

        <form action="mission_5-1.php" method="POST">

        削除対象番号<input type="text" name="deletenumber">
         <input type="password" name="delpass" value="" />
        <input type="submit" name="delete" value="削除">

        </form>

        <form action="mission_5-1.php" method="POST">

        編集番号指定<input type="text" name="fixno">
         <input type="password" name="edipass" value="" />
        <input type="submit" name="fix" value="編集">
    
        </form>

</center>
    </body>
</html>