# SilverStripe supported module skeleton

## Requirements

* SilverStripe ^4.9
* [Yarn](https://yarnpkg.com/lang/en/), [NodeJS](https://nodejs.org/en/) (6.x) and [npm](https://npmjs.com) (for building
  frontend assets)

## Installation

```
composer require silverstripe/userguide
```

## Usage
```yml
Page:
  extensions:
    - SilverStripe\UserGuide\Extension\UserGuideExtension
```

Config options:
- by default the module looks for documents in the '/docs/userguides' folder. You can change this like so:

```yml
SilverStripe\UserGuide:
  directory: '/docs/some-other-folder'
```

- by default the module supports `md, html, pdf` file extensions, you can update it like so:

```yml
SilverStripe\UserGuide:
  allowed_file_extensions:
    - pdf
    - md
```

## License
See [License](license.md)

## Documentation
 * [Documentation readme](docs/en/readme.md)

## Example configuration (optional)

@TODO

## Bugtracker
Bugs are tracked in the issues section of this repository. Before submitting an issue please read over
existing issues to ensure yours is unique.

If the issue does look like a new bug:

 - Create a new issue
 - Describe the steps required to reproduce your issue, and the expected outcome. Unit tests, screenshots
 and screencasts can help here.
 - Describe your environment as detailed as possible: SilverStripe version, Browser, PHP version,
 Operating System, any installed SilverStripe modules.

Please report security issues to the module maintainers directly. Please don't file security issues in the bugtracker.

## Development and contribution
If you would like to make contributions to the module please ensure you raise a pull request and discuss with the module maintainers.
