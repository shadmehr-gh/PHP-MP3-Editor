# PHP-MP3-Editor
get or change music tags and cover or trim it very easy

## intro
this is a small library for easy using of [getid3](https://github.com/JamesHeinrich/getID3) and [phpmp3](https://github.com/thegallagher/PHP-MP3) libraries.

## instalition
get a clone of project and use this code
```php
require '/path/to/PHP-MP3-Editor/php-mp3-editor.php';
$mp3 = new mp3editor();
```

## Methods
### `tags`
`tags(`**`string`**` $path)`

get mp3 file tags as a clean array
```php
$mp3 = new mp3editor();
$tags = $mp3->tags('/my/file.mp3');
```

### `cover `
`cover(`**`string`**` $path,`**`string|false`**` $saveto = false)`

get content of music cover file . you can also with using `$saveto` parameter use a path to save cover content into a image file
```php
$mp3 = new mp3editor();

/// get content of cover
$cover = $mp3->cover('/my/file.mp3');
/// save cover as separately
file_put_contents("/a/path/file.png",file_get_contents($cover);

/// get cover content and save into a path
$cover = $mp3->cover('/my/file.mp3','/cover/path/file.jpg');
```

### `tagEdit` 
`tagEdit(`**`string`**` $path,`**`array`**` $data)`

replace any tags into a mp3 file very simple
```php
$mp3 = new mp3editor();
$new_tags = [
  "title"  => "new title",
  "artist" => "any artist name",
  "cover"  => "/a/picture.jpg"
];
$mp3->tagEdit('/my/file.mp3',$new_tags);
```

### `trim` 
`trim(`**`string`**` $path,`**`int`**` $offset,`**`int`**` $limit,`**`string|false`**` $saveto = false)`

trim a mp3 file and save it as overwrite or into another path
if dont use `$saveto` parameter it means you want trim and overwrite mp3 file
```php
$mp3 = new mp3editor();
$start_secound = 20;
$trim_time_secounds = 40;
/// it means method trims music from 0:20 to 1:00
$mp3->trim('/my/file.mp3',$start_secound,$trim_time_secounds,'/new/path.mp3');
```
