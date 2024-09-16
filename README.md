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

Ultimately, the `*_pattern` values need to match the configuration of the source data. For additional detail on their particular meaning, it might be easiest to reference the [inline comments of the original Java code](https://github.com/fcrepo3/fcrepo/blob/37df51b9b857fd12c6ab8269820d406c3c4ad774/fcrepo-server/src/main/java/org/fcrepo/server/storage/lowlevel/akubra/HashPathIdMapper.java#L17-L68).

| Environment variable            | Description | Default |
|---------------------------------| --- | --- |
| `AKUBRA_ADAPTER_WRITE_PARANOIA` | Due to how migrations (or more specifically, rolling back migrations) might operate, it can be prudent to avoid allowing items through that are writable or in writable directories, such that they cannot potentially be deleted. By passing something false-y here, we will avoid pre-filtering when iterating over objects. | (unset, which enables paranoia by default) |

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
* [FLVC](https://www.flvc.org/)

## Development/Contribution

If you would like to contribute to this module, please check out github's helpful
[Contributing to projects](https://docs.github.com/en/get-started/quickstart/contributing-to-projects) documentation and Islandora community's [Documention for developers](https://islandora.github.io/documentation/contributing/CONTRIBUTING/#github-issues) to create an issue or pull request and/or
contact [discoverygarden](http://support.discoverygarden.ca).

## License

[GPLv3](http://www.gnu.org/licenses/gpl-3.0.txt)

[akubra]: https://github.com/akubra/akubra
[CTDA: Connecticut Digital Archive]: https://lib.uconn.edu/find/connecticut-digital-archive/
