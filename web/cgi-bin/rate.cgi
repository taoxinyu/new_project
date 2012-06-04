#!/bin/bash

s=`cat /proc/net/dev |grep LAN |sed 's/:/ /g'|awk '{sum1+=$2;sum2+=$10}END{print sum1+sum2}'`
sleep 1
p=`cat /proc/net/dev |grep LAN |sed 's/:/ /g'|awk '{sum1+=$2;sum2+=$10}END{print sum1+sum2}'`
total_r=`echo "$s $p"|awk '{print $2-$1}'`

echo "$total_r" | awk '{print $1*8/1024/1024}'
