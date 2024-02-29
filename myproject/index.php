<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Circle of Squares</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="header">
        <img src="pinkbanner.png" alt="Descriptive Alt Text">
    </div>

    <?php
    $colors = ["Pink", "Blue", "Lime", "Orange", "Red", "Black", "White"];
    $colorCounts = [];
    $colorImages = [
        "Pink" => "Pink.png",
        "Blue" => "blue.png",
        "Lime" => "lime.png",
        "Orange" => "orange.png",
        "Red" => "red.png",
        "Black" => "black.png",
        "White" => "white.png"
    ];

    foreach ($colors as $color) {
        $files = glob("wallet/*$color*.png");
        $colorCounts[$color] = count($files);
    }
    ?>


<div class="circle-container">
  <?php for ($i = 1; $i <= 42; $i++): ?>
    <div class="square-container dropdown" data-chain-square="<?= $i ?>" data-current-color="">
      <div class="square dropdown-toggle" id="dropdownMenu<?= $i ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="square-number"><?= $i ?></span>
        <img src="trans.png" alt="" class="square-image">
      </div>
       <div class="dropdown-menu" aria-labelledby="dropdownMenu<?php echo $i; ?>">
    <a class="dropdown-item" href="#" data-color="#FFC0CB" data-image="Pink.png" data-color-name="Pink">Pink</a>
    <a class="dropdown-item" href="#" data-color="#0000FF" data-image="Blue.png" data-color-name="Blue">Blue</a>
    <a class="dropdown-item" href="#" data-color="#00FF00" data-image="Lime.png" data-color-name="Lime">Lime</a>
    <a class="dropdown-item" href="#" data-color="#FFA500" data-image="Orange.png" data-color-name="Orange">Orange</a>
    <a class="dropdown-item" href="#" data-color="#FF0000" data-image="Red.png" data-color-name="Red">Red</a>
    <a class="dropdown-item" href="#" data-color="#000000" data-image="Black.png" data-color-name="Black">Black</a>
    <a class="dropdown-item" href="#" data-color="#FFFFFF" data-image="White.png" data-color-name="White">White</a>
</div>
    </div>
  <?php endfor; ?>

 <!-- Inventory container -->
 <div class="inventory-container">
        <?php foreach ($colorCounts as $color => $count): ?>
            <div class="square-container inventory" data-color="<?= $color ?>">
                <div class="square">
                    <span class="remaining-text"><?= $count ?></span>
                    <img src="<?= $colorImages[$color] ?>" alt="<?= $color ?>" class="square-image">
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Remaining count container -->
    <div class="remaining-count-container">
        <?php foreach ($colorCounts as $color => $count): ?>
            <div class="square-container remaining-count" data-color="<?= $color ?>">
                <div class="remaining-count-square">
                    <span class="count-text">Total: <?= $count ?></span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function(){
    var colorUsage = {
        Pink: 0,
        Blue: 0,
        Lime: 0,
        Orange: 0,
        Red: 0,
        Black: 0,
        White: 0
    };

    function updateRemainingCounts() {
        $('.inventory').each(function() {
            var color = $(this).data('color');
            var totalCount = <?php echo json_encode($colorCounts); ?>[color];
            var usedCount = colorUsage[color];
            var remainingCount = totalCount - usedCount;
            $(this).find('.count-text').text("Total: " + totalCount);
        $(this).find('.remaining-text').text(remainingCount);

            // Disable or hide the dropdown item if the remaining count is 0
            if (remainingCount <= 0) {
                $('.dropdown-item[data-color-name="' + color + '"]').addClass('disabled').attr('aria-disabled', 'true');
            } else {
                $('.dropdown-item[data-color-name="' + color + '"]').removeClass('disabled').attr('aria-disabled', 'false');
            }
        });
    }

    updateRemainingCounts();

    $('.dropdown-item').click(function(e){
        e.preventDefault();
        var selectedColorName = $(this).data('color-name');
        var imagePath = $(this).data('image');
        var colorHex = $(this).data('color');
        var dropdownContainer = $(this).closest('.dropdown');
        var currentColor = dropdownContainer.data('current-color');

        if (currentColor !== "") {
            colorUsage[currentColor]--;
        }
        colorUsage[selectedColorName]++;
        dropdownContainer.data('current-color', selectedColorName);
        dropdownContainer.find('.square-image').attr('src', imagePath);
        dropdownContainer.find('.square').css('background-color', colorHex);

        updateRemainingCounts();
    });

    updateRemainingCounts();
});
</script>
</body>
</html>
