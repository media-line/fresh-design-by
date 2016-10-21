<?php
/**
 * Akeeba Engine
 * The modular PHP5 site backup engine
 * @copyright Copyright (c)2009-2012 Nicholas K. Dionysopoulos
 * @license GNU GPL version 3 or, at your option, any later version
 * @package akeebaengine
 * @version $Id$
 */

// Protection against direct access
defined('AKEEBAENGINE') or die('Restricted access');

if(!class_exists('AEPlatformJoomla15')) {
	require_once dirname(__FILE__).'/../joomla15/platform.php';
}

if(!defined('DS')) {
	define('DS',DIRECTORY_SEPARATOR); // Still required by Joomla! :(
}

/**
 * Joomla! 2.5 platform class 
 */
class AEPlatformJoomla25 extends AEPlatformJoomla15
{
	/** @var int Platform class priority */
	public $priority = 53;
	
	public $platformName = 'joomla25';
		
	public function getPlatformDirectories()
	{
		return array(
			dirname(__FILE__),
			dirname(__FILE__).'/../joomla15'
		);
	}
	
	/**
	 * Performs heuristics to determine if this platform object is the ideal
	 * candidate for the environment Akeeba Engine is running in.
	 * 
	 * @return bool
	 */
	public function isThisPlatform()
	{
		// We need JVERSION to be defined
		if(!defined('JVERSION')) return false;
		
		return version_compare(JVERSION, '2.5.0', 'ge');
	}
	
	/**
	 * Returns the current timestamp, taking into account any TZ information,
	 * in the format specified by $format.
	 * @param string $format Timestamp format string (standard PHP format string)
	 * @return string
	 */
	public function get_local_timestamp($format)
	{
		jimport('joomla.utilities.date');

		$jregistry = JFactory::getConfig();
		$tzDefault = $jregistry->getValue('config.offset');
		$user = JFactory::getUser();
		$tz = $user->getParam('timezone', $tzDefault);
		
		$dateNow = new JDate('now',$tz);
		
		return $dateNow->toFormat($format);
	}
	
	/**
	 * Returns a list of emails to the Super Administrators
	 * @return unknown_type
	 */
	public function get_administrator_emails()
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery();
		$query->select(array(
				$db->nq('u').'.'.$db->nq('name'),
				$db->nq('u').'.'.$db->nq('email'),
			))
			->from($db->nq('#__users').' AS '.$db->nq('u'))
			->join(
				'INNER', $db->nq('#__user_usergroup_map').' AS '.$db->nq('m').' ON ('.
				$db->nq('m').'.'.$db->nq('user_id').' = '.$db->nq('u').'.'.$db->nq('id')
			)
			->where($db->nq('m').'.'.$db->nq('group_id').' = '.$db->q('8'));
		$db->setQuery($query);
		$superAdmins = $db->loadAssocList();

		$mails = array();
		if(!empty($superAdmins))
		{
			foreach($superAdmins as $admin)
			{
				$mails[] = $admin['email'];
			}
		}

		return $mails;
	}
}