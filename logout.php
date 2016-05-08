<?php
setcookie('token', '42', time() - 3600, '/');
header('Location: .');