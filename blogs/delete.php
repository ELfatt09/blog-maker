<?php
session_start();
require 'controller.php';
$blogId = $_GET['id'];
delete($blogId);