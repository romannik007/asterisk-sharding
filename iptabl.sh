#!/bin/bash
# Переменные
INET_IP=192.168.88.222 # Внешний IPшник 
ASTER_IP=172.16.16.2 # IPшник SIP сервера
EXTEN_IP=192.168.0.100 # IPшник SIP клиента
FRTP=10000
LRTP=10100
SIPPORT=5060
eth=enp2s0
# Подключить модули:
/sbin/modprobe nf_conntrack_sip
/sbin/modprobe nf_nat_sip
/sbin/modprobe nf_conntrack_h323
# Разрешить пересылку пакетов
iptables -A FORWARD -m state --state ESTABLISHED,RELATED -j ACCEPT -v
iptables -A FORWARD -p udp --dport $SIPPORT -j ACCEPT -v
iptables -A FORWARD -p udp -m multiport --dports $FRTP:$LRTP -j ACCEPT -v

iptables -t nat -A PREROUTING -i $eth -p udp \
-m udp --dport $FRTP:$LRTP -j DNAT \
--to-destination $ASTER_IP -v
iptables -t nat -A PREROUTING -i $eth -p udp \
-m udp --dport $SIPPORT -j DNAT \
--to-destination $ASTER_IP -v
netfilter-persistent save