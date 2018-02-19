<?php
/**
 * This plugin enables to use AdSense inside a document
 * to be rendered by Grav.
 *
 * Licensed under the MIT Version 4 licenses, see LICENSE.
 * http://cookie-soft.de/license
 *
 * @since       1.1.0
 *
 * @see         https://github.com/muuvmuuv/grav-plugin-adsense
 *
 * @author      Marvin Heilemann <marvin.heilemann@cookie-soft.de>
 * @copyright   2015, Marvin Heilemann
 * @license     http://opensource.org/licenses/MIT
 */

namespace Grav\Plugin;

use Grav\Common\Plugin;
use Grav\Common\Page\Page;
use Grav\Common\Twig\Twig;
use RocketTheme\Toolbox\Event\Event;

/**
 * AdSensePlugin.
 *
 * This plugin enables to use AdSense inside a document
 * to be rendered by Grav.
 */
class AdSense2Plugin extends Plugin
{
  /**
   * Return a list of subscribed events.
   *
   * @return array a list of events
   */
  public static function getSubscribedEvents()
  {
    return [
      'onPluginsInitialized' => ['onPluginsInitialized', 1],
    ];
  }

  /**
   * Initialize configuration.
   */
  public function onPluginsInitialized()
  {
    if ($this->isAdmin()) {
      $this->active = false;

      return;
    }

    if ($this->config->get('plugins.adsense2.enabled')) {
      $this->enable([
        'onShortcodeHandlers' => ['onShortcodeHandlers', 0],
        'onPageContentRaw' => ['onPageContentRaw', 0],
        'onTwigSiteVariables' => ['onTwigSiteVariables', 0],
        'onTwigTemplatePaths' => ['onTwigTemplatePaths', 0],
      ]);
    }
  }

  /**
   * Initialize shortcode.
   */
  public function onShortcodeHandlers()
  {
    $this->grav['shortcode']->registerAllShortcodes(__DIR__.'/shortcodes');
  }

  /**
   * Add content after page content was read into the system.
   *
   * @param Event $event an event object, when `onPageContentRaw` is fired
   */
  public function onPageContentRaw(Event $event)
  {
    /** @var Page $page */
    $page = $event['page'];

    /** @var Twig $twig */
    $twig = $this->grav['twig'];

    $ads_config = $this->config->get("plugins.adsense2.adsense");

    /* Set twig vars */
    $twig->twig_vars['adsense_sandy']     = $this->config->get('plugins.adsense2.sandbox');
    $twig->twig_vars['adsense_position']  = isset($ads_config["options"]["position"]) ? $ads_config["options"]["position"]: "center";

    // Page ads
    $ad = array();
    if(isset($ads_config["page_ads"]) && is_array($ads_config["page_ads"])) {
      foreach($ads_config["page_ads"] as $value){
        if(isset($value["id"]) && strlen($value["id"])>3
          && isset($value["client"])  && strlen($value["client"])>3
          && isset($value["slot"]) && $value["slot"]>3 ) {

          $ad[$value["id"]]["client"] = $value["client"];
          $ad[$value["id"]]["slot"]   = $value["slot"];
          $ad[$value["id"]]["type"]   = $value["type"];
          $ad[$value["id"]]["height"] = isset($value["height"]) ? intval($value["height"]): 90;
          $ad[$value["id"]]["width"]  = isset($value["width"]) ? intval($value["width"]): 728;
        }
      }
    }
    $twig->twig_vars['adsense_page_ads'] = $ad;

    // Default Modular Ads
    if(isset($ads_config["modular_ads"])) {
      // Horizontal
      if(isset($ads_config["modular_ads"]["horizontal"])) {
        $modular_ad = $ads_config["modular_ads"]["horizontal"];
        if(isset($modular_ad["client"]) && strlen($modular_ad["client"])>3 &&
          isset($modular_ad["slot"]) && intval($modular_ad["slot"])>0 &&
          isset($modular_ad["width"]) && intval($modular_ad["width"])>0 &&
          isset($modular_ad["height"]) && intval($modular_ad["height"])>0) {
          $twig->twig_vars['adsense_default_horizontal_client'] = $modular_ad["client"];
          $twig->twig_vars['adsense_default_horizontal_slot'] = $modular_ad["slot"];
          $twig->twig_vars['adsense_default_horizontal_width'] = $modular_ad["width"];
          $twig->twig_vars['adsense_default_horizontal_height'] = $modular_ad["height"];
        } else {
          $twig->twig_vars['adsense_default_horizontal_client'] = null;
        }
      }
      // Vertical
      if(isset($ads_config["modular_ads"]["vertical"])) {
        $modular_ad = $ads_config["modular_ads"]["vertical"];
        if(isset($modular_ad["client"]) && strlen($modular_ad["client"])>3 &&
          isset($modular_ad["slot"]) && intval($modular_ad["slot"])>0 &&
          isset($modular_ad["width"]) && intval($modular_ad["width"])>0 &&
          isset($modular_ad["height"]) && intval($modular_ad["height"])>0) {
          $twig->twig_vars['adsense_default_vertical_client'] = $modular_ad["client"];
          $twig->twig_vars['adsense_default_vertical_slot'] = $modular_ad["slot"];
          $twig->twig_vars['adsense_default_vertical_width'] = $modular_ad["width"];
          $twig->twig_vars['adsense_default_vertical_height'] = $modular_ad["height"];
        } else {
          $twig->twig_vars['adsense_default_vertical_client'] = null;
        }
      }
      // Square
      if(isset($ads_config["modular_ads"]["square"])) {
        $modular_ad = $ads_config["modular_ads"]["square"];
        if(isset($modular_ad["client"]) && strlen($modular_ad["client"])>3 &&
          isset($modular_ad["slot"]) && intval($modular_ad["slot"])>0 &&
          isset($modular_ad["width"]) && intval($modular_ad["width"])>0 &&
          isset($modular_ad["height"]) && intval($modular_ad["height"])>0) {
          $twig->twig_vars['adsense_default_square_client'] = $modular_ad["client"];
          $twig->twig_vars['adsense_default_square_slot'] = $modular_ad["slot"];
          $twig->twig_vars['adsense_default_square_width'] = $modular_ad["width"];
          $twig->twig_vars['adsense_default_square_height'] = $modular_ad["height"];
        } else {
          $twig->twig_vars['adsense_default_square_client'] = null;
        }
      }
    }


    //Mode
    if($this->config->get('plugins.adsense2.sandbox')) {
      $twig->twig_vars['adsense_mode'] = "sandy";
    } else {
      $twig->twig_vars['adsense_mode'] = isset($ads_config["options"]["mode"]) ? $ads_config["options"]["mode"]: "async";
    }


  }

  /**
   * Add style and script to page.
   */
  public function onTwigSiteVariables()
  {
    /* adding the style to the assets */
    $this->grav['assets']->addCss('plugin://adsense2/assets/css/adsense.css');
  }

  /**
   * Add current directory to twig lookup paths.
   */
  public function onTwigTemplatePaths()
  {
      $this->grav['twig']->twig_paths[] = __DIR__.'/templates';
  }
}
