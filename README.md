# phpBB - Display Only First Post Extension
#### Display Only the First Post to specified groups, or display Only the First Post to specified groups and replace replies post's content with custom content

## Installation

Copy the extension to phpBB/ext/w3all/displayonlyfirstpost

Go to "ACP" > "Customise" > "Extensions" and enable the "Display Only First Post" extension.

Then go to "ACP" > "Extensions" > "Display Only First Post" and setup required values.


#### *I want to display custom content in place of the default text!*
Look into file

     /ext/w3all/displayonlyfirstpost/language/en (or your active language)/common.php
   
then change this line

     'DISPLAYONLYFIRSTPOST_EVENT_REPLACEMENT_TEXT'   => '<b>Please register to see this content!</b>',


## License

[GNU General Public License v2](license.txt)
