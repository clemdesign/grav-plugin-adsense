# [![Grav adsense Plugin](assets/logo.png)][project]

## The **Adsense 2** plugin for [Grav](https://getgrav.org) introduces integration of Adsense blocs for your modular page and your page content.

#### Table of Contents:

-   [About](#about)
-   [Installation and Updates](#installation-and-updates)
-   [configuration](#configuration)
-   [Usage](#usage)
-   [Contributing](#contributing)
-   [Credits](#credits)
-   [License](#license)

## About

`AdSense 2` is a plugin for [**Grav**](http://getgrav.org) that let you add Adsense blocs to some place in your modular page and/or page content. 

![Screenshot adsense Plugin](assets/screenshot.png "AdSense Preview")

For modular page, plugin allow user to define default `horizontal`, `vertical` or `square` Ad.

For page content, plugin allow user to define a list of Adsense blocs and integrate it through [Shortcode](https://github.com/getgrav/grav-plugin-shortcode-core).

Development of this version of Adsense plugin is inspirated from [Adsense Grav plugin](https://github.com/muuvmuuv/grav-plugin-adsense) of [Marvin Heilemann](https://github.com/muuvmuuv/).

The following kinds of Adsense are compatible:
- Graphic and Text Ad
- InArticle Ad

## Installation

Installing the `Adsense 2` plugin can be done only in manual installation mode by downloading this one and extracting all files to

    user/plugins/adsense2

## Configuration

Configuration can be done by the **Admin Panel** or by the configuration file `adsense2.yaml` into your `users/config/plugins/` folder:

```yaml
# Global plugin configurations

enabled: true             # Set to false to disable this plugin completely
sandbox: false            # Enables a demo mode for local purpose
built_in_css: true        # Use the default plugin CSS
add_editor_button: true   # Add an Adsense button to Admin panel in order to add Adsense tag template

# Default configurations for AdSense

adsense:
  options:
    mode: "async"        # Code integration mode (either "async" or "sync")
    position: "center"   # Ad position in page (either "center", "left" or "right")

  page_ads:              # Ad blocs for page content
    -                    # List of ad blocs
      id: unique-id                         # Unique Id for the Ad
      client: ca-pub-0000000000000000       # AdSense client
      slot: 0000000000                      # AdSense slot
      type: inarticle                       # Adsense type (either "inarticle" or "normal")
      width: 468                            # Adsense width
      height: 60                            # Adsense height

  modular_ads:          # Ad blocs for modular page (as default)
    horizontal:         # For Horizontal Ad
      client: ca-pub-0000000000000000       # AdSense client
      slot: 0000000000                      # AdSense slot
      width: 728                            # Adsense width
      height: 90                            # Adsense height
    vertical:         # For Vertical Ad
      client: ca-pub-0000000000000000       # AdSense client
      slot: 0000000000                      # AdSense slot
      width: 200                            # Adsense width
      height: 600                           # Adsense height
    square:         # For Square Ad
      client: ca-pub-0000000000000000       # AdSense client
      slot: 0000000000                      # AdSense slot
      width: 300                            # Adsense width
      height: 300                           # Adsense height
```

## Usage

There are many ways to use `Adsense 2` plugin.

### By Shortcode

Using Shortcode allow user to integrate Adsense bloc in page content. There are 2 ways:

- Using unique ID

```md
[adsense id="my-id"][/adsense]
```

It look for the adsense bloc with unique ID  `id` in the configuration list `page_ads` and display the Ad.

- Using specific Adsense informations

```md
[adsense client="adsense-client" slot="adsense-slot" width="adsense-width" height="adsense-height" type="adsense-type"][/adsense]
```

It display the Ad with the tag informations.  
`type` can be :
- `inarticle` for InArticle Ad
- `normal` or _without value_ for Graphic and Text Ad

In case of  InArticle Ad, `width` and `height` is **not** mandatory.

> "Unique ID" have priority on "specific Adsense informations".

> The optional parameter `[class]` can be added to the tag.

### By modular integration

Using modular integration allow user to add default Ad in theming of **Grav** website. User have possibility to choose among 3 kinds of Ad:

- The Horizontal Ad

This way display an Ad in horizontal format by adding the following lines in your theme skeleton:

```twig
{% include 'partials/adsense-horizontal.html.twig' %}
```

Render demo:  
![Grav adsense Plugin in Horizontal](assets/img/sandy_horizontal.png)

- The Vertical Ad

This way display an Ad in vertical format by adding the following lines in your theme skeleton:

```twig
{% include 'partials/adsense-vertical.html.twig' %}
```

Render demo:  
![Grav adsense Plugin in Vertical](assets/img/sandy_vertical.png)

- The Square Ad

This way display an Ad in square format by adding the following lines in your theme skeleton:

```twig
{% include 'partials/adsense-square.html.twig' %}
```

Render demo:  
![Grav adsense Plugin in Square](assets/img/sandy_square.png)

## Contributing

You can contribute at any time but before opening any issue, please search for existing issues.

After that please note:

-   If you find a bug, would like to make a feature request or suggest an improvement, [please open a new issue][issues]. If you have any interesting ideas for additions to the syntax please do suggest them as well!
-   Feature requests are more likely to get attention if you include a clearly described use case.
-   Add images/links/etc so I can help you faster

Thanks!

## Credits

- [Adsense Grav Plugin](https://github.com/muuvmuuv/grav-plugin-adsense) of [Marvin Heilemann](https://github.com/muuvmuuv/)
- [Shortcode Core](https://github.com/getgrav/grav-plugin-shortcode-core)

## License

Copyright (c) 2018 [clemdesign][github].

For use under the terms of the [MIT][mit-license] license.

[github]: https://github.com/clemdesign/ "GitHub account from Clemdesign"

[mit-license]: http://www.opensource.org/licenses/mit-license.php "MIT license"

[project]: https://github.com/clemdesign/grav-plugin-adsense2

[issues]: https://github.com/clemdesign/grav-plugin-adsense2/issues "GitHub Issues for Grav Adsense 2 Plugin"
