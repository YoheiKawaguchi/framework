<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="/css/default.css" />
<head>
<title><?php echo $pageTitle; ?></title>
</head>
<body>

<div id="header">Simple PHP Framework</div>

<!-- Display flash messages if there are any -->
<?php if($flashMessage):?>
    <div id="flashMessage">
    <?php foreach($flashMessage as $key => $messages):?>
        <ul class="flash-<?php echo $key;?>">
        <?php foreach($messages as $message):?>
            <li><?php echo $message;?></li>
        <?php endforeach;?>
        </ul>
    <?php endforeach;?>
    </div>
<?php endif;?>
<!-- /Display flash messages if there are any -->
