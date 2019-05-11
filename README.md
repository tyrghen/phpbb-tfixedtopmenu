# TFixedTopMenu

## Installation

Copy the extension to phpBB/ext/tyrghen/fixedtopmenu

Go to "ACP" > "Customise" > "Extensions" and enable the "TFixedTopMenu" extension.

Then go to "ACP" > "Extensions" > "TFixedTopMenu" and configure the menu as needed.

## Styling

The topmenu is created using the bootstrap navbar system. In order to have the menu displaying correctly you will need to add bootstrap to your configured styles.

## Example configuration

In order to have a menu, you need to add a line per menu item.
The menu entry is divided in two elements, the display name you'll see on the button and the link it points to.

Example:
Forum rules|https://yourdomain.com/viewtopic.php?f=1&t=2
Last News|https://yourdomain.com/app.php/tnewspage

In order to create a submenu, you need to have an item followed by it's subitems.
Each subitem needs to start with two spaces.

Example:
Forum rules|https://yourdomain.com/viewtopic.php?f=1&t=2
Our founders
  John Smith|https://yourdomain.com/viewtopic.php?f=2&t=1
  Bob Smith|https://yourdomain.com/viewtopic.php?f=2&t=2
Last News|https://yourdomain.com/app.php/tnewspage

## License

[GPLv2](license.txt)
