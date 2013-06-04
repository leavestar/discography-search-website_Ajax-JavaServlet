<?php

	function nullCheck($item)
	{
		if($item==null)
		{
			$item="NA";
		}
		return htmlspecialchars($item);
	}

	function artistsParser($content_match) 
	{
		$regex_artists="/<tr\sclass=\"search-result\sartist\">(.*?)<\/tr>/is";
		preg_match_all($regex_artists, $content_match, $match_artists);
		$cnt=count($match_artists[1]);
		if(count($match_artists[1])>5)
		{
			$cnt=5;
		}
		$xml_body="";
		$image_artists=array();
		$name_artists=array();
		$genre_artists=array();
		$year_artists=array();
		$link_artists=array();

		for($i=0;$i<$cnt;$i++)
		{
			$regex_img_artists="/<img\ssrc=\"(.*?)\"\s/is";
			preg_match_all($regex_img_artists,$match_artists[1][$i],$match_img_artists);
			$regex_name_artists="/<div\sclass=\"name\">[\s]*<a\shref=\"(.*?)\"\s[^>]*>(.*?)<\/a>/is";
			preg_match_all($regex_name_artists,$match_artists[1][$i],$match_name_artists);
			$regex_info_artists="/<div\sclass=\"info\">[\s]*(.*?)[\s]*<br\/>[\s]*(.*?)[\s]*<\/div>/is";
			preg_match_all($regex_info_artists,$match_artists[1][$i],$match_info_artists);
			$regex_link_artists="/<div\sclass=\"thumbnail\ssm\sartist\">[\s]*<a\shref=\"(.*?)\"/is";
			preg_match_all($regex_link_artists,$match_artists[1][$i],$match_link_artists);

			$image_artists[$i]=nullCheck($match_img_artists[1][0]);
			$name_artists[$i]=nullCheck($match_name_artists[2][0]);
			$genre_artists[$i]=nullCheck($match_info_artists[1][0]);
			$year_artists[$i]=nullCheck($match_info_artists[2][0]);
			$link_artists[$i]=nullCheck($match_name_artists[1][0]);

			$xml_body.="<result ";
			$xml_body.="cover=\"".$image_artists[$i]."\" ";
			$xml_body.="name=\"".$name_artists[$i]."\" ";
			$xml_body.="genre=\"".$genre_artists[$i]."\" ";
			$xml_body.="year=\"".$year_artists[$i]."\" ";
			if($link_artists[$i]!="NA")
			{
				$xml_body.="details=\"".$link_artists[$i]."\"/>";
			}
			else
			{
				$xml_body.="details=\"NA\"/>";
			}
		}
		return $xml_body;
	}

	function albumsParser($content_match)
	{
		$regex_albums="/<tr\sclass=\"search-result\salbum\">(.*?)<\/tr>/is";
		preg_match_all($regex_albums, $content_match, $match_albums);
		$cnt=count($match_albums[1]);
		if(count($match_albums[1])>5)
		{
			$cnt=5;
		}
		$xml_body="";
		$image_albums=array();
		$title_albums=array();
		$artist_albums=array();
		$genre_albums=array();
		$year_albums=array();
		$link_albums=array();

		for($i=0;$i<$cnt;$i++)
		{
			$regex_img_albums="/<img\ssrc=\"(.*?)\"\s/is";
			preg_match_all($regex_img_albums,$match_albums[1][$i],$match_img_albums);
			$regex_title_albums="/<div\sclass=\"title\">[\s]*<a\s[^>]+>(.*?)<\/a>/is";
			preg_match_all($regex_title_albums,$match_albums[1][$i],$match_title_albums);
			$regex_artist_albums="/<div\sclass=\"artist\">[\s]*<a\s[^>]+>(.*?)<\/a>/is";
			preg_match_all($regex_artist_albums,$match_albums[1][$i],$match_artist_albums);
			$regex_info_albums="/<div\sclass=\"info\">[\s]*(.*?)[\s]*<br\/>[\s]*(.*?)[\s]*<\/div>/is";
			preg_match_all($regex_info_albums,$match_albums[1][$i],$match_info_albums);
			$regex_link_albums="/<div\sclass=\"title\">[\s]*<a\shref=\"(.*?)\"/is";
			preg_match_all($regex_link_albums,$match_albums[1][$i],$match_link_albums);

			$image_albums[$i]=nullCheck($match_img_albums[1][0]);
			$title_albums[$i]=nullCheck($match_title_albums[1][0]);
			$artist_albums[$i]=nullCheck($match_artist_albums[1][0]);
			$year_albums[$i]=nullCheck($match_info_albums[1][0]);
			$genre_albums[$i]=nullCheck($match_info_albums[2][0]);
			$link_albums[$i]=nullCheck($match_link_albums[1][0]);

			$xml_body.="<result ";
			$xml_body.="cover=\"".$image_albums[$i]."\" ";
			$xml_body.="title=\"".$title_albums[$i]."\" ";
			$xml_body.="artist=\"".$artist_albums[$i]."\" ";
			$xml_body.="genre=\"".$genre_albums[$i]."\" ";
			$xml_body.="year=\"".$year_albums[$i]."\" ";
			$xml_body.="details=\"".$link_albums[$i]."\" />";
		}
		return $xml_body;
	}

	function songsParser($content_match)
	{
		$regex_songs="/<tr\sclass=\"search-result\ssong\">(.*?)<\/tr>/is";
		preg_match_all($regex_songs, $content_match, $match_songs);
		$cnt=count($match_songs[1]);
		if(count($match_songs[1])>5)
		{
			$cnt=5;
		}
		$xml_body="";
		$linksample_songs=array();
		$title_songs=array();
		$performer_songs=array();
		$composers_songs=array();
		$link_songs=array();

		for($i=0;$i<$cnt;$i++)
		{
			$regex_linksample_songs="/<div\sclass=\"ui360\sicon-search-song-new\">[\s]*<a\shref=\"(.*?)\"/is";
			preg_match_all($regex_linksample_songs,$match_songs[1][$i],$match_linksample_songs);
			$regex_title_songs="/<div\sclass=\"title\">.*?<a\s[^>]+>&quot;(.*?)&quot;<\/a>/is";
			preg_match_all($regex_title_songs,$match_songs[1][$i],$match_title_songs);
			$regex_performer_songs="/<span\sclass=\"performer\">.*?<a\s[^>]+>(.*?)<\/a>/is";
			preg_match_all($regex_performer_songs,$match_songs[1][$i],$match_performer_songs);
			$regex_composers_songs="/<div\sclass=\"info\">[\s]*(.*?)[\s]*<\/div>/is";
			preg_match_all($regex_composers_songs,$match_songs[1][$i],$match_composers_songs);
			$regex_composer_songs="/<a\s.*?>(.*?)<\/a>/is";//"/<a\s[^>]+>(.*?)<\/a>/is";
			preg_match_all($regex_composer_songs,$match_composers_songs[1][0],$match_composer_songs);

			$composers_songs[$i]="";
			if(count($match_composer_songs[1])!=0)
			{
				for($j=0;$j<count($match_composer_songs[1]);$j++)
				{
					$composers_songs[$i].=htmlspecialchars($match_composer_songs[1][$j]);
					$composers_songs[$i].=" ";
				}
			}
			else
			{
				$composers_songs[$i]="NA";
			}
			$regex_link_songs="/<div\sclass=\"title\">[\s]*<a\shref=\"(.*?)\"/is";
			preg_match_all($regex_link_songs,$match_songs[1][$i],$match_link_songs);

			$linksample_songs[$i]=nullCheck($match_linksample_songs[1][0]);
			$title_songs[$i]=nullCheck($match_title_songs[1][0]);
			$performer_songs[$i]=nullCheck($match_performer_songs[1][0]);
			$link_songs[$i]=nullCheck($match_link_songs[1][0]);

			$xml_body.="<result ";
			$xml_body.="sample=\"".$linksample_songs[$i]."\" ";
			$xml_body.="title=\"".$title_songs[$i]."\" ";
			$xml_body.="performer=\"".$performer_songs[$i]."\" ";
			$xml_body.="composers=\"".htmlspecialchars($composers_songs[$i])."\" ";
			$xml_body.="details=\"".$link_songs[$i]."\" />";
		}
		return $xml_body;
	}
		ini_set('default_charset', 'utf-8');
		header('Content-Type:text/xml; charset=utf-8');
		error_reporting( E_ALL&~E_NOTICE );
		$title=$_GET['title'];
		$type=$_GET['type'];
		$url="http://www.allmusic.com/search/".$type."/".$title;
		$url=str_replace(" ","%20",$url);
		$total_content=file_get_contents($url);

		$regex_search="/<table\sclass=\"search-results\"[^>]+>(.*?)<\/table>/is"; 
		preg_match_all($regex_search, $total_content, $content_match);
		$xml_text="<?xml version=\"1.0\" encoding=\"UTF-8\"?><results>";
		
		if(count($content_match[1])!=0)
		{
			if($type=="artists")
			{
				$xml_text.=artistsParser($content_match[1][0]);
			}
			else if($type=="albums")
			{
				$xml_text.=albumsParser($content_match[1][0]);
			}
			else
			{
				$xml_text.=songsParser($content_match[1][0]);
			}
		}
		$xml_text.="</results>";
		echo $xml_text;
?>
