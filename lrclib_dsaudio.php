<?php
// lrclib_dsaudio plugin to retreive song lyric on your dsaudio synology application
// alex at ouki.com
// v1.0.1 13/01/2025
class lrclib_dsaudio {
    private $apiUrl = 'https://lrclib.net/api';
    public function __construct() { } 
    public function getLyricsList($artist, $title, $info) {
        $count = 0;
        $searchUrl = sprintf(
        "%s/search?artist_name=%s&track_name=%s",
        $this->apiUrl, urlencode($artist), urlencode($title)
        );
        $content = $this->getContent($searchUrl);
        $obj = json_decode($content, TRUE);
        if ($obj[0] ) {
            foreach ($obj as $result) {
                $info->addTrackInfoToList( $result['artistName'], $result['trackName'], $result['id'], substr($result['plainLyrics'],0,120));
                $count++;
            }
        } else {
            return 0;
        }
        return $count;
    } 
    public function getLyrics($id, $info) {
        $lyric = $this->getLyricById($id);
        if ($lyric) {
            $info->addLyrics($lyric, $id); 
            return true;
        } else {
            return false;
        }
    }
    private function getContent($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_ENCODING, 'gzip,deflate');
        curl_setopt($curl, CURLOPT_USERAGENT, 'Lrclib-dsaudio/1.0.1');
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($curl, CURLOPT_TIMEOUT, 3);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_VERBOSE, false);
        curl_setopt($curl, CURLOPT_URL, $url);
        $result = @curl_exec($curl);
        curl_close($curl);
        return $result;
    }
    private function getLyricById($id) {
        $getURL=$this->apiUrl.'/get/'.$id;
        $content = $this->getContent($getURL);
        $obj = json_decode($content, TRUE);
        if (!$obj['id']) {
            return false;
        }
        if (strlen($obj['syncedLyrics'])<10) {
            return $obj['plainLyrics'];
        } else {
            return $obj['syncedLyrics'];
        }
    }
}

/* LRCLIB search results https://lrclib.net/api/search?q=beyonce

[
    {
        "id": 341,
        "name": "BREAK MY SOUL",
        "trackName": "BREAK MY SOUL",
        "artistName": "Beyoncé",
        "albumName": "RENAISSANCE",
        "duration": 278.0,
        "instrumental": false,
        "plainLyrics": "I'm 'bout to explode, take off this load\nBend it, bust it open, won't ya make it go?\nYaka, yaka, yaka, yaka, yaka, yaka, yaka, yaka\nYaka, yaka, yaka, yaka, yaka, yaka, yaka, yaka (release ya wiggle)\nYaka, yaka, yaka, yaka, yaka, yaka, yaka, yaka\nYaka, yaka, yaka, yaka, yaka, yaka, yaka, yaka (release ya wiggle)\nAh, la-la-la-la-la-la-la-la-la-la-la\nLa-la-la-la-la-la-la-la-la-la-la-la-la\n\nYou won't break my soul\nYou won't break my soul\nYou won't break my soul\nYou won't break my soul\nI'm telling everybody, everybody\nEverybody, everybody\n\nNow, I just fell in love, and I just quit my job\nI'm gonna find new drive, damn, they work me so damn hard\nWork by nine, then off past five\nAnd they work my nerves, that's why I cannot sleep at night\n\nMotivation\nI'm looking for a new foundation, yeah\nAnd I'm on that new vibration\nI'm building my own foundation, yeah\nHol' up, oh, baby, baby\n\nYou won't break my soul (na, na)\nYou won't break my soul (no-no, na, na)\nYou won't break my soul (no-no, na, na)\nYou won't break my soul (na, na)\nI'm telling everybody, na, na, everybody\nEverybody, everybody\n\nRelease ya anger, release ya mind\nRelease ya job, release the time\nRelease ya trade, release the stress\nRelease the love, forget the rest\n\nI'ma let down my hair 'cause I lost my mind\nBey is back and I'm sleeping real good at night\nThe queens in the front and the Doms in the back\nAin't taking no flicks, but the whole clique snapped\nThere's a whole lot of people in the house\nTrying to smoke with the 'gnac in your mouth\n(Good at night) and we back outside\nYou said you outside, but you ain't that outside\nWorldwide, hoodie with the mask outside\nIn case you forgot how we act outside\n\nGot motivation (motivation)\nI done found me a new foundation, yeah (new foundation)\nShaking my new salvation (oh, yeah, yeah, yeah, new salvation)\nAnd I'ma build my own foundation, yeah (oh, yeah, yeah, yeah, oh, yeah, yeah, yeah)\nOh, baby, baby\n\nYou won't break my soul (you won't)\nYou won't break my soul (break my soul)\nYou won't break my soul (you won't)\nYou won't break my soul (break my soul)\nAnd I'm telling everybody (everybody)\nEverybody (everybody)\nEverybody (everybody)\nEverybody, yeah\n\nYou don't seek it, you won't see it\nThat, we all know (can't break my soul)\nIf you don't think it, you won't be it\nThat love ain't yours (can't break my soul)\nTrying to fake it, never makes it\nThat, we all know (can't break my soul)\nYou can have the stress and not take less\nI'll justify love\n\nWe go 'round in circles, 'round in circles\nSearching for love ('round in circles)\nWe go up and down, lost and found\nSearching for love\nLooking for something that lives inside me\nLooking for something that lives inside me\n\nYou won't break my soul\nYou won't break my soul\nYou won't break my soul\nYou won't break my soul\nI'm telling everybody, telling everybody\nEverybody, everybody\n\nYou won't break my soul\nYou won't break my soul, no, no\nYou won't break my soul\nYou won't break my soul\nAnd I'm telling everybody (oh yeah, yeah)\nEverybody (oh yeah, yeah)\nEverybody\nEverybody (oh yeah, yeah)\n\nI'm taking my new salvation\nAnd I'ma build my own foundation, yeah\nGot motivation (motivation)\nI done found me a new foundation, yeah (new foundation)\nI'm taking my new salvation (new salvation)\nAnd I'ma build my own foundation, yeah (own foundation)\n\nI'm 'bout to explode, take off this load\nBend it, bust it open, won't ya make it go?\nYaka, yaka, yaka, yaka, yaka, yaka, yaka, yaka\nYaka, yaka, yaka, yaka, yaka, yaka, yaka, yaka (release ya wiggle)\nYaka, yaka, yaka, yaka, yaka, yaka, yaka, yaka\nYaka, yaka, yaka, yaka, yaka, yaka, yaka, yaka (release ya wiggle)\nRelease ya, release ya\nRelease ya wiggle\nRelease ya anger, release ya mind\nRelease ya job, release the time\nRelease ya trade, release the stress\nRelease the love, forget the rest",
        "syncedLyrics": "[00:00.06] I'm 'bout to explode, take off this load\n[00:02.20] Bend it, bust it open, won't ya make it go?\n[00:04.27] Yaka, yaka, yaka, yaka, yaka, yaka, yaka, yaka\n[00:06.33] Yaka, yaka, yaka, yaka, yaka, yaka, yaka, yaka (release ya wiggle)\n[00:08.50] Yaka, yaka, yaka, yaka, yaka, yaka, yaka, yaka\n[00:10.07] Yaka, yaka, yaka, yaka, yaka, yaka, yaka, yaka (release ya wiggle)\n[00:11.75] Ah, la-la-la-la-la-la-la-la-la-la-la\n[00:15.72] La-la-la-la-la-la-la-la-la-la-la-la-la\n[00:21.00] You won't break my soul\n[00:23.15] You won't break my soul\n[00:25.01] You won't break my soul\n[00:27.17] You won't break my soul\n[00:28.81] I'm telling everybody, everybody\n[00:33.46] Everybody, everybody\n[00:37.98] Now, I just fell in love, and I just quit my job\n[00:42.59] I'm gonna find new drive, damn, they work me so damn hard\n[00:47.07] Work by nine, then off past five\n[00:50.80] And they work my nerves, that's why I cannot sleep at night\n[00:53.63] Motivation\n[00:57.81] I'm looking for a new foundation, yeah\n[01:02.01] And I'm on that new vibration\n[01:06.08] I'm building my own foundation, yeah\n[01:09.80] Hol' up, oh, baby, baby\n[01:10.95] You won't break my soul (na, na)\n[01:13.05] You won't break my soul (no-no, na, na)\n[01:15.25] You won't break my soul (no-no, na, na)\n[01:17.35] You won't break my soul (na, na)\n[01:18.68] I'm telling everybody, na, na, everybody\n[01:23.42] Everybody, everybody\n[01:27.72] Release ya anger, release ya mind\n[01:29.63] Release ya job, release the time\n[01:31.78] Release ya trade, release the stress\n[01:33.83] Release the love, forget the rest\n[01:36.50] I'ma let down my hair 'cause I lost my mind\n[01:41.12] Bey is back and I'm sleeping real good at night\n[01:44.33] The queens in the front and the Doms in the back\n[01:46.48] Ain't taking no flicks, but the whole clique snapped\n[01:48.37] There's a whole lot of people in the house\n[01:50.45] Trying to smoke with the 'gnac in your mouth\n[01:52.79] (Good at night) and we back outside\n[01:54.73] You said you outside, but you ain't that outside\n[01:57.17] Worldwide, hoodie with the mask outside\n[01:59.26] In case you forgot how we act outside\n[02:00.95] Got motivation (motivation)\n[02:04.53] I done found me a new foundation, yeah (new foundation)\n[02:08.95] Shaking my new salvation (oh, yeah, yeah, yeah, new salvation)\n[02:12.65] And I'ma build my own foundation, yeah (oh, yeah, yeah, yeah, oh, yeah, yeah, yeah)\n[02:17.00] Oh, baby, baby\n[02:17.76] You won't break my soul (you won't)\n[02:19.87] You won't break my soul (break my soul)\n[02:22.01] You won't break my soul (you won't)\n[02:24.28] You won't break my soul (break my soul)\n[02:25.55] And I'm telling everybody (everybody)\n[02:28.11] Everybody (everybody)\n[02:30.24] Everybody (everybody)\n[02:32.42] Everybody, yeah\n[02:35.68] You don't seek it, you won't see it\n[02:37.49] That, we all know (can't break my soul)\n[02:39.39] If you don't think it, you won't be it\n[02:41.69] That love ain't yours (can't break my soul)\n[02:43.82] Trying to fake it, never makes it\n[02:45.93] That, we all know (can't break my soul)\n[02:47.98] You can have the stress and not take less\n[02:49.75] I'll justify love\n[02:51.84] We go 'round in circles, 'round in circles\n[02:54.20] Searching for love ('round in circles)\n[02:56.09] We go up and down, lost and found\n[02:58.22] Searching for love\n[03:00.68] Looking for something that lives inside me\n[03:04.95] Looking for something that lives inside me\n[03:07.82] You won't break my soul\n[03:10.01] You won't break my soul\n[03:12.02] You won't break my soul\n[03:14.19] You won't break my soul\n[03:15.77] I'm telling everybody, telling everybody\n[03:20.45] Everybody, everybody\n[03:24.64] You won't break my soul\n[03:26.81] You won't break my soul, no, no\n[03:28.85] You won't break my soul\n[03:30.80] You won't break my soul\n[03:32.28] And I'm telling everybody (oh yeah, yeah)\n[03:34.96] Everybody (oh yeah, yeah)\n[03:37.18] Everybody\n[03:39.04] Everybody (oh yeah, yeah)\n[03:40.88] I'm taking my new salvation\n[03:44.62] And I'ma build my own foundation, yeah\n[03:49.45] Got motivation (motivation)\n[03:52.96] I done found me a new foundation, yeah (new foundation)\n[03:57.21] I'm taking my new salvation (new salvation)\n[04:01.35] And I'ma build my own foundation, yeah (own foundation)\n[04:06.15] I'm 'bout to explode, take off this load\n[04:08.43] Bend it, bust it open, won't ya make it go?\n[04:10.58] Yaka, yaka, yaka, yaka, yaka, yaka, yaka, yaka\n[04:12.74] Yaka, yaka, yaka, yaka, yaka, yaka, yaka, yaka (release ya wiggle)\n[04:14.69] Yaka, yaka, yaka, yaka, yaka, yaka, yaka, yaka\n[04:16.52] Yaka, yaka, yaka, yaka, yaka, yaka, yaka, yaka (release ya wiggle)\n[04:18.65] Release ya, release ya\n[04:19.88] Release ya wiggle\n[04:20.75] Release ya anger, release ya mind\n[04:22.93] Release ya job, release the time\n[04:25.04] Release ya trade, release the stress\n[04:27.28] Release the love, forget the rest\n[04:28.65] "
    },


    get results https://lrclib.net/api/get/104109
    {
    "id": 104109,
    "name": "ALIEN SUPERSTAR",
    "trackName": "ALIEN SUPERSTAR",
    "artistName": "Beyoncé",
    "albumName": "RENAISSANCE",
    "duration": 215.0,
    "instrumental": false,
    "plainLyrics": "Please, do not be alarmed, remain calm\nDo not attempt to leave the dancefloor\nThe DJ booth is conducting a tro-tro-troubleshoot test of the entire system\n\nI'm one of one, I'm number one, I'm the only one\nDon't even waste your time trying to compete with me (Don't do it)\nNo one else in this world can think like me (True)\nI'm twisted (Twisted), I'll contradict it, keep him addicted\nLies on his lips, I lick it\n\nUnique, that's what you are\nStilеttos kicking vintage crystal off the bar\nCategory bad b-, I'm thе bar (Ooh)\nAlien superstar, whip, whip\n\nI'm too classy for this world, forever I'm that girl\nFeed you diamonds and pearls, ooh, baby\nI'm too classy to be touched, I paid 'em all in dust\nI'm stingy with my love, ooh, baby\n\nYou are unique (U-N-I-Q-U-E)\nOoh, I'm stingy with my love\nOoh, baby, I'm (U-N-I-Q-U-E)\nOh, I'm stingy with my love (Unique)\n\nUnicorn is the uniform you put on\nEyes on you when you perform, eyes on I when I put on\nMastermind in haute couture\nLabel wh- can't clock, I'm so obscure (Unique)\n\nMasterpiece genius, drip intravenous\nPatty cake on that wrist Tiffany, blue billboards over that ceiling (Unique)\nWe don't like plain, always dreamed of paper planes\nMile high when I rodeo, then I come down and take off again (Unique)\n\nYou see pleasure in my glare\nLook over my shoulder and you ain't scared\nThe effects you have on me when you stare\nHead on a pillow, hike it in the air\n\nI'm too classy for this world, forever I'm that girl\nFeed you diamonds and pearls, ooh, baby\nI'm too classy to be touched, I paid 'em all in dust (Unique)\nI'm stingy with my love, ooh, baby\n\nI got pearls beneath my legs, my lips, my hands, my hips (U-N-I-Q-U-E)\nI got diamonds beneath my thighs where his ego will find bliss\nCan't find an ocean deep and can't compete with this cinnamon kiss (U-N-I-Q-U-E)\nFire beneath your feet, music when you speak, you're so unique\n\nUnique, that's what you are\nLingerie reflecting off the mirror on the bar\nCategory sexy b-, I'm the bar\nAlien superstar\n\nWe dress a certain way, we walk a certain way\nWe talk a certain way, we-we paint a certain way\nWe make love a certain way, you know?\nAll of these things we do in a different, unique, specific way that is personally ours\n\nWe just reaching out to the solar\nSystem, we flying over\nWe, we, we flying over\nSupernatural love up in the air (Yeah)\n\nI just talk my talk Casanova\nSuperstar, supernova, power pull 'em in closer\nIf that's your man, then why he over here?\n(Unique)",
    "syncedLyrics": "[00:00.25] Please, do not be alarmed, remain calm\n[00:03.79] Do not attempt to leave the dancefloor\n[00:06.86] The DJ booth is conducting a tro-tro-troubleshoot test of the entire system\n[00:11.74] \n[00:14.04] I'm one of one, I'm number one, I'm the only one\n[00:21.03] Don't even waste your time trying to compete with me (Don't do it)\n[00:24.99] No one else in this world can think like me (True)\n[00:28.75] I'm twisted (Twisted), I'll contradict it, keep him addicted\n[00:33.65] Lies on his lips, I lick it\n[00:36.57] Unique, that's what you are\n[00:41.63] Stilеttos kicking vintage crystal off the bar\n[00:45.31] Category bad b-, I'm thе bar (Ooh)\n[00:49.12] Alien superstar, whip, whip\n[00:52.25] I'm too classy for this world, forever I'm that girl\n[00:56.57] Feed you diamonds and pearls, ooh, baby\n[00:59.83] I'm too classy to be touched, I paid 'em all in dust\n[01:04.43] I'm stingy with my love, ooh, baby\n[01:07.74] You are unique (U-N-I-Q-U-E)\n[01:11.01] Ooh, I'm stingy with my love\n[01:13.98] Ooh, baby, I'm (U-N-I-Q-U-E)\n[01:19.23] Oh, I'm stingy with my love (Unique)\n[01:23.34] Unicorn is the uniform you put on\n[01:25.53] Eyes on you when you perform, eyes on I when I put on\n[01:28.78] Mastermind in haute couture\n[01:30.85] Label wh- can't clock, I'm so obscure (Unique)\n[01:33.20] Masterpiece genius, drip intravenous\n[01:36.44] Patty cake on that wrist Tiffany, blue billboards over that ceiling (Unique)\n[01:41.10] We don't like plain, always dreamed of paper planes\n[01:44.58] Mile high when I rodeo, then I come down and take off again (Unique)\n[01:48.68] You see pleasure in my glare\n[01:50.89] Look over my shoulder and you ain't scared\n[01:52.50] The effects you have on me when you stare\n[01:54.73] Head on a pillow, hike it in the air\n[01:58.17] I'm too classy for this world, forever I'm that girl\n[02:02.37] Feed you diamonds and pearls, ooh, baby\n[02:05.77] I'm too classy to be touched, I paid 'em all in dust (Unique)\n[02:10.31] I'm stingy with my love, ooh, baby\n[02:13.04] I got pearls beneath my legs, my lips, my hands, my hips (U-N-I-Q-U-E)\n[02:17.03] I got diamonds beneath my thighs where his ego will find bliss\n[02:20.97] Can't find an ocean deep and can't compete with this cinnamon kiss (U-N-I-Q-U-E)\n[02:25.01] Fire beneath your feet, music when you speak, you're so unique\n[02:31.25] Unique, that's what you are\n[02:35.88] Lingerie reflecting off the mirror on the bar\n[02:39.44] Category sexy b-, I'm the bar\n[02:43.59] Alien superstar\n[02:47.75] We dress a certain way, we walk a certain way\n[02:50.07] We talk a certain way, we-we paint a certain way\n[02:53.92] We make love a certain way, you know?\n[02:56.29] All of these things we do in a different, unique, specific way that is personally ours\n[03:01.47] We just reaching out to the solar\n[03:03.89] System, we flying over\n[03:05.82] We, we, we flying over\n[03:07.51] Supernatural love up in the air (Yeah)\n[03:16.72] I just talk my talk Casanova\n[03:19.19] Superstar, supernova, power pull 'em in closer\n[03:23.16] If that's your man, then why he over here?\n[03:26.60] \n[03:32.42] (Unique)\n[03:33.57] "
}



tar zcf lrclib_dsaudio-10.aum INFO lrclib_dsaudio.php
    */

?>
