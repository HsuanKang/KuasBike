<?php
   $name=$_POST['name'];
   $account=$_POST['account'];
   $password=$_POST['password'];
   $password2=$_POST['password2'];
   $birth=$_POST['birth'];
   $gamil=$_POST['gamil'];
  
   require_once 'data.php';
    try{
          $conn=  open_db();
          $sql="INSERT INTO app_user (account,password,name,birth,gamil) VALUES (?,?,?,?,?)";
		   if($password!=$password2)
         {
             $msg="密碼確認有誤";
          }
        else
        {
            $stmt=$conn->prepare($sql);
			$result=$stmt->execute(array("$account","$password","$name"," $birth"," $gamil"));
                  
			  if($result<1)
			 {
				 $msg="註冊失敗！非常抱歉，請再重新試一次";
			  }
			else
			{
				$msg="註冊成功！現在可以開始使用APP記錄你的運動生活囉～";
						
			}    
                    
        }    
          
   } catch (PDOException $e) {
        echo $e->getMessage();
    }
   
       
?>

<html>
    <head>
        <title>Member_Check_Page</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
       <?php
        echo $msg;
       ?>
    </body>
</html>