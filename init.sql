-- Pastikan user dibuat dengan autentikasi yang benar
CREATE USER IF NOT EXISTS 'phpuser'@'%' IDENTIFIED WITH mysql_native_password BY '';
GRANT ALL PRIVILEGES ON onlinefoodphp.* TO 'phpuser'@'%';
FLUSH PRIVILEGES;