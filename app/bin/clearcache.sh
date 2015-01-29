#!/bin/bash

CacheDirectory="app/cache"

echo ""; 
echo "------------------------------------------------------";
echo " FlatApp| Clearing cache @ $CacheDirectory"; 
echo "------------------------------------------------------"; 
echo  "";



# Does that build directory exist?
if [ -d $CacheDirectory ]; then

	echo "Cache Contents"
	ls -al $CacheDirectory;
	sudo rm -rf $CacheDirectory/*/;
	echo "";
	echo "Done";


else 
	echo "You are not in the root app directory, cache not cleared";
fi
