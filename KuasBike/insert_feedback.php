<?php
    
    session_start();
    $se= $_SESSION['account'];


    $name=$_POST['name'];
    $email=$_POST['email'];
    $feed=$_POST['feed'];
    $points=$_POST['points'];
 

   require_once 'data.php';
    try{
          $conn=  open_db();
      
          $sql="INSERT INTO app_user_feedback (`account`, `name`, `email`, `feed`, `points`) VALUES (?,?,?,?,?)";
		 
            $stmt=$conn->prepare($sql);
			$result=$stmt->execute(array($se,$name,$email,$feed,$points));
                  
			  if($result<1)
			 {
                ini_set('display_errors','1');
                $body="失敗";
			  }
			else
			{
                $url = "http://fs.mis.kuas.edu.tw/~s1105137240/KuasBike/KuasBike_singin.html";
                
                $body=<<<EOT
                    <div style="border-width:7px;border-color:#FFFFFF;border-style:dotted;font-family:微軟正黑體;position:absolute;top:100px;left:400px;width:30%;height:200px;overflow:auto;background-color:#FF8800;" id="thx">
                    <center><p><h1 style="color:white;">感謝您寶貴的意見</h1></p>
                        <a href="#" class="ui-btn ui-btn-inline ui-corner-all" data-rel="back">返回</a></center>
                    </div>
EOT;
						
			}    
                    
         
          
   } catch (PDOException $e) {
        echo $e->getMessage();
    }
   
       
?>

<html>
    <head>
        <title>Save_Record_Page</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
    <?php echo $body ?>
    </body>
</html>