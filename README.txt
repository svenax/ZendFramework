Welcome to the Zend Framework 1.10 Release! 

RELEASE INFORMATION
---------------
Zend Framework 1.10dev Release ([INSERT REV NUM HERE]).
Released on <Month> <Day>, <Year>.

NEW FEATURES
------------

* Zend_Filter_Null, contributed by Thomas Weidner
* Zend_Filter_Compress/Decompress, contributed by Thomas Weidner
* Zend_Validate_Callback, contributed by Thomas Weidner
* Zend_Validate_PostCode, contributed by Thomas Weidner

A detailed list of all features and bug fixes in this release may be found at:

http://framework.zend.com/changelog/

MIGRATION NOTES
---------------

* Zend_Cache_Backend_File
  * renamed options, old names still exists but triggers an E_USER_NOTICE error
    * 'hashed_directory_umask' to 'hashed_directory_perm'
    * 'cache_file_umask' to 'cache_file_perm'

A detailed list of migration notes may be found at:

http://framework.zend.com/manual/en/migration.html

SYSTEM REQUIREMENTS
-------------------

Zend Framework requires PHP 5.2.11 or later. Please see our reference
guide for more detailed system requirements:

http://framework.zend.com/manual/en/requirements.html

INSTALLATION
------------

Please see INSTALL.txt.

QUESTIONS AND FEEDBACK
----------------------

Online documentation can be found at http://framework.zend.com/manual.
Questions that are not addressed in the manual should be directed to the
appropriate mailing list:

http://framework.zend.com/wiki/display/ZFDEV/Mailing+Lists

If you find code in this release behaving in an unexpected manner or
contrary to its documented behavior, please create an issue in the Zend
Framework issue tracker at:

http://framework.zend.com/issues

If you would like to be notified of new releases, you can subscribe to
the fw-announce mailing list by sending a blank message to
fw-announce-subscribe@lists.zend.com.

LICENSE
-------

The files in this archive are released under the Zend Framework license.
You can find a copy of this license in LICENSE.txt.

ACKNOWLEDGEMENTS
----------------

The Zend Framework team would like to thank all the contributors to the Zend
Framework project, our corporate sponsor, and you, the Zend Framework user.
Please visit us sometime soon at http://framework.zend.com.
