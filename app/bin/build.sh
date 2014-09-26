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
Views=web/views/*.html
ViewManifest="$BuildDirectory/viewManifest.txt";

# CLI Display
echo -e "${header}";
echo "••••••••••••••••••••••••••••••••••••••••••••";
echo " GUS > Building App $BuildDirectory"; 
echo ""; 
echo " Log located at:";
echo " $(pwd)/$BuildLog"; 
echo -e "••••••••••••••••••••••••••••••••••••••••••••${resetColor}"; 
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
sed -i 's/web\/views\///g' $ViewManifest;
sed -i 's/\.html//g' $ViewManifest;

echo "Rendering Views..."; echo "";

echo "RENDERING" >> $BuildLog; 
echo "" >> $BuildLog;

# Loop on each view in the manifest
while read viewName; do

	echo "$viewName" >> $BuildLog;
	
	# Rendering with PHP (twig)
	php web/index.php $(pwd)/web $viewName > $BuildDirectory/$viewName.html
	
	# TODO FIXME
	# Update links to point to local html files
	while read linkName; do
		sed -i "s/\/$linkName\"/$linkName\.html\"/g" $BuildDirectory/$viewName.html;
	done <$ViewManifest
	
	#Make JS include local
	sed -i 's/src="\/js/src="js/g' $BuildDirectory/$viewName.html;
	
	#Make CSS include local
	sed -i 's/href="\/css/href="css/g' $BuildDirectory/$viewName.html;
	
	#Make Image include local
	sed -i 's/src="\/img/src="img/g' $BuildDirectory/$viewName.html;
	
	#Make Image include local
	sed -i "s/url('\/img/url('img/g" $BuildDirectory/$viewName.html;
	
	#Make Lib include local
	sed -i 's/\/library/library/g' $BuildDirectory/$viewName.html;
	
done <$ViewManifest

# Copy CSS
echo "Duplicating CSS..."; echo "";
rsync -qav --exclude=".git/*" web/css/ $BuildDirectory/css/;

#Update CSS links to be local
sed -i "s/url('\/img/url('\.\.\/img/g" $BuildDirectory/css/*.css;

# Copy JS
echo "Duplicating JS..."; echo "";
rsync -qav --exclude=".git/*" web/js/ $BuildDirectory/js/;

# Copy Image
echo "Duplicating Images..."; echo "";
rsync -qav --exclude=".git/*" web/img/ $BuildDirectory/img/;

# Copy Libs
echo "Duplicating libaraies..."; echo "";
rsync -qav --exclude=".git/*" --exclude="twig/" web/library/ $BuildDirectory/library/;

echo "Build generated at $BuildDirectory";

# IF deploy is specified as build

if [ "$2" == "deploy" ]; then

	echo "" >> $BuildLog;
	echo "DEPLOYING" >> $BuildLog;
	echo "" >> $BuildLog;
		
	unlink web;
	ln -s $BuildDirectory web;

	echo -e "${footer}";
	echo "••••••••••••••••••••••••••••••••••••••••••••";
	echo "Build deployed to web!";
	echo -e "••••••••••••••••••••••••••••••••••••••••••••${resetColor}";

fi

# IF zip is specified as build
if [ "$2" == "zip" ]; then

	echo "" >> $BuildLog;
	echo "COMPRESSING" >> $BuildLog;
	echo "" >> $BuildLog;
	
	# ZIP File 
	zip -r $BuildDirectory.zip $BuildDirectory >> $BuildLog;
		
	echo -e "${footer}";
	echo "••••••••••••••••••••••••••••••••••••••••••••";
	echo "Build compressed:";
	du -h $BuildDirectory.zip;
	echo -e "••••••••••••••••••••••••••••••••••••••••••••${resetColor}";

fi

echo -e "${success}";
echo "Build complete!"; 

echo -e "${resetColor}";