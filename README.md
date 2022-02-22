# Akubra Adapter

## Introduction

Faciliates the access of Fedora3 data directly from [Akubra][akubra]-flavored
filesystem storage.

## Requirements

This module requires the following modules/libraries:

* [FOXML](https://github.com/discoverygarden/foxml)

## Installation

Install as usual, see
[this](https://drupal.org/documentation/install/modules-themes/modules-8) for
further information.

Additionally, there's some configuration to be done in sites `settings.php`
files to configure the services; specifically:

|Key|Description|Default|
|---|---|---|
|`akubra_adapter_datastream_basepath`|The path to the datastream store to be read.| (none; requires configuration) |
|`akubra_adapter_datastream_pattern`|The folder/directory structure created within the datastream store.|`##`|
|`akubra_adapter_object_basepath`|The path to the object store to be read.| (none; requires configuration) |
|`akubra_adapter_object_pattern`|The folder/directory structure created within the object store.|`##`|

## Usage

This module provides services that are collected by service collectors in the
FOXML module... there's no direct usage outside of configuring it.

## Troubleshooting/Issues

Having problems or solved one? contact
[discoverygarden](http://support.discoverygarden.ca).

## Maintainers/Sponsors

Current maintainers:

* [discoverygarden](http://www.discoverygarden.ca)

## Development

If you would like to contribute to this module create an issue, pull request
and or contact
[discoverygarden](http://support.discoverygarden.ca).

## License

[GPLv3](http://www.gnu.org/licenses/gpl-3.0.txt)

[akubra]: https://github.com/akubra/akubra
