<?php

require_once('./config/config.php');
require_once('./helpers/alert_helper.php');

// import your Controllers here..
require_once('./controllers/MainController.php');

// create an instance for you Controller
$main = new MainController();

require_once('./router.php');


