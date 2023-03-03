# Akubra Adapter

![](https://github.com/discoverygarden/akubra_adapter/actions/workflows/auto_lint.yml/badge.svg)
![](https://github.com/discoverygarden/akubra_adapter/actions/workflows/auto-semver.yml/badge.svg)
[![License: GPL v3](https://img.shields.io/badge/License-GPLv3-blue.svg)](https://www.gnu.org/licenses/gpl-3.0)

## Introduction

Facilitates the access of Fedora3 data directly from [Akubra][akubra]-flavored
filesystem storage.

## Table of Contents

* [Requirements](#requirements)
* [Installation](#installation)
* [Configuration](#configuration)
* [Usage](#usage)
* [Troubleshooting/Issues](#troubleshootingissues)
* [Maintainers and Sponsors](#maintainers-and-sponsors)
* [Development/Contribution](#developmentcontribution)
* [License](#license)

## Requirements

This module requires the following modules/libraries:

* [FOXML](https://github.com/discoverygarden/foxml)

## Installation

Install as usual, see
[this](https://drupal.org/documentation/install/modules-themes/modules-8) for
further information.

## Configuration

Configuration to be done in site's `settings.php`
files to configure the services:

|Key|Description|Default|
|---|---|---|
|`akubra_adapter_datastream_basepath`|The path to the datastream store to be read.| (none; requires configuration) |
|`akubra_adapter_datastream_pattern`|The folder/directory structure created within the datastream store.|`##`|
|`akubra_adapter_object_basepath`|The path to the object store to be read.| (none; requires configuration) |
|`akubra_adapter_object_pattern`|The folder/directory structure created within the object store.|`##`|

So, assuming a Fedora's "data" directory is mounted to `/nfs/fedora_data`, you might add to `settings.php`:

```php
$settings['akubra_adapter_datastream_basepath'] = '/nfs/fedora_data/datastreamStore';
$settings['akubra_adapter_object_basepath'] = '/nfs/fedora_data/objectStore';
```

## Usage

This module provides services that are collected by service collectors in the
FOXML module. there's no direct usage outside of configuring it.

## Troubleshooting/Issues

Having problems or solved one? contact
[discoverygarden](http://support.discoverygarden.ca).

## Maintainers and Sponsors

Current maintainers:

* [discoverygarden](http://www.discoverygarden.ca)

Sponsors:

* [CTDA: Connecticut Digital Archive]
* [FLVC](Add link)

## Development/Contribution

If you would like to contribute to this module create an issue, pull request
and or contact
[discoverygarden](http://www.discoverygarden.ca).

## License

[GPLv3](http://www.gnu.org/licenses/gpl-3.0.txt)

[akubra]: https://github.com/akubra/akubra
[CTDA: Connecticut Digital Archive]: https://lib.uconn.edu/find/connecticut-digital-archive/
