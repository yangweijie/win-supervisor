<?php

namespace app\crontab\crontab;



class Test
{
	static private $number = 0;
	/**
	 * Cron6位：* * * * * *	秒、分、时、天、月、周
	 */
	const CRONTAB = '*/1 * * * * *';
	static	function handle()
	{
		self::$number =  self::$number + 1;
		dump(self::CRONTAB . ' this is Crontab Test ' . date('Y-m-d H:i:s', time()).'----' . self::$number);
	}
}
