<?php
$hashedPassword = password_hash($enteredPassword, PASSWORD_DEFAULT);
 
 
// Lấy từ database
$storedHashPassword = '$2y$10$89uX3LBy4mlU/DcBveQ1l.32nSianDP/E1MfUh.Z.6B4Z0ql3y7PK';
 
echo $storedHashPassword;
 
echo "<br>";
 
 
if(password_verify($enteredPassword, $storedHashPassword)){
    echo "Login thành công";
}else{
    echo "Truy cập trái phép";
}
?>