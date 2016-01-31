<?php

	if ( isset ( $_GET [ 'id' ] ) && trim ( $_GET [ "id" ] ) == 'working' ) {
		$handbookFile = 'working.htm';
	} else {
		$handbookFile = 'current-version.htm';
	}	

	$input = new DOMDocument();
	$input -> loadHTMLFile ( $handbookFile );


	$menu = $input -> createElement ( "ul" );
	$menu -> setAttribute ( "id", "anchor-menu" );


	$content = $input -> getElementByID ( "content" );


	$lastMenuItem = null;
	$subMenu = null;
	foreach ( $content -> childNodes as $child ) {
		if( $child -> nodeName == 'h3' ) {
			$li = $input -> createElement ( "li" );
			$anchor = $input -> createElement ( "a", $child-> nodeValue );
			$anchor -> setAttribute ( 'href', "#" . $child->getAttribute ( 'id' ) );

			$li -> appendChild ( $anchor );
			$menu -> appendChild ( $li ); 

			$lastMenuItem = $li;
			$subMenu = null;
		}
		
		if( $child -> nodeName == 'h4' ) {
			$li = $input -> createElement ( "li" );
			$anchor = $input -> createElement ( "a", $child-> nodeValue );
			$anchor -> setAttribute ( 'href', "#" . $child->getAttribute ( 'id' ) );

			$li -> appendChild ( $anchor );

			if ( $subMenu == null ) {
				$subMenu = $input -> createElement ( "ul" );
				$lastMenuItem -> appendChild ( $subMenu );
			}
			
			$subMenu -> appendChild ( $li ); 
		}
	}
	$menuHeader = $input -> createElement ( "h2" );
	$menuHeader -> setAttribute ( "id", "menu-header" );
	$menuHeader -> nodeValue = 'Navigation';
	$menuTag = $input -> getElementByID ( "nav-anchor-menu" );
	$menuTag -> appendChild ( $menuHeader );
	$menuTag -> appendChild ( $menu );

	print $input -> saveHTML();

?>
