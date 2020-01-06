<?php
    
    session_start();
    $se= $_SESSION['account'];



   
   $money=$_POST['insert_money'];
 

   require_once 'data.php';
    try{
          $conn=  open_db();
      
          $sql="INSERT INTO app_user_history (`account`, `money`) VALUES (?,?)";
		 
            $stmt=$conn->prepare($sql);
			$result=$stmt->execute(array($se,$money));
                  
			  if($result<1)
			 {
               
                 
			  }
			else
			{
                $url = "http://fs.mis.kuas.edu.tw/~s1105137240/KuasBike/KuasBike_singin.html";
                
                $body=<<<EOT
                    
                <iframe src="$url" frameborder="0"  width="1400" height="700"></iframe>
                    
                    
                 
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