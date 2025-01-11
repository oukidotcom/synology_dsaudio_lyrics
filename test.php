<?php
include("lrclib_dsaudio.php");
$lrclib=new lrclib_dsaudio();

class lyric {
    public function addTrackInfoToList($artist,$title,$id,$lyric) {
        print_r($artist);
        print_r($title);
        print_r(value: $id);
    }
    public function addLyrics($lyric, $id) {
        print_r($lyric);
    } 
}
$info=new lyric();

$count=$lrclib->getLyricsList("jul", "coeur en or", $info);
echo 'count='.$count."\n";
$lrclib->getLyrics(15911471, $info);
