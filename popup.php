<?php 
 if ($msgSuccess) { ?>
    <div class="alert alert-success" role="alert">
        <?= $msgSuccess ?>
    </div>

<?php }
 if ( !empty($msgError)) {
    var_dump('Hello');
    ?>
<div class="alert alert-danger" role="alert">
    <?= $msgError ?>
</div>
<?php } ?>