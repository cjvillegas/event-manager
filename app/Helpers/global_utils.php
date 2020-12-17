<?php
	/****************************************
	* Methods registered here are global.
	* Make sure to prefix the method with __,
	* just to make sure we avoid conflict.
	*/

	/**
	 * Returns a Carbon Instance in UTC
	 *
	 * @return <Carbon>
	 */
	function __utc_time_now()
	{
	  	date_default_timezone_set('UTC');
            
        return (new \Carbon())->now();
	}	

	/**
	 * Set the timezone to Asia/Manila
	 *
	 * @return <Carbon>
	 */
	function __set_manila_timezone()
	{
		date_default_timezone_set('Asia/Manila');
	}

	/**
	 * Converts a datetime string/object from Asia/Manila timezone to UTC
	 *
	 * @param $datetime <string | object> - the date to convert
	 * @param $format <string> - the format of the returned date
	 * 
	 * @return <string>
	 */
	function __asia_timezone_to_utc($datetime, $format = 'Y-m-d H:i:s')
	{
		if (!$datetime) return null;

        $date = new \DateTime($datetime, new \DateTimeZone('Asia/Manila'));
        $date->setTimeZone(new \DateTimeZone("UTC"));
        $date = $date->format($format);

        return $date;
	}	
?>
