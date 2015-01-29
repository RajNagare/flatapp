#!/bin/bash

#Colors
success='\e[0;32m'
resetColor='\e[0m'
header='\e[45m'
footer='\e[0;30m\e[43m'

# Current Date
CurrentDate=$(date +"%Y-%m-%d");

#Build Directory
if [ ! -z $1 ]; then
	BuildDirectory=$1;
else
	BuildDirectory="build-$CurrentDate";
fi

BuildLog="$BuildDirectory/build.log";

# Views
Views=src/views/*.html
ViewManifest="$BuildDirectory/viewManifest.txt";

# CLI Display
echo -e "${header}";
echo "------------------------------------------------------";
echo " FlatApp > Building App $BuildDirectory"; 
echo ""; 
echo " Log located at:";
echo " $(pwd)/$BuildLog"; 
echo -e "------------------------------------------------------${resetColor}"; 
echo  "";

# Does that build directory exist?
if [ ! -d $BuildDirectory ]; then

	echo "Creating build directory $BuildDirectory"; echo "";

	mkdir $BuildDirectory;

else 
	echo "Removing build directory contents $BuildDirectory"; echo "";

	rm -rf $BuildDirectory/*;
	
fi

# Log to Build Log

echo "Build Log $CurrentDate" >> $BuildLog; 
echo "------------------------------------" >> $BuildLog;
echo "" >> $BuildLog;

echo "Generating view manifest..."; echo "";

# Make manifest
for file in $Views
do
	echo $file >> $ViewManifest	
done

# Clean up the manifest
sed -i 's/src\/views\///g' $ViewManifest;
sed -i 's/\.html//g' $ViewManifest;

echo "Rendering Views..."; echo "";

echo "RENDERING" >> $BuildLog; 
echo "" >> $BuildLog;

# Loop on each view in the manifest
while read viewName; do

	echo "$viewName" >> $BuildLog;
	
	# Rendering with PHP (twig)
	php web/index.php $(pwd)/web $viewName > $BuildDirectory/$viewName
	
	# Make all <script> src attributes a local include (remove the /)
	sed -i 's/src="\/js/src="js/g' $BuildDirectory/$viewName;

	# Make all <style> href attributes a local include (remove the /)
	sed -i 's/href="\//href="/g' $BuildDirectory/$viewName;
	
	# Make all img attributes a local include (remove the /)
	sed -i 's/\/img/img/g' $BuildDirectory/$viewName;
	
	# Remove the / from  library includes
	sed -i 's/\/library/library/g' $BuildDirectory/$viewName;
	
done <$ViewManifest

# Copy CSS
echo "Duplicating CSS..."; echo "";
rsync -qav --exclude=".git/*" web/css/ $BuildDirectory/css/;

#Update CSS links to be local
sed -i "s/\/img/..\/img/g" $BuildDirectory/css/*.css;

# Copy JS
echo "Duplicating JS..."; echo "";
rsync -qav --exclude=".git/*" src/js/ $BuildDirectory/js/;

# Copy Image
echo "Duplicating Images..."; echo "";
rsync -qav --exclude=".git/*" src/img/ $BuildDirectory/img/;

# Copy Libs
echo "Duplicating libaraies..."; echo "";
rsync -qav --exclude=".git/*" --exclude="twig/" src/library/ $BuildDirectory/library/;

echo "Build generated at $BuildDirectory";

# IF deploy is specified as build

if [ "$2" == "deploy" ]; then

	echo "" >> $BuildLog;
	echo "DEPLOYING" >> $BuildLog;
	echo "" >> $BuildLog;
		
	unlink web;
	ln -s $BuildDirectory web;

	echo -e "${footer}";
	echo "------------------------------------------------------";
	echo "Build deployed $BuildDirectory > web/!";
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

echo -e "${success}";
echo "Build complete!"; 

echo -e "${resetColor}";
