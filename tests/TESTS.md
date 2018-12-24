# Testing

## PHPUnit

All tests should be written in PHPUnit. This document lays out the testing configuration and the folder layout.

Before making a pull request, please make sure all tests still pass, and that your new code is covered by tests.

This repository is also set up on Scrutinizer-ci, to ensure a high code quality. The Scrutinizer page may be found [here](https://scrutinizer-ci.com/g/tobytwigger/nus-unioncloud-api-wrapper/).

## Framework
All framework tests should be placed here. These are tests (both Unit and Feature tests) which make up the request and response framework.

No tests have yet been written. Why not write one now?

## Endpoints

These are tests for each resource. Each resource request class should have a file here, with all tests relevant to that resource present in the file.