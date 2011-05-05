Welcome to the Zend Framework 1.10 Release! 

RELEASE INFORMATION
---------------
Zend Framework 1.10.9 Release ([INSERT REV NUM HERE]).
Released on <Month> <Day>, <Year>.

SECURITY NOTICE FOR 1.10.9
--------------------------

This release includes a patch that helps prevent SQL injection
attacks in applications using the MySQL PDO driver of PHP while
using non-ASCII compatible encodings. Developers using ASCII-
compatible encodings like UTF8 or latin1 are not affected by
this PHP issue, which is described in more detail here:
http://bugs.php.net/bug.php?id=47802

The PHP Group included a feature in PHP 5.3.6+ that allows any
character set information to be passed as part of the DSN in
PDO to allow both the database as well as the c-level driver to be
aware of which charset is in use which is of special importance
when PDO::quote() is utilized, which Zend Framework makes use of.

Our patch ensures that any charset information provided to the
Zend_Db PDO MySQL adapter will be sent to PDO both as part of
the DSN as well as in a SET NAMES query.  This ensures that any
developer using ZF on PHP 5.3.6+ while using non-ASCII compatible
encodings is safe from SQL injection while using the PDO's 
quoting mechanisms or emulated prepared statements.

If you are using non-ASCII compatible encodings, like GBK, we
strongly urge you to consider upgrading to at least PHP 5.3.6 and
use Zend Framework version 1.11.6 or 1.10.9

NEW FEATURES
------------

* Zend_Barcode, contributed by Mikael Perraud and Thomas Weidner
* Zend_Cache_Backend_Static, contributed by Pádraic Brady
* Zend_Cache_Manager, contributed by Pádraic Brady
* Zend_Exception - previous exception support, contributed by Marc Bennewitz
* Zend_Feed_Pubsubhubbub, contributed by Pádraic Brady
* Zend_Feed_Writer, contributed by Pádraic Brady
* Zend_Filter_Boolean, contributed by Thomas Weidner
* Zend_Filter_Compress/Decompress, contributed by Thomas Weidner
* Zend_Filter_Null, contributed by Thomas Weidner
* Zend_Log::factory(), contributed by Mark van der Velden and Martin Roest ibuildings
* Zend_Log_Writer_ZendMonitor, contributed by Matthew Weier O'Phinney
* Zend_Markup, contributed by Pieter Kokx
* Zend_Oauth, contributed by Pádraic Brady
* Zend_Serializer, contributed by Marc Bennewitz
* Zend_Service_DeveloperGarden, contributed by Marco Kaiser
* Zend_Service_LiveDocx, contributed by Jonathan Maron
* Zend_Service_WindowsAzure, contributed by Maarten Balliauw
* Zend_Validate_Barcode, contributed by Thomas Weidner
* Zend_Validate_Callback, contributed by Thomas Weidner
* Zend_Validate_CreditCard, contributed by Thomas Weidner
* Zend_Validate_PostCode, contributed by Thomas Weidner
* Additions to Zend_Application resources, including Cachemanager, Dojo, Jquery,
  Layout, Log, Mail, and Multidb (contributed by Dolf Schimmel)
* Refactoring of Zend_Loader::loadClass() to conform to PHP Framework Interop
  Group reference implementation, which allows for autoloading PHP 5.3
  namespaced code
* Updated Dojo version to 1.4

A detailed list of all features and bug fixes in this release may be found at:

http://framework.zend.com/changelog/

SYSTEM REQUIREMENTS
-------------------

Zend Framework requires PHP 5.2.4 or later. Please see our reference
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
