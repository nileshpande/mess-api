set doc=C:\xampp\htdocs\nmumess
cd "%doc%"
copy /y nul "file.php"
ECHO ^<?php echo 'This is executed via scheduler task!'; ?^> >file.php
schtasks /create /tn "Cron" /tr "C:\Program Files (x86)\Google\Chrome\Application\chrome.exe http://localhost/nmumess/bill.php" /st minute /mo 10