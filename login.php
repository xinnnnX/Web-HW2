<?php
//檢查有沒有來自index.php帳密的POST
if (!isset($_POST["Account"]) || !isset($_POST["Password"])) {
    echo "<h1>你沒有成功利用POST傳資料過來</h1>";
    echo "<p>你的表單裡面沒有設定好相關變數</p>";
    echo "<a href='index.php'>回到登入首頁！</a>";
    
    exit;
}

session_start();

$Account = $_POST["Account"]; //使用者帳號
$Password = $_POST["Password"]; //密碼
$CheckWord = strtolower($_POST["Checkword"]); //驗證碼，想想看，???處應該補上甚麼原始碼？
$RemeberMe = "";

if (isset($_POST["RemeberMe"])) //取得是不是有勾選「記住我」，建議要先確定有傳過來POST再記錄
    $RemeberMe = $_POST["RemeberMe"]; 

if ($Account == "abc" && $Password == "123" && $CheckWord == $_SESSION['code']){ //想想看，???處應該補上甚麼原始碼？
    
    $date = "";
    
    if ($RemeberMe == "YesRememberMe")
        $date = strtotime("+10 days", time()); //如果有勾選「記住我」，設定一個十天後的日期
    else
        $date = strtotime("+1 minutes", time()); //如果沒有勾選「記住我」，設定一個1分鐘後的日期，也就是說你將Cookie設定1分鐘後過期    

    //建立一個名稱叫"LoginOK"的Cookie裡面，並且我們賦值為OK
    setcookie("LoginOK", "OK", $date); // 新增Cookie，???處應該補上甚麼原始碼？
    
    echo "<h1>你已成功登入系統</h1>";
    echo "<p>你的帳號是：" . $Account . "<p>";
    echo "<p>你的密碼是：" . $Password . "<p>";
    echo "<p>你輸入的驗證碼是：" . $CheckWord . "<p>";
    echo "<p>5秒後頁面將自動跳轉到會員專屬頁面！</p>";
    
    header("refresh:5; url=vip.php");
}else{
    echo "<p>你輸入的驗證碼是：" . $CheckWord . "<p>";
    echo "<p>驗證碼是：" . $_SESSION['code'] . "<p>";
    echo "<h1>帳號、密碼或驗證碼輸入錯誤</h1>";
    echo "<p>5秒後頁面將自動跳轉到登入首頁！或者你也可以<a href='index.php'>回到登入首頁！</a></p>";

    header("refresh:5; url=index.php");
}
