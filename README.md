# plugins2019
Enhance PHPMaker project with Material Design template.
## Instalation
### 1. Clone or copy repository into PHPMaker project folder.
Open console and goto inside PHPMaker project folder, then run command:  
```Git
git clone https://github.com/erikfva/plugins2019.git
````
### 2. Configure plugin.
Edit **plugins2019/phpfn.php** file and configure your main project namespace. You can find this information in the begining of your **phpfn15.php** file into main project folder.
#### phpfn15.php
```PHP
<?php

/**
 * PHPMaker Common classes and functions
 * (C) 2002-2019 e.World Technology Limited. All rights reserved.
*/
namespace PHPMaker2019\contab;
```
#### plugins2019/phpfn.php
```PHP
<?php
/** CONFIG YOUR MAIN PROJECT NAMESPACE HERE!!! **/
use PHPMaker2019\contab as phpfn;
/* **************************************** */
```
In this sample the namespace is **contab**.
### 3. Configure your PHPMaker project.
In PHPMaker select ***Tools/Advanced Settings*** and checkin ***Disable project CSS styles***
![img-disable-project-css](/documents/images/disable-project-css.png)

In ***Server Events/Global/All Pages/Page_Head*** include php code:
```PHP
include_once "plugins2019/plg_coolui/header.php";
```
![img-disable-project-css](/documents/images/page-head.png)

In ***Server Events/Global/All Pages/Page_Foot*** include php code:
```PHP
include_once "plugins2019/plg_coolui/footer.php";
```
### 4. Generate your project again.

## Features
![img-list-page](/documents/images/list-page.png)

![img-list-page-fixed-head](/documents/images/list-page-fixed-head.png)

![img-left-menu](/documents/images/left-menu.png)

![img-mobile-list](/documents/images/mobile-list.png)

![img-mobile-responsive-table](/documents/images/mobile-responsive-table.png)

![img-mobile-list-pager](/documents/images/mobile-list-pager.png)