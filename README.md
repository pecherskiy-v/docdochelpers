# Helper for API DocDoc 1.0.9 

#### [Official API Documentation Version 1.0.6](https://pk.docdoc.ru/docs/partner-api.pdf)

#### [Official API Documentation Version 1.0.9](https://dd109.docs.apiary.io/#reference/0/4//doctor/list)

для клиник версия 1.0.6 более не поддерживаеться
### Example:
```
    $client = new Client($this->docdoc['login'], $this->docdoc['password'], 'production');
    $clinics = new Clinics($client);
    $result = $clinics->getClinics(
        (new ClinicsQueryBuilder())
            ->setStart(8)
            ->setCount(1)
            ->setCity(1)
    );
```

### Install

Install by [composer](http://getcomposer.org/download/).

```
composer require pecherskiy-v/docdochelpers
```

### Example

```
API_URL = [
    // предыдущая версия Api
    'api_1.0.6' => 'https://api.docdoc.ru/public/rest/1.0.6/json/',
    // сервера доступные для Api 1.0.9
    'production' => 'https://api.docdoc.ru/public/rest/1.0.9/',
    'mock_server' => 'https://private-anon-5e031e7a1a-dd109.apiary-mock.com/public/rest/1.0.9',
    'debugging_proxy' => 'https://private-anon-5e031e7a1a-dd109.apiary-proxy.com/public/rest/1.0.9'
]
```

```php
use Leyhmann\DocDoc\Client;
use Leyhmann\DocDoc\Services\Doctors;
use Leyhmann\DocDoc\Services\Clinics;

$client = new Client(DOCDOC_LOGIN, DOCDOC_PASSWORD, API_URL = 'production');
$doctorsService = new Doctors($client);
$doctors = $doctorsService->all(cityId : int, [count int = 500], [start : int = 1]);

foreach($doctors as $doctor) {
    // do something
}
```

### See Services folder for make request
