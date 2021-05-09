####################################################
#--------- WELCOME TO NATIVE PARENT THEME ---------#
-------------------- ***** -------------------------
#------------ Official documentation --------------#
####################################################

This is a partial documentation. We'll be completed soon!

Native is a free parent theme to use as a framework or as a base for child theme of your upcoming projects. It was thought to be a solid foundation for wordpress themes while remaining lightweight and versatile thanks to the few essential features included.
Native uses HTML close tag and not XHTML ones. So a breakpoint would be written <br> and not <br />.
You can use XHTML syntax anyway but the MIME type must be set to XML. Pay attention that XML has strict validation rules.
Native is also responsive and adapts to most of the mobile devices currently in use.
Native is using Genericon Icon Set by Automattic (http://genericons.com) freely distributed under the GPL license.

##############
Supports:

 * Custom Background
   with image upload and selection background color
 * Custom Header
   with image upload
 * Custom Menus
        top menu, suitable for general entries and information
        main menu, the menu that contains the main items of the site
 * Four widget
        a side widget
        three widgets in the footer and placed horizontally structured into three columns
 * Location
   or the translation of the theme in multiple languages. Native currently supports:
        English
        Italian

##############
Structure
-------------
The file structure of the theme differs slightly from the basic one provided by wordpress.org, but simply as a matter of order. Below is a list of files and folders related to Native explanation.

 * ASSETS/
 * CUSTOMS/
 * INCLUDES/
 * LANG/
 * TEMPLATES/
 * style.css
 * changelog.txt
 * license.txt
 * readme.txt
 * screenshot.png
 * 404.php
 * comments.php
 * footer.php
 * functions.php
 * header.php
 * index.php
 * loop.php
 * sidebar.php
 * sidebar-footer.php

The files are the ones commonly provided by a theme wordpress.org. Please refer to the official documentation for their definition.
We'll analyze additional files of Native instead.
The "assets" folder contains all the parts of the structure of the theme as grafic styles css, images and js effects.
The "customs" folder contains all customizations of the theme and is actually an extension of the functions.php file. In this folder are uploaded all the files useful in setting the theme and so it is here that will be set the features supported by the theme previously seen together with the definition of sidebars, hooks, etc. ...
In "includes" can be found some files (two in the current version) that should be available to use or diversified only. An example is the page 404.php that includes only head.php and foot.php, instead of header.php and footer.php which contain superfluous code for the page in question.
Inside "lang" folder take place files for the localization/translation of the site. Use default.php to create a new translation of the theme.
Finally "templates" folder brings together the template files used in the theme. For a cleaner workplace you can continue using this folder for your personal template files.

Two more words on other files not present in conventional Native.
* sidebar-footer.php contains the three widget set for the footer.


Documentation on http://themes.designedby.it/native