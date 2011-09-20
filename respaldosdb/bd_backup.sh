#####
# Set these values!
####
host=$1
db=$2
user=$3
if [ "$4" = "empty" ]; then
  pass=""
else
  pass=$4
fi 


#Directory to save generated sql files (domain name is appended)
opath=/usr/tmp/sql_dumps/
 
# your mysql host
mysqlhost=$host
 
 
#date to append
suffix=$(date +%Y-%m-%d-%H-%M)
cpath=$opath$host

if [ -d $cpath ]
then
	filler="nothing to do"
else
	echo "Creating $cpath"
	mkdir -p $cpath
fi

SQLFILE=${cpath}/${db}_$suffix.sql.gz
mysqldump -c -h $host --user $user --password=$pass $db 2>error | gzip > $SQLFILE

if [ -s error ]
then
	printf "WARNING: An error occured while attempting to backup %s  \n\tError:\n\t" ${sqldbs[$i]}
	cat error
	rm -f er
else
	printf "%s was backed up successfully to %s\n\n" $db $SQLFILE
fi

if [ "${5}" = "ftp" ]; then
	echo "es un ftp"
	USER=${8}
	PASS=${9}
	ftp -n ${6} <<SCRIPT
	user $USER $PASS
	binary
        lcd ${cpath}/
        cd ${7}	
	put ${db}_$suffix.sql.gz
	quit
SCRIPT

else
	echo "a"
fi

if [ "${5}" = "win" ]; then
	if [ "${9}"="empty" ]; then
		smb_pass="-N"
	else
		smb_pass=${9}
	fi
       echo "es un windows directory"
       smbclient ${6} $smb_pass <<SCRIPT
       lcd ${cpath}
       cd ${7}
       put ${db}_$suffix.sql.gz
       quit
SCRIPT
else
	echo "b"
fi
