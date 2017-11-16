# Keboola Docker Demo Application

[![Build Status](https://travis-ci.org/keboola/docker-demo-app.svg?branch=master)](https://travis-ci.org/keboola/docker-demo-app) [![Code Climate](https://codeclimate.com/github/keboola/docker-demo-app/badges/gpa.svg)](https://codeclimate.com/github/keboola/docker-demo-app) [![Test Coverage](https://codeclimate.com/github/keboola/docker-demo-app/badges/coverage.svg)](https://codeclimate.com/github/keboola/docker-demo-app/coverage) [![codecov.io](http://codecov.io/github/keboola/docker-demo-app/coverage.svg?branch=master)](http://codecov.io/github/keboola/docker-demo-app?branch=master)

This is a working example of an application which is encapsulated in a Docker image and is integrated with KBC. Application functionality is simple, it splits long text columns from a single table into multiple rows and adds index number into a new column and writes the result into `/data/out/tables/sliced.csv` file.

## Development
 
Clone this repository and init the workspace with following command:

```
git clone https://github.com/keboola/docker-demo-app
cd docker-demo-app
docker-compose build
docker-compose run --rm dev composer install
```

Run the test suite using this command:

```
docker-compose run --rm tests
```

### Composer

```
docker-compose run dev composer install
```

### Code Style Checker
```
docker-compose run --rm dev /code/vendor/bin/phpcs --standard=psr2 -n --ignore=vendor --extensions=php .
```

### PHP Static Code Analysis

```
docker-compose run --rm dev /code/vendor/bin/phpstan analyse --level=7 ./src ./tests
```

### Running the container (via docker-compose)

```
docker-compose run --rm --volume /my-data-dir:/data docker-demo-app
```

Note: `--volume` needs to be adjusted accordingly and has to lead to a [`data` directory](http://developers.keboola.com/extend/common-interface/).

## Configuration

The data folder must contain 

 - JSON configuration stored in `data/config.json`
 - CSV file in `data/in/tables` 

### Sample configuration
Mapped to `/data/config.json` 

```json
{
  "storage": {
    "input": {
      "tables": [
        {
          "source": "in.c-main.yourtable",
          "destination": "source.csv"
        }
      ]
    },
    "output": {
      "tables": [
        {
          "source": "sliced.csv",
          "destination": "out.c-main.yourtable"
        }
      ]
    }
  },
  "parameters": {
    "primary_key_column": "id",
    "data_column": "text",
    "string_length": 255
  }
}
```

 - `storage.input.tables[0].destination` (required): source table file
 - `parameters.primary_key_column` (required): primary key column of the source table
 - `parameters.data_column` (required): column to be split
 - `parameters.string_length` (required): split length

Note: attributes `storage.input.tables[0].source` and `storage.output` are not required for this script, but required for full functionality within Keboola Docker Bundle.


### Data sample

#### Source
Mapped to `/data/in/tables/source.csv`

```
id,text,some_other_column
1,"Short text","Whatever"
2,"Long text Long text Long text","Something else"
```

#### Destination
Created in `/data/out/tables/sliced.csv`


```
id,text,row_number
1,"Short text",0
2,"Long text Long ",0
2,"text Long Text",1

```
