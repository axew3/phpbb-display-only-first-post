# phpBB - Display Only First Post Extension
##### Display Only the First Post to specified groups, and optionally append a custom content to the post text

## Installation

Copy the extension to phpBB/ext/w3all/displayonlyfirstpost

Go to "ACP" > "Customise" > "Extensions" and enable the "Display Only First Post" extension.

Then go to "ACP" > "Extensions" > "Display Only First Post" and setup required values.


#### *I want to display custom content in place of the default text!*
Look into file

     /ext/w3all/displayonlyfirstpost/language/en (or your active language)/common.php
   
then change this line

     'DISPLAYONLYFIRSTPOST_EVENT_REPLACEMENT_TEXT'   => '<p class="error">You can only view the first post into this topic.<br />Please register or join the memberships allowed to view all the replies!</p>',


## License

[GNU General Public License v2](license.txt)
