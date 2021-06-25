#!/bin/bash


asterisk -vvvvv
if [ ! -f "/home/install" ]; then
cat <<EOF > /etc/odbcinst.ini
[MySQL]
Description = ODBC for MySQL (MariaDB)
Driver = /usr/lib/x86_64-linux-gnu/odbc/libmaodbc.so
FileUsage = 1
EOF

cat <<EOF > /etc/odbc.ini
[MySQL-asteriskcdrdb]
Description = MySQL connection to 'asteriskcdrdb' database
Driver = MySQL
Server = localhost
Database = asteriskcdrdb
Port = 3306
Socket = /var/run/mysqld/mysqld.sock
Option = 3
EOF

  cd /usr/local/src
  wget "https://johnvansickle.com/ffmpeg/releases/ffmpeg-release-amd64-static.tar.xz"
  tar xf ffmpeg-release-amd64-static.tar.xz
  cd ffmpeg-4*
  mv ffmpeg /usr/local/bin

  cd /usr/local/src
  wget http://mirror.freepbx.org/modules/packages/freepbx/freepbx-15.0-latest.tgz
  tar zxvf freepbx-15.0-latest.tgz
  cd /usr/local/src/freepbx/
  ./start_asterisk start
  ./install -n

  fwconsole ma installall

  cd /usr/share/asterisk
  mv sounds sounds-DIST
  ln -s /var/lib/asterisk/sounds sounds

  fwconsole restart
  #echo "1" >> /home/install
fi;
#/usr/sbin/fwconsole start -q

