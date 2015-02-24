<?php

/**
 * @package        ats
 * @copyright      2014 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license        GNU GPL version 3 or later
 */
class AtsHelperTime
{
	/**
	 * Returns a fancy formatted time lapse code
	 *
	 * @param  $referenceTime        int        Timestamp of the reference date/time
	 * @param  $currentTime          int        Timestamp of the current date/time
	 * @param  $quantifyBy           string    One of s, m, h, d, or y (time unit)
	 * @param  $autoText             bool
	 *
	 * @return  string
	 */

	/**
	 * @param int    $referenceTime Timestamp of the reference date / time
	 * @param string $currentTime   Timestamp of the current date / time
	 * @param string $quantifyBy    Quantify by unit, one of s (seconds), m (minutes), h (yours), d (days) or y (years)
	 * @param bool   $autoText		Automatically appent text
	 *
	 * @return string
	 */
	public static function timeAgo($referenceTime = 0, $currentTime = '', $quantifyBy = '', $autoText = true)
	{
		if ($currentTime == '')
		{
			$currentTime = time();
		}

		// Raw time difference
		$rawTimeDifference = $currentTime - $referenceTime;
		$absoluteTimeDifference = abs($rawTimeDifference);

		$uomMap = array(
			array('s', 60),
			array('m', 60 * 60),
			array('h', 60 * 60 * 60),
			array('d', 60 * 60 * 60 * 24),
			array('y', 60 * 60 * 60 * 24 * 365)
		);

		$textMap = array(
			's' => array(1, 'COM_ATS_TIME_SECOND'),
			'm' => array(60, 'COM_ATS_TIME_MINUTE'),
			'h' => array(60 * 60, 'COM_ATS_TIME_HOUR'),
			'd' => array(60 * 60 * 24, 'COM_ATS_TIME_DAY'),
			'y' => array(60 * 60 * 24 * 365, 'COM_ATS_TIME_YEAR')
		);

		if ($quantifyBy == '')
		{
			$uom = 's';

			for ($i = 0; $i < count($uomMap); $i++)
			{
				if ($absoluteTimeDifference <= $uomMap[$i][1])
				{
					$uom = $uomMap[$i][0];

					break;
				}
			}
		}
		else
		{
			$uom = $quantifyBy;
		}

		$dateDifference = floor($absoluteTimeDifference / $textMap[$uom][0]);

		$prefix = '';
		$suffix = '';

		if ($autoText == true && ($currentTime == time()))
		{
			if ($rawTimeDifference < 0)
			{
				$prefix = JText::_('COM_ATS_TIME_AFTER_PRE');
				$suffix = JText::_('COM_ATS_TIME_AFTER_POST');
			}
			else
			{
				$prefix = JText::_('COM_ATS_TIME_AGO_PRE');
				$suffix = JText::_('COM_ATS_TIME_AGO_POST');
			}
		}

		if ($prefix)
		{
			$prefix = trim($prefix) . ' ';
		}

		if ($suffix)
		{
			$suffix = ' ' . trim($suffix);
		}

		return $prefix . $dateDifference . ' ' . JText::_($textMap[$uom][1]) . $suffix;
	}
} 