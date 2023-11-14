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
$prijs_artikel = 2.5;
$prijs_totaal =0;
$patatje = 0;

//totaal prijs berekenen
foreach($cart as $artikelnummer => $artikel_counter){
    $prijs_totaal += $artikel_counter * $prijs_artikel;
    print($artikelnummer . " " . $artikel_counter . "<br>");
}

print($prijs_totaal);
//etc.

?>
<p><a href='view.php?id=0'>Naar artikelpagina van artikel 0</a></p>
</body>
</html>