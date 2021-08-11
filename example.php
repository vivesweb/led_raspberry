<?php


/** Example of use led class
 * BLINK 2 LEDS EVERY SECOND. ONLY 1 IS ON AT A TIME FOR 10 TIMES.
 *
 * Class for get direct access to GPIO ports on a Raspberry pi with PHP. Made through fwrite() function
 * 
 * 
 * @author Rafael Martin Soto
 * @author {@link http://www.inatica.com/ Inatica}
 * @blog {@link https://rafamartin10.blogspot.com/ Rafa Martin's blog}
 * @since July 2021
 * @version 1.0.1
 * @license GNU General Public License v3.0 *
*/


include( 'led.class.php' );

// Get de file handle for Export & unexport

$fpUnexport = fopen( '/sys/class/gpio/unexport', 'w' );
$fpExport 	= fopen( '/sys/class/gpio/export', 'w' );

$Led18 = new Led( '18', $fpUnexport, $fpExport);
$Led23 = new Led( '23', $fpUnexport, $fpExport);

fclose( $fpExport ); // No need Export file handle more
unset( $fpExport );


for($i=0;$i<10;$i++){
	if($i%2 == 0){
		$Led18->On();
		$Led23->Off();
	} else {
		$Led18->Off();
		$Led23->On();
	}

	sleep(1);
}

// Power off leds
$Led18->Off();
$Led23->Off();

// Unexport leds
$Led18->unexport();
$Led23->unexport();

fclose($fpUnexport); // close file handle unexport

// Free Mem
unset( $Led18 );
unset( $Led23 );
unset( $i );
unset( $fpUnexport );
?>