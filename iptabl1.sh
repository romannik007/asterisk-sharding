#!/bin/bash

iptables -A INPUT -p tcp --dport 443 -j ACCEPT
iptables -A INPUT -p udp --dport 5060:5061 -j ACCEPT
iptables -A INPUT -p tcp --dport 80 -j ACCEPT
iptables -v -t nat -A DOCKER -p udp --dport 10000:10099 -j DNAT --to-destination 172.16.16.2:10000-10099
iptables -v -t nat -A POSTROUTING -j MASQUERADE -p udp --source 172.16.16.2 --destination 172.16.16.2 --dport 10000:10099
iptables -v -A DOCKER -j ACCEPT -p udp --destination 172.16.16.2 --dport 10000:10099

iptables-save

