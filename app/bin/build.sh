#!/bin/bash

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
Theme="default"
ThemeDirectory=src/themes/$Theme
Views=$ThemeDirectory/*.html
ViewManifest="$BuildDirectory/viewManifest.txt";

# CLI Display
echo "";
echo "------------------------------------------------------";
echo " FlatApp > Building App $BuildDirectory"; 
echo ""; 
echo " Log located at:";
echo " $(pwd)/$BuildLog"; 
echo -e "------------------------------------------------------"; 
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

#echo "Build Log | $BuildDirectory on $CurrentDate" >> $BuildLog; 
#echo "------------------------------------" >> $BuildLog;
#echo "" >> $BuildLog;

echo "Generating view manifest..."; echo "";

# Make manifest
for file in $Views
do
	echo $file >> $ViewManifest	
done

# Clean up the manifest
sed -i 's/src\/themes\/default\///g' $ViewManifest;
sed -i 's/\.html//g' $ViewManifest;

echo "Rendering Views..."; echo "";

#echo "RENDERING" >> $BuildLog; 
#echo "" >> $BuildLog;

# Loop on each view in the manifest
while read viewName; do

	#echo "$viewName" >> $BuildLog;

	# Rendering with PHP (twig)
	php web/index.php $(pwd)/web $viewName > $BuildDirectory/$viewName.html

	# TODO FIXME
	# Update links to point to local html files
	#while read linkName; do
		#sed -i "s/\/$linkName\"/$linkName\.html\"/g" $BuildDirectory/$viewName.html;
	#done <$ViewManifest
	
	# Make all <script> src attributes a local include (remove the /)
	#sed -i 's/src="\/js/src="js/g' $BuildDirectory/$viewName.html;

	# Make all <style> href attributes a local include (remove the /)
	#sed -i 's/href="\//href="/g' $BuildDirectory/$viewName.html;
	
	# Make all img attributes a local include (remove the /)
	#sed -i 's/\/img/img/g' $BuildDirectory/$viewName.html;
	
	# Remove the / from  library includes
	#sed -i 's/\/bower/bower/g' $BuildDirectory/$viewName.html; 

	# Remove themes/{themeName} from web dependecies
	sed -i "s/\/themes\/$Theme//g" $BuildDirectory/$viewName.html; 
	
done <$ViewManifest

rm $ViewManifest;

# Copy CSS
echo "Duplicating CSS..."; echo "";
rsync -qav --exclude=".git/*" $ThemeDirectory/css/ $BuildDirectory/css/;

#Update CSS links to be local
sed -i "s/\/img/..\/img/g" $BuildDirectory/css/*.css;

# Copy JS
echo "Duplicating JS..."; echo "";
rsync -qav --exclude=".git/*" $ThemeDirectory/js/ $BuildDirectory/js/;

# Copy Image
echo "Duplicating Images..."; echo "";
rsync -qav --exclude=".git/*" $ThemeDirectory/img/ $BuildDirectory/img/;

# Copy Bower Dependecies
echo "Duplicating bower dependencies..."; echo "";
rsync -qav --exclude=".git/*"  src/bower/ $BuildDirectory/bower/;

#Create robots.txt
echo "Creating robots.txt..."; echo "";
printf "User-agent: * \nAllow: /" >> $BuildDirectory/robots.txt;

# Humans.txt 
echo "Dulicating humans.txt..."; echo "";
cp $ThemeDirectory/humans.txt $BuildDirectory/humans.txt

echo "Build generated at $BuildDirectory";

echo "";
echo "Build complete!"; 
