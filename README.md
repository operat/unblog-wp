# Unblog WP

A plugin for WordPress that removes blog specific functionality (posts, comments) to run a clean page-based website.

## Description

Occasionally WordPress is used as a CMS for websites that don't need blogging functionality. This plugin removes all blog related features, like the the built-in post type `post` and comments. The plugin works unobstrusively: No data is deleted from the database; all is done by disabling, hiding and redirecting. The plugin is simple by design, because it's meant to be comfortable and fast.

The code is in parts [forked from tonykwon](https://github.com/tonykwon/wp-disable-posts) and [forked from mattclements](https://gist.github.com/mattclements/eab5ef656b2f946c4bfb).

## Installation

1. [Download the plugin](https://github.com/operat/unblog-wp/archive/master.zip)
2. Upload `unblog-wp` folder to `/wp-content/plugins/` directory
3. Activate the plugin in WordPress

To get automatic updates also install the [GitHub Updater](https://github.com/afragen/github-updater) plugin.

## License

The code is available under the [GNU GPLv3 license](LICENSE.md).
