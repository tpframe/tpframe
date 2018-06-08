![](http://www.tpframe.com/data/assets/images/mark_logo.jpg) 
TPFrame
===============
TPFrame keeps all of the ThinkPHP5's original features, and has done further development in the ThinkPHP drive mode, strengthening the CBD mode, optimizing the core, reducing the dependence, providing an efficient and fast solution for the individual or enterprise building station, which is the first choice for your fast doing in line finished products and expanding your own. The main features of TPFrame:

 + The structure of the web site is clear and reasonable
 + Keep all ThinkPHP5 modes, you can use any ThinkPHP5 available operation.
 + The system can be extended at random with the CBD mode
 + The system uses multiple layers (control layer, model layer, validation layer, logic layer, view layer) to reduce the coupling between each module, so that your code can be better reused when developing different systems.
 + The system can plug in the development of functional modules, rich free plug-ins can be downloaded directly
 + Based on namespace and many new features of PHP
 + Core function component-based
 + enhanced routing function
 + more flexible controller
 + reconfigured models and database classes
 + configuration file can be separated
Automatic verification and completion of + rewriting
 + simplified extension mechanism
 + API supports perfection
 + command line access support
 + REST support
 + boot file support
 + convenient automatic generation definition
 + real lazy loading
 + distributed environment support
 + more social class libraries

> The running environment of TPFrame requires more than PHP5.4.

## Standard directory structure

The initial directory structure is as follows:

~~~
www  WEB deployment directories (or subdirectories)
├─addon           		Plug-in directory
│  └─...        		...
├─application           Application directory
│  ├─common             Public module directory (can be changed)
│  ├─backend            Backend module directory (can be changed)
│  ├─frontend           Frontend module directory (can be changed)
│  ├─extra           	Configuration file directory
│  ├─install            Install the module directory (after installation is recommended to delete)
│  ├─module_name        
│  │  ├─config.php      
│  │  ├─controller      
│  │  ├─logic      		
│  │  ├─model           
│  │  ├─service      	
│  │  ├─validate      	
│  │  └─ ...            
│  ├─command.php        
│  ├─common.php         
│  ├─config.php         
│  ├─route.php          
│  ├─tags.php           
│  └─database.php       
├─coreframe           	
│  ├─source        		tpframe source
│  ├─thinkphp        	
│  ├─vendor        		
│  └─...        		
├─data                	
│  ├─assets          	
│  ├─runtime         	
│  ├─uploads        	Upload the file directory
│  ├─install.lock       Installation identification file
│  └─...		        
│─extend                
├─theme              	
│  ├─backend            
│  ├─frontend           
│  └─install            
│
├─build.php             Automatic generation of definition files (Reference)
├─LICENSE.txt           ....
├─README.md             README
├─think                 Command line entry file
├─index.php             Entry file
├─...            		
~~~

## Automatic installation
The system will be installed automatically after the system is run
For reinstalled users, manually delete `data/install.lock` files and'application/extra/database.php'files

## Naming specification

`TPFrame` follows the PSR-2 naming specification and the PSR-4 automatic loading specification, and takes note of the following specifications

### Catalogues and files

* directory is not mandatory, hump and lowercase + underline mode are supported;
* class libraries and function files are unified with `.php` suffix.
* file names are defined in namespace, and the namespace path is the same as the class library file.
* the class name and class file name remain the same, and the hump method is used uniformly (initialization capital)

### Function and class, attribute naming
* the name of the class is humped, and the initials are capitalized, such as `User`, `UserType`, and the default does not need to be added. For example, `UserController` should be named `User` directly.
* the naming of functions is in the form of lowercase letters and underlines (lowercase letters), such as `get_client_ip`;
* the naming of the method uses the hump method, and the initials are lowercase, such as `getUserName`;
* the naming of attributes uses the hump method, and the initials are lowercase, such as `tableName` and `instance`.
* function or method that takes the lead in double underline "`__call`" as magic method, such as `__call` and `__autoload`;

### Constant and configuration
* constants are named after capital letters and underscores, such as `APP_PATH` and `THINK_PATH`.
* configuration parameters are named after lowercase letters and underscores, such as `url_route_on` and `url_convert`;

### Data tables and fields
* data tables and fields are named by lowercase and underlined, and note that field names do not start with the following lines, such as the `think_user` table and the `user_name` field, and do not recommend the use of hump and Chinese as a data table field

### Web site instructions:

[tpframe official network] (http://www.tpframe.com)

[tpframe demo website] (http://demo.tpframe.com/backend)

## Copyright information

TPFrame follows the Apache2 open source protocol and provides free use.

The copyright information contained in the third party source code and binary files will be separately marked.

Copyright Copyright by 2006-2017 http://www.tpframe.com TPFrame (http://www.tpframe.com)

All rights reserved.
