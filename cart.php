<?php
include "cartfuncties.php";
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Winkelwagen</title>
</head>
<body>
<h1>Inhoud Winkelwagen</h1>

<?php
$cart = getCart();


//gegevens per artikelen in $cart (naam, prijs, etc.) uit database halen
$prijsartikel = 2.50;
foreach($cart as $cart_ding => $gegevens){
    print($cart_ding . " ". $gegevens. "<br>");
}
//totaal prijs berekenen
//$prijstotaal = $gegevens*$prijsartikel;
//print($prijstotaal);

//mooi weergeven in html
//etc.

?>
<p><a href='view.php?id=0'>Naar artikelpagina van artikel 0</a></p>
</body>
</html>


