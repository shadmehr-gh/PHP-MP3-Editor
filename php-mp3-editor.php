<?php
class mp3editor
{
    function __construct()
    {
        require_once "id3/getid3/getid3.php";
        require_once 'id3/getid3/write.php';
        require_once "phpmp3/phpmp3.php";
    }
    function tags($path)
    {
        $getID3 = new getID3;
        $audiofile = $getID3->analyze($path);
        $tag = $audiofile['tags']['id3v2'];
        if (!$tag) $tag = array('comments' => array());
        foreach ($tag as $k => $v) $tag[$k] = $v[0];
        return $tag;
    }
    function cover($path, $saveto)
    {
        $getID3 = new getID3;
        $audiofile = $getID3->analyze($path);
        $x = false;
        if (isset($audiofile['comments']['picture'][0]['data'])) $x = $audiofile['comments']['picture'][0];
        if ($x != false) file_put_contents($saveto, $x);
        return $x;
    }
    function tagEdit($file, $data)
    {
        $getID3 = new getID3;
        $audiofile = $getID3->analyze($file);
        $tag = $audiofile['tags']['id3v2'];
        if (!$tag) {
            $tag = array('comments' => array());
        }
        foreach ($data as $k => $v) {
            if ($k != 'cover') $tag[$k] = [$v];
            else {
                $ext = pathinfo($v, PATHINFO_EXTENSION);
                $tag['attached_picture'] = array(
                    array(
                        'data' => file_get_contents($v),
                        'picturetypeid' => 0x03,
                        'mime' => 'image/' . $ext,
                        'description' => 'cover'
                    )
                );
            }
        }
        $tagwriter = new getid3_writetags;
        $tagwriter->filename = $file;
        $tagwriter->overwrite_tags = true;
        $tagwriter->tagformats = array('id3v1', 'id3v2.3');
        $tagwriter->tag_data = $tag;
        $tagwriter->WriteTags();
    }
    function trim($path, $offset, $l, $to = false)
    {
        if (!$to) $to = $path;
        $mp3 = new PHPMP3($path);
        $mp3_1 = $mp3->extract($offset, $l);
        $mp3_1->save($to);
    }
}

$mp3 = new mp3editor();
echo $mp3->tagEdit("x.mp3", [
    'title' => 'farasssz',
    'artist' => 'massssmad',
    'cover' => 'y.png'
]);
