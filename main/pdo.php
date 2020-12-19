<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=library_management', 'rahul', 'pass');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);