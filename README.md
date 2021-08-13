# led_raspberry

## Class for manage directly leds on raspberry pi in PHP

We can access GPIO ports directly with fwrite() for power on|off leds, without use shell_exec() function. The result is a fasted library to access GPIO ports. This one is written to manage LEDS, but with a litlle changes you can use it for other components (buttons, relay, ....)
 
 # REQUERIMENTS:
 
 - A minimum (minimum, minimum, minimum requeriments is needed). Tested on:
 		
    - Simple Raspberry pi (B +	512MB	700 MHz ARM11) with Raspbian Lite PHP7.3 (i love this gadgets)  :heart_eyes:
 
 
  # FILES:
 There are 2 files:
 
 *led.class.php* -> **Master class**. This file is the main file that you need to include in your code.
 
 *example.php* -> **Code with example use of the class**
 
 
 # INSTALLATION:
 A lot of easy :smiley:. It is written in PURE PHP. Only need to include the files. Tested on basic PHP installation
 
         require_once( 'led.class.php' );
 
 # BASIC USAGE:
 
 - Create the variable with led class on GPIO 18:
 
        $Led18 = new Led( '18' );
 
 
 - Power ON GPIO led 18:

        $Led18->On();
        
 - Power OFF GPIO led 18:

        $Led18->Off();
 
 - Unexport GPIO port 18:

        $Led18->unexport();
 
# RESUME OF METHODS:


**CREATE LED ON GPIO PORT 'X':**

- You can pass $fpUnexport & $fpExport file handles if you have more than 1 led. In this way, only 1 file will be openned for Export and Unexport. If not params given, every led will open and close individually files for export and unexport. With $fpUnexport & $fpExport params yo will get a better performance.

Without file handles:

         $Led18 = new Led( '18' ); // Without file handles

With file handles:

         $fpUnexport = fopen( '/sys/class/gpio/unexport', 'w' );
         $fpExport   = fopen( '/sys/class/gpio/export', 'w' );
         
         $Led18      = new Led( '18', $fpUnexport, $fpExport); // With file handles
         
         // Remember do Unexport & close files at the end of your code
         $Led18->unexport();
         
         fclose( $fpUnexport );
         fclose( $fpExport );

**Power ON led:**

         $Led18->On();
 
 
**Power OFF led:**

         $Led18->Off();
 
 
**Unexport GPIO PORT:**

         $Led18->unexport();

 
 **Of course. You can use it freely :vulcan_salute::alien:**
 
 By Rafa.
 
 
 @author Rafael Martin Soto
 
 @author {@link http://www.inatica.com/ Inatica}
 
 @blog {@link https://rafamartin10.blogspot.com/ Rafael Martin's Blog}
 
 @since July 2021
 
 @version 1.0.0
 
 @license GNU General Public License v3.0
