Groundwork
----------

CLI tool for code generation from templates.

Rather than providing code generation of classes to someone elses standard, groundwork gives you a tool to set up and use your own project specific code generation templates.

Install with composer.

    {
        "minimum-stability": "dev",
        "require": {
            "dancras/groundwork": "*"
        }
    }

Add a .groundwork folder to your project. Each subfolder is a groundwork "template". The only requirement is a run.php file.

To generate the code:

    vendor/bin/groundwork create %template% "%fully qualified class%"

See the .groundwork folder of this project for a class generation example. Clone the project and try it out:

    bin/groundwork create class "MyVendor\MyProject\MyClass"    
