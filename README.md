# SecretServerAPI

Dependencies
---

- PHP 7.3
- PHP 7.3 XML extension
- PHP 7.3 SQLite3 extension
- [SoapBox/laravel-formatter](https://github.com/SoapBox/laravel-formatter)
- [UniSharp/laravel-ckeditor](https://github.com/UniSharp/laravel-ckeditor)
SecretServerAPI requires [Laravel](https://laravel.com/docs/5.8/installation) 5.8.12+ to run.

Install the dependencies.

```sh
$ apt-get install php7.3
$ apt-get install php7.3-xml
$ apt-get install php7.3-sqlite3
```

### Configuration
| Environment variable | Description               |
| -------- | -------------------- |
| APP_KEY      | Random generated 64 bit key used for AES-128-ECB encryption. |
| APP_PARSER      | You can switch between XML and JSON parser.        |

SecretServerAPI use both GET and POST method. For further information see below.

### POST /secret

### Expected Response Types
| Response | Reason               |
| -------- | -------------------- |
| 200      | successful operation |
| 405      | Invalid input        |

### Parameters
| Name             | In       | Description                                                                                                 | Required? | Type    |
| ---------------- | -------- | ----------------------------------------------------------------------------------------------------------- | --------- | ------- |
| secret           | formData | This text will be saved as a secret                                                                         | true      | string  |
| expireAfterViews | formData | The secret won't be available after the given number of views. It must be greater than 0.                   | true      | integer |
| expireAfter      | formData | The secret won't be available after the given time. The value is provided in minutes. 0 means never expires | true      | integer |

### Content Types Produced
| Produces         |
| ---------------- |
| application/json |
| application/xml  |

### Content Types Consumed
| Consumes                          |
| --------------------------------- |
| application/x-www-form-urlencoded |

### GET /secret/{hash}
### Expected Response Types
| Response | Reason               |
| -------- | -------------------- |
| 200      | successful operation |
| 404      | Secret not found     |

### Parameters
| Name | In   | Description                        | Required? | Type   |
| ---- | ---- | ---------------------------------- | --------- | ------ |
| hash | path | Unique hash to identify the secret | true      | string |

### Content Types Produced
| Produces         |
| ---------------- |
| application/json |
| application/xml  |
