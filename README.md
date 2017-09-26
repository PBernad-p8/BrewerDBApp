# BreweryDB app
Web app that get list of beers from BrewerDB Api and stores it ​HTML (name, desription, large​ ​image​ URLs) into​​ JSON​​ or ​XML​ file.

## Requirements
Php cUrl library installed (To install run: "apt-get install php7.0-curl")

## Usage instruction
config/
	BreweryDBApi.php	- Api configuration file - please update with your settings as required
	config.php			- Application configuration file - please update with your settings as required

To run type the command:
* php get_list -f [file_format]

## PARAMETERS
* -f [file_format] - format of file needed. Required. Possible options: json, xml, both(json and xml)

## EXAMPLES OF USAGE
For json format:
* php get_list -f json

For json and xml format:
* php get_list -f both