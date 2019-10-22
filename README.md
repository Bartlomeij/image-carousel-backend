Image Carousel Backend
============

That's not the simplest solution. I know. It’s maybe over engineered in this case but I wanted to show how do I work with code in more advanced architecture. You can get Json or Xml response.

### Example CSV file (comma-separated):
```
id,name,image,discount_percentage
123,Atlantis The Palm,​https://via.placeholder.com/250x250​,25
```

## Requirements

* php 7.3.10+
* composer

## Installation

* Clone the repository:
```
git clone https://github.com/Bartlomeij/image-carousel-backend.git ~/Code/carousel-backend
``` 

* Add permission to var directory:
```
chmod 0777 -R var
```
* Install composer:
```
composer install
```

## Useful commands
* There are just a few tests. Writing them all (or work with TDD) would take me a lot more time than expected. Run tests:
```
./bin/phpunit
```

* Run generating json/xml images lists on server from csv file. The file will be stored in ./var/files directory.
```
./bin/console carousel:generate --format=xml /path/to/file/on/server/images.csv
```
Note: option --format=xml is optional, json is a default format.

## Endpoint

You can list all images from generated files:
```
http://yourdomain.local/images
``` 
You can choose from which file you want to get data (json/xml file). Default: json file.
```
http://yourdomain.local/images?source=xml
``` 
You can filter by name and discount values:
```
http://yourdomain.local/images?name=image&discount_from=10&discount_to=20
``` 
You can simply change response format. application/json and application/xml are supported. Just sent header:
```
ACCEPT: application/xml
```
