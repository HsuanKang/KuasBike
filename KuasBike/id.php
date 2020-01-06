<?php


    require_once 'data.php';
    
    $account = $_POST['account'];
    $password = $_POST['password'];
    
    $conn = open_db();

    // SQL
    $sql = "SELECT * FROM app_user WHERE account=:account && password=:password";
    
    // 準備執行 SQL
    $stmt = $conn->prepare($sql);

    // 替換變數
    $stmt->bindValue(':account', $account);
    $stmt->bindValue(':password', $password);
    
    // 實際執行
    $stmt->execute();
    
    // 取得結果筆數
    $result = $stmt->rowCount();
    session_start();
    $_SESSION['account']=$account;
	
    // 如果不等於 1 => 登入失敗
    if ($result != 1) {
        
        $url = "http://fs.mis.kuas.edu.tw/~s1105137240/KuasBike/KuasBike.html";
        $body=<<<EOT
            
        登入失敗
        <a href="http://fs.mis.kuas.edu.tw/~s1105137240/KuasBike/KuasBike.html" class="ui-btn ui-btn-inline ui-corner-all" style="color:white;background-color:#FF8800;border-style:none;box-shadow:none;">重新登入</a>
         
EOT;
 
		
    } else {
        //$msg= 'aaa';
        //$msg= '<a href="http://fs.mis.kuas.edu.tw/~s1105137210/groupapp/KuasBike.html">XCSD</a>';
		
        $url = "http://fs.mis.kuas.edu.tw/~s1105137240/KuasBike/KuasBike_singin.html";
        $body=<<<EOT
            
        <input type="button" value="確定登入" data-inline="true" onclick="location.href='http://fs.mis.kuas.edu.tw/~s1105137240/KuasBike/KuasBike_singin.html'"> 
            
            
         
EOT;
		//header("Location:http://localhost/app/KuasBike_singin.html");
		//exit;
		//<iframe src=" $url" frameborder="0"  width="1400" height="700"></iframe>
    }



?>
<html>
    <head>
        <title>Member_FrontPage</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		
    </head>
    <body>
		
        <?php echo $body ?>
     
    </body>
</html>