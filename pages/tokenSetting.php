<?php
if (!empty($_SESSION['token'])) {
  if (time() >= $_SESSION['tokenexpire']) {
    unset($_SESSION['token']);
    unset($_SESSION['tokenexpire']);
  }
}

if (empty($_SESSION['token'])) {
  $_SESSION['token'] = bin2hex(random_bytes(32));
  $_SESSION['tokenexpire'] = time() + 3600;
}
