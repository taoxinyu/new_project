#!/bin/bash
num=`cat /proc/net/nf_conntrack | grep ESTABLISHED |wc -l`
udp=`cat /proc/net/nf_conntrack | grep udp | sed '/ASSURED/g' | wc -l`
num=`expr $num + $udp`
echo "Content-type: text/plain"
echo -e "\n"
echo "$num"
