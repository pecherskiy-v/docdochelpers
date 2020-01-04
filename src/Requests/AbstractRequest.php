<?php


namespace Pecherskiy\DocDoc\Requests;

use Pecherskiy\DocDoc\Exceptions\MethodIsNotSet;
use Pecherskiy\DocDoc\Exceptions\RequiredFieldIsNotSet;

use Pecherskiy\DocDoc\Exceptions\ResponseError;
use Pecherskiy\DocDoc\Exceptions\Unauthorized;
use Pecherskiy\DocDoc\Interfaces\ClientInterface;

use stdClass;

use function array_key_exists;
use function count;
use function implode;
use function in_array;
use function is_array;

class AbstractRequest
{
    /**
     * Обязательные поля
     *
     * @var array $requiredFields
     */
    public $requiredFields = [];

    /**
     * List of fields to rename
     */
    public const TRANSFORMED = [];

    /**
     * @var array
     */
    public $repalseProperty = [];

    /**
     * @return string
     * @throws RequiredFieldIsNotSet
     */
    public function makeRequestUrl(): string
    {
        $params = [];
        foreach (get_object_vars($this) as $prop => $value) {
            if ('repalseProperty' === $prop || 'requiredFields' === $prop || 'client' === $prop) {
                continue;
            }
            if (null === $value
                && in_array(
                    $prop,
                    $this->requiredFields,
                    true
                )
            ) {
                throw new RequiredFieldIsNotSet("The field {$prop} is required");
            }
            if (null !== $value) {
                if (is_array($value)) {
                    if (0 === count($value)) {
                        continue;
                    }
                    $value = implode(',', $value);
                }
                if (in_array($prop, static::TRANSFORMED, true)) {
                    $prop = static::TRANSFORMED[$prop];
                }
                if (array_key_exists($prop, $this->repalseProperty)) {
                    $prop = $this->repalseProperty[$prop];
                }

                $params[] = "$prop/$value";
            }
        }
        return implode('/', $params);
    }

    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;

    }

    /**
     * @param string $query
     * @param string $key
     * @return object
     * @throws ResponseError
     * @throws MethodIsNotSet
     * @throws Unauthorized
     */
    protected function get(string $query, string $key) : object
    {
        $this->client->setMethod($query);
        $response = $this->client->getJson();
        if (is_array($response)) {
            if (isset($response['message'])) {
                throw new ResponseError($response['message'] ?? 'Response is error');
            }
            $result = new stdClass();
            $result->response = $response;
            return $result;
        }

        if (isset($response->$key)) {
            return $response;
        }
        throw new ResponseError($response->message ?? 'Response is error');
    }

    /**
     * @param string $query
     * @param string $key
     * @return array|object
     * @throws ResponseError
     * @throws MethodIsNotSet
     * @throws Unauthorized
     */
    protected function getOnly(string $query, string $key)
    {
        $get = $this->get($query, $key);
        if (!isset($get->$key)) {
            throw new ResponseError($response->message ?? 'Response is error');
        }

        return $get->$key;
    }

    /**
     * @param string $query
     * @param string $key
     *
     * @return object
     * @throws MethodIsNotSet
     * @throws ResponseError
     * @throws Unauthorized
     */
    protected function getFirst(string $query, string $key): object
    {
        $response = $this->get($query, $key);
        if (isset($response->$key[0])) {
            return $response->$key[0];
        }
        throw new ResponseError($response->message ?? 'Response is error');
    }
}
