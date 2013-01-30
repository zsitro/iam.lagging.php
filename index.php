<?php 

	/*
	 *
	 * This file is part of the iamLagging package.
	 *
	 * (c) Gabor Zsoter <helo@zsitro.com>
	 * http://zsitro.com
	 *
	 *
	 * ***********************
	 * ***   PARAMETERS    ***
	 * ***********************
	 *
	 *	@param {Integer} lag		- response delay in seconds
	 *	@param {String} response	- response content-type
	 *
	 * 		* html
	 * 		* txt
	 * 		* json
	 * 		* js
	 * 		* css
	 * 		* xml
	 * 		* png
	 * 		* jpg
	 * 		* gif
	 *
	 *	@param {String} status		- response status-code
	 *	 
	 *		* 200, 201 ... 500
	 *	 
	 *	@param {Integer} width		- output image's width in pixels (available only for png,jpg,gif)
	 *	@param {Integer} height		- output image's height in pixels (available only for png,jpg,gif)
	 *	 
	 *	 
	 *
	 * ***********************
	 * *** EXAMPLE USAGES: ***
	 * ***********************
	 *
	 * 	Delay response by 3 seconds
	 *
	 *		?lag=3
	 *
	 *	.. and it should be json
	 *
	 *		?lag=3&response=json
	 *
	 *	.. ohh I need a nifty response status code
	 *
	 *		?lag=3&response=json&status=201
	 *
	 *	.. wait, I rather load a jpg with grumpycat face (without lag)
	 *
	 *		?response=jpg
	 *
	 *	.. thats nice, but I want a 800 x 600 image
	 *
	 *		?response=jpg&width=800&height=600
	 *
	 *
	 * ***********************
	 * ***    INCLUDES     ***
	 * ***********************
	 *
	 * libs/http_response_code.php	from craig at craigfrancis dot co dot uk
	 * libs/resize-class.php		from Jarrod Oberto
	 *
	 *
	 */

	error_reporting(E_ERROR);
	ini_set("display_errors", 1);


	/*
	 * Do not ever try to cache me!
	 */
	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: Mon, 5 Sep 1986 05:00:00 GMT');


	/*
	 * Yaaay, parameters!
	 *
	 * image optional width/height parameters are initialized later on demand
	 */
	$lag	= ctype_digit($_GET['lag']) ?  $_GET['lag'] : 0;
	$status = ctype_digit($_GET['status']) ?  $_GET['status'] : 200;
	$response = !empty($_GET['response']) ?  $_GET['response'] : 'html';
	

	
	/*
	 * Include http_response_code if not loaded
	 */
	if (!function_exists('http_response_code')) {
		require_once 'libs/http_response_code.php';
	}

	
	/*
	 * Set response code
	 */
	http_response_code($status);


	/*
	 * Rest! (in sec)
	 */
	sleep($lag);

	
	/*
	 * If statuscode > 202 then content should not be released
	 * @TODO: Am I wrong || is it okay?
	 */	
	if ($status > 202){
		die();
	}

	
	/*
	 * This will be the output when XML or JSON requested
	 */
	$data = array("status" => 1, "message" => "I'm f_ing lag!");


	/*
	 * Set response header and body
	 */
	switch ($response){

		default:
		case 'html' : {			
			header('Content-type: text/html');
			echo "<DOCTYPE html>I'm f_ing lag!";
			break;
		}

		case 'txt' : {			
			header("Content-Type: text/plain");
			echo "I'm f_ing lag!";
			break;
		}
		
		case 'json' : {			
			header('Content-type: application/json');
			echo json_encode($data);
			break;
		}
		
		case 'js' : {		
			header('Content-type: text/javascript');
			echo "console.log('js response');";
			break;
		}

		case 'css' : {		
			header('Content-type: text/css');
			echo ".iamlag{color:blue}";
			break;
		}
		
		case 'xml' : {		
			header('Content-type: text/xml');
			$xml = new SimpleXMLElement('<response/>');
			array_walk_recursive(array_flip($data), array ($xml, 'addChild'));
			print $xml->asXML();			
			break;
		}
		
		case 'jpg' :
		case 'png' :
		case 'gif' :
		{					
			header('Content-Type: image/jpeg');
			
			require_once "libs/resize-class.php";
			
			$width = !empty($_GET['width']) ?  $_GET['width'] : 200;
			$height = !empty($_GET['height']) ?  $_GET['height'] : 100;
			
			$filename = 'gfx/grumpycat.jpg';
			
			// Initialise / load image
			$resizeObj = new resize($filename);

			// Resize image (options: exact, portrait, landscape, auto, crop)
			$resizeObj -> resizeImage( $width, $height, 'crop');

			// Write image
			$resizeObj -> writeImage('fakename.'.$_GET['response'], 75);
			
			break;
		}
		
		/* bonus */
		case 'htmlwithimage' : {
			header('Content-type: text/html');
			echo "<img src='http://placekitten.com/g/1024/480'>";
			break;
		}
		
	}
