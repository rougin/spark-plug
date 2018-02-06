# Changelog

All notable changes to `Spark Plug` will be documented in this file.

## [0.6.1](https://github.com/rougin/spark-plug/compare/v0.6.0...v0.6.1) - Unreleased

### Added
- Loaded `Output` class

## [0.6.0](https://github.com/rougin/spark-plug/compare/v0.5.0...v0.6.0) - 2018-01-12

### Added
- `SparkPlug::instance` method (replaces `getCodeIgniter` method)
- `SparkPlug::set` method for specifying constants manually (e.g `APPPATH`)

### Changed
- Code quality (renaming all protected methods into one word)
- Renamed `get_instance.php` to `helpers.php`

### Removed
- `bin` directory
- `CONDUCT.md`
- `CONTRIBUTING.md`

## [0.5.0](https://github.com/rougin/spark-plug/compare/v0.4.4...v0.5.0) - 2016-10-23

### Changed
- Code quality

## [0.4.4](https://github.com/rougin/spark-plug/compare/v0.4.3...v0.4.4) - 2016-09-10

### Added
- StyleCI for conforming code to PSR standards

## [0.4.3](https://github.com/rougin/spark-plug/compare/v0.4.2...v0.4.3) - 2016-05-13

### Changed
- Version of `rougin/codeigniter` to `^3.0.0`

## [0.4.2](https://github.com/rougin/spark-plug/compare/v0.4.1...v0.4.2) - 2016-05-09

### Fixed
- `CI_` prefix issue when loading a library from `application/libraries`

## [0.4.1](https://github.com/rougin/spark-plug/compare/v0.4.0...v0.4.1) - 2016-04-29

### Fixed
- `MB_ENABLED` issue when using `Inflector` helper

## [0.4.0](https://github.com/rougin/spark-plug/compare/v0.3.0...v0.4.0) - 2016-04-25

### Added
- `Instance::create`

## [0.3.0](https://github.com/rougin/spark-plug/compare/v0.2.0...v0.3.0) - 2016-03-22

### Added
- `$path` in constructor for setting test application directory (useful for unit testing)
- Tests

## [0.2.0](https://github.com/rougin/spark-plug/compare/v0.1.2...v0.2.0) - 2015-10-23

### Changed
- `Instance` to `SparkPlug`
- Code structure

## [0.1.2](https://github.com/rougin/spark-plug/compare/v0.1.1...v0.1.2) - 2015-09-18

### Fixed
- Issues on defined constants

## [0.1.1](https://github.com/rougin/spark-plug/compare/v0.1.0...v0.1.1) - 2015-09-15

### Added
- Namespaces

### Changed
- Documentation

## 0.1.0 - 2015-06-25

### Added
- `Spark Plug` library
