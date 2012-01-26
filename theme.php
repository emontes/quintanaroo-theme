<?php

/************************************************************/
/* Remember to change the logo. The default logo has been   */
/* left as a "reference only".                              */
/************************************************************/

/************************************************************/
/* IMPORTANT NOTE FOR THEMES DEVELOPERS!                    */
/*                                                          */
/* When you start coding your theme, if you want to         */
/* distribute it, please double check it to fit the HTML    */
/* 4.01 Transitional Standard. You can use the W3 validator */
/* located at http://validator.w3.org                       */
/* If you don't know where to start with your theme, just   */
/* start modifying this theme, it's validate and is cool ;) */
/************************************************************/

/************************************************************/
/* Theme Colors Definition                                  */
/*                                                          */
/* Define colors for your web site. $bgcolor2 is generaly   */
/* used for the tables border as you can see on OpenTable() */
/* function, $bgcolor1 is for the table background and the  */
/* other two bgcolor variables follows the same criteria.   */
/* $texcolor1 and 2 are for tables internal texts           */
/************************************************************/

$bgcolor1 = "";
$bgcolor2 = "";
$bgcolor3 = "";
$bgcolor4 = "";
$textcolor1 = "";
$textcolor2 = "";

$ThemeSel = get_theme();
if(file_exists("themes/$ThemeSel/tables.php")){
	include("themes/$ThemeSel/tables.php");
}

function imprime_template($tmpl_file){
		$thefile = implode ( "", file ( $tmpl_file ) );
		$thefile = addslashes ( $thefile );
		$thefile = "\$r_file=\"" . $thefile . "\";";
		eval ( $thefile );
		print $r_file;	
}
/************************************************************/
/* Function themeheader()                                   */
/*                                                          */
/* Control the header for your site. You need to define the */
/* BODY tag and in some part of the code call the blocks    */
/* function for left side with: blocks(left);               */
/* $swapblock = 0 - Regular Block
/* $swapblock = 1 - Right Block						*/

/************************************************************/

function themeheader() {
	global $user, $banners, $sitename, $slogan, $cookie, $prefix, $anonymous, $swapblock, $name, $db, $subsbanner, $index, $name, $op, $ThemeSel;

	switch ($name){
		case "hoteles":
			$topmenu = "
			<a class=\"topNavItem\" href=modules.php?name=hoteles&filtro=ofertas&nowpage=1>Ofertas</a>
			<a class=\"topNavItem\" href=modules.php?name=hoteles&filtro=economicos&nowpage=1>Econ&oacute;micos</a>
			<a class=\"topNavItem\" href=modules.php?name=hoteles&filtro=noche-gratis&nowpage=1>Noche Gr&aacute;tis</a>
			<a class=\"topNavItem\" href=modules.php?name=hoteles&filtro=completos&nowpage=1>M&aacute;s completos</a>
			<a class=\"topNavItem\" href=modules.php?name=hoteles&filtro=grandes&nowpage=1>M&aacute;s grandes</a>";
			
		break;
		
		default:
		  $topmenu = "<a class=\"topNavItem\" href=\"modules.php?name=hoteles\">Hoteles</a> <a class=\"topNavItem\" href=\"modules.php?name=rentaautos\">Renta de Autos</a>
		   <a class=\"topNavItem\" href=\"modules.php?name=boletosavion\">Boletos de Avión</a>
		   <a class=\"topNavItem\" href=\"modules.php?name=Fotos\">Fotos</a>";	
	}
	$tmpl_file ="themes/$ThemeSel/header.html";
	$thefile = implode ( "", file ( $tmpl_file ) );
	$thefile = addslashes ( $thefile );
	$thefile = "\$r_file=\"" . $thefile . "\";";
	eval ( $thefile );
	print $r_file;
	$swapblock = 0;	
	imprime_template("themes/$ThemeSel/leftb.html");
	blocks ( left );
	imprime_template("themes/$ThemeSel/leftbb.html");
	$swapblock = "1";
	if (defined ( 'INDEX_FILE' ) or $index == 1) {	
		imprime_template ("themes/$ThemeSel/left_center.html");		
	}else{
		imprime_template ("themes/$ThemeSel/left_centernrb.html");
	}	
}

/************************************************************/
/* Function themefooter()                                   */
/*                                                          */
/* Control the footer for your site. You don't need to      */
/* close BODY and HTML tags at the end. In some part call   */
/* the function for right blocks with: blocks(right);       */
/* Also, $index variable need to be global and is used to   */
/* determine if the page your're viewing is the Homepage or */
/* and internal one.                                        */
/************************************************************/

function themefooter() {
	global $index, $swapblock, $foot1, $foot2, $foot3, $foot4, $index, $name, $ThemeSel, $sid;
	echo "<br>";
	
	$banner = ads( 0 );
	$print_right = false;
	if (defined ( 'INDEX_FILE' ) or $index == 1) { $print_right=true; }
	if ( ($name=="News") and isset($sid) ){ $print_right=false; }
	if ( ($name=="hoteles")){$print_right=false;}
	if ( $print_right ) {
		$swapblock = "1";		
		imprime_template("themes/$ThemeSel/rightb.html");		    		    
			blocks ( "right" );		    
			//imprime_template("themes/$ThemeSel/rightbb.html");
			$tmpl_file = "themes/$ThemeSel/rightbb.html";
			$thefile = implode("", file($tmpl_file));
			$thefile = addslashes($thefile);
			$thefile = "\$r_file=\"".$thefile."\";";
			eval($thefile);
			print $r_file;
		
	} else {
		//imprime_template("themes/$ThemeSel/center_right.html");	
		$tmpl_file = "themes/$ThemeSel/center_right.html";
		$thefile = implode("", file($tmpl_file));
		$thefile = addslashes($thefile);
		$thefile = "\$r_file=\"".$thefile."\";";
		eval($thefile);
		print $r_file;
	}
	$footer_message = "$foot1<br />$foot2<br />$foot3<br />$foot4";	
	imprime_template("themes/$ThemeSel/footer.html");	
}

/************************************************************/
/* Function themeindex()                                    */
/*                                                          */
/* This function format the stories on the Homepage         */
/************************************************************/

function themeindex ($aid, $informant, $time, $title, $counter, $topic, $thetext, $notes, $morelink, $topicname, $topicimage, $topictext) {
	global $anonymous, $tipath,$ThemeSel;
	if (file_exists("themes/$ThemeSel/images/topics/$topicimage")) {
		$t_image = "themes/$ThemeSel/images/topics/$topicimage";
	} else {
		$t_image = "$tipath$topicimage";
	}
	if (!empty($notes)) {
		$notes = "<br /><br /><b>"._NOTE."</b> <i>$notes</i>\n";
	} else {
		$notes = "";
	}
	if ("$aid" == "$informant") {
		$content = "$thetext$notes\n";
	} else {
		if(!empty($informant)) {
			$content = "<a href=\"modules.php?name=Your_Account&amp;op=userinfo&amp;username=$informant\">$informant</a> ";
		} else {
			$content = "$anonymous ";
		}
		$content .= ""._WRITES." <i>\"$thetext\"</i>$notes\n";
	}
	$posted = ""._POSTEDBY." ";
	$posted .= get_author($aid);
	$posted .= " "._ON." $time $timezone ($counter "._READS.")";
	$tmpl_file = "themes/$ThemeSel/story_home.html";
	$thefile = implode("", file($tmpl_file));
	$thefile = addslashes($thefile);
	$thefile = "\$r_file=\"".$thefile."\";";
	eval($thefile);
	print $r_file;

}

/************************************************************/
/* Function themearticle()                                  */
/*                                                          */
/* This function format the stories on the story page, when */
/* you click on that "Read More..." link in the home        */
/************************************************************/

function themearticle ($aid, $informant, $datetime, $title, $thetext, $topic, $topicname, $topicimage, $topictext) {
	global $admin, $sid, $tipath, $ThemeSel;
	if (file_exists("themes/$ThemeSel/images/topics/$topicimage")) {
		$t_image = "themes/$ThemeSel/images/topics/$topicimage";
	} else {
		$t_image = "$tipath$topicimage";
	}
	$posted = ""._POSTEDON." $datetime "._BY." ";
	$posted .= get_author($aid);
	if (!empty($notes)) {
		$notes = "<br /><br /><b>"._NOTE."</b> <i>$notes</i>\n";
	} else {
		$notes = "";
	}
	if ("$aid" == "$informant") {
		$content = "$thetext$notes\n";
	} else {
		if(!empty($informant)) {
			$content = "<a href=\"modules.php?name=Your_Account&amp;op=userinfo&amp;username=$informant\">$informant</a> ";
		} else {
			$content = "$anonymous ";
		}
		$content .= ""._WRITES." <i>\"$thetext\"</i>$notes\n";
	}
	$tmpl_file = "themes/$ThemeSel/story_page.html";
	$thefile = implode("", file($tmpl_file));
	$thefile = addslashes($thefile);
	$thefile = "\$r_file=\"".$thefile."\";";
	eval($thefile);
	print $r_file;
  
}

/************************************************************/
/* Function themesidebox()                                  */
/*                                                          */
/* Control look of your blocks. Just simple.                */
/************************************************************/

function themesidebox($title, $content) {
	global $swapblock, $name, $ThemeSel;
	if ($swapblock == "1") {
		$tmpl_file = "themes/$ThemeSel/blocks_Right.html";
		if ($name == "News") {
			$tmpl_file = "themes/$ThemeSel/Newsblocks.html";
		}
	} else {
		$tmpl_file = "themes/$ThemeSel/blocks.html";
	}
		
	$thefile = implode("", file($tmpl_file));
	$thefile = addslashes($thefile);
	$thefile = "\$r_file=\"".$thefile."\";";
	eval($thefile);
	print $r_file;
    
}


?>