#!/bin/bash

if [ -n "$QUERY_STRING" ]; then

eth_name=$QUERY_STRING

else

eth_name="ETH1"

fi

send_n=`/sbin/ifconfig $eth_name | grep bytes | awk '{print $6}' | awk -F : '{print $2}'`

recv_n=`/sbin/ifconfig $eth_name | grep bytes | awk '{print $2}' | awk -F : '{print $2}'`
echo "Content-type: text/plain"
echo -e "\n"
echo "1248243017|$recv_n|$send_n"
#echo "$recv_n"
