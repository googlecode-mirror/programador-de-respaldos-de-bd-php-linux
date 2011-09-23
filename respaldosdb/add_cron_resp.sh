#!/bin/bash

equis="X"
echo $1
if [ "$1" = $equis ]; then
 minute="*"
else
 minute=$1
fi

if [ "$2" = $equis ]; then
 hour="*"
else
 hour=$2
fi

if [ "$3" = $equis ]; then
 day="*"
else
 day=$3
fi

if [ "$4" = $equis ]; then
 month="*"
else
 month=$4
fi

if [ "$5" = $equis ]; then
 week="*"
else
 week=$5
fi


crontab -l > /tmp/user_crontab
echo "$minute $hour $day $month $week $6 $7 $8 $9 ${10} ${11} ${12} ${13} ${14} ${15}" >> /tmp/user_crontab
crontab /tmp/user_crontab
