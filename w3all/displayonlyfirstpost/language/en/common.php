<?php
/**
 *
 * Display Only First Post. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2022, axew3, http://axew3.com
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

if (!defined('IN_PHPBB'))
{
  exit;
}

if (empty($lang) || !is_array($lang))
{
  $lang = [];
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, [

  'DISPLAYONLYFIRSTPOST_REP_MODE_HIDE_POST'   => 'Hide the entire post content',
  'DISPLAYONLYFIRSTPOST_REP_MODE_REPLACE'   => 'Replace the post text with custom content',
  'DISPLAYONLYFIRSTPOST_SEP_BYCOMMA'    => ' &nbsp;if more than one, separate by comma',

  //'DISPLAYONLYFIRSTPOST_EVENT'    => ' :: Displayonlyfirstpost Event :: ',

  'DISPLAYONLYFIRSTPOST_EVENT_REPLACEMENT_TEXT'   => '<p class="error">You can only view the first post into this topic.<br />Please register or join the memberships allowed to view and see all the replies!</p>',

  'ACP_DISPLAYONLYFIRSTPOST_GROUPS_IDS'     => 'Users Groups IDS (intended as the user\'s default group) that will see only the first post',
  'ACP_DISPLAYONLYFIRSTPOST_FORUMS_IDS'     => 'Forums IDS that will shown only the first post to the selected groups.<br />If you wish to select all the forums in once, set the word <i style="color:red"><b>all</b></i> as value here, so that this rule will affect all the existent forums',
  'ACP_DISPLAYONLYFIRSTPOST_REP_MODE'     => 'Hide the post content or replace the post text',
  'ACP_DISPLAYONLYFIRSTPOST_SETTING_SAVED'  => 'Settings have been saved successfully!',
  'ACP_DISPLAYONLYFIRSTPOST_NOTES'  => 'Note that the extension is not active until both Users Groups and Forums (IDS) fields are not set<br />To change the text and html output for the <i style="font-size:85%">Replace the post text with custom content</i> option, see the file<br /><i style="font-size:85%">/ext/w3all/displayonlyfirstpost/language/_YourActiveLanguage_/<b>common.php</b></i>',

]);
