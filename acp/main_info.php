<?php
/**
 *
 * TFixedTopMenu. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Tyrghen, http://tyrghen.armasites.com
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace tyrghen\fixedtopmenu\acp;

/**
 * TFixedTopMenu ACP module info.
 */
class main_info
{
	public function module()
	{
		return array(
			'filename'	=> '\tyrghen\fixedtopmenu\acp\main_module',
			'title'		=> 'ACP_TFIXEDTOPMENU_TITLE',
			'modes'		=> array(
				'settings'	=> array(
					'title'	=> 'ACP_TFIXEDTOPMENU',
					'auth'	=> 'ext_tyrghen/fixedtopmenu',
					'cat'	=> array('ACP_TFIXEDTOPMENU_TITLE')
				),
			),
		);
	}
}
