# Crafter 

[![StyleCI](https://styleci.io/repos/63488822/shield?style=flat)](https://styleci.io/repos/63488822)
[![Build Status](https://travis-ci.org/percymamedy/crafter.svg?branch=master)](https://travis-ci.org/percymamedy/crafter)
[![Dependency Status](https://dependencyci.com/github/percymamedy/crafter/badge)](https://dependencyci.com/github/percymamedy/crafter)
[![Latest Stable Version](https://poser.pugx.org/crafter/installer/v/stable)](https://packagist.org/packages/crafter/installer)
[![Total Downloads](https://poser.pugx.org/crafter/installer/downloads)](https://packagist.org/packages/crafter/installer)
[![Latest Unstable Version](https://poser.pugx.org/crafter/installer/v/unstable)](https://packagist.org/packages/crafter/installer)
[![License](https://poser.pugx.org/crafter/installer/license)](https://packagist.org/packages/crafter/installer)
[![composer.lock](https://poser.pugx.org/crafter/installer/composerlock)](https://packagist.org/packages/crafter/installer)

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/c8be1988-0980-4881-a6ba-e87b13d8b85e/big.png)](https://insight.sensiolabs.com/projects/c8be1988-0980-4881-a6ba-e87b13d8b85e)

Install your favourite PHP frameworks using only one installer. 

## How it works

Crafter tries to provide a single installer to allow installation of multiple PHP frameworks using only one command.

## Installation

Begin by installing Crafter globally using composer.

```php
composer global require "crafter/installer"
```
Make sure to place the ```~/.composer/vendor/bin``` directory (or the equivalent directory for your OS) in your PATH so the ```craft``` executable can be located by your system.

## Usage

Now you use the ```new``` command to install an available framework.

```php
craft new <framework> <name> [<version>]
```

## Supported Frameworks

For the moment Crafter supports only:

* Laravel
* Symfony
* Zend Framework

You can use the ```show:frameworks``` command to list available frameworks.

```php
craft show:frameworks
```

Any PR that can include other frameworks will be welcome.

## Caution

This package is still in its infancy, bugs and issues are bound to happen. You can report any issue or open any PR that solves particular problems.

## Credits

[![Percy Mamedy](https://img.shields.io/badge/Author-Percy%20Mamedy-orange.svg)](https://twitter.com/PercyMamedy)

Twitter: [@PercyMamedy](https://twitter.com/PercyMamedy)
<br/>
GitHub: [percymamedy](https://github.com/percymamedy)
