<?php

if(!isset($_SESSION)){
    session_start();
} // altijd hiermee starten als je gebruik wilt maken van sessiegegevens


$cart = getCart();
$totalPriceRow = 0;

function getCart()
{
    if (isset($_SESSION['cart'])) {
        $cart = $_SESSION['cart'];
    } else {
        $cart = array();
    }
    return $cart;
}

function saveCart($cart)
{
    $_SESSION["cart"] = $cart;
}

function addProductToCart($stockItemID)
{
    $cart = getCart();

    if (array_key_exists($stockItemID, $cart)) {
        $cart[$stockItemID]['quantity'] += 1;
    } else {
        $cart[$stockItemID] = array('quantity' => 1);
    }

    saveCart($cart);
}

if (isset($_POST['minus'])) {
    if ($cart[$_POST['id']]['quantity'] <= 1) {
        unset($cart[$_POST['id']]);
    } else {
        $cart[$_POST['id']]['quantity'] = $cart[$_POST['id']]['quantity'] - 1;
    }

    saveCart($cart);
}

if (isset($_POST['delete'])) {
    unset($cart[$_POST['id']]);
    saveCart($cart);
}
if (isset($_POST['plus'])) {

    $cart[$_POST['id']]['quantity'] = $cart[$_POST['id']]['quantity'] + 1;

    saveCart($cart);

}

?>