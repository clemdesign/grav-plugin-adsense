<?php

namespace Grav\Plugin\Shortcodes;

use Thunder\Shortcode\Shortcode\ShortcodeInterface;

class AdSenseShortcode extends Shortcode
{
  public function init()
  {
    $this->shortcode->getHandlers()->add('adsense', function (ShortcodeInterface $sc) {

      $hash   = $this->shortcode->getId($sc);
      $adid   = $sc->getParameter("id");

      $class  = $sc->getParameter('class');

      /* Ad defined by user by integration code */
      $client = $sc->getParameter('client');
      $slot   = $sc->getParameter('slot');
      $type   = $sc->getParameter('type');
      $width  = intval($sc->getParameter('width'));
      $height = intval($sc->getParameter('height'));

      /** Load an Ad according the unique ID */
      if(!empty($adid) && isset($this->twig->twig_vars['adsense_page_ads'][$adid])){
        $params = $this->twig->twig_vars['adsense_page_ads'][$adid];

        $output = $this->twig->processTemplate('partials/adsense.html.twig', array(
          'adsense_hash'    => $hash,
          'adsense_mode'    => $this->twig->twig_vars['adsense_mode'],
          'adsense_position'=> $this->twig->twig_vars['adsense_position'],
          'adsense_client'  => $params["client"],
          'adsense_slot'    => $params["slot"],
          'adsense_height'  => $params["height"],
          'adsense_width'   => $params["width"],
          'adsense_type'    => $params["type"],
          'adsense_format'  => $this->getFormat($params["width"], $params["height"]),
          'adsense_class'   => $class,
        ));

        return $output;

        /** Load an Ad defined by user through integration shortcode */
      } elseif(isset($client) && strlen($client)>3 &&
                isset($slot) && intval($slot)>0 &&
                (($height>0 && $width>0) || (isset($type) && ($type == "inarticle" || $type == "normal")))){

        $output = $this->twig->processTemplate('partials/adsense.html.twig', array(
          'adsense_hash'    => $hash,
          'adsense_mode'    => $this->twig->twig_vars['adsense_mode'],
          'adsense_position'=> $this->twig->twig_vars['adsense_position'],
          'adsense_client'  => $client,
          'adsense_slot'    => $slot,
          'adsense_height'  => $height,
          'adsense_width'   => $width,
          'adsense_type'    => $type,
          'adsense_format'  => $this->getFormat($width , $height),
          'adsense_class'   => $class,
        ));

        return $output;
      }

      return null;
    });
  }

  /**
   * Return format for sandy box
   * @param $width
   * @param $height
   * @return string
   */
  private function getFormat($width, $height){
    if($width > $height) {
      return "horizontal";
    } else if(abs($width - $height) < 100){
      return "square";
    } else {
      return "vertical";
    }
  }
}
