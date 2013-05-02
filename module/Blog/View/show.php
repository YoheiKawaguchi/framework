<?php $this->includeLayout('Common', 'Header');?>

<div id="container">
    <h1><?php echo $pageTitle; ?></h1>

    <div class="date"><?php echo $post['id_blog']; ?></div>
    <div class="body">
        <?php echo $post['body']; ?>
    </div>
</div>

<?php $this->includeLayout('Common', 'Footer');?>
