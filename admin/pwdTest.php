<?php
$hashCode = password_hash('Password123!@#', PASSWORD_BCRYPT);

echo $hashCode;