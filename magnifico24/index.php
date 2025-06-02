<?php
session_start();

require './src/servises/connect.php';
require './src/utils/Router.php';
require './src/controller/Auth.php';
require './src/controller/Catalog.php';
require './src/controller/Product.php';
require './src/controller/Adm.php';
require './src/controller/Basket.php';
require './src/controller/getTitle.php';
require './src/controller/Usl.php';
require './src/controller/Profile.php';
require './src/controller/Constr.php';

require './src/router/route.php';






