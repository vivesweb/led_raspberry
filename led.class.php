<?php

/** led class
 *
 * Class for get direct access to GPIO ports on a Raspberry pi with PHP. Made through fwrite() function
 * 
 * 
 * @author Rafael Martin Soto
 * @author {@link http://www.inatica.com/ Inatica}
 * @blog {@link https://rafamartin10.blogspot.com/ Rafa Martin's blog}
 * @since July 2021
 * @version 1.0.1
 * @license GNU General Public License v3.0
 *
 *
 * Docs original for write GPIO through FILES: https://www.ics.com/blog/gpio-programming-using-sysfs-interface
 *
 * List GPIO'S: 						ls /sys/class/gpio/
 * Export GPIO 24:						echo 24 >/sys/class/gpio/export
 * Set in/out direction GPIO 24:		echo in >/sys/class/gpio/gpio24/direction
 *										echo out >/sys/class/gpio/gpio24/direction
 * Get direction GPIO 24:				cat /sys/class/gpio/gpio24/direction 
 * Set 1/0 value GPIO 24:				echo 0 >/sys/class/gpio/gpio24/value
 *										echo 1 >/sys/class/gpio/gpio24/value
 * Get value GPIO 24:					cat /sys/class/gpio/gpio24/value
 * Unexport GPIO 24:					echo 24 >/sys/class/gpio/unexport
 *
*/

define('_LED_ON', 	'1');
define('_LED_OFF', 	'0');


/* ******************** *
 *	CLASS LED			*
 * ******************** */

class Led
{
    private $GpioNumber 	= null;
	private $fpUnexport 	= null;
	private $fpWriteValue 	= null;


	/**
	 * Led CONSTRUCT
	 *
	 * Required:
	 * - $lGpioNumber
	 
	 * Optional:
	 * - $fpUnexport
	 * - $fpExport
	 *
	 * @param string $GpioNumber
	 * @param file pointer $fpUnexport
	 * @param file pointer $fpExport
	 */
	public function __construct($GpioNumber, $fpUnexport = null, $fpExport = null) {
		$this->GpioNumber = (string)$GpioNumber;

		$this->$fpUnexport = $fpUnexport; // Save it to use at the end of the use

		// Sometimes, if you are doing tests, is better to unexport before do an export
		// $this->Unexport( ); // Unexport

		$this->fExport( $fpExport ); // Export

		$this->fSetGPIODirection( 'out' ); // GPIO => Out

		$this->fpWriteValue = fopen( '/sys/class/gpio/gpio'.$this->GpioNumber.'/value', 'w' ); // Get file pointer to access the GPIO port led
	}

		
	/**
	 * Led __destruct
	 *
	 */
    public function __destruct( ) {
		fclose($this->fpWriteValue); // close the file handler to read and write GPIO port
	} // /__destruct()



	/**
	 * Power ON led
	 *
	 */
	public function On(){
		$this->fWriteValueLed( _LED_ON );
	} // /On()
	
	
	/**
	 * Power OFF led
	 *
	 */
	public function Off(){
		$this->fWriteValueLed( _LED_OFF );
	} // /Off()


	/**
	 * Export GPIO port
	 *
	 */
	private function fExport( $fp ){
		$privateFp = ( ($fp)?$fp: fopen('/sys/class/gpio/export', 'w') );

		fwrite ( $privateFp, $this->GpioNumber);

		if( !$fp ){
			fclose( $privateFp );
		}
		
		unset( $privateFp );
	} // /fExport()


	/**
	 * UnExport GPIO port
	 *
	 */
	private function Unexport( ){
		$privateFp = ( ($this->fpUnexport)?$this->fpUnexport: fopen('/sys/class/gpio/unexport', 'w') );

		fwrite ( $privateFp, $this->GpioNumber);

		if( !$this->fpUnexport ){
			fclose( $privateFp );
		}

		unset( $privateFp );
	} // /Unexport()
	
	
	/**
	 * Set direction of the GPIO port
	 *
	 * @param string $Direction ['in'|'out']
	 */
	private function fSetGPIODirection( $Direction = 'out' ){
		$fp = fopen( '/sys/class/gpio/gpio'.$this->GpioNumber.'/direction', 'w' );
		fwrite ( $fp, $Direction );
		fclose( $fp );

		unset( $fp );
	} // /fSetGPIODirection()
	
	
	/**
	 * Write a value to the GPIO port
	 *
	 * @param string $value ['0'|'1']
	 */
	private function fWriteValueLed( $value = _OFF ){
		fwrite ( $this->fpWriteValue, $value );
	} /// /fWriteValueLed()
}
?>