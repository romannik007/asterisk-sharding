#!/bin/bash

firewall-cmd --zone=external --add-masquerade --permanent
firewall-cmd --zone=public --add-masquerade --permanent
firewall-cmd --zone=public --permanent --add-forward-port=port=10000-10099:proto=udp:toport=10000-10099:toaddr=172.16.16.2
firewall-cmd --zone=public --permanent --add-forward-port=port=10100-10200:proto=udp:toport=10100-10200:toaddr=172.16.16.3
firewall-cmd --zone=public --permanent --add-port=5060-5061/udp
#firewall-cmd --runtime-to-permanent
firewall-cmd --reload
firewall-cmd --zone=public --permanent --query-forward-port=port=10000-10099:proto=udp:toport=10000-10099:toaddr=172.16.16.2
firewall-cmd --zone=public --permanent --query-forward-port=port=10100-10200:proto=udp:toport=10100-10200:toaddr=172.16.16.3

