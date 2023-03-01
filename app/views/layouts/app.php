<?php

use cal\View;

/** @var $this View */


$this->getPart('parts/appheader');

?>

<?php if (!empty($_SESSION['errors'])): ?>
    <div class="alert-block">
        <p>
            <?php echo $_SESSION['errors'];
            unset($_SESSION['errors']); ?>
        </p>
        <button class="alert-block__close-btn">&times;</button>
    </div>
<?php endif; ?>

<?php if (!empty($_SESSION['success'])): ?>
    <div class="alert-block alert-block__success">
        <p>
            <?php echo $_SESSION['success'];
            unset($_SESSION['success']); ?>
        </p>
        <button class="alert-block__close-btn">&times;</button>
    </div>
<?php endif; ?>

    <!--блок по выводу видов-->
<?php
echo $this->content;
?>


<?php $this->getPart('parts/appfooter'); ?>