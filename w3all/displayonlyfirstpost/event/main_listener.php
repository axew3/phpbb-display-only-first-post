<?php
/**
 *
 * Display Only First Post. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2022, axew3, http://axew3.com
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace w3all\displayonlyfirstpost\event;

/**
 * @ignore
 */
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Display Only First Post Event listener.
 */
class main_listener implements EventSubscriberInterface
{
  public static function getSubscribedEvents()
  {
    return [
     'core.user_setup'  => 'load_language_on_setup',
     'core.viewtopic_modify_post_data' => 'viewtopic_modify_post_data',
    ];
  }

  protected $config;
  protected $language;
  //protected $user;

  /**
   * Constructor
   *
   * @param \phpbb\language\language  $language Language object
   */
  //public function __construct(\phpbb\config\config $config, \phpbb\language\language $language, \phpbb\user $user)
  public function __construct(\phpbb\config\config $config, \phpbb\language\language $language)
  {
    $this->config = $config;
    $this->language = $language;
    $this->gid = $this->uid = 1; // guests, anonymous
    $this->user_type = 0; // 1 == deactivated in phpBB
    //$this->user = $user;
  }

  /**
   * Load common language files during user setup
   *
   * @param \phpbb\event\data $event  Event object
   */
  public function load_language_on_setup($e)
  {

    $this->gid = $e['user_data']['group_id'];
    $this->uid = $e['user_data']['user_id'];
    $this->user_type = $e['user_data']['user_type'];

    $lang_set_ext = $e['lang_set_ext'];
    $lang_set_ext[] = [
      'ext_name' => 'w3all/displayonlyfirstpost',
      'lang_set' => 'common',
    ];
    $e['lang_set_ext'] = $lang_set_ext;
  }

  public function viewtopic_modify_post_data($e)
  {

   // if one or both settings on ACP are empty, ignore
   if( !empty($this->config['w3all_displayonlyfirstpost_u_groups']) && !empty($this->config['w3all_displayonlyfirstpost_forums_ids']) )
   {

     $u_groups = explode(",", $this->config['w3all_displayonlyfirstpost_u_groups']);
     $forums_ids = explode(",", $this->config['w3all_displayonlyfirstpost_forums_ids']);

     if( is_array($u_groups) && is_array($forums_ids) )
     {
       // if the user is deactivated, or belong to one of the groups and the specified forum result to be on list, or the forums ids settings contains the word 'all' (all forums)
       if ( $this->user_type == 1 OR in_array($this->gid, $u_groups) && in_array($e['forum_id'], $forums_ids) OR in_array($this->gid, $u_groups) && in_array('all', $forums_ids) )
       {

        $fpid = $e['topic_data']['topic_first_post_id'];
        //$tempRW = $e['rowset'];

        if( !in_array($fpid, $e['post_list']) ) // * the requested posts ids array do not contain the topic's first_post_id : then redirect to the topic first page, and show only the first post at next request
        {
          global $phpbb_root_path,$phpEx; // may should be added before and not declared as globals here?
          // * here we go
          redirect(append_sid("{$phpbb_root_path}viewtopic.$phpEx?t=".$e['topic_id']));
        }

        $tempRW[$fpid] = $e['rowset'][$fpid];

       if( $this->config['w3all_displayonlyfirstpost_rep_mode'] > 0 )
       {
        if( !empty($this->config['w3all_displayonlyfirstpost_rep_content']) )
        {
         $tempRW[$fpid]['post_text'] = html_entity_decode($this->config['w3all_displayonlyfirstpost_rep_content'], ENT_SUBSTITUTE) . $tempRW[$fpid]['post_text'];
        } else {
            $tempRW[$fpid]['post_text'] = $this->language->lang('DISPLAYONLYFIRSTPOST_EVENT_REPLACEMENT_TEXT') . $tempRW[$fpid]['post_text'];
          }
       }

      if(!empty($tempRW)){
        $e['rowset'] = $tempRW;
      }
        unset($tempRW);

       }
      }
     }

  } // END viewtopic_modify_post_data
}
