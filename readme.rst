###################
What is DML
###################

DML is a web application project for a school department. 
The purpose of the project is to keep a list of the students enrolled to a specific subject and to automate the  
ordering process of materials that is necessary in a laboratory class. The application also tracks the inventory 
of the said department.

There are 4 types of users to this system.
: Admin
: Staff
: Teacher
: Student

1.) Admin
Admin serves as an overseer of the whole application.
Capabilities:
-  `Creates/Deletes accounts for the teachers and staff
-  `Approves student account
-  `Create/Edit/Delete new class
-  `Add/Remove students in a class
-  `Add/update/remove new materials in the inventory
-  `Resets the web application when the new semester comes in

2.) Staff
Capabilities:
-  `Approve student pending accounts
-  `Add/update/remove new materials in the inventory
-  `Keeps track on the approved orders and dispense them in the lab
-  `Logs the status of the material after the material is returned (If its broken or damaged)

3.) Teacher
Teacher approves the materials ordered by the students. 
Capabilities:
-  `Approves/Decline/View Order of items from the students

4.)
Capabilities:
-  `Orders materials





###################
What is CodeIgniter
###################

CodeIgniter is an Application Development Framework - a toolkit - for people
who build web sites using PHP. Its goal is to enable you to develop projects
much faster than you could if you were writing code from scratch, by providing
a rich set of libraries for commonly needed tasks, as well as a simple
interface and logical structure to access these libraries. CodeIgniter lets
you creatively focus on your project by minimizing the amount of code needed
for a given task.

*******************
Release Information
*******************

This repo contains in-development code for future releases. To download the
latest stable release please visit the `CodeIgniter Downloads
<https://codeigniter.com/download>`_ page.

**************************
Changelog and New Features
**************************

You can find a list of all changes for each release in the `user
guide change log <https://github.com/bcit-ci/CodeIgniter/blob/develop/user_guide_src/source/changelog.rst>`_.

*******************
Server Requirements
*******************

PHP version 5.6 or newer is recommended.

It should work on 5.3.7 as well, but we strongly advise you NOT to run
such old versions of PHP, because of potential security and performance
issues, as well as missing features.

************
Installation
************

Please see the `installation section <https://codeigniter.com/user_guide/installation/index.html>`_
of the CodeIgniter User Guide.

*******
License
*******

Please see the `license
agreement <https://github.com/bcit-ci/CodeIgniter/blob/develop/user_guide_src/source/license.rst>`_.

*********
Resources
*********

-  `User Guide <https://codeigniter.com/docs>`_
-  `Language File Translations <https://github.com/bcit-ci/codeigniter3-translations>`_
-  `Community Forums <http://forum.codeigniter.com/>`_
-  `Community Wiki <https://github.com/bcit-ci/CodeIgniter/wiki>`_
-  `Community Slack Channel <https://codeigniterchat.slack.com>`_

Report security issues to our `Security Panel <mailto:security@codeigniter.com>`_
or via our `page on HackerOne <https://hackerone.com/codeigniter>`_, thank you.

***************
Acknowledgement
***************

The CodeIgniter team would like to thank EllisLab, all the
contributors to the CodeIgniter project and you, the CodeIgniter user.
