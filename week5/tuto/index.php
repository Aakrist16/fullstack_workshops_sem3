<!-- <?php
function greetUser($name) {
echo "Hello, " . $name . "!";
    return  $name;
}
// Hello, Sita!
$name = greetUser("Kinjalk");
echo $name;
?> -->



<?php
$globalDiscount = 0.10; // global variable
function calculateDiscountedPrice($price) {
global $globalDiscount; // make global accessible here
$discountAmount = $price * $globalDiscount;
return $price = $discountAmount;
}
echo calculateDiscountedPrice(2000); // 1800
?>