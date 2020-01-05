Change namespase -> Pecherskiy\DocDoc

# Helper for API DocDoc 1.0.12

#### [Official API Documentation Version 1.0.12](https://dd1012.docs.apiary.io/)

### Example:
опция клиента
```
    $client = new Client($this->docdoc['login'], $this->docdoc['password'], Constants::MOCK_SERVER);
    $clinics = new Clinics($client);
    $clinics->start = 0;
    $clinics->count = 1;
    $clinics->city = 1;
    $result = $clinics->getClinics();
```

### Install

Install by [composer](http://getcomposer.org/download/).

```
composer require pecherskiy-v/docdochelpers
```

### Example

```php
use Pecherskiy\DocDoc\Client;
use Pecherskiy\DocDoc\Requests\Doctors;

$client = new Client(DOCDOC_LOGIN, DOCDOC_PASSWORD, API_URL = Constants::MOCK_SERVER);
$doctorsRequest = new Doctors($client);
$doctorsRequest->city = 1;
$doctorsRequest->count = 10;
$doctorsRequest->start = 0;
$doctors = $doctorsRequest->all();

foreach($doctors as $doctor) {
    // do something
}
```
