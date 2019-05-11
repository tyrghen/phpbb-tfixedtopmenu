<?php

/**
 *
 * TFixedTopMenu. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) phpBB Limited, https://www.phpbb.com
 * @copyright (c) 2018, kasimi, https://kasimi.net
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace tyrghen\fixedtopmenu\event;

use phpbb\auth\auth;
use phpbb\collapsiblecategories\operator\operator as cc_operator;
use phpbb\config\config;
use phpbb\db\driver\driver_interface as db_interface;
use phpbb\config\db_text;
use phpbb\event\data;
use phpbb\event\dispatcher_interface;
use phpbb\language\language;
use phpbb\request\request_interface;
use phpbb\template\template;
use phpbb\controller\helper;
use phpbb\user;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	/** @var user */
	protected $user;

	/** @var language */
	protected $lang;

	/** @var auth */
	protected $auth;

	/** @var request_interface */
	protected $request;

	/** @var config */
	protected $config;

	/** @var \phpbb\config\db_text */
	protected $config_text;

	/** @var template */
	protected $template;

	/** @var dispatcher_interface */
	protected $dispatcher;

	/** @var \phpbb\controller\helper */
	protected $helper;

	/**
	 * @param template $template
	 */
	public function __construct(
		user $user,
		language $lang,
		auth $auth,
		request_interface $request,
		config $config,
		db_text $config_text,
		template $template,
		dispatcher_interface $dispatcher,
		helper $helper
	)
	{
		$this->user			= $user;
		$this->lang			= $lang;
		$this->auth			= $auth;
		$this->request		= $request;
		$this->config		= $config;
		$this->config_text	= $config_text;
		$this->template		= $template;
		$this->dispatcher	= $dispatcher;
		$this->helper   	= $helper;
	}

	/**
	 * @return array
	 */
	public static function getSubscribedEvents()
	{
		return [
		 	'core.page_header'							=> 'add_page_header_menu',
		];
	}

	/**
	 *
	 */
	public function add_page_header_menu()
	{
		$l_debug = array();

		$l_menuitems = array();
		$menu_string = $this->config_text->get('tyrghen_fixedtopmenu_content');
		$l_debug[] = "MENU String\n" . $menu_string;

		if ($menu_string) {
			$lines = preg_split( '/\r\n|\r|\n/', $menu_string);
			$l_debug[] = "MENU lines\n" . print_r($lines,true);
			if ($lines && count($lines))
			{
				foreach ($lines as $line)
				{
					$entry = array();
					if ($line)
					{
						$items = explode('|', $line);
						if (count($items))
						{
							$entry["name"] = trim($items[0]);
							$entry["link"] = '';
							$entry["active"] = 0;
							$entry["subitems"] = array();
							if (count($items) > 1)
							{
								$entry["link"] = trim($items[1]);
								$entry["active"] = ($entry["link"] && stripos($this->helper->get_current_url(), $entry["link"]) === 0) ? 1 : 0;
							}
							$l_debug[] = "Link match\n" . print_r(array(
								$entry["link"],
								$this->helper->get_current_url(),
								stripos($this->helper->get_current_url(), $entry["link"]),
							),true);
							// Checking for the special case of a submenu
							if (count($l_menuitems) && strpos($items[0],"  ") === 0)
							{
								$parent_item = $l_menuitems[count($l_menuitems) - 1];
								$parent_item["active"] = max($entry["active"],$parent_item["active"]);
								$children = $parent_item["subitems"];
								$children[] = $entry;
								$parent_item["subitems"] = $children;
								$l_menuitems[count($l_menuitems) - 1] = $parent_item;
							}
							else
							{
								$l_menuitems[] = $entry;
							}
						}
					}
				}
			}
			$l_debug[] = "MENU Items\n" . print_r($l_menuitems,true);
		}

		$this->template->assign_vars(array(
			'topmenu_items'	=> $l_menuitems,
			'topmenu_brand' => $this->config['tyrghen_fixedtopmenu_brand'],
		));

		if ($this->config['tyrghen_fixedtopmenu_debug'])
		{
			$this->template->assign_vars(array(
				'topmenu_debug'	=> implode("\n",$l_debug),
			));
		}
	}
}
