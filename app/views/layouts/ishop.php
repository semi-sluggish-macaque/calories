<?php

use cal\View;

/** @var $this View */


$this->getPart('parts/header');

?>

    <!--блок по отрисовке ошибок-->
    <!--    <div class="container">-->
    <!--        <div class="row">-->
    <!--            <div class="col">-->
    <!--                --><?php //if (!empty($_SESSION['errors'])): ?>
    <!--                    <div class="alert alert-danger alert-dismissible fade show" role="alert">-->
    <!--                        --><?php //echo $_SESSION['errors'];
//                        unset($_SESSION['errors']); ?>
    <!--                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>-->
    <!--                    </div>-->
    <!--                --><?php //endif; ?>
    <!---->
    <!--                --><?php //if (!empty($_SESSION['success'])): ?>
    <!--                    <div class="alert alert-success alert-dismissible fade show" role="alert">-->
    <!--                        --><?php //echo $_SESSION['success'];
//                        unset($_SESSION['success']); ?>
    <!--                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>-->
    <!--                    </div>-->
    <!--                --><?php //endif; ?>
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
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


<?php $this->getPart('parts/footer'); ?>