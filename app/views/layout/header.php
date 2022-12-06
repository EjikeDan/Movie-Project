<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Movie Hunter</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
<link rel="stylesheet" href="<?=URL?>/assets/css/style.css" type="text/css" media="all" />
<link rel="stylesheet" href="<?=URL?>/assets/css/bootstrap.min.css" type="text/css" />
<script type="text/javascript" src="<?=URL?>/assets/js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="<?=URL?>/assets/js/jquery-func.js"></script>
<script type="text/javascript" src="<?=URL?>/assets/js/bootstrap.min.js"></script>
</head>
<body>
<!-- START PAGE SOURCE -->
<div id="shell">
  <div id="header">
    <h1 id="logo"><a href="#">MovieHunter</a></h1>
    <div style="display: flex; width: 100%; justify-content: end;" class="social">
    <?php if(isset($data['user']) && $data['user']){
      echo '
      <span style="color: white; font-size: 15px; margin-top: 4px;">'.$data['user']['name'].'</span>
      <span style="color: white; margin-left: 5px; font-size: 15px; margin-top: 3px;">|</span>
      <a href="'.URL.'/home/logout" style="color: white; text-decoration: none;">Log out</a>
      ';
    } else {
      echo '
      <a href="'.URL.'/home/login" style="color: white; text-decoration: none;">Login</a>
      <span style="color: white; margin-left: 5px; font-size: 15px; margin-top: 3px;">|</span>
      <a href="'.URL.'/home/register" style="color: white; text-decoration: none;">Register</a>
      ';
    } ?>
    </div>
    <div id="navigation">
      <ul>
        <li><a href="<?=URL?>">HOME</a></li>
        <?=isset($data['user']) && $data['user'] ? '<li><a href="'.URL.'/create">CREATE MOVIE</a></li>' : ''?>
        <li><a href="#">LATEST</a></li>
        <li><a href="#">TOP RATED</a></li>
        <li><a href="#">MOST COMMENTED</a></li>
      </ul>
    </div>
    <div id="sub-navigation"></div>
  </div>