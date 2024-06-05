<?php

namespace util;

class Mask
{
	const CARD = 1;     //身份证
	const PHONE = 2;    //手机号
	const NAME = 3;     //姓名

	/**
	 * Notes: 脱敏格式化字符串
	 * @param string $str 需要脱敏字符
	 * @param $type 内容类型
	 * @return mixed|string
	 */
	static	private function formatData($str, $type)
	{
		$res = '';
		if (empty($str) || empty($type)) {
			return $res;
		}

		$len = strlen($str);
		switch ($type) {
			case self::CARD:
				$res = substr_replace($str, str_repeat('*', ($len - 8)), 6, $len - 8);
				break;
			case self::PHONE:
				$res = substr_replace($str, str_repeat('*', ($len - 7)), 7, $len - 7);
				break;
			case self::NAME:
				$res = static::formatName($str);
				break;
			default:
				$res = $str;
				break;
		}
		return $res;
	}

	/**
	 * Notes: 批量脱敏格式化数据
	 * @param array $data 格式化字符数组
	 * @param $type 内容类型
	 * @return array|mixed
	 */
	static	private function bacthFormatData($data, $type)
	{
		$ret = [];
		if (empty($data) || !is_array($data) || empty($type)) {
			return $ret;
		}

		switch ($type) {
			case self::CARD:
				foreach ($data as $item) {
					$len = strlen($item);
					$ret[$item] = substr_replace($item, str_repeat('*', ($len - 8)), 6, $len - 8);
				}
				break;
			case self::PHONE:
				foreach ($data as $item) {
					$len = strlen($item);
					$ret[$item] = substr_replace($item, str_repeat('*', ($len - 7)), 3, $len - 7);
				}
				break;
			case self::NAME:
				foreach ($data as $item) {
					$ret[$item] = static::formatName($item);
				}
				break;
			default:
				$ret = $data;
				break;
		}
		return $ret;
	}


	/**
	 * Notes:脱敏格式化名称
	 * @param $str 需要脱敏字符
	 * @return mixed|string
	 */
	static	private function formatName($str)
	{
		$res = '';
		if (empty($str)) {
			return $res;
		}

		$len = mb_strlen($str);
		$res = $str;
		if ($len == 2) {
			$res = static::stringTrim($res, '*', 0, 1);
		} elseif ($len == 3) {
			$res = static::stringTrim($res, '*', 0, 1, 1, 1);
		} elseif ($len > 3 && $len <= 6) {
			$res = static::stringTrim($res, '*', 0, 1, 2, 2);
		} elseif ($len > 6) {
			$res = static::stringTrim($res, '*', 0, 2, 3, 3);
		}
		return $res;
	}


	/**
	 * Notes:中文脱敏替换
	 * @param $str 脱敏字符
	 * @param string $replace 替换字符
	 * @param int $start 头部位置
	 * @param int $startLen 头部替换长度
	 * @param int $end 尾部位置
	 * @param int $endLen 尾部替换长度
	 * @return string
	 */
	static	private function stringTrim($str, $replace = '*', $start = 0, $startLen = 0, $end = 0, $endLen = 0)
	{
		$str = mb_substr($str, $start, $startLen) . str_repeat($replace, (mb_strlen($str) - ($startLen + $endLen))) . mb_substr($str, -$end, $endLen);
		return $str;
	}


	/**
	 * Notes:数据脱敏格式化
	 * @param array|string $datas 需要格式化的数据内容
	 * @param int $type 内容类型 1：身份证，2：手机号，3：姓名
	 * @return array|mixed|string|string[]
	 */
	static	public function dataMark($datas, $type = self::NAME)
	{
		if (!is_array($datas)) {
			return static::formatData($datas, $type);
		}
		return static::bacthFormatData($datas, $type);
	}
}


// //调用测试demo
// $mask = new Mask();
// $name = '我是中文名称';
// $card = '333333333333333333';
// $phone = '15012345678';

// $names = ['我是中文名称1', '我是中文名称2'];
// $cards = ['333333333333333333', '222222222222222222'];
// $phones = ['15012345678', '13012345678'];

// echo "<pre>";

// echo $mask->dataMark($card, 1)."</br>";
// echo $mask->dataMark($phone, 2)."</br>";
// echo $mask->dataMark($name, 3)."</br>";

// print_r($mask->dataMark($cards, 1));
// print_r($mask->dataMark($phones, 2));
// print_r($mask->dataMark($names, 3));

// echo "</pre>"; 