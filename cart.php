<?php
include __DIR__ . "/header.php";
include "cartfuncties.php";

if (!empty($cart)) {
    $ids = array_keys($cart);
    $where = 'WHERE SI.StockItemID IN (' . implode(',', $ids) . ')';

    $Query = "
        SELECT SI.StockItemID, SI.StockItemName, SI.MarketingComments, TaxRate, RecommendedRetailPrice, ROUND(TaxRate * RecommendedRetailPrice / 100 + RecommendedRetailPrice,2) as SellPrice,
        QuantityOnHand,
        (SELECT ImagePath FROM stockitemimages WHERE StockItemID = SI.StockItemID LIMIT 1) as ImagePath,
        (SELECT ImagePath FROM stockgroups JOIN stockitemstockgroups USING(StockGroupID) WHERE StockItemID = SI.StockItemID LIMIT 1) as BackupImagePath
        FROM stockitems SI
        JOIN stockitemholdings SIH USING(stockitemid)
        $where";

    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_execute($Statement);
    $ReturnableResult = mysqli_stmt_get_result($Statement);
    $ReturnableResult = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC);
}

$totalPriceOfCart = 0; // Houd de totale prijs van de winkelwagen bij

if (!empty($ReturnableResult)) {
    ?>
    <div class="container">
        <h1>Inhoud Winkelwagen</h1>

        <div class="row">
            <div class="col-12">
                <?php
                foreach ($ReturnableResult as $row) {
                    $totalPriceForRow = $row["SellPrice"] * $cart[$row["StockItemID"]]['quantity'];
                    $totalPriceOfCart += $totalPriceForRow; // Voeg de totaalprijs van dit item toe aan de totale winkelwagenprijs
                    ?>
                    <div id="ProductFrame">
                        <?php if (isset($row['ImagePath'])) { ?>
                            <div class="ImgFrame"
                                 style="background-image: url('<?php print "Public/StockItemIMG/" . $row['ImagePath']; ?>'); background-size: 230px; background-repeat: no-repeat; background-position: center;"></div>
                        <?php } elseif (isset($row['BackupImagePath'])) { ?>
                            <div class="ImgFrame"
                                 style="background-image: url('<?php print "Public/StockGroupIMG/" . $row['BackupImagePath'] ?>'); background-size: cover;"></div>
                        <?php } ?>

                        <div id="StockItemFrameRight">
                            <div class="row">
                                <div class="col-8">
                                    <h1 class="StockItemID">Artikelnummer: <?php print $row["StockItemID"]; ?></h1>
                                    <a class="ListItem" href='view.php?id=<?php print $row['StockItemID']; ?>'>
                                        <p class="StockItemName"><?php print $row["StockItemName"]; ?></p>
                                    </a>
                                </div>
                                <div class="col-4">
                                    <h2 class="StockItemPriceSingle"><?= sprintf(" %0.2f", $row["SellPrice"]) ?></h2>
                                    <p class="StockItemID">Aantal: <?php echo $cart[$row["StockItemID"]]['quantity']; ?></p>
                                    <p class="StockItemID">Totaal prijs: <?= sprintf(" %0.2f", $totalPriceForRow) ?></p>
                                    <!-- Voeg hier de formulieren toe voor aanpassen hoeveelheid, verwijderen, etc. -->
                                    <form method="post" action="Cart.php" class="action-form">
                                        <input type="hidden" name="delete" value="true" />
                                        <input type="hidden" name="id" value="<?= $row['StockItemID'] ?>" />
                                        <button type="submit" class="btn btn-danger">
                                            verwijderen
                                        </button>
                                    </form>
                                    <form method="post" action="Cart.php" class="action-form">
                                        <input type="hidden" name="minus" value="true" />
                                        <input type="hidden" name="id" value="<?= $row['StockItemID'] ?>" />
                                        <button type="submit" class="btn btn-primary">
                                            -
                                        </button>
                                    </form>
                                    <form method="post" action="Cart.php" class="action-form">
                                        <input type="hidden" name="plus" value="true" />
                                        <input type="hidden" name="id" value="<?= $row['StockItemID'] ?>" />
                                        <button type="submit" class="btn btn-success">
                                            +
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <p> Totaalprijs van de winkelwagen: <?= sprintf(" %0.2f", $totalPriceOfCart) ?></p>
            </div>
        </div>
    </div>
    <?php
}
?>
</body>
<script src="/public/js/cart.js"></script>
</html>
<p><a href='categories.php'>Verder winkelen!</a></p>
