Sublime Projects for Alfred 2
============

A simple but useful Alfred 2 workflow with Sublime Projects support.


Requirements
----------------
You have to install the `subl` command line tool.

- Instructions for [Sublime Text 3](http://www.sublimetext.com/docs/3/osx_command_line.html)
- Instructions for [Sublime Text 2](http://www.sublimetext.com/docs/2/osx_command_line.html)


Installation
----------------

- Download "Sublime Text Projects.alfredworkflow" extension by clicking the "raw" link.
- Double click the *.alfredextension file to install.


Instructions
----------------

sub `<Project name>`


Fuzzy-ish type maching
----------------

Thanks to [natecavanaugh](https://github.com/natecavanaugh) contribute now are allowed a fuzzy-ish type matching of the names of projects; for instance, if you have 3 projects such as:

- dotfiles
- Liferay Dev
- Liferay Plugins

Typing `de` will give you `dotfiles` and `Liferay Dev`.
Typing `lfr` will give you both `Liferay Dev` and `Liferay Plugins`.
Typing `ldev` will give you just `Liferay Dev`.

This fits more with how fuzzy matching is done in Sublime and makes it really easy to select projects.