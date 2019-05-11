<?php
/**
 *
 * TFixedTopMenu. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Tyrghen, http://tyrghen.armasites.com
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace tyrghen\fixedtopmenu\migrations;

class install_acp_module extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['tyrghen_fixedtopmenu_active']);
	}

	public static function depends_on()
	{
		return array('\phpbb\db\migration\data\v320\v320');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('tyrghen_fixedtopmenu_active', 1)),
			array('config.add', array('tyrghen_fixedtopmenu_debug', 0)),
			array('config.add', array('tyrghen_fixedtopmenu_brand', '')),
			array('config_text.add', array('tyrghen_fixedtopmenu_content', '')),

			array('module.add', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_TFIXEDTOPMENU_TITLE'
			)),
			array('module.add', array(
				'acp',
				'ACP_TFIXEDTOPMENU_TITLE',
				array(
					'module_basename'	=> '\tyrghen\fixedtopmenu\acp\main_module',
					'modes'				=> array('settings'),
				),
			)),
		);
	}
}
