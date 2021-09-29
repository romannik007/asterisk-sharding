#!/bin/bash
# Переменные
sudo iptables -A DOCKER -t nat -p udp -m udp ! -i docker0 --dport 10000:10099 -j DNAT --to-destination $CIP:10000-10099
sudo iptables -A DOCKER -p udp -m udp -d $CIP/32 ! -i docker0 -o docker0 --dport 10000:10099 -j ACCEPT
sudo iptables -A POSTROUTING -t nat -p udp -m udp -s $CIP/32 -d $CIP/32 --dport 10000:10099 -j MASQUERADE

iptables-save

# $CID - имя контейнера или его идентификатор
# $NID - идентификатор используемой overlay сети
# запускается на хосте после запуска контейнераДелает проброс большого диапазона портов одним правилом
