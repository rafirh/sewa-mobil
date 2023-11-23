<?php
require_once './helper/helpers.php';

redirectIfAuthenticated();
redirectIfNotAuthenticated('./login.php');
