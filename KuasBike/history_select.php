<?php
    
    session_start();
    $se= $_SESSION['account'];



   
   
 

   require_once 'data.php';
    try{
          $conn=  open_db();
         
        
        $sql="SELECT*FROM app_user_history WHERE account=?";
        $stmt=$conn->prepare($sql);
        $result=$stmt->execute(array($se));
        $msg="<center><table border='1' width='250' height='100' style='text-align:center'><tr><th bgcolor='orange'><font color='white'>日期與時間</font></th><th bgcolor='orange'><font color='white'>總金額</font></th></tr>";
        
        foreach($stmt->fetchAll() as $row){
            $msg.="<tr><td>".$row['date']."</td><td>$".$row['money']."</td></tr>";
            //$msg.="日期：".$row['date']."金額：".$row['money']."<br/>";
        }
        $msg.="</table></center>";
          

        $sql="SELECT*FROM app_user WHERE account=?";
        $stmt=$conn->prepare($sql);
        $result=$stmt->execute(array($se));
        $name="";
        foreach($stmt->fetchAll() as $row){
            if($row['account']==$se){
                $name=$row['name'];
            }else{
                $name="錯誤";
            }
        }  
         
          
   } catch (PDOException $e) {
        echo $e->getMessage();
    }
   
       
?>

<html>
    <head>
        <title>Show_History_Page</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <center><h2 style="color:orange">親愛的 <?php echo $name?> 您好<br/>
        以下為您使用此APP的歷程記錄</h2></center>
        <?php echo $msg; ?>
        <center><a href="http://fs.mis.kuas.edu.tw/~s1105137240/KuasBike/KuasBike_singin.html" class="ui-btn ui-btn-inline ui-corner-all" style="color:white;background-color:#FF8800;border-style:none;box-shadow:none;">回到上一頁</a></center>
    </body>
</html>