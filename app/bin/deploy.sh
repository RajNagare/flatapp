#!/bin/bash

BuildDirectory=$1;
BuildLog="$BuildDirectory/build.log";

# CLI Display
echo "";
echo "------------------------------------------------------";
echo " Deploying App $BuildDirectory"; 
echo ""; 
echo "------------------------------------------------------"; 
echo  "";

# S3 Deployment
if [ "$2" == "s3" ]; then

	if [ ! $3 ]; then

		echo "No s3 bucket passed, exiting"

	else

	echo "" >> $BuildLog;
	echo "DEPLOYING to S3" >> $BuildLog;
	echo "" >> $BuildLog;
	
	aws s3 sync $BuildDirectory/ s3://$3 --delete --recursive

	echo -e "${footer}";
	echo "------------------------------------------------------";
	echo "Deployed $BuildDirectory to S3 $3 ";
	echo -e "------------------------------------------------------${resetColor}";

	fi

fi

# IF deploy is specified as build

if [ "$2" == "local" ]; then

	echo "" >> $BuildLog;
	echo "DEPLOYING" >> $BuildLog;
	echo "" >> $BuildLog;
		
	unlink web;
	ln -s $BuildDirectory web;

	echo -e "${footer}";
	echo "------------------------------------------------------";
	echo "Build deployed $BuildDirectory locally under web/";
	echo -e "------------------------------------------------------${resetColor}";

fi

# IF zip is specified as build
if [ "$2" == "zip" ]; then

	echo "" >> $BuildLog;
	echo "COMPRESSING" >> $BuildLog;
	echo "" >> $BuildLog;
	
	# ZIP File 
	zip -r $BuildDirectory.zip $BuildDirectory >> $BuildLog;
		
	echo -e "${footer}";
	echo "------------------------------------------------------";
	echo "Build compressed:";
	du -h $BuildDirectory.zip;
	echo -e "------------------------------------------------------${resetColor}";

fi
