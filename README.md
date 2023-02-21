## Install `make`
### Windows
- Install chocolatey from [here](https://chocolatey.org/install).
- ```choco install make```
### macOS
- ```brew install make```
### Linux
- ```sudo apt-get update```
- ```sudo apt-get install -y make```

## Run Development Environment
- ```make start```
- ```make migrate```

_Frontend is exposed on port 8080_;

## Run Tests
### Unit Tests
- ```make test-unit```
### Controller Integration Tests
- ```make test-env-up```
- _Wait until docker container starts (+-20s)_;
- ```make test-integration```

## Notes
- [x] _GET_ request without previous _POST_ requests returns `401 Unauthorized`;
- [x] Calculator is managed through session cookie, so it is not possible to make a request to another calculator;
- [x] Calculator returns last 5 calculations;
- [x] Calculation's _expression_ and _result_ are stored as `string` type;