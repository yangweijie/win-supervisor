<?php
	/**
	 * Created by PhpStorm.
	 * User: mybook-lhp
	 * Date: 18/4/12
	 * Time: 下午2:50
	 */

	namespace app\common\traits;

	trait Instance
	{
		static protected $Instance = null;

		static public function Instance(...$params)
		{
			if (static::$Instance === null)
			{
				static::$Instance = new static($params);
			}
			return static::$Instance;
		}
	}