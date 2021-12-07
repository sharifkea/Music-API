# Final Assignment - Web Application Development
# API
# Chinook_abridged

## Purpose
This is a REST API for dents of the elective subject Web Application Development in the Professional Bachelor Degree in Software Development at KEA (Københavns Erhvervsakademi / Copenhagen School of Design and Technology). The API manages a film database adapted from 

## Tools
PHP8 / MySQL

## API Documentation

####Main usage:

http://_<server_name>_/php-mysql-films-rest-api/_<end_point>_

####Endpoints:

| Method | Usage        | Description                         |
| ------ |:------------ |:----------------------------------- |
| GET    |/    | Returns the API description for GET methods     |
| GET    |/admin| Returns Admin Password|
| GET    |/artist?name=_<search_text>_ | Returns information of artists_<search_text>_ |
| GET    |/album?name=_<search_text>_ | Returns information of albums_<search_text>_ |
| GET    |/album?artistId=_<artist_id>_ | Returns all albums of that artist_<artist_id>_ |
| GET    |/track?name=_<search_text>_ | Returns information of tracks_<search_text>_ |
| GET    |/track?albumId=_<album_id>_ | Returns information of all tracks of that album_<album_id>_ |
| GET    |/track?trackId=_<track_id>_ | Returns information of the tracks have trackId_<album_id>_ |
| POST<br><br><br><br><br><br><br><br>   |/track/new<br><br>Request body<br><br><br><br><br><br> | Adds a new track<br><br>Name<br>AlbumId<br>MediaTypeId<br>GenreId<br>Composer<br>Milliseconds<br>Bytes<br>UnitPrice|
| POST<br><br><br><br><br><br><br><br>   |/track<br><br>Request body<br><br><br><br><br><br> | Update the trasck with TrackId<br><br>TrackId<br><br>Name<br>AlbumId<br>MediaTypeId<br>GenreId<br>Composer<br>Milliseconds<br>Bytes<br>UnitPrice|
| DELETE    |/track/_<track_id>_ | Delete the film with ID _<track_id>_ |
| GET    |/invoice/_<invoice_id>_ | Returns detailed information of that invoice with ID _<invoice_id>_ |
| GET    |/invoice?customerId=_<customer_id>_ | Returns all invoice of that custoner<customer_id>
| GET    |/customer/_<customer_id>_ | Returns detailed information of the customer with ID _<customer_id>_ |




####Examples:
